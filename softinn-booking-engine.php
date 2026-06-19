<?php
/**
 * @package  SoftinnBE
 */
/**
 * Plugin Name:       Softinn Hotel Booking Engine
 * Plugin URI:        https://wordpress.org/plugins/softinn-booking-engine/
 * Description:       Hotel Booking Engine for boutique hotels in Asia. Customizable. Support local payment gateways (iPay88, Midtrans, eGHL, PayPal etc). Email and SMS notification. Rule-based promotion code system.
 * Version:           2.2.0
 * Author:            Softinn Solutions Sdn Bhd
 * Author URI:        https://www.mysoftinn.com/
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Tested up to:      7.0
 * Text Domain:       softinn-booking-engine
 */
 /*
    Softinn Hotel Booking engine
    - Shortcode support to insert booking engine.
    - Date picker widget

    Copyright (C) 2019  Softinn Solutions Sdn Bhd

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
 */

defined ('ABSPATH') or die ('You should not be here man!'); //security purpose, avoid direct access

//check if the class actually exist
if ( !class_exists( 'SoftinnBE' ) ) {

    class SoftinnBE
    {
        public $plugin_name;//public variable that will store the plugin name

        //construct will be the first thing to be run after the plugin activated
        function __construct() {
            $this->plugin_name = plugin_basename( __FILE__ ); //the plugin name stored in $plugin_name
            add_action('wp_enqueue_scripts', array($this,'softinn_enqueue_front') );
            add_action('admin_head', array($this,'softinn_custom_admin_panel'));
            include_once('inc/softinn-calendarwidget.php'); //include the widget file
        }

        //hook method here
        function register() {
            add_shortcode('softinnBE', array( $this, 'iframe_plugin_add_shortcode_cb'));
            add_filter( "plugin_action_links_$this->plugin_name", array( $this, 'settings_link' ) );
            add_action( 'widgets_init', function(){register_widget( 'Softinn_CalendarWidget' );});
            add_action('admin_menu', array( $this, 'softinnBE_plugin_menu_setup'));
        }

        //add custom settings link
        public function settings_link( $links ) {
            $settings_link = '<a href="admin.php?page=softinn_booking_engine">Settings</a>';
            array_push( $links, $settings_link ); //inject 
            return $links;
        }

        //activate the plugin
        function activate() {
            //require_once plugin_dir_path( __FILE__ ) . 'inc/softinn-booking-engine-activate.php';
            //SoftinnBEActivate::activate();
        }

        //deactivate the plugin
        function deactivate() {
            //require_once plugin_dir_path( __FILE__ ) . 'inc/softinn-booking-engine-deactivate.php';
            //SoftinnBEDeactivate::deactivate();
        }

        //admin menu setup
        function softinnBE_plugin_menu_setup() {
            add_menu_page('Softinn Hotel Booking Engine', 'Softinn BE', 'manage_options', 'softinn_booking_engine', array($this,'admin_index'), plugins_url('/assets/images/icon-256x256.png', __FILE__));
        }

        //admin form
        public function admin_index() {
            if (isset($_POST['softinn_hotel_id'])) {
                check_admin_referer('softinn_save_settings', 'softinn_nonce');
                $hotel_id = preg_replace('/[^0-9]/', '', wp_unslash($_POST['softinn_hotel_id']));
                update_option('softinn_hotel_id', $hotel_id);
            }
            require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
        }

        //setup the shortcode
        public function iframe_plugin_add_shortcode_cb() {
            
            //initialize the html
            $html = '';

            $hotel_id = get_option('softinn_hotel_id');
            
            // check if hotelId is not null or an empty string and append the value taken from db to the html link
            if($hotel_id !== null && $hotel_id !== '') {
                $html .= '<iframe class="softinn-booking-engine" frameborder="0" src="' . esc_url('https://be.mysoftinn.com/bookhotelroom/' . rawurlencode($hotel_id)) . '" > </iframe>' ;
            }
            else {
                $html .= '<p>'.esc_html('Please insert your hotel ID in Softinn BE plugin setting.').'</p>';
            }
            return $html;
        } 

        // enqueue all our scripts for the frontend
        function softinn_enqueue_front(){
            // CSS
            wp_register_style('softinn_tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
            wp_enqueue_style('softinn_tailwind');
            wp_enqueue_style('softinn-iframe-css', plugins_url( '/assets/iframe.css', __FILE__ ) );
            wp_enqueue_style('softinn-jq-ui-css', plugins_url( '/assets/jquery-ui.min.css', __FILE__ ) );

            // JS
            //Custom JS
            wp_enqueue_script('softinn-datepicker-js', plugins_url( '/assets/datepicker.js', __FILE__ ), array('jquery', 'jquery-ui-datepicker'), '2.8', true);
            wp_enqueue_script ('softinn-iframe-js',plugins_url( '/assets/iframe.js', __FILE__ ), array('jquery'), '2.4', true);
        }

        // custom Admin Panel CSS
        function softinn_custom_admin_panel(){
            echo '<style>
                .toplevel_page_softinn_booking_engine img {
                    width: 20px;
                }
            </style>';
        }
    }

    //create class object
    $softinnBE = new SoftinnBE();
    $softinnBE->register(); //calling the hooked method thru this register function

    // activation
    register_activation_hook( __FILE__, array( $softinnBE, 'activate' ) );

    // deactivation
    register_deactivation_hook( __FILE__, array( $softinnBE, 'deactivate' ) );
}