<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


class Subtotal_Percentage_Shipping_Method extends WC_Shipping_Method {

	// holds percentage rate
	private $percentage_rate;

	/**
	 * Constructor. The instance ID is passed to this.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id                    = 'subtotal_percentage';
		$this->instance_id 			 = absint( $instance_id );
		$this->method_title          = __( 'Subtotal Percentage' );
		$this->method_description    = __( 'Charges a certain percentage of the cart subtotal as shipping fee' );
		$this->supports              = array(
			'shipping-zones',
			'instance-settings',
			'instance-settings-modal' // popup style settings page
		);
		// the settings available for this shipping method
		$this->instance_form_fields = array(
			'enabled' => array(
				'title' 		=> __( 'Enabled' ),
				'type' 			=> 'checkbox',
				'default' 		=> 'yes',
			),
			'title' => array(
				'title' 		=> __( 'Display Title' ),
				'type' 			=> 'text',
				'description' 	=> __( 'This controls the title which the user sees during checkout.' ),
				'default'		=> __( 'Subtotal percentage' ),
				'desc_tip'		=> true
			),
			'percentage_rate' => array(
				'title' 		=> __( 'Percentage Rate' ),
				'type' 			=> 'number',
				'description' 	=> __( 'Percentage of cart subtotal charged as shipping fee' ),
				'default'		=> 10, // 10% default percentage rate
				'desc_tip'      => true
			)
		);
		// gets options from settings
		$this->enabled		    = $this->get_option( 'enabled' );
		$this->title            = $this->get_option( 'title' );
		$this->percentage_rate  = $this->get_option( 'percentage_rate' );

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * calculate_shipping function.
	 * @param array $packages (default: array())
	 */
	public function calculate_shipping( $packages = array() ) {
		
		// note: this one gets just the cart subtotal without any tax and discounts
		$this->add_rate( array(
			'id'	=> $this->get_rate_id(),
			'label'	=> $this->title,
			'cost'	=> $packages['cart_subtotal'] * $this->percentage_rate / 100,
		) );

	}
}
