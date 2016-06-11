jQuery(document).ready(function($){

    /**
     * Declaration of some variables.
     */
    var messages = $('#messages'),
        loadingSpinner = $('.loading-spinner');

    /**
     * AJAX form submit.
     */
    loadingSpinner.hide();

    $('.wordpress-ajax-form').on('submit', function(e) {
        loadingSpinner.show();
        e.preventDefault();

        var $form = $(this),
            action = $form.find('.wordpress-ajax-form-action').val();

        $.ajax({
            data: {
                action: action,
                data: $form.serialize()
            },
            type: 'post',
            url: AjaxProcess.ajaxurl,
            success: function() {
                loadingSpinner.hide();
                showMessage('<div class="updated update-nag"><p>'+AjaxProcess.success+'</p></div>');
            },
            error: function() {
                loadingSpinner.hide();
                showMessage('<div class="error update-nag"><p>'+AjaxProcess.error+'</p></div>');
            }
        });
    });

    function showMessage(msg) {
        messages.show();
        messages.html(msg)
        setTimeout(function() {
            messages.fadeOut('fast');
        }, 3000);
    }
});