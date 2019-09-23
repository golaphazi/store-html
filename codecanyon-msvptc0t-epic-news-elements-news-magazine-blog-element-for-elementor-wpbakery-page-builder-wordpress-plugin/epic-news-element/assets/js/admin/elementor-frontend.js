(function ($) {
    'use strict';

    /** elementor element hook **/

    function element_ready_hook() {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function (element) {


            // hook module
            $(element).find('.jeg_module_hook').jmodule();

            // hero module
            epic.hero.init(element);

            // news ticker
            $(element).find(".jeg_news_ticker").epicticker();

            // carousel
            $(element).epic_carousel();

            // block link
            $(element).find(".jeg_blocklink .jeg_videobg").jvideo_background();

            // slider
            $(element).epic_slider();

            // video playlist
            $(element).find(".jeg_video_playlist").addClass('jeg_col_4').jvidplaylist();

        });
    }

    function do_ready() {
        element_ready_hook();
    }

    $(document).ready(do_ready);

})(jQuery);
