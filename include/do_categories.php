<?php
defined("ABSPATH") or die("You cannot access it in this way.");

$option = get_option('nr_dowooma_products_categories');
$fee = get_option('nr_dowooma_products_fees');

if ($option == false || $option == " " || !is_array($option)) {

    $option = array();

}

?>

<h1>Add Donation Products Categories:</h1>

<?php

// Get all product categories
$product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
));

// Check if there are categories
if (!empty($product_categories) && !is_wp_error($product_categories)) {
    echo '<form id="nr_dowooma_cform">'; // Form opening tag (action should be adjusted based on your needs)

    // Loop through each category and create a checkbox
    foreach ($product_categories as $category) {

        if (in_array($category->term_id, $option)) {

            $check = "checked";

        } else {

            $check = "";

        }

        echo '<div>';
        echo '<input ' . $check . ' type="checkbox" id="cat_' . esc_attr($category->term_id) . '" name="product_categories[]" value="' . esc_attr($category->term_id) . '">';
        echo '<label for="cat_' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</label>';
        echo '</div>';
    }

    echo '<h2>Payment Fee (%):</h2>';

    echo '<input style="width:100px" type="number" name="payment_fee" min="0" step="0.001" value="' . $fee . '"><br>';

    echo '<input type="submit" id="nr_dowooma_cform_submit" value="Save Changes">';

    echo '</form>'; // Form closing tag
} else {
    echo '<p>' . __('No product categories found.', 'my-woocommerce-submenu') . '</p>';
}
