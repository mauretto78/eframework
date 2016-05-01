jQuery(function($) {

    /**
     * Declaration of all variables.
     */
    var $window = $(window),
        toggleBtn = $('.toggle-btn'),
        navigation = $('.navigation'),
        panel = $('.panel'),
        editor = ace.edit("editor");

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
    editor.getSession().setMode("ace/mode/css");
});
