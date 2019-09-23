var epic_iframe = {};
( function($) {
    'use strict';

    function get_current_width(element)
    {
        var parent = $(element).parents('.vc_vc_column, .vc_vc_column_inner');
        var current_width = 12;
        var width = [];

        for(var i = 0; i < parent.length; i++) {
            var class_string = $(parent[i]).attr('class');
            var str_array = class_string.split(" ");
            for(var j = 0; j < str_array.length; j++) {
                var index = str_array[j].indexOf('vc_col-sm-');
                if(index === 0) {
                    var column_width = parseInt(str_array[j].substring(10));
                    width.push(column_width);
                }
            }
        }

        for(var k = 0; k < width.length; k++) {
            current_width = width[k] / 12 * current_width;
        }

        return  Math.ceil(current_width);
    }

    function prevent_duplicate(element, selector)
    {
        var length = $(element).find(selector).length;
        if(length > 1) {
            $(element).find(selector).each(function(index, value){
                if(index > 0) $(this).remove();
            });
        }
    }

    // Module JS
    window.epic_iframe.module_js = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");
        $(element).find('.jeg_module_hook').jmodule();
    };

    // Module Hero
    window.epic_iframe.hero_js = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");
        epic.hero.init(element);
    };

    // Newsticker
    window.epic_iframe.newsticker_js = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");
        $(element).find(".jeg_news_ticker").epicticker();
    };

    // Video Playlist
    window.epic_iframe.video_playlist_js = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");
        var width_element = get_current_width(element);
        var width_class = 'jeg_col_' + width_element;
        $(element).find(".jeg_video_playlist").addClass(width_class).jvidplaylist();
    };

    // Block link module
    window.epic_iframe.block_link_module = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");
        $(element).find(".jeg_blocklink .jeg_videobg").jvideo_background();
    };

    // Slider module
    window.epic_iframe.slider = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");
        $(element).epic_slider();
    };

    // Carousel module
    window.epic_iframe.carousel = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");
        $(element).epic_carousel();
    };

    // Row overlay. Prevent multiple row overlay generated
    window.epic_iframe.additional_row_option = function(model_id){
        var element = $("[data-model-id='" + model_id + "']");

        // Overlay
        prevent_duplicate(element, '.jeg_row_overlay');
        prevent_duplicate(element, '.jeg_top_ribon');
        prevent_duplicate(element, '.jeg_bottom_ribon');
    };
})(window.jQuery);
