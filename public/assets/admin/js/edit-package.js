(function ($) {
    "use strict";
    if (permission.includes("Storage Limit")) {
        $("#storage_input").show();
    } else {
        $("#storage_input").hide();
    }
    $('input[name="is_trial"]').on('change', function () {
        if ($(this).val() == 1) {
            $('#trial_day').show();
        } else {
            $('#trial_day').hide();
        }
        $('#trial_days_2').val(null);
        $('#trial_days_1').val(null);
    });
    $(document).on('click', '#storage', function () {
        const isChecked = $(this).is(':checked');
        if (isChecked) {
            $("#storage_input").show();
        } else {
            $("#storage_input").hide();
        }
    });

    // for shop managemnt
    if (permission.includes("Shop Management")) {
        $("#products_input").show();
        $("#product_orders_input").show();
    } else {

        $("#products_input").hide();
        $("#product_orders_input").hide();
    }
    $(document).on('click', '#shopManagement', function () {
        const isChecked = $(this).is(':checked');
        if (isChecked) {
            $("#products_input").show();
            $("#product_orders_input").show();
        } else {
            $("#products_input").hide();
            $("#product_orders_input").hide();
        }
    });
    // for vCard 
    if (permission.includes("vCard")) {

        $("#vCard_input").show();
    } else {
        $("#vCard_input").hide();
    }
    $(document).on('click', '#vCard', function () {
        const isChecked = $(this).is(':checked');
        if (isChecked) {
            $("#vCard_input").show();
        } else {
            $("#vCard_input").hide();
        }
    });
})(jQuery); 
