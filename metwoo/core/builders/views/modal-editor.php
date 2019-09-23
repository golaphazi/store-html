<div class="attr-modal attr-fade" id="metwoo_form_modal" tabindex="-1" role="dialog"
	aria-labelledby="metwoo_form_modalLabel">
	<div class="attr-modal-dialog attr-modal-dialog-centered" id="metwoo-form-modalinput-form" role="document">
		<form action="" mathod="post" id="metwoo-form-modalinput-settings" 
		data-open-editor="0" 
		data-editor-url="<?php echo get_admin_url(); ?>"
		data-nonce="<?php echo wp_create_nonce('wp_rest');?>"
		>
		<input type="hidden" name="post_author" value ="<?php echo get_current_user_id(); ?>">
			<div class="attr-modal-content">
				<div class="attr-modal-header">
					<button type="button" class="attr-close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
					<h4 class="attr-modal-title" id="metwoo_form_modalLabel"><?php esc_html_e('Form Settings', 'metwoo'); ?></h4>
					<div id="message" style="display:none" class="attr-alert attr-alert-success mf-success-msg"></div>
					<ul class="attr-nav attr-nav-tabs" role="tablist">
						<li role="presentation" class="attr-active"><a href="#mf-general" aria-controls="general" role="tab" data-toggle="tab"><?php esc_html_e('General', 'metwoo'); ?></a></li>
						<li role="presentation"><a href="#mf-confirmation" aria-controls="confirmation" role="tab" data-toggle="tab"><?php esc_html_e('Confirmation', 'metwoo');?></a></li>
						<li role="presentation"><a href="#mf-notification" aria-controls="notification" role="tab" data-toggle="tab"><?php esc_html_e('Notification', 'metwoo'); ?></a></li>
						<li role="presentation"><a href="#mf-integration" aria-controls="integration" role="tab" data-toggle="tab"><?php esc_html_e('Integration', 'metwoo');?></a></li>
					</ul>
				</div>

				<div class="attr-tab-content">
					<div role="tabpanel" class="attr-tab-pane attr-active" id="mf-general">
						
						<div class="attr-modal-body" id="metwoo_form_modal_body">
							<div class="mf-input-group">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Title:', 'metwoo'); ?></label>
								<input type="text" name="form_title" class="mf-form-modalinput-title attr-form-control" data-default-value="<?php echo esc_html__('New Form # ', 'meform') . time(); ?>">
								<span class='mf-input-help'><?php esc_html_e('This is the form title','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Success Message:', 'metwoo'); ?></label>
								<input type="text" name="success_message" class="mf-form-modalinput-success_message attr-form-control" data-default-value="<?php esc_html_e('Thank you! Form submitted successfully.','metwoo'); ?>" >
								<span class='mf-input-help'><?php esc_html_e('This mesage will be shown after a successful submission.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="require_login" class="mf-admin-control-input mf-form-modalinput-require_login">
									<span><?php esc_html_e('Required Login:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Without login, users can\'t submit the form.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="capture_user_browser_data" class="mf-admin-control-input mf-form-modalinput-capture_user_browser_data">
									<span><?php esc_html_e('Capture User Browser Data:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Store user\'s browser data (ip, browser name, etc)','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="hide_form_after_submission" class="mf-admin-control-input mf-form-modalinput-hide_form_after_submission">
									<span><?php esc_html_e('Hide Form After Submission:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('After submission, hide the form for preventing multiple submission.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="store_entries" class="mf-admin-control-input mf-form-modalinput-store_entries">
									<span><?php esc_html_e('Store Entries:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Save submitted form data to database.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<div class="mf-input-group-inner">
									<label class="attr-input-label">
										<input type="checkbox" value="1" name="limit_total_entries_status" class="mf-admin-control-input mf-form-modalinput-limit_status">
										<span><?php esc_html_e('Limit Total Entries:', 'metwoo'); ?></span>
									</label>
									<div class="mf-input-group" id='limit_status'>
										<input type="number" min="1" name="limit_total_entries" class="mf-form-modalinput-limit_total_entries attr-form-control">
									</div>
								</div>
								<span class='mf-input-help'><?php esc_html_e('Limit the total number of submissions for this form.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Redirect To:', 'metwoo'); ?></label>
								<input type="text" name="redirect_to" class="mf-form-modalinput-redirect_to attr-form-control" placeholder="<?php esc_html_e('Redirection link', 'metwoo'); ?>">
								<span class='mf-input-help'><?php esc_html_e('Users will be redirected to the this link after submission.','metwoo'); ?></span>
							</div>

						</div>
						
					</div>
					<div role="tabpanel" class="attr-tab-pane" id="mf-confirmation">
						
						<div class="attr-modal-body" id="metwoo_form_modal_body">

							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="enable_user_notification" class="mf-admin-control-input mf-form-user-enable">
									<span><?php esc_html_e('Confirmation mail to user :', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Want to send a submission copy to user by email? Active this one.','metwoo'); ?><strong><?php esc_html_e('The form must have at least one Email widget and it should be required.', 'metwoo'); ?></strong></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-user-confirmation">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email Subject:', 'metwoo'); ?></label>
								<input type="text" name="user_email_subject" class="mf-form-user-email-subject attr-form-control" placeholder="<?php esc_html_e('Email subject', 'metwoo');?>"
								<span class='mf-input-help'><?php esc_html_e('Enter here email subject.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-user-confirmation">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email From:', 'metwoo'); ?></label>
								<input type="email" name="user_email_from" class="mf-form-user-email-from attr-form-control" placeholder="<?php esc_html_e('From email', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter the email by which you want to send email to user.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-user-confirmation">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email Reply To:', 'metwoo'); ?></label>
								<input type="email" name="user_email_reply_to" class="mf-form-user-reply-to attr-form-control" placeholder="<?php esc_html_e('Reply to email', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter email where user can reply/ you want to get reply.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-user-confirmation">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Thank you message :', 'metwoo'); ?></label>
								<textarea name="user_email_body" id="" class="mf-form-user-email-body attr-form-control" cols="30" rows="5" placeholder="<?php esc_html_e('Thank you message!', 'metwoo');?>"></textarea>
								<span class='mf-input-help'><?php esc_html_e('Enter here your message to include it in email body. Which will be send to user.','metwoo'); ?></span>
							</div>
							<br>
							<!-- <div class="mf-input-group">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email Attached Submission Copy:', 'metwoo'); ?></label>
								<input type="checkbox" value="1" name="user_email_attach_submission_copy" class="mf-admin-control-input mf-form-user-submission-copy">
							</div> -->
							
						</div>
						
					</div>
					<div role="tabpanel" class="attr-tab-pane" id="mf-notification">
						
						<div class="attr-modal-body" id="metwoo_form_modal_body">
							
							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="enable_admin_notification" class="mf-admin-control-input mf-form-admin-enable">
									<span><?php esc_html_e('Notification mail to admin :', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Want to send a submission copy to admin by email? Active this one.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-admin-notification">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email Subject:', 'metwoo'); ?></label>
								<input type="text" name="admin_email_subject" class="mf-form-admin-email-subject attr-form-control" placeholder="<?php esc_html_e('Email subject', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter here email subject.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-admin-notification">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email To:', 'metwoo'); ?></label>
								<input type="text" name="admin_email_to" class="mf-form-admin-email-to attr-form-control" placeholder="<?php esc_html_e('example@mail.com, example@email.com', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter admin email where you want to send mail.','metwoo'); ?><strong><?php esc_html_e(' for multiple email addresses please use "," separator.', 'metwoo'); ?></strong></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-admin-notification">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email From:', 'metwoo'); ?></label>
								<input type="email" name="admin_email_from" class="mf-form-admin-email-from attr-form-control" placeholder="<?php esc_html_e('Email from', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter the email by which you want to send email to admin.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-admin-notification">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Email Reply To:', 'metwoo'); ?></label>
								<input type="email" name="admin_email_reply_to" class="mf-form-admin-reply-to attr-form-control" placeholder="<?php esc_html_e('Email reply to', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter email where admin can reply/ you want to get reply.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-form-admin-notification">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Admin Note : ', 'metwoo'); ?></label>
								<textarea name="admin_email_body" class="mf-form-admin-email-body attr-form-control" cols="30" rows="5" placeholder="<?php esc_html_e('Admin note!', 'metwoo');?>"></textarea>
								<span class='mf-input-help'><?php esc_html_e('Enter here your email body. Which will be send to admin.','metwoo'); ?></span>
							</div>
						</div>
						
					</div>
					<div role="tabpanel" class="attr-tab-pane" id="mf-integration">
						
						<div class="attr-modal-body" id="metwoo_form_modal_body">

							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="mf_mail_chimp" class="mf-admin-control-input mf-form-modalinput-mail_chimp">
									<span><?php esc_html_e('Mail Chimp:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Integrate mailchimp with this form.','metwoo'); ?><strong><?php esc_html_e('The form must have at least one Email widget and it should be required.', 'metwoo'); ?></strong></span>
							</div>
							<br>
							<div class="mf-input-group mf-mailchimp">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('MailChimp API Key:', 'metwoo'); ?></label>
								<input type="text" name="mf_mailchimp_api_key" class="mf-mailchimp-api-key attr-form-control" placeholder="<?php esc_html_e('Mailchimp api key', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter here mailchimp api key.','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group mf-mailchimp">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('MailChimp List ID:', 'metwoo'); ?></label>
								<input type="text" name="mf_mailchimp_list_id" class="mf-mailchimp-list-id attr-form-control" placeholder="<?php esc_html_e('Mailchimp contact list id', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter here mailchimp list id.','metwoo'); ?></span>
							</div>
							<br>

							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="mf_slack" class="mf-admin-control-input mf-form-modalinput-slack">
									<span><?php esc_html_e('Slack:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Integrate slack with this form.','metwoo'); ?><strong><?php esc_html_e('slack info.', 'metwoo'); ?></strong></span>
							</div>
							<br>
							<div class="mf-input-group mf-slack">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Slack webhook:', 'metwoo'); ?></label>
								<input type="text" name="mf_slack_webhook" class="mf-slack-web-hook attr-form-control" placeholder="<?php esc_html_e('Slack webhook', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('Enter here slack web hook.','metwoo'); ?><a href="http://slack.com/apps/A0F7XDUAZ-incoming-webhooks"><?php esc_html_e('create from here', 'metwoo');?></a></span>
							</div>
							<br>

							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="1" name="mf_recaptcha" class="mf-admin-control-input mf-form-modalinput-recaptcha">
									<span><?php esc_html_e('reCAPTCHA:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('reCAPTCHA protects you against spam and other types of automated abuse.','metwoo'); ?><strong><?php esc_html_e('The form must have reCAPTCHA widget to use this feature.', 'metwoo'); ?></strong></span>
							</div>
							<br>
							<div class="mf-input-group mf-recaptcha">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Site Key:', 'metwoo'); ?></label>
								<input type="text" name="mf_recaptcha_site_key" class="mf-recaptcha-site-key attr-form-control" placeholder="<?php esc_html_e('Google recaptcha v2 site key', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('make your reCAPTCHA from google','metwoo'); ?><strong><?php esc_html_e(' reCAPTCHA V2. ', 'metwoo'); ?></strong><a target="_blank"href="https://www.google.com/recaptcha/admin"><?php esc_html_e('Create from here', 'metwoo')?></a></span>
							</div>
							<br>
							<div class="mf-input-group mf-recaptcha">
								<label for="attr-input-label" class="attr-input-label"><?php esc_html_e('Secret Key:', 'metwoo'); ?></label>
								<input type="text" name="mf_recaptcha_secret_key" class="mf-recaptcha-secret-key attr-form-control" placeholder="<?php esc_html_e('Google recaptcha v2 secret key', 'metwoo');?>">
								<span class='mf-input-help'><?php esc_html_e('make your reCAPTCHA from google','metwoo'); ?><strong><?php esc_html_e(' reCAPTCHA V2. ', 'metwoo'); ?></strong><a target="_blank"href="https://www.google.com/recaptcha/admin"><?php esc_html_e('Create from here', 'metwoo')?></a></span>
							</div>
							<br>

						</div>
						
					</div>
				</div>

				<div class="attr-modal-footer">
					<button type="button" class="attr-btn attr-btn-default metwoo-form-save-btn-editor"><?php esc_html_e('Edit content', 'metwoo'); ?></button>
					<button type="submit" class="attr-btn attr-btn-primary metwoo-form-save-btn"><?php esc_html_e('Save changes', 'metwoo'); ?></button>
				</div>

				<div class="mf-spinner"></div>
			</div>
		</form>	
	</div>
</div>