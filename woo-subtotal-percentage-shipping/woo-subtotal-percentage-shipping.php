<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Subtotal Percentage Shipping
 * Description:       Calculates shipping based on percentage of cart subtotal
 * Version:           0.0.0
 * Author:            dedbuck
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Plugin version
define( 'SUBTOTAL_PERCENTAGE_SHIPPING_VERSION', '0.0.0' );

/**
 * Includes the shipping method class
 *
 * @since    0.0.0
 */

require plugin_dir_path( __FILE__ ) . 'class-subtotal-percentage-shipping.php';

function add_subtotal_percentage_shipping_method( $methods ) {
    $methods['subtotal_percentage'] = 'Subtotal_Percentage_Shipping'; 
    return $methods;
}

add_filter( 'woocommerce_shipping_methods', 'add_subtotal_percentage_shipping_method' );