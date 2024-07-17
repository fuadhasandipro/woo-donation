<?php

defined("ABSPATH") or die("You cannot access it in this way.");

ob_start();

?>

<form id="nr_dowooma_form">




	<?php

$option = get_option('nr_dowooma_products_categories');
$fee = get_option('nr_dowooma_products_fees');

if (!empty($option) && is_array($option)) {

    $i = 1;

    foreach ($option as $cat_id) {

        if ($i == 1) {

            $dstyle = "style='display:block;height:auto'";
        } else {
            $dstyle = "";
        }

        $category = get_term($cat_id, 'product_cat');
        $category_name = $category->name;

        $product_ids = nr_dowooma_get_simple_virtual_product_ids_by_category($cat_id);

        if (count($product_ids) > 0) {

            ?>


				<div class="dowooma_loop_mdiv">

					<div onclick="nr_dowooma_content_hide(<?php echo $i; ?>)" class="dowooma_loop_cdiv" id="dowooma_loop_cdiv_<?php echo $i; ?>">


						<div class="dowooma_loop_icon_div">
							<i class="fa fa-chevron-down"></i>
						</div>

						<div class="dowooma_loop_cname_div">
							<?php echo $category_name; ?>
						</div>

						<div class="dowooma_loop_cprice_div">
							<span id="dowooma_ctprice_total_<?php echo $i; ?>">0,00 </span> <?php echo get_woocommerce_currency_symbol(); ?>
						</div>

						<input type="hidden" value="0" name="" id="dowooma_loop_ctprice_<?php echo $i; ?>">


					</div>



					<div <?php echo $dstyle; ?> class="dowooma_loop_content_div" id="dowooma_loop_content_div_<?php echo $i; ?>">

						<?php

            foreach ($product_ids as $pid) {

                $p_title = get_the_title($pid);
                // Get the product
                $product = wc_get_product($pid);
                if ($product && $product->is_type('simple')) {
                    $p_price = $product->get_price(); // Get the product price
                    $p_price = number_format($p_price, 2, '.', '');

                    ?>



								<div class="dowooma_loop_pdiv" id="dowooma_loop_pdiv_<?php echo $i . "_" . $pid; ?>">

									<div class="dowooma_loop_ptitle">

										<?php echo $p_title; ?>

									</div>


									<div class="dowooma_loop_pprice">
										<?php echo $p_price . get_woocommerce_currency_symbol(); ?>
									</div>


									<div class="dowooma_loop_pquantity">
										<span class="dowooma_pprice_left price_left" onclick="nr_dowooma_loop_pleft_fn(<?php echo $i . "," . $pid; ?>)"><i class="fa fa-minus"></i></span>
										<span class="dowooma_pprice_middle price_middle" id="dowooma_loop_pquantity_<?php echo $i . "_" . $pid; ?>">0</span>
										<span class="dowooma_pprice_right price_right" onclick="nr_dowooma_loop_pright_fn(<?php echo $i . "," . $pid; ?>)"><i class="fa fa-plus"></i></span>

									</div>

									<input type="hidden" name="" id="dowooma_loop_pac_price_<?php echo $i . "_" . $pid; ?>" value="<?php echo $p_price; ?>">


									<input type="hidden" name="dowooma_loop_pac_quantity_<?php echo $i . "_" . $pid; ?>" id="dowooma_loop_pac_quantity_<?php echo $i . "_" . $pid; ?>" value="0">

									<input type="hidden" name="dowooma_loop_pids_<?php echo $i; ?>[]" id="dowooma_loop_pids_<?php echo $i . "_" . $pid; ?>" value="0">


								</div>

						<?php
}
            }

            ?>






					</div>



				</div>





		<?php

            $i++;
        }
    }
    ?>


		<div class="bottom_bar">
			<input type="hidden" id="nr_dowooma_total_amount" value="0">
			<input type="submit" name="submit" id="nr_dowooma_form_submit" value="Add To Cart">


			<div class="loading_WPNayo_dots">
				<span class="WPNayo_dot"></span>
				<span class="WPNayo_dot"></span>
				<span class="WPNayo_dot"></span>
				<span class="WPNayo_dot"></span>
				<span class="WPNayo_dot"></span>
			</div>

			<input type="hidden" name="nr_dowooma_additional_fee" id="nr_dowooma_additional_fee" value="<?php echo $fee; ?>">

		</div>



</form>

<?php

}
