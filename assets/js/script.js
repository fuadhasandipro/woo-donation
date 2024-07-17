//qr code form submit

jQuery("#nr_dowooma_cform").on("submit", function (e) {
  e.preventDefault();

  jQuery("#nr_dowooma_cform_submit").val("Please wait...");

  var formdata = new FormData(this);
  formdata.append("action", "nr_dowooma_cform_action");

  jQuery.ajax({
    url: dowooma_script_objects.ajax_url,
    type: "post",
    data: formdata,
    contentType: false,
    processData: false,
    success: function (val) {
      alert("Settings Updated Successfully.");

      location.reload();
    },
    error: function () {
      alert("Something went wrong.");

      location.reload();
    },
  });
});

// //hide and show content

// function nr_dowooma_content_hide(cat_id){

//   jQuery(".dowooma_loop_content_div").css("height","0");
//   jQuery(".dowooma_loop_content_div").css("display","none");
//   jQuery(".dowooma_loop_content_div").css("opacity","0");
//   jQuery("#dowooma_loop_content_div_"+cat_id).css("display","block");
//   jQuery("#dowooma_loop_content_div_"+cat_id).css("opacity","1");
//   jQuery("#dowooma_loop_content_div_"+cat_id).css("height","auto");

// }

function nr_dowooma_content_hide(cat_id) {
  // Hide all content divs without transition
  jQuery(".dowooma_loop_content_div").each(function () {
    jQuery(this).css("height", "0");
    jQuery(this).css("display", "none");
  });

  // Show the selected content div with transition
  var contentDiv = jQuery("#dowooma_loop_content_div_" + cat_id);

  if (contentDiv.css("display") === "none") {
    contentDiv.css("display", "block");
    var height = contentDiv[0].scrollHeight;
    contentDiv.css("height", "0");
    contentDiv[0].offsetHeight; // Force reflow
    contentDiv.css("height", height + "px");

    // Remove the inline height style after the transition ends for auto height
    contentDiv.on("transitionend", function () {
      contentDiv.css("height", "auto");
    });
  }
}

//right icon onclick

function nr_dowooma_loop_pright_fn(i, pid) {
  var p_price = jQuery("#dowooma_loop_pac_price_" + i + "_" + pid).val();
  var p_quantity = jQuery("#dowooma_loop_pac_quantity_" + i + "_" + pid).val();

  var new_quantity = +p_quantity + 1;

  jQuery("#dowooma_loop_pac_quantity_" + i + "_" + pid).val(new_quantity);
  jQuery("#dowooma_loop_pquantity_" + i + "_" + pid).html(
    new_quantity * p_price
  );

  var total_price = jQuery("#dowooma_loop_ctprice_" + i).val();

  var nt_price = +total_price + +p_price;

  nt_price = nt_price.toFixed(2);

  jQuery("#dowooma_ctprice_total_" + i).html(nt_price);
  jQuery("#dowooma_loop_ctprice_" + i).val(nt_price);

  //for total price

  var mt_price = jQuery("#nr_dowooma_total_amount").val();
  var p_fee = jQuery("#nr_dowooma_additional_fee").val();
  var fee = +p_fee / 100;

  mt_price = +mt_price + +p_price;
  mt_price = mt_price.toFixed(2);

  jQuery("#nr_dowooma_total_amount").val(mt_price);

  if (+mt_price !== 0) {
    mt_price = +mt_price + mt_price * fee;

    mt_price = mt_price.toFixed(2);

    jQuery("#nr_dowooma_form_submit").val("SPENDEN 🤍 € (" + mt_price + ")");

    jQuery("#nr_dowooma_form_submit").css("display", "block");
  }

  // add the product id

  jQuery("#dowooma_loop_pids_" + i + "_" + pid).val(pid);
}

//left icon onclick

function nr_dowooma_loop_pleft_fn(i, pid) {
  var p_price = jQuery("#dowooma_loop_pac_price_" + i + "_" + pid).val();
  var p_quantity = jQuery("#dowooma_loop_pac_quantity_" + i + "_" + pid).val();

  if (+p_quantity !== 0) {
    var new_quantity = +p_quantity - 1;

    jQuery("#dowooma_loop_pac_quantity_" + i + "_" + pid).val(new_quantity);
    jQuery("#dowooma_loop_pquantity_" + i + "_" + pid).html(
      new_quantity * p_price
    );

    var total_price = jQuery("#dowooma_loop_ctprice_" + i).val();

    var nt_price = +total_price - +p_price;

    nt_price = nt_price.toFixed(2);

    jQuery("#dowooma_ctprice_total_" + i).html(nt_price);
    jQuery("#dowooma_loop_ctprice_" + i).val(nt_price);

    //for total price

    var mt_price = jQuery("#nr_dowooma_total_amount").val();
    var p_fee = jQuery("#nr_dowooma_additional_fee").val();
    var fee = +p_fee / 100;

    mt_price = +mt_price - +p_price;
    mt_price = mt_price.toFixed(2);
    jQuery("#nr_dowooma_total_amount").val(mt_price);

    if (+mt_price !== 0) {
      mt_price = +mt_price + mt_price * fee;
      mt_price = mt_price.toFixed(2);

      jQuery("#nr_dowooma_form_submit").val("SPENDEN 🤍 € (" + mt_price + " )");

      jQuery("#nr_dowooma_form_submit").css("display", "block");
    } else {
      jQuery("#nr_dowooma_form_submit").css("display", "none");
    }

    // remove the product id

    if (+new_quantity == 0) {
      jQuery("#dowooma_loop_pids_" + i + "_" + pid).val("0");
    }
  } else {
    // remove the product id

    jQuery("#dowooma_loop_pids_" + i + "_" + pid).val("0");
  }
}

//add to cart

jQuery("#nr_dowooma_form").on("submit", function (e) {
  e.preventDefault();

  jQuery("#nr_dowooma_form_submit").css("display", "none");
  jQuery(".loading_WPNayo_dots").css("display", "block");

  var formdata = new FormData(this);
  formdata.append("action", "nr_dowooma_form_add_to_cart_action");

  jQuery.ajax({
    url: dowooma_script_objects.ajax_url,
    type: "post",
    data: formdata,
    contentType: false,
    processData: false,
    success: function (val) {
      if (val !== "error") {
        window.location.href = val;
      } else {
        alert("Something went wrong");
      }
    },
  });
});
