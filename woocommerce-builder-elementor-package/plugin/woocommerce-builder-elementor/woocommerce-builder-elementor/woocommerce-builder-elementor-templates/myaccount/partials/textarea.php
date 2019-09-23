<?php
$textarea_field = get_user_meta( get_current_user_id(), $field_name, TRUE );
?>

<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<label for="reg_<?php echo esc_attr($field_name); ?>">
		<?php echo esc_html($label); ?>
		<?php if ( $required == 'yes' ) : ?>
			<span class="required">*</span>
		<?php endif; ?>
	</label>
	<textarea name="<?php echo esc_attr($field_name); ?>"
	          id="reg_<?php echo esc_attr($field_name); ?>" cols="30" rows="10"><?php echo isset( $textarea_field ) ?
			$textarea_field :
			NULL ?></textarea>
</p>