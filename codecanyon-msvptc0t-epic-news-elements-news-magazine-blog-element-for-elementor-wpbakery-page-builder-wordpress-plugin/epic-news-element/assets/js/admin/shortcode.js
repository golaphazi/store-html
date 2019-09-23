/*jslint browser:true */
(function ($, api) {
    "use strict";

    tinymce.PluginManager.add('epic-shortcode', function (editor, url) {
        editor.addButton('epic-shortcode-generator', {
            title: 'Epic Generator',
            image: url + '/shortcode/generator.png',
            cmd: 'shortcode_list'
        });

        editor.addCommand('shortcode_list', function () {
            if (!api.shortcodepopup.has('epic')) {
                api.shortcodepopup.add('epic', new api.ShortCodeListPopup(editor));
            } else {
                var epic = api.shortcodepopup.instance('epic');
                epic.showPopup();
            }
        });
    });

})(jQuery, wp.customize);