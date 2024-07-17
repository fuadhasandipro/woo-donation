<?php

defined("ABSPATH") or die("You cannot access it in this way.");

function nr_dowooma_get_simple_virtual_product_ids_by_category($category_id) {
    // Ensure WooCommerce functions are available
	if (!class_exists('WC_Product_Query')) {
		return array();
	}

    // Query for simple and virtual products in the given category
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $category_id,
				'operator' => 'IN',
			),
		),
		'meta_query' => array(
			array(
				'key'   => '_virtual',
				'value' => 'yes',
			),
		),
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $category_id,
				'operator' => 'IN',
			),
		),
	);

	$query = new WP_Query($args);
	$product_ids = array();

    // Loop through products and filter by type
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$product = wc_get_product(get_the_ID());
			if ($product->is_type('simple') && $product->is_virtual()) {
				$product_ids[] = $product->get_id();
			}
		}
		wp_reset_postdata();
	}

	return $product_ids;
}



// add to cart function 


function nr_dowooma_add_product_to_cart($product_id, $quantity) {
    // Ensure WooCommerce functions are available
	if (!class_exists('WC_Cart')) {
		return false;
	}

    // Check if the product exists and is a simple product
	$product = wc_get_product($product_id);
	if (!$product || !$product->is_type('simple')) {
		return false;
	}

    // Add the product to the cart
	$cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);

    // Check if the product was successfully added to the cart
	if ($cart_item_key) {
		return true;
	} else {
		return false;
	}
}



//payment fees.

add_action('woocommerce_cart_calculate_fees', 'nr_dowooma_add_custom_percentage_fee');

function nr_dowooma_add_custom_percentage_fee() {
    // Ensure WooCommerce functions are available
	if (!is_admin() && WC()->cart->is_empty() === false) {
        // Calculate 3% of the cart total
		$percentage = get_option('nr_dowooma_products_fees');

		if($percentage == true && !empty($percentage)){

			$fee=$percentage/100;

			$cart_total = WC()->cart->cart_contents_total;
			$fee = $cart_total * $fee;

        // Add the fee to the cart
			WC()->cart->add_fee(__('Payment Fee', 'your-text-domain'), $fee);

		}
	}
}


