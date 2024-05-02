<?php
/**
 * Trigger this file on Plugin uninstall
 *
 * @package  SoftinnBE
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Clear Database stored data
delete_option('softinn_hotel_id');
delete_option('softinn_theme_color');
delete_option('softinn_theme_color_temp');
delete_option('softinn_admin_nonce');