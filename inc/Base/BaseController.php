<?php

/**
 * @package LocationsAndAreasPlugin
 */
namespace LocationsAndAreasPlugin\Base;

class BaseController
{
    public  $plugin_path ;
    public  $plugin_url ;
    public  $plugin_version ;
    public  $plugin ;
    public  $map_styles = array(
        "Stamen.TonerLite"     => "TonerLite (Stamen)",
        "Esri.WorldStreetMap"  => "WorldStreetMap (Esri)",
        "OpenStreetMap.Mapnik" => "Mapnik (OpenStreetMap)",
        "CartoDB.DarkMatter"   => "DarkMatter (CartoDB)",
        "CartoDB.Positron"     => "Positron (CartoDB)",
    ) ;
    public  $pro_map_styles = array(
        "Custom1" => "Light with big labels",
        "Custom2" => "Purple Glow with big labels",
        "Custom3" => "Blue with big labels",
    ) ;
    public  $marker_icons = array( "default", "custom1" ) ;
    public  $pro_marker_icons = array( "custom2", "custom3", "custom4" ) ;
    public function __construct()
    {
        $this->plugin_path = plugin_dir_path( dirname( dirname( __FILE__ ) ) );
        $this->plugin_url = plugin_dir_url( dirname( dirname( __FILE__ ) ) );
        $this->plugin_version = get_file_data( dirname( dirname( dirname( __FILE__ ) ) ) . '/locations-and-areas.php', array(
            'Version' => 'Version',
        ) )['Version'];
        $this->plugin = plugin_basename( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/locations-and-areas.php';
    }
    
    /**
     * Render the map
     */
    public function render_block_map( $block_attributes, $content )
    {
        // error_log(print_r($block_attributes, true));
        // error_log(print_r($content, true));
        ob_start();
        wp_enqueue_style(
            'laa_frontend_css',
            $this->plugin_url . 'assets/frontend.css',
            array(),
            $this->plugin_version
        );
        wp_enqueue_style(
            'laa_leaflet_css',
            $this->plugin_url . 'src/leaflet/leaflet.css',
            array(),
            $this->plugin_version
        );
        wp_enqueue_style(
            'laa_leaflet_gesture_css',
            $this->plugin_url . 'src/leaflet/leaflet-gesture-handling.min.css',
            array(),
            $this->plugin_version
        );
        wp_enqueue_style(
            'laa_leaflet_markercluster_css',
            $this->plugin_url . 'src/leaflet/leaflet-markercluster.css',
            array(),
            $this->plugin_version
        );
        wp_enqueue_style(
            'laa_leaflet_markercluster_default_css',
            $this->plugin_url . 'src/leaflet/leaflet-markercluster.default.css',
            array(),
            $this->plugin_version
        );
        wp_enqueue_script(
            'laa_leaflet_js',
            $this->plugin_url . 'src/leaflet/leaflet.js',
            array(),
            $this->plugin_version
        );
        wp_enqueue_script(
            'laa_leaflet_providers_js',
            $this->plugin_url . 'src/leaflet/leaflet-providers.js',
            array( 'laa_leaflet_js' ),
            $this->plugin_version
        );
        wp_enqueue_script(
            'laa_leaflet_gesture_js',
            $this->plugin_url . 'src/leaflet/leaflet-gesture-handling.min.js',
            array( 'laa_leaflet_js' ),
            $this->plugin_version
        );
        wp_enqueue_script(
            'laa_leaflet_markercluster_js',
            $this->plugin_url . 'src/leaflet/leaflet-markercluster.js',
            array( 'laa_leaflet_js' ),
            $this->plugin_version
        );
        require_once "{$this->plugin_path}/templates/block-map.php";
        wp_enqueue_script(
            'laa_frontend_block_map_js',
            $this->plugin_url . 'src/js/frontend-block-map.js',
            array( 'laa_leaflet_providers_js', 'laa_leaflet_gesture_js', 'laa_leaflet_markercluster_js' ),
            $this->plugin_version
        );
        return ob_get_clean();
    }
    
    /**
     * [PRO] Add location from frontend (AJAX)
     */
    public function ajax_add_location_from_frontend()
    {
    }

}