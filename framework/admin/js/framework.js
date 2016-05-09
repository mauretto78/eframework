jQuery(document).ready(function($){

    /**
     * Declaration of some variables.
     */
    var $window = $(window),
        toggleBtn = $('.toggle-btn'),
        navigation = $('.navigation'),
        panel = $('.panel'),
        aceExists = $('.ace-textarea').length,
        loadingSpinner = $('#loading-spinner'),
        saveIcon = $('#save-icon');

    /**
     * Panel tabs.
     */
    navigation.find("li > a").on("click",function(e){
        var $this = $(this),
            target = $this.data("target");

        navigation.find("li > a").removeClass('active');
        $(this).addClass('active');
        panel.addClass('hidden').filter(target).removeClass('hidden');

        e.preventDefault();
    });

    /**
     *  Slide toggle navigation (mobile devices).
     */
    toggleBtn.on('click',function () {
        navigation.slideToggle(300);
    });

    /**
     * On window resize call toggleNavigation().
     */
    $window.resize(function () {
        toggleNavigation();
    });

    /**
     * Show/hide navigation on the base of window size.
     */
    function toggleNavigation() {
        var windowsize = $window.width();
        if (windowsize > 767) {
            navigation.show();
        } else {
            navigation.hide();
        }
    }

    /**
     * Ace editor.
     */
    if(aceExists){
        editor = ace.edit("editor");
        editor.getSession().setMode("ace/mode/css");
        var textarea = $('.ace-textarea').hide();

        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function(){
            textarea.val(editor.getSession().getValue());
        });
    }

    /**
     * tinyMCE editor.
     */
    tinyMCE.init({
        mode : "specific_textareas",
        theme : "modern",
        /*plugins : "autolink, lists, spellchecker, style, layer, table, advhr, advimage, advlink, emotions, iespell, inlinepopups, insertdatetime, preview, media, searchreplace, print, contextmenu, paste, directionality, fullscreen, noneditable, visualchars, nonbreaking, xhtmlxtras, template",*/
        editor_selector :"tinymce-enabled"
    })

    /**
     * AJAX form submit.
     */
    loadingSpinner.hide();

    $('.wordpress-ajax-form').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this),
            action = $form.find('.wordpress-ajax-form-action').val();

        $.ajax({
            data: {
                action: action,
                data: $form.serialize()
            },
            type: 'post',
            url: ajaxurl,
            success: function(success) {
                console.log('Ajax request successfully sent. Response: ' + success);
            },
            error: function(error) {
                console.log('Ajax request error. Response: ' + error);
            }
        });
    });

    /**
     * JQuery UI sortable.
     */
    $('#ef-slider-sortable').sortable();

});
