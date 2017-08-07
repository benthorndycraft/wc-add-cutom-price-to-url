<?php
/**
 * Plugin Name: WooCommerce Add Custom Price To URL
 * Plugin URI: https://github.com/benthorndycraft/wc-add-cutom-price-to-url
 * Description: Allow selected products to have a price set in the URL
 * Version: 1.0.1
 * Author: Ben Thorndycraft
 * Author URI: http://overlima.com/
 *
 * Copyright: © 2017 Ben Thorndycraft
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


//BT: add price to url

add_filter('woocommerce_add_cart_item', 'set_woo_prices');
add_filter('woocommerce_get_cart_item_from_session', 'set_session_prices', 20, 3);

function set_woo_prices($woo_data)
{
	$setUrlPrice = get_post_meta( $woo_data['product_id'] , 'url_price_checkbox' , true );
	if ( $setUrlPrice != 'yes' || !isset($_GET['price']) || empty ($_GET['price'])) {
		return $woo_data;
	}
	$woo_data['data']->set_price($_GET['price']);
	$woo_data['my_price'] = $_GET['price'];
	return $woo_data;
}

function set_session_prices($woo_data, $values, $key)
{
	$setUrlPrice = get_post_meta( $woo_data['product_id'] , 'url_price_checkbox' , true );
	$test =1;
	if ( $setUrlPrice != 'yes' || !isset($woo_data['my_price']) || empty ($woo_data['my_price'])) {
		return $woo_data;
	}

	$woo_data['data']->set_price($woo_data['my_price']);
	return $woo_data;
}

// Display Url Price checkbox using WooCommerce Action Hook
add_action( 'woocommerce_product_options_general_product_data', 'woocommerce_general_product_data_custom_field' );

function woocommerce_general_product_data_custom_field() {
	global $woocommerce, $post;
	echo '<div class="options_group">';
	woocommerce_wp_checkbox(
		array(
			'id' => 'url_price_checkbox',
			'wrapper_class' => 'checkbox_class',
			'label' => __('Allow URL Price', 'woocommerce' ),
			'description' => __( 'Set the price by adding a param to the url: <code>&price=12.34</code>', 'woocommerce' )
		)
	);
	echo '</div>';
}

// Save Fields using WooCommerce Action Hook
add_action( 'woocommerce_process_product_meta', 'woocommerce_process_product_meta_fields_save' );
function woocommerce_process_product_meta_fields_save( $post_id ){
	$woo_checkbox = isset( $_POST['url_price_checkbox'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, 'url_price_checkbox', $woo_checkbox );
}