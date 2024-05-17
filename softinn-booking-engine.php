<?php
/**
 * @package  SoftinnBE
 */
/**
 * Plugin Name: Softinn Hotel Booking Engine
 * Plugin URI:  https://wordpress.org/plugins/
 * Description: Hotel Booking Engine for boutique hotels in Asia. Customizable. Support local payment gateways (iPay88, Midtrans, eGHL, PayPal etc). Email and SMS notification. Rule-based promotion code system.
 * Version:     2.1.3
 * Author:      Softinn Solutions Sdn Bhd
 * Author URI:  https://www.mysoftinn.com/
 * License:     GPL3
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
			add_action('admin_enqueue_scripts', array( $this, 'softinn_enqueue_back' ) );
			add_action('wp_enqueue_scripts', array($this,'softinn_enqueue_front') );
			add_action('admin_head', array($this,'softinn_custom_admin_panel'));
			add_option('softinn_hotel_id'); //create new option_name row
			add_option('softinn_theme_color');
			add_option('softinn_theme_color_temp');
			add_option('softinn_admin_nonce');
			include_once(ABSPATH . 'wp-includes/pluggable.php'); //inlude pluggable.php to use wp_get_current_user
			include_once('inc/softinn-calendarwidget.php'); //include the widget file
		}

		//hook method here
		function register() {
			add_shortcode('softinnBE', array( $this, 'iframe_plugin_add_shortcode_cb'));
			add_filter( "plugin_action_links_$this->plugin_name", array( $this, 'settings_link' ) );
			add_action( 'widgets_init', function(){register_widget( 'Softinn_CalendarWidget' );});
			//check if the user is who they claim to be
			if(current_user_can('administrator')){
				 add_action('admin_menu', array( $this, 'softinnBE_plugin_menu_setup')); //admin menu will show-up if the user is admin
				 $requestNonce =wp_create_nonce('form-nonce'); //create nonce if the user is admin
				 update_option('softinn_admin_nonce',$requestNonce);
			} 
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
			
			$requestNonce = get_option('softinn_admin_nonce');
		
			//if the nonce doesn't match
			if(!wp_verify_nonce( $requestNonce, 'form-nonce' )){
			
				wp_die("Admin Form Hidden (nonce verification fail)");
			}

			if(isset($_POST["softinn_hotel_id"])) { 
				update_option('softinn_hotel_id', sanitize_text_field( $_POST["softinn_hotel_id"] ));//update the value in db, from the POST 
				update_option('softinn_theme_color',sanitize_hex_color( $_POST["softinn_theme_color"] ));
				
				//take the value of color from db, then remove the #, then save it to db
				$temp = get_option('softinn_theme_color');
				$remove_hash = substr($temp, strpos($temp, "#") + 1);  
				update_option('softinn_theme_color_temp',sanitize_hex_color_no_hash( $remove_hash ));  
			}
			require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';//call the admin html form
		}

		//setup the shortcode
		public function iframe_plugin_add_shortcode_cb() {
			
			//initialize the html
			$html = '';

			//get variable from db
			$hotel_id = get_option('softinn_hotel_id');
			$theme_color = get_option('softinn_theme_color_temp');
			
			// check if hotelId is not null or an empty string and append the value taken from db to the html link
			if($hotel_id !== null && $hotel_id !== '') {
				$html .= '<iframe class="softinn-booking-engine" frameborder="0" src="https://booking.mysoftinn.com/BookHotelRoom/Web?hotelId=' . $hotel_id . '&themeColor='. $theme_color . '" autosize="true" > </iframe>' ;
			}
			else {
				$html .= '<p>'.esc_html('Please insert your hotel ID in Softinn BE plugin setting.').'</p>';
			}
			return $html;
		} 

		// enqueue all our scripts for the backend
		function softinn_enqueue_back() {
			wp_enqueue_style( 'wp-color-picker');
			wp_enqueue_script( 'softinn-wp-color-picker', plugins_url( '/assets/iris-init.js', __FILE__ ), array( 'wp-color-picker' ), false, true  );
		}

		// enqueue all our scripts for the frontend
		function softinn_enqueue_front(){
			// CSS
			wp_register_style('softinn_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
			wp_enqueue_style('softinn_bootstrap');
			wp_enqueue_style('softinn-iframe-css', plugins_url( '/assets/iframe.css', __FILE__ ) );
			wp_enqueue_style('softinn-jq-ui-css', plugins_url( '/assets/jquery-ui.min.css', __FILE__ ) );
			wp_enqueue_style('softinn-font-awesome-css', plugins_url( '/assets/all.css', __FILE__ ) );

			// JS
			wp_enqueue_script('jquery', plugins_url( '/assets/jquery-3.5.0.min.js', __FILE__ ), array(), '3.5.0', true);
			wp_enqueue_script('jquery-ui', plugins_url( '/assets/jquery-ui.min.js', __FILE__ ), array(), '1.12.1', true);
			wp_register_script('softinn_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
			wp_enqueue_script('softinn_bootstrap');
			wp_enqueue_script('softinn-iframe-resize-js', plugins_url( '/assets/iframeResizer.min.js', __FILE__ ), array('jquery'));

			//Custom JS
			wp_enqueue_script ('softinn-datepicker-js',plugins_url( '/assets/datepicker.js', __FILE__ ));
			wp_enqueue_script ('softinn-iframe-js',plugins_url( '/assets/iframe.js', __FILE__ ));
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