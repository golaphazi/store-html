<div class="attr-modal attr-fade" id="<?php echo $form_prefix;?>_form_modal" tabindex="-1" role="dialog"
	aria-labelledby="<?php echo $form_prefix;?>_form_modalLabel">
	<div class="attr-modal-dialog attr-modal-dialog-centered" id="<?php echo $form_prefix;?>-form-modalinput-form" role="document">
		<form action="" mathod="post" id="<?php echo $form_prefix;?>-form-modalinput-settings" 
		data-open-editor="0" 
		data-editor-url="<?php echo get_admin_url(); ?>"
		data-nonce="<?php echo wp_create_nonce('wp_rest');?>"
		>
		<input type="hidden" name="post_author" value ="<?php echo get_current_user_id(); ?>">
			<div class="attr-modal-content">
				<div class="attr-modal-header">
					<button type="button" class="attr-close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
					<h4 class="attr-modal-title" id="<?php echo $form_prefix;?>_form_modalLabel"><?php esc_html_e('Template Settings', 'metwoo'); ?></h4>
					<div id="message" style="display:none" class="attr-alert attr-alert-success mf-success-msg"></div>
					
				</div>

				<div class="attr-tab-content">
					<div role="tabpanel" class="attr-tab-pane attr-active" id="mf-general">
						
						<div class="attr-modal-body" id="<?php echo $form_prefix;?>_form_modal_body">
							<div class="mf-input-group">
								<label for="attr-input-template" class="attr-input-label"><?php esc_html_e('Name:', 'metwoo'); ?></label>
								<input type="text" name="form_title" id="attr-input-template" class="mf-form-modalinput-template-name attr-form-control" data-default-value="<?php echo esc_html__('New Template # ', 'meform') . time(); ?>">
								<span class='mf-input-help'><?php esc_html_e('This is the template name','metwoo'); ?></span>
							</div>
							<div class="mf-input-group">
								<label for="attr-input-type" class="attr-input-label"><?php esc_html_e('Type:', 'metwoo'); ?></label>
								
								<select name="form_type" id="attr-input-type" class="mf-form-modalinput-template-type attr-form-control" data-default-value="single">
									<?php if(is_array($this->template_type) && sizeof($this->template_type) > 0){
										foreach( $this->template_type as $k=>$v):
										?>
										<option value="<?php echo esc_attr($k)?>"> <?php echo esc_html__($v, 'metwoo')?> </option>
									<?php 
										endforeach;
									}?>
								</select>
								<span class='mf-input-help'><?php esc_html_e('Select template type','metwoo'); ?></span>
							</div>
							<br>
							<div class="mf-input-group">
								<label class="attr-input-label">
									<input type="checkbox" value="Yes" id="set_default" name="set_defalut" class="mf-admin-control-input mf-form-modalinput-set-deafult" data-default-value="No">
									<span><?php esc_html_e('Set Default:', 'metwoo'); ?></span>
								</label>
								<span class='mf-input-help'><?php esc_html_e('Set default template for all.','metwoo'); ?></span>
							</div>
							<br>
							
						</div>
						
					</div>
					
				</div>

				<div class="attr-modal-footer">
					<button type="button" class="attr-btn attr-btn-default <?php echo $form_prefix;?>-form-save-btn-editor"><?php esc_html_e('Edit with Elementor', 'metwoo'); ?></button>
					<button type="submit" class="attr-btn attr-btn-primary <?php echo $form_prefix;?>-form-save-btn"><?php esc_html_e('Save changes', 'metwoo'); ?></button>
				</div>

				<div class="mf-spinner"></div>
			</div>
		</form>	
	</div>
</div>