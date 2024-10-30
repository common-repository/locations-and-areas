<?php

/**
 * @package LocationsAndAreasPlugin
 */
/*
Plugin Name: Locations and Areas - Leaflet Map with Region Tabs
Plugin URI: https://wordpress.org/plugins/locations-and-areas/
Description: An awesome map with features like: multiple regions as tabs, no API keys needed, frontend location adding, marker clustering & beautiful map and marker styles
Author: 100plugins
Version: 1.7.2
Author URI: https://www.locations-and-areas.com/
License: GPLv3 or later
Text Domain: locations-and-areas
*/
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

Copyright 2021 100plugins
*/
defined( 'ABSPATH' ) or die( 'Direct access is not allowed.' );

if ( function_exists( 'laa_fs' ) ) {
    laa_fs()->set_basename( false, __FILE__ );
} else {
    // FREEMIUS INTEGRATION CODE
    
    if ( !function_exists( 'laa_fs' ) ) {
        // Create a helper function for easy SDK access.
        function laa_fs()
        {
            global  $laa_fs ;
            
            if ( !isset( $laa_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $laa_fs = fs_dynamic_init( array(
                    'id'             => '8986',
                    'slug'           => 'locations-and-areas',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_938a72f128414125581269993da86',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 7,
                    'is_require_payment' => false,
                ),
                    'menu'           => array(
                    'slug'       => 'locations_and_areas',
                    'first-path' => 'options-general.php?page=locations_and_areas',
                    'contact'    => false,
                    'support'    => false,
                    'parent'     => array(
                    'slug' => 'options-general.php',
                ),
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $laa_fs;
        }
        
        // Init Freemius.
        laa_fs();
        // Signal that SDK was initiated.
        do_action( 'laa_fs_loaded' );
    }
    
    // Special uninstall routine with Freemius
    function laa_fs_uninstall_cleanup()
    {
        global  $wpdb ;
        //delete posts
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "posts WHERE post_type='laa-location'" );
        //delete postmeta
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "postmeta WHERE meta_key LIKE '%laa_%'" );
        //delete taxonomy
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "terms WHERE term_id IN (SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy='laa-area')" );
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "termmeta WHERE term_id IN (SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy='laa-area')" );
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "term_relationships WHERE term_taxonomy_id IN (SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy='laa-area')" );
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy='laa-area'" );
        //delete options
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "options WHERE option_name LIKE 'laa_%'" );
    }
    
    laa_fs()->add_action( 'after_uninstall', 'laa_fs_uninstall_cleanup' );
    // Better Opt-In Screen
    add_action( 'admin_body_class', function ( $class ) {
        if ( laa_fs()->is_activation_mode() ) {
            $class .= ' laa-fs-optin-dashboard';
        }
        return $class;
    } );
    laa_fs()->add_action( 'connect/before', function () {
        echo  '<div class="laa-optin-wrapper"><div class="laa-optin-hero"><div class="laa-optin-image"></div></div>' ;
    } );
    laa_fs()->add_action( 'connect/after', function () {
        echo  '</div>' ;
    } );
    laa_fs()->add_filter( 'connect_message', function ( $text ) {
        // if (strpos($text, '<br>') !== false) {
        //     $exploded_message = explode('<br>', $text);
        //     $text = '<span>' . $exploded_message[0] . '</span>' . $exploded_message[1];
        // }
        $current_user = wp_get_current_user();
        $text = '<span>Hey ' . $current_user->user_login . ',</span>Never miss an important update - opt in to our security &amp; feature updates notifications, and non-sensitive diagnostic tracking with <a href="https://freemius.com?id=8986&amp;slug=locations-and-areas" target="_blank" rel="noopener" tabindex="1">freemius.com</a>. For developing the <strong>Locations and Areas plugin</strong> in the way you want it this helps us a lot. Thank you!';
        return $text;
    } );
    // ... Your plugin's main file logic ...
    // Require once the composer autoload
    if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
        require_once dirname( __FILE__ ) . '/vendor/autoload.php';
    }
    /**
     * The code that runs during plugin activation
     */
    function laa_activate_locationsandareas_plugin()
    {
        LocationsAndAreasPlugin\Base\Activate::activate();
    }
    
    register_activation_hook( __FILE__, 'laa_activate_locationsandareas_plugin' );
    /**
     * The code that runs during plugin deactivation
     */
    function laa_deactivate_locationsandareas_plugin()
    {
        LocationsAndAreasPlugin\Base\Deactivate::deactivate();
    }
    
    register_deactivation_hook( __FILE__, 'laa_deactivate_locationsandareas_plugin' );
    /**
     * Initialize all the core classes of the plugin
     */
    if ( class_exists( 'LocationsAndAreasPlugin\\Init' ) ) {
        LocationsAndAreasPlugin\Init::register_services();
    }
}
