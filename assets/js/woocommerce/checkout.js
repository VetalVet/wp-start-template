jQuery('#appform').change(function() {
    if (this.files.length) {
        const file = this.files[0];
        const formData = new FormData();
        formData.append('appform', file);
        jQuery.ajax({
            url: wc_checkout_params.ajax_url + '?action=appformupload',
            type: 'POST',
            data: formData,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(response) {
                jQuery('input[name=\"appform_field\"]').val(response);
            }
        });
    }
});