(function ($) {
    'use strict';

    // New Select Mechanism
    var ajaxCall = function (query, callback) {
        var field = this;
        if (!query.length || query.length < 3) return callback();

        var request = wp.ajax.send(field.ajax, {
            data: {
                query: query,
                nonce: field.nonce
            }
        });

        request.done(function (response) {
            callback(response);
        });
    };

    $('.vc-select-wrapper').each(function () {
        var ajax = $(this).data('ajax'),
            multiple = $(this).data('multiple'),
            nonce = $(this).data('nonce'),
            input, setting;

        if (multiple > 1) {
            var optionText = $(this).find(".data-option").text();
            var options = JSON.parse(optionText);
            input = $(this).find('input');

            setting = {
                plugins: ['drag_drop', 'remove_button'],
                multiple: multiple,
                hideSelected: true,
                persist: true,
                options: options,
                render: {
                    option: function (item) {
                        return '<div><span>' + item.text + '</span></div>';
                    }
                }
            };
        } else {
            input = $(this).find('select');
            setting = {
                allowEmptyOption: true
            };
        }

        if (ajax !== '') {
            setting.load = ajaxCall.bind({
                ajax: ajax,
                nonce: nonce
            });
            setting.create = true;
        }

        $(input).selectize(setting);
    });

    // Number.js
    $('.number-input-wrapper input[type=text]').each(function () {
        var element = this,
            min = $(this).attr('min'),
            max = $(this).attr('max'),
            step = $(this).attr('step');

        $(element).spinner({
            min: min,
            max: max,
            step: step
        });
    });

    // Checkblock.js
    $('.wp-tab-panel.vc_checkblock').each(function () {
        var parent = this;
        var input = $(parent).find('.wpb-input');

        $(this).find('.checkblock').bind('click', function () {
            var result = [];
            $(parent).find('.checkblock').each(function () {
                if ($(this).is(":checked")) {
                    result.push($(this).val());
                }
            });
            $(input).val(result);
        });
    });

    // Radioimage.js
    window.vc.atts.radioimage = {
        init: function (param, $field) {
            $('.radio-image-wrapper label input', $field).change(function () {
                var $input = $(this).closest('.radio-image-wrapper').find('.wpb_vc_param_value');
                $input.val($(this).val()).trigger('change');
            });
        }
    };

    // Slider.js
    $('.slider-input-wrapper').each(function () {
        var element = $(this).find('input[type=range]');

        element.on('mousedown', function () {
            $(this).mousemove(function () {
                var value = $(this).attr('value');
                $(this).closest('div').find('.jeg_range_value .value').text(value);
            });
        });

        element.click(function () {
            var value = $(this).attr('value');
            $(this).closest('div').find('.jeg_range_value .value').text(value);
        });

        $(this).find('.jeg-slider-reset').click(function () {
            thisInput = $(this).parent().find('input');
            inputDefault = thisInput.data('reset_value');
            thisInput.val(inputDefault);
            thisInput.change();

            $(this).parent().find('.jeg_range_value .value').text(inputDefault);
        });
    });

    // File.js
    $(".input-uploadfile").each(function () {
        var element = this;
        var input = $(element).find('input[type="text"]');

        $(this).find('.selectfileimage').bind('click', function (e) {
            e.preventDefault();

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function () {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                var url = attachment.url;
                input.val(url);
            });

            //Open the uploader dialog
            custom_uploader.open();
        });
    });
})(window.jQuery);
