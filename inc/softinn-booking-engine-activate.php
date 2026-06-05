<?php
/**
 * @package  SoftinnBE
 */
class SoftinnBEActivate
{
    public static function activate() {
        add_option( 'softinn_hotel_id', '' );
        add_option( 'softinn_theme_color', '#8ebc00' );
        add_option( 'softinn_theme_color_temp', '8ebc00' );
    }
}