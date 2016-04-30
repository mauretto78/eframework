jQuery(function($) {

    /**
     *  Slide toggle navigation.
     */
    var $window = $(window),
        toggleBtn = $('.toggle-btn'),
        navigation = $('.navigation');
    
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
    var editor = ace.edit("editor");
    editor.getSession().setMode("ace/mode/css");
});
