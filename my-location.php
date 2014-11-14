<?php
/*
Plugin Name: My Location
Description: Just like the name suggests. This is a simple that works by collecting whoever logs in the back end's geo coordinates and display them on the front page map as the current location.
Author: Archie Makuwa
Author URI: http://www.aatsol.co.za/
Plugin URI: http://www.aatsol.co.za/
License: Copy and distribute... you will thank me later.
Version: 1.0.0
*/

// Load Some Scripts
function loadMyScripts()
{
    wp_register_style('mylocstyle', plugins_url( '/css/styles.css', __FILE__ ) );
    wp_register_script( 'custom-script', plugins_url( '/js/scripts.js', __FILE__ ) );

    wp_enqueue_style( 'mylocstyle' );
    wp_enqueue_script( 'custom-script' );
}
add_action( 'admin_enqueue_scripts', 'loadMyScripts' );


// Create Database Table / or Drop it if need arises
require_once(plugin_dir_path(__FILE__) . '/inc/db_schema.php');

// Require Dashboard
require_once(plugin_dir_path(__FILE__) . '/inc/dash.php');

// Require front end stuff
require_once(plugin_dir_path(__FILE__) . '/inc/display_location.php');


// Plugin Class
Class myLocation {

    function __construct()
    {
        add_action( 'wp_dashboard_setup', array( $this, 'remove_dashboard_widgets' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ) );
    }

    function remove_dashboard_widgets()
    {
        global $remove_defaults_widgets;

        foreach ($remove_defaults_widgets as $wigdet_id => $options)
        {
            remove_meta_box($wigdet_id, $options['page'], $options['context']);
        }
    }

    function add_dashboard_widgets()
    {
        global $custom_dashboard_widgets;

        foreach ($custom_dashboard_widgets as $widget_id => $options)
        {
            wp_add_dashboard_widget(
                $widget_id,
                $options['title'],
                $options['callback']
            );
        }
    }

}


// Initiate Class
$wdw = new myLocation();

