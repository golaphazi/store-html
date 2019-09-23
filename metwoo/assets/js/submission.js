//recaptcha render
var form = jQuery('.metform-form-content');
if(form.length > 0){
    var site_key = form.attr("site_key");
    if(site_key != ''){
        var onloadMetFormCallback = function() {
            var $recaptcha_site_key = jQuery('.recaptcha_site_key');

            $recaptcha_site_key.each(function (indx) {
                var $el = jQuery(this);

                $el.attr( 'id', $el.attr('id') + '_' + indx );

                grecaptcha.render('recaptcha_site_key' + '_' + indx, {
                    'sitekey' : site_key
                });
            });
        };
    }
}


jQuery(document).ready(function($) {

    $(".metform-form-content").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var msg = form.parent().find('.metform-msg');
        var post_url = form.attr("action");
        var form_data =form.serialize();
        var nonce = form.attr('data-nonce');

        if(msg.length > 1){
            form.parent().find('.metform-inx').remove();
        }

        $.ajax({
            url: post_url,
            type: 'POST',
            dataType: 'JSON',
            data: new FormData(this),
            processData: false,
			contentType: false,
            headers: {
                'X-WP-Nonce': nonce
            },
            success: function (response) {
                var status = Number(response.status);
                var formatedError = '';
                $.each(response.error, function(i, v){
                    formatedError += v + '<br>';
                });
                formatedError.replace(/<br>+$/,'');
                if (status == 1) {
                    msg.css("display","block");
                    msg.removeClass('attr-alert-warning');
                    msg.addClass('attr-alert-success');
                    msg.html(response.data['message']);
                    setTimeout( function(){ 
                        msg.css("display","none");
                    }  , 8000 );
                    form.trigger("reset");

                    if(form.attr('site_key') != '') grecaptcha.reset();
                    
                } else {
                    msg.css("display","block");
                    msg.removeClass('attr-alert-success');
                    msg.addClass('attr-alert-warning');
                    msg.html(formatedError);
                    setTimeout( function(){ 
                        msg.css("display","none");
                    }  , 8000 );
                }

                if(response.data['hide_form'] != ''){
                    setTimeout( function(){ 
                        form.css('display','none');
                    }  , 2000 );
                }

                if(response.data['redirect_to'] != ''){
                    setTimeout( function(){ 
                        window.location.replace(response.data['redirect_to']);
                    }  , 1500 );
                }
            }
        });


    });
});