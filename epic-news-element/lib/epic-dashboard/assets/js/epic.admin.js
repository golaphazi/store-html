/*jslint browser:true */
(function ($) {
    "use strict";

    $.fn.do_action_notice = function() {
        var container = $(this),
            notice    = container.find('.epic-action-notice');

        notice.addClass('expanded').slideDown();

        notice.find('.fa').on('click', function(e)
        {
            e.stopPropagation();
            notice.removeClass('expanded').slideUp();
        });

        setTimeout( function()
        {
            if ( notice.hasClass('expanded') && !notice.hasClass('warning') )
            {
                notice.slideUp().removeClass('expanded');
            }
        }, 3000);
    };

    function do_copy_system_report() {
        $(".debug-report").on('click', function(e)
        {
            e.preventDefault();
            $(this).find('textarea').focus().select();
            document.execCommand('copy');
            $(this).do_action_notice();
        });
    }

    function plugin_accordion() {
        var wrapper = $('.epic-plugin-wrap')

        wrapper.find('.epic-plugin-heading').on('click', function(){
            var element = $(this), parent = element.parent()

            if ( !parent.hasClass('active') ) {
                wrapper.find('.epic-plugin-body').slideUp().parent().removeClass('active')
                parent.addClass('active').find('.epic-plugin-body').slideToggle()
            } else {
                parent.removeClass('active').find('.epic-plugin-body').slideUp()
            }
        })

        $(wrapper.find('.epic-plugin-body').get(0)).slideDown().parent().addClass('active')

        wrapper.find('.epic-plugin-item').each(function(){
            var element = $(this)

            if ('update' === element.attr('data-status')) {
                element.closest('.epic-plugin-group').find('.epic-plugin-heading .update').css('display','block')
            }
        })
    }

    function plugin_action() {
        var wrapper = $('.epic-plugin-wrap')

        wrapper.find('.epic-plugin-item .action .button').on('click', function(e){
            e.preventDefault()
            if (wrapper.hasClass('processing')) return false

            var button = $(this),
                container = button.closest('.epic-plugin-item'),
                nonce = wrapper.find('input[name="epic-dashboard-nonce"]').val(),
                status = container.attr('data-status'),
                slug = container.attr('data-slug'),
                path = container.attr('data-path')


            button.prepend('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>')
            container.find('.epic-action-notice').remove()
            container.find('.progress-bar').remove()
            container.prepend(
                $('<div class="progress-bar"><div class="progress-line"></div></div>').hide().fadeIn('fast')
            )
            wrapper.addClass('processing')
            container.addClass('processing')
            container.find('.progress-line').width(((Math.floor(Math.random() * 5) + 1)*10)+'%')

            ajax_plugin_action(container, nonce, slug, path, status)
        })
    }

    function ajax_plugin_action(container, nonce, slug, path, doing) {
        $.ajax({
            url : ajaxurl,
            type: 'post',
            data: {
                action: 'epic_ajax_plugin',
                slug  : slug,
                path  : path,
                nonce : nonce,
                doing : doing
            }
        })
        .done(function(response) {
            if ('install' == doing || 'update' == doing) {
                response = response.match(/\{"(?:[^{}]|)*\"}/)
                response = JSON.parse(response[0])
                container.find('.info').html(response.info)
                container.attr('data-path', response.path)
            }

            container.attr('data-status', response.doing)
            container.find('.progress-line').width('100%')
            container.find('.button .fa').remove()

            setTimeout(function() {
                container.closest('.epic-plugin-wrap').removeClass('processing')
                container.removeClass('processing')

                container.append('<div class="epic-action-notice '+ response.status +'" style="display: none;"><span>'+response.notice+'</span><i class="fa fa-times"></i></div>')
                container.do_action_notice()
            }, 800);
        })
    }

    // Ready function
    function do_ready() {
        do_copy_system_report()
        plugin_accordion()
        plugin_action()
    }

    $(document).ready(do_ready);
})(jQuery);
