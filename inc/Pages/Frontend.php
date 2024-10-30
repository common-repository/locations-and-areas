<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Pages;

use \LocationsAndAreasPlugin\Base\BaseController;

class Frontend extends BaseController
{
    public function register()
    { 
      // Shortcodes
      add_action('init', array($this, 'set_shortcodes'));
    }

    /**
     * Setup Shortcode
     */
    public function set_shortcodes()
    {
      add_shortcode('locations-and-areas-map', array($this, 'render_block_map'));
    }
}
