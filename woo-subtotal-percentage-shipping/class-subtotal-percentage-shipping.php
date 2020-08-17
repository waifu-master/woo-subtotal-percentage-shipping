<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'woocommerce_shipping_init', 'subtotal_percentage_shipping_init' );

// defines the shipping method
function subtotal_percentage_shipping_init() {
	if (!class_exists('Subtotal_Percentage_Shipping')) {
		/**
		 * Subtotal_Percentage_Shipping class.
		 *
		 * @since		0.0.0
		 * @category	Class
		 * @author 		Wenzel Matthew
		 */
		class Subtotal_Percentage_Shipping extends WC_Shipping_Method {

			/**
			 * % rate to charge. Default is 10%
			 *
			 * @since		0.0.0
			 */
			private $percentage_rate = 10;

			/**
			 * Constructor
			 *
			 * @since		0.0.0
			 */
			public function __construct() {
				$this->id = 'subtotal_percentage';
				$this->method_title = __('Subtotal Percentage', 'subtotal_percentage');
				$this->method_description = __('Charges a certain percentage of the cart subtotal as shipping fee', 'subtotal_percentage');
				$this->init();
				$this->enabled = isset($this->settings['enabled']) ? $this->settings['enabled'] : 'yes';
				$this->title = isset($this->settings['title']) ? $this->settings['title'] : __('Subtotal Percentage', 'subtotal_percentage');
				$this->percentage_rate = isset($this->settings['percentage_rate']) ? $this->settings['deposit_percent'] : 10;
			}

			/**
			 * Loads setting API
			 *
			 * @since		0.0.0
			 */
			function init() {
				$this->init_form_fields();
				$this->init_settings();
				add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
			}

			/**
			 * Loads setting form fields
			 *
			 * @since		0.0.0
			 */
			function init_form_fields() {
				$this->form_fields = array(
					'enabled' => array(
						'title' => __('Enable', 'subtotal_percentage'),
						'type' => 'checkbox',
						'default' => 'yes'
					),
					'percentage_rate' => array(
						'title' => __('% of cart subtotal to charge', 'subtotal_percentage'),
						'type' => 'number',
						'default' => 10
					),
					'title' => array(
						'title' => __('Title', 'subtotal_percentage'),
						'type' => 'text',
						'default' => __('subtotal_percentage Shipping', 'subtotal_percentage')
					)
				);
			}

			/**
			 * Calculates shipping
			 *
			 * @since		0.0.0
			 */
			public function calculate_shipping($package {

				$subtotal = 0;
				$cost = 0;

				$subtotal = WC()->cart->get_cart_subtotal();
				$cost = $subtotal * $this->deposit_percent / 100;
				
				$rate = array(
				'id' => $this->id,
				'label' => $this->title,
				'cost' => $cost
				);

				$this->add_rate($rate);
			}

		}
	}
}