<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Pages;

use \LocationsAndAreasPlugin\Base\BaseController;

class Settings extends BaseController
{
    public function register()
    {
        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_action('admin_init', array($this, 'add_plugin_settings'));
        add_action('admin_notices', array($this, 'show_getting_started_notice'));
        add_action('wp_ajax_laa_dismiss_getting_started_notice', array($this, 'getting_started_dismiss_notice'));
    }

    public function add_admin_pages()
    {
        add_options_page('Locations and Areas', 'Locations and Areas', 'manage_options', 'locations_and_areas', array($this, 'admin_index'));
    }

    public function add_plugin_settings()
    {
        register_setting('locations-and-areas-settings-group', 'laa_getting_started_notice_dismissed');
        register_setting('locations-and-areas-settings-group', 'laa_map_style');
        register_setting('locations-and-areas-settings-group', 'laa_marker_icon');
        register_setting('locations-and-areas-settings-group', 'laa_layout_style');
        register_setting('locations-and-areas-settings-group', 'laa_start_lat', array('sanitize_callback' => array($this, 'validate_geocoordinate')));
        register_setting('locations-and-areas-settings-group', 'laa_start_lng', array('sanitize_callback' => array($this, 'validate_geocoordinate')));
        register_setting('locations-and-areas-settings-group', 'laa_start_zoom', array('sanitize_callback' => 'intval'));
        register_setting('locations-and-areas-settings-group', 'laa_disable_areas');
        register_setting('locations-and-areas-settings-group', 'laa_hide_address');
        register_setting('locations-and-areas-settings-group', 'laa_disable_gmaps_link');
        register_setting('locations-and-areas-settings-group', 'laa_disable_cluster');
        register_setting('locations-and-areas-settings-group', 'laa_enable_frontend_location_adding');
        register_setting('locations-and-areas-settings-group', 'laa_thankyou_headline');
        register_setting('locations-and-areas-settings-group', 'laa_thankyou_text');
    }

    public function admin_index()
    {
        require_once $this->plugin_path . 'templates/page-backend-settings.php';
    }

    public static function validate_geocoordinate($input) 
    {
        // Validation
        $geocoordinate_validated = floatval(str_replace(',', '.', sanitize_text_field($input)));
        if(!$geocoordinate_validated) {
            $geocoordinate_validated = '';
        }

        return $geocoordinate_validated;
    }

    public static function show_getting_started_notice() 
    {
        // return if already dismissed
        if( ! empty(get_option( 'laa_getting_started_notice_dismissed' )) ) {
            return;
        }

        $screen = get_current_screen();
        
        // Only render this notice in the plugin settings page.
        if ( ! $screen || 'settings_page_locations_and_areas' !== $screen->base ) {
            return;
        }

        // Render the notice's HTML.
        echo '<div class="notice laa-getting-started-notice notice-success is-dismissible">';
        echo sprintf( __( '<h3>Getting started</h3><ol><li>Create your first <a href="%s">location</a> and <a href="%s">area</a> (optional)</li><li>Use the Gutenberg Block "Locations and Areas Map" or the shortcode <code>[locations-and-areas-map]</code> to place the map within your content</li></ol>', 'locations-and-areas' ), '/wp-admin/post-new.php?post_type=laa-location', '/wp-admin/edit-tags.php?taxonomy=laa-area&post_type=laa-location' );
        echo '</div>';
    }

    public static function getting_started_dismiss_notice() 
    {
        update_option( 'laa_getting_started_notice_dismissed', 1 );
    }
}
