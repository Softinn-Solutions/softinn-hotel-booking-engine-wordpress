<?php
/**
 * @package  SoftinnBE
 */
/**
 * Plugin Name: Softinn Booking Engine
 * Plugin URI:  https://wordpress.org/plugins/
 * Description: Display Softinn Booking Engine iframe using Shortcode. Admin plugin menu setting to set the Hotel Id and Theme Color.
 * Version:     1.0.0
 * Author:      Softinn Solutions Sdn Bhd
 * Author URI:  https://www.mysoftinn.com/
 * License:     GPL3
 */
 /*
	Softinn Booking Engine. To display Softinn Booking Engine iframe using Shortcode. 
	Admin Plugin Setting to set the Hotel Id and Theme Color.
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
			add_option( 'softinn_hotel_id'); //create new option_name row
			add_option( 'softinn_theme_color');
			add_option( 'softinn_theme_color_temp');
			add_option( 'softinn_admin_nonce');
			include_once(ABSPATH . 'wp-includes/pluggable.php'); //inlude pluggable.php to use wp_get_current_user
		}

		//hook method here
		function register() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'wp_enqueue_scripts', array($this,'enqueue_iframe') );
			//add_action( 'admin_notices', 'softinnBE_admin_notice_success' );
			//add_action( 'admin_notices', 'softinnBE_admin_notice_error' );
			add_shortcode('softinnBE', array( $this, 'iframe_plugin_add_shortcode_cb'));
			add_filter( "plugin_action_links_$this->plugin_name", array( $this, 'settings_link' ) );
			
			//check if the user is who they claim to be
			if(current_user_can('administrator')){
				 add_action('admin_menu', array( $this, 'softinnBE_plugin_menu_setup')); //admin menu will show-up if the user is admin
				 $requestNonce =wp_create_nonce('form-nonce'); //create nonce if the user is admin
				 update_option('softinn_admin_nonce',$requestNonce);
			} 
		}

		/*
		function softinnBE_admin_notice_success() {
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php _e( 'Done!', 'sample-text-domain' ); ?></p>
			</div>
			<?php
		}
		
		function softinnBE_admin_notice_error() {
			$class = 'notice notice-error';
			$message = __( 'Irks! An error has occurred.', 'sample-text-domain' );
		
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
		}
		*/

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

		//admin menu setup
		function softinnBE_plugin_menu_setup() {
			add_menu_page('Softinn Booking Engine Setting', 'Softinn BE ', 'manage_options', 'softinn_booking_engine', array($this,'admin_index'), 'dashicons-admin-multisite');
		}

		//admin form
		public function admin_index() {
			global $wpdb;
		
			$requestNonce = get_option('softinn_admin_nonce');
		
			//if the nonce doesn't match
			if(!wp_verify_nonce( $requestNonce, 'form-nonce' )){
			
				wp_die("Admin Form Hidden (nonce verification fail)");
			}

			//echo 'test';
			if(isset($_POST["softinn_hotel_id"])) { 
				update_option('softinn_hotel_id', sanitize_text_field( $_POST["softinn_hotel_id"] ));//update the value in db, from the POST 
				update_option('softinn_theme_color',sanitize_hex_color( $_POST["softinn_theme_color"] ));
				
				//take the value of color from db, then remove the #, then save it to db
				$temp = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_name = 'softinn_theme_color'");
				$remove_hash = substr($temp, strpos($temp, "#") + 1);  
				update_option('softinn_theme_color_temp',sanitize_hex_color_no_hash( $remove_hash ));  
			}
			require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';//call the admin html form
		}

		//setup the shortcode
		function iframe_plugin_add_shortcode_cb() {
			global $wpdb;

			//get variable from db
			$hotel_id = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_name = 'softinn_hotel_id'");
			$theme_color = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_name = 'softinn_theme_color_temp'");
			
			// check if hotelId has been set and append the value taken from db to the html link
			if(isset($hotel_id)) {
				$html .= '<iframe class="softinn-booking-engine" frameborder="0" src="https://booking.mysoftinn.com/BookHotelRoom/Web?hotelId=' . $hotel_id . '&themeColor='. $theme_color . '" autosize="true" > </iframe>' ;
			}
			else {
				$html .= '<p>'.esc_html('Please insert your hotel ID in Softinn BE plugin setting.').'</p>';
			}
			return $html;
		} 

		// enqueue all our scripts
		function enqueue() {
			wp_enqueue_style( 'wp-color-picker');
			wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/iris-init.js', __FILE__ ), array( 'wp-color-picker' ), false, true  );
			
		}

		function enqueue_iframe(){
			wp_enqueue_script ('booking-js',plugins_url( '/assets/iframe.js', __FILE__ ));
			wp_enqueue_style( 'iframe-css', plugins_url( '/assets/iframe.css', __FILE__ ) );
		}
	}

	//create class object
	$softinnBE = new SoftinnBE();
	$softinnBE->register(); //calling the hooked method thru this register function

	// activation
	register_activation_hook( __FILE__, array( $softinnBE, 'activate' ) );

	// deactivation
	//require_once plugin_dir_path( __FILE__ ) . 'inc/softinn-booking-engine-deactivate.php';
	register_deactivation_hook( __FILE__, array( $softinnBE, 'deactivate' ) );
}