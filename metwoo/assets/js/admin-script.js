jQuery(document).ready(function ($) {
    "use strict"; 
    var form_prefix = 'metwoo';

    $('.row-actions .edit > a, .page-title-action, .'+form_prefix+'-form-edit-btn, body.post-type-'+form_prefix+'-form a.row-title').on('click', function (e) {
        e.preventDefault();
        var id = 0;
        var modal = $('#'+form_prefix+'_form_modal');
        var parent = $(this).parents('.column-title');

        modal.addClass('loading');
        modal.modal('show');
        if (parent.length > 0) {
            id = $(this).attr('data-'+form_prefix+'-form-id');
            id = (id !== undefined) ? id : parent.find('.hidden').attr('id').split('_')[1];
            var nonce = $('#'+form_prefix+'-form-modalinput-settings').attr('data-nonce');
            $.ajax({
                url: window.metwoo_api.resturl + form_prefix +'/v1/template/getdata/' + id,
                type: 'get',
                headers: {
                    'X-WP-Nonce': nonce
                },
                dataType: 'json',
                success: function (data) {
                    MetWoo_Form_Editor(data);
                    modal.removeClass('loading');
                }
            });


        } else {
            var data = {
                form_title: $('.mf-form-modalinput-template-name').attr('data-default-value'),
                form_type: $('.mf-form-modalinput-template-type').attr('data-default-value'),
                set_defalut: $('.mf-form-modalinput-set-deafult').attr('data-default-value'),
            };
            MetWoo_Form_Editor(data);
            modal.removeClass('loading');
        }

        modal.find('form').attr('data-mf-id', id);
    });

    $('.'+form_prefix+'-form-save-btn-editor').on('click', function () {
        $('.'+form_prefix+'-form-save-btn-editor').attr('disabled', true);
        var form = $('#'+form_prefix+'-form-modalinput-settings');
        form.attr('data-open-editor', '1');
        form.trigger('submit');
    });

    // save form data
    $('#'+form_prefix+'-form-modalinput-settings').on('submit', function (e) {
        e.preventDefault();
        var modal = $('#'+form_prefix+'_form_modal');
        modal.addClass('loading');

        $('.'+form_prefix+'-form-save-btn-editor').attr('disabled', true);
        $('.'+form_prefix+'-form-save-btn').attr('disabled', true);

        var form_data = $(this).serialize();
        var id = $(this).attr('data-mf-id');
        var open_editor = $(this).attr('data-open-editor');
        var admin_url = $(this).attr('data-editor-url');
        var nonce = $(this).attr('data-nonce');
        $.ajax({
            url: window.metwoo_api.resturl + form_prefix +'/v1/template/add/' + id,
            type: 'post',
            data: form_data,
            headers: {
                'X-WP-Nonce': nonce
            },
            dataType: 'json',
            success: function (output) {
                $('#message').css('display','block');
                console.log(output);
               
                if(output.saved == true){
                    $('#post-' + output.data.id).find('.row-title').html(output.data.title);
                    $('#message').removeClass('attr-alert-warning').addClass('attr-alert-success').html(output.status);
                }else{
                    $('#message').removeClass('attr-alert-success').addClass('attr-alert-warning').html(output.status);
                }

                setTimeout( function(){ 
                    $('#message').css('display','none');
                }  , 5000 );
                
                modal.removeClass('loading');

                if (open_editor == '1') {
                    setTimeout( function(){ 
                        window.location.href = admin_url + '?post=' + output.data.id + '&action=elementor';
                    }  , 1500 );
                }else if(id != '0'){
                    $('.'+form_prefix+'-form-save-btn-editor').removeAttr('disabled');
                    $('.'+form_prefix+'-form-save-btn').removeAttr('disabled');
                }else if(id == '0'){
                    setTimeout( function(){ 
                        location.reload();
                    }  , 1500 );
                }
            }
        });

    });

    function MetWoo_Form_Editor(data) {
       
        if(data.form_title != ''){
            $('.mf-form-modalinput-template-name').val(data.form_title);
            $('.mf-form-modalinput-template-type').val(data.form_type);
           if(data.set_defalut != 'No'){
                $('.mf-form-modalinput-set-deafult').attr ( "checked" ,"checked" );
           }else{
            $('.mf-form-modalinput-set-deafult').removeAttr ( "checked" );
           }
          
        }

    }

});