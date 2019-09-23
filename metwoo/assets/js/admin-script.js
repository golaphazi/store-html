jQuery(document).ready(function ($) {
    "use strict"; 

    $('.row-actions .edit a, .page-title-action, .metform-form-edit-btn, body.post-type-metform-form a.row-title').on('click', function (e) {
        e.preventDefault();
        var id = 0;
        var modal = $('#metwoo_form_modal');
        var parent = $(this).parents('.column-title');

        modal.addClass('loading');
        modal.modal('show');
        if (parent.length > 0) {
            id = $(this).attr('data-metform-form-id');
            id = (id !== undefined) ? id : parent.find('.hidden').attr('id').split('_')[1];
            var nonce = $('#metform-form-modalinput-settings').attr('data-nonce');

            $.ajax({
                url: window.metform_api.resturl + 'metform/v1/forms/get/' + id,
                type: 'get',
                headers: {
                    'X-WP-Nonce': nonce
                },
                dataType: 'json',
                success: function (data) {
                    MetForm_Form_Editor(data);
                    modal.removeClass('loading');
                }
            });


        } else {
            var data = {
                form_title: $('.mf-form-modalinput-title').attr('data-default-value'),
                admin_email_body: "",
                admin_email_from: "",
                admin_email_reply_to: "",
                admin_email_subject: "",
                capture_user_browser_data: "",
                enable_admin_notification: "",
                limit_total_entries_status: "",
                limit_total_entries: "0",
                redirect_to: "",
                require_login: "",
                store_entries: "1",
                success_message: $('.mf-form-modalinput-success_message').attr('data-default-value'),
                user_email_body: "",
                user_email_from: "",
                user_email_reply_to: "",
                user_email_subject: "",
            };
            MetForm_Form_Editor(data);
            modal.removeClass('loading');
        }

        modal.find('form').attr('data-mf-id', id);
    });

    $('.metform-form-save-btn-editor').on('click', function () {
        $('.metform-form-save-btn-editor').attr('disabled', true);
        var form = $('#metform-form-modalinput-settings');
        form.attr('data-open-editor', '1');
        form.trigger('submit');
    });

    $('#metform-form-modalinput-settings').on('submit', function (e) {
        e.preventDefault();
        var modal = $('#metform-form-modal');
        modal.addClass('loading');

        $('.metform-form-save-btn-editor').attr('disabled', true);
        $('.metform-form-save-btn').attr('disabled', true);

        var form_data = $(this).serialize();
        var id = $(this).attr('data-mf-id');
        var open_editor = $(this).attr('data-open-editor');
        var admin_url = $(this).attr('data-editor-url');
        var nonce = $(this).attr('data-nonce');

        $.ajax({
            url: window.metform_api.resturl + 'metform/v1/forms/update/' + id,
            type: 'post',
            data: form_data,
            headers: {
                'X-WP-Nonce': nonce
            },
            dataType: 'json',
            success: function (output) {
                $('#message').css('display','block');

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
                    $('.metform-form-save-btn-editor').removeAttr('disabled');
                    $('.metform-form-save-btn').removeAttr('disabled');
                }else if(id == '0'){
                    setTimeout( function(){ 
                        location.reload();
                    }  , 1500 );
                }
            }
        });

    });

    $('input.mf-form-modalinput-limit_status').on('change',function(){
        if($(this).is(":checked")){
            $('#limit_status').find('input').removeAttr('disabled');
        }
        else if($(this).is(":not(:checked)")){
            $('#limit_status').find('input').attr('disabled', 'disabled');
        }
    });

    $('input.mf-form-user-enable').on('change',function(){
        if($(this).is(":checked")){
            $('.mf-form-user-confirmation').show();
        }
        else if($(this).is(":not(:checked)")){
            $('.mf-form-user-confirmation').hide();
        }
    });

    $('input.mf-form-admin-enable').on('change',function(){
        if($(this).is(":checked")){
            $('.mf-form-admin-notification').show();
        }
        else if($(this).is(":not(:checked)")){
            $('.mf-form-admin-notification').hide();
        }
    });

    $('input.mf-form-modalinput-mail_chimp').on('change',function(){
        if($(this).is(":checked")){
            $('.mf-mailchimp').show();
        }
        else if($(this).is(":not(:checked)")){
            $('.mf-mailchimp').hide();
        }
    });

    $('input.mf-form-modalinput-slack').on('change',function(){
        if($(this).is(":checked")){
            $('.mf-slack').show();
        }
        else if($(this).is(":not(:checked)")){
            $('.mf-slack').hide();
        }
    });

    $('input.mf-form-modalinput-recaptcha').on('change',function(){
        if($(this).is(":checked")){
            $('.mf-recaptcha').show();
        }
        else if($(this).is(":not(:checked)")){
            $('.mf-recaptcha').hide();
        }
    });

    $('input.mf-form-modalinput-capture_user_browser_data').click(function(){
        if($(this).is(":checked")){
            $('#multiple_submission').removeClass('hide_input');
            $('#multiple_submission').addClass('show_input');
        }
        else if($(this).is(":not(:checked)")){
            $('#multiple_submission').removeClass('show_input');
            $('#multiple_submission').addClass('hide_input');
        }
    });

    function MetForm_Form_Editor(data) {
        $('.mf-form-user-confirmation').hide();
        $('.mf-form-admin-notification').hide();

        $('.mf-mailchimp').hide();
        $('.mf-slack').hide();
        $('.mf-recaptcha').hide();

        if(data.form_title != ''){
            $('.mf-form-modalinput-title').val(data.form_title);
            $('.mf-form-modalinput-success_message').val(data.success_message);
            $('.mf-form-modalinput-redirect_to').val(data.redirect_to);
            $('.mf-form-modalinput-limit_total_entries').val(data.limit_total_entries);

            var store_entries = $('.mf-form-modalinput-store_entries');
            if (data.store_entries == '1') {
                store_entries.attr('checked', true);
            } else {
                store_entries.removeAttr('checked');
            }

            var hide_form_after_submission = $('.mf-form-modalinput-hide_form_after_submission');
            if (data.hide_form_after_submission == '1') {
                hide_form_after_submission.attr('checked', true);
            } else {
                hide_form_after_submission.removeAttr('checked');
            }

            var require_login = $('.mf-form-modalinput-require_login');
            if (data.require_login == '1') {
                require_login.attr('checked', true);
            } else {
                require_login.removeAttr('checked');
            }
            var limit_entry_status = $('.mf-form-modalinput-limit_status');
            if (data.limit_total_entries_status == '1') {
                limit_entry_status.attr('checked', true);
            } else {
                limit_entry_status.removeAttr('checked');
            }

            var multiple_submission = $('.mf-form-modalinput-multiple_submission');
            if (data.multiple_submission == '1') {
                multiple_submission.attr('checked', true);
            } else {
                multiple_submission.removeAttr('checked');
            }

            var enable_recaptcha = $('.mf-form-modalinput-enable_recaptcha');
            if (data.enable_recaptcha == '1') {
                enable_recaptcha.attr('checked', true);
            } else {
                enable_recaptcha.removeAttr('checked');
            }

            var capture_user_browser_data = $('.mf-form-modalinput-capture_user_browser_data');
            if (data.capture_user_browser_data == '1') {
                capture_user_browser_data.attr('checked', true);
                $('#multiple_submission').removeClass('hide_input');
                $('#multiple_submission').addClass('show_input');
            } else {
                capture_user_browser_data.removeAttr('checked');
            }


            $('.mf-form-user-email-subject').val(data.user_email_subject);
            $('.mf-form-user-email-from').val(data.user_email_from);
            $('.mf-form-user-reply-to').val(data.user_email_reply_to);
            $('.mf-form-user-email-body').val(data.user_email_body);

        
            var enable_user_notification = $('.mf-form-user-enable')
            if(data.enable_user_notification == '1'){
                enable_user_notification.attr('checked', true);
                $('.mf-form-user-confirmation').show();
            }
            else{
                enable_user_notification.removeAttr('checked');
                $('.mf-form-user-confirmation').hide();
            }

            var user_submission_copy = $('.mf-form-user-submission-copy')
            if(data.user_email_attach_submission_copy == '1'){
                user_submission_copy.attr('checked', true);
            }
            else{
                user_submission_copy.removeAttr('checked');
            }

            $('.mf-form-admin-email-subject').val(data.admin_email_subject);
            $('.mf-form-admin-email-from').val(data.admin_email_from);
            $('.mf-form-admin-email-to').val(data.admin_email_to);
            $('.mf-form-admin-reply-to').val(data.admin_email_reply_to);
            $('.mf-form-admin-email-body').val(data.admin_email_body);


            var enable_admin_notification = $('.mf-form-admin-enable')
            if(data.enable_admin_notification == '1'){
                enable_admin_notification.attr('checked', true);
                $('.mf-form-admin-notification').show();
            }
            else{
                enable_admin_notification.removeAttr('checked');
                $('.mf-form-admin-notification').hide();
            }

            var admin_submission_copy = $('.mf-form-admin-submission-copy')
            if(data.admin_email_attach_submission_copy == '1'){
                admin_submission_copy.attr('checked', true);
            }
            else{
                admin_submission_copy.removeAttr('checked');
            }

            var mailchimp = $('.mf-form-modalinput-mail_chimp');
            if(data.mf_mail_chimp == '1'){
                mailchimp.attr('checked', true);
                $('.mf-mailchimp').show();
            }else{
                mailchimp.removeAttr('checked');
                $('.mf-mailchimp').hide();
            }

            var slack = $('.mf-form-modalinput-slack');
            if(data.mf_slack == '1'){
                slack.attr('checked', true);
                $('.mf-slack').show();
            }else{
                slack.removeAttr('checked', true);
                $('.mf-slack').hide();
            }

            var recaptcha = $('.mf-form-modalinput-recaptcha');
            if(data.mf_recaptcha == '1'){
                recaptcha.attr('checked', true);
                $('.mf-recaptcha').show();
            }else{
                recaptcha.removeAttr('checked');
            }

            $('.mf-mailchimp-api-key').val(data.mf_mailchimp_api_key);
            $('.mf-mailchimp-list-id').val(data.mf_mailchimp_list_id);

            $('.mf-slack-web-hook').val(data.mf_slack_webhook);

            $('.mf-recaptcha-site-key').val(data.mf_recaptcha_site_key);
            $('.mf-recaptcha-secret-key').val(data.mf_recaptcha_secret_key);

            $('input.mf-form-modalinput-limit_status').trigger('change');
        }

    }

});