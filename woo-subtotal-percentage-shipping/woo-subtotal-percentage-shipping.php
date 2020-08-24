<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Subtotal Percentage Shipping for Woocommerce
 * Description:       Calculates shipping based on percentage of cart subtotal
 * Version:           0.0.3
 * Author:            dedbuck
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Plugin version
define( 'SUBTOTAL_PERCENTAGE_SHIPPING_VERSION', '0.0.3' );

/**
 * Includes the shipping method class
 *
 * @since    0.0.0
 */

//

function subtotal_percentage_shipping_method_init() {
    if ( ! class_exists( 'Subtotal_Percentage_Shipping_Method' ) ) {
        require plugin_dir_path( __FILE__ ) . 'class-subtotal-percentage-shipping.php';
    }
}

add_action( 'woocommerce_shipping_init', 'subtotal_percentage_shipping_method_init' );

function add_subtotal_percentage_shipping_method( $methods ) {
    $methods['subtotal_percentage'] = 'Subtotal_Percentage_Shipping_Method';
    return $methods;
}

add_filter( 'woocommerce_shipping_methods', 'add_subtotal_percentage_shipping_method' );