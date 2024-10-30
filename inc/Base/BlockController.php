<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Base;

use LocationsAndAreasPlugin\Base\BaseController;

class BlockController extends BaseController
{
    public function register() {
        // Gutenberg Blocks
        add_action('init', array($this, 'set_gutenberg_blocks'));
    }

    /**
     * Setup Gutenberg Blocks
     */
    public function set_gutenberg_blocks()
    {   
        // register JS for Gutenberg Blocks
        $asset_file = include( $this->plugin_path . 'blocks/build/index.asset.php');
        wp_register_script(
            'locationsandareas_blocks_script', 
            $this->plugin_url . 'blocks/build/index.js', 
            $asset_file['dependencies'],
            $asset_file['version']
        );

        // Register Block: Locations and Areas Map
        register_block_type( 'locations-and-areas/map', array(
            'api_version' => 2,
            'editor_script' => 'locationsandareas_blocks_script',
            'render_callback' => is_admin() ? null : array($this, 'render_block_map')
        ) );

        // add JS translation for Gutenberg Blocks script
        /*
         Pay Attention: 
         - currently doesnt work with wordpress.org translation --> use local translation file 
         - Translation file needs to be called "locations-and-areas-de_DE-locationsandareas_blocks_script.json"
         - Howto: https://developer.wordpress.org/block-editor/how-to-guides/internationalization/
         */
        wp_set_script_translations( 
            'locationsandareas_blocks_script', 
            'locations-and-areas', 
            $this->plugin_path . 'languages' 
        );
    }
}
