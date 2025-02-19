<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Base;

use LocationsAndAreasPlugin\Base\BaseController;

class Enqueue extends BaseController
{
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin'));

        //Enqueue the Dashicons script
        add_action( 'wp_enqueue_scripts', array($this, 'load_dashicons_front_end'));
    }

    public function enqueue_admin()
    {
        // enqueue Leaflet
        wp_enqueue_style('laa_leaflet_css', $this->plugin_url . 'src/leaflet/leaflet.css', array(), $this->plugin_version);
        wp_enqueue_style('laa_leaflet_geosearch_css', $this->plugin_url . 'src/leaflet/geosearch.css', array(), $this->plugin_version); //https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.css

        wp_enqueue_script('laa_leaflet_js', $this->plugin_url . 'src/leaflet/leaflet.js', array(), $this->plugin_version);
        wp_enqueue_script('laa_leaflet_providers_js', $this->plugin_url . 'src/leaflet/leaflet-providers.js', array('laa_leaflet_js'), $this->plugin_version);
        wp_enqueue_script('laa_leaflet_polyfill_unfetch_js', $this->plugin_url . 'src/js/polyfills/unfetch.js', array('laa_leaflet_js'), $this->plugin_version);
        wp_enqueue_script('laa_leaflet_geosearch_js', $this->plugin_url . 'src/leaflet/geosearch.js', array('laa_leaflet_polyfill_unfetch_js'), $this->plugin_version);//https://unpkg.com/leaflet-geosearch@3.1.0/dist/bundle.min.js
        
        
        // enqueue admin styles
        wp_enqueue_style('locationsandareas_style', $this->plugin_url . 'assets/style.css', array(), $this->plugin_version);

        // add media API (media uploader)
        if ( !did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        
        // enqueue admin scripts
        wp_register_script(
            'locationsandareas_script', 
            $this->plugin_url . 'src/js/backend.js',
            array('wp-i18n', 'jquery'),
            $this->plugin_version
        );

        wp_enqueue_script('locationsandareas_script');

        // add JS translation for admin scripts
        wp_set_script_translations( 
            'locationsandareas_script', 
            'locations-and-areas', 
            $this->plugin_path . 'languages' 
        );
    }

    public function load_dashicons_front_end() 
    {
        wp_enqueue_style( 'dashicons' );
    }
}
