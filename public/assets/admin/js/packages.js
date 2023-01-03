(function ($) {
    "use strict";
    $("#storage_input").hide();
    $('input[name="is_trial"]').on('change',function () {
        if ($(this).val() == 1) {
            $('#trial_day').show();
        } else {
            $('#trial_day').hide();
        }
        $('#trial_days').val(null);
    });
    $(document).on('click','#storage',function(){
        const isChecked = $(this).is(':checked');
        if(isChecked){
            $("#storage_input").show();
        }else{
            $("#storage_input").hide();
        }
    });
})(jQuery);
