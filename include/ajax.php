<?php

defined("ABSPATH") or die("You cannot access it in this way.");

//For update settings action
add_action("wp_ajax_nr_dowooma_cform_action", "nr_dowooma_cform_action_function");
add_action("wp_ajax_nopriv_nr_dowooma_cform_action", "nr_dowooma_cform_action_function");

function nr_dowooma_cform_action_function() {

    if (isset($_POST['product_categories'])) {

        $option = $_POST['product_categories'];
        $fee = $_POST['payment_fee'];

        update_option('nr_dowooma_products_categories', $option);
        update_option('nr_dowooma_products_fees', $fee);

        wp_die();

    }

}

//For update settings action
add_action("wp_ajax_nr_dowooma_form_add_to_cart_action", "nr_dowooma_form_add_to_cart_action_function");
add_action("wp_ajax_nopriv_nr_dowooma_form_add_to_cart_action", "nr_dowooma_form_add_to_cart_action_function");

function nr_dowooma_form_add_to_cart_action_function() {

    if (isset($_POST['action'])) {

        $option = get_option('nr_dowooma_products_categories');

        if (!empty($option) && is_array($option)) {

            $i = 1;

            foreach ($option as $cat_id) {

                if (isset($_POST["dowooma_loop_pids_" . $i])) {

                    $product_ids = $_POST["dowooma_loop_pids_" . $i];

                    if (is_array($product_ids)) {

                        foreach ($product_ids as $pid) {

                            if ($pid !== 0) {

                                $product = wc_get_product($pid);
                                if ($product && $product->is_type('simple')) {

                                    if (isset($_POST["dowooma_loop_pac_quantity_" . $i . "_" . $pid])) {

                                        $quantity = $_POST["dowooma_loop_pac_quantity_" . $i . "_" . $pid];

                                        if ($quantity !== 0) {

                                            if (nr_dowooma_add_product_to_cart($pid, $quantity)) {

                                                $nayo = "success";

                                            }
                                            //quantity !==0
                                        }

                                        //isset quantity
                                    }

                                    //is simple
                                }

                                //not ==0
                            }

                            //pid foreach close
                        }

                        //array checking close
                    }

                    //isset close
                }

                $i++;

                // i foreach close
            }

        }

        if ($nayo == "success") {

            $cart_url = wc_get_cart_url();

            echo $cart_url;

            wp_die();

        } else {

            echo "error";

            wp_die();
        }

    }

}