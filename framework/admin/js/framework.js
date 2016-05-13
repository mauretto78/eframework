jQuery(document).ready(function($){

    /**
     * Declaration of some variables.
     */
    var $window = $(window),
        toggleBtn = $('.toggle-btn'),
        navigation = $('.navigation'),
        panel = $('.panel'),
        aceExists = $('.ace-textarea').length,
        addSlide = $('.add-slide'),
        sliderSortable = $('#ef-slider-sortable');

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
     * Append slides and sort with JQuery UI sortable.
     */
    addSlide.on('click', function(e){

        var template = '<div id="slide-1" class="ef-slide clearfix">';
        template += '<div class="ef-slide-delete"><i class="fa fa-close"></i></div>';
        template += '<input type="hidden" class="ef-slide-img-value">';
        template += '<div class="ef-slide-img"><a class="media-upload">upload</a></div>';
        template += '<div class="ef-slide-text">';
        template += '<input type="text" class="ef-slide-input" placeholder="title here">';
        template += '<textarea rows="4" class="ef-slide-textarea" placeholder="caption here"></textarea>';
        template += '<input type="text" class="ef-slide-link" placeholder="link here">';
        template += '</div>';

        sliderSortable.append(template);

        e.preventDefault();
    });

    sliderSortable.on("click", ".ef-slide-delete", function(e) {

        var $this = $(this),
            slide = $this.parents('.ef-slide');

        slide.remove();

        e.preventDefault();
    });

    sliderSortable.sortable();

});
