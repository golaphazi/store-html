<?php
$dropdown_field = get_user_meta( get_current_user_id(), $field_name, TRUE );
?>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<label for="reg_<?php echo esc_attr($field_name); ?>">
		<?php echo esc_html($label); ?>
		<?php if ( $required == 'yes' ) : ?>
			<span class="required">*</span>
		<?php endif; ?>
	</label>
	<select name="<?php echo esc_attr($field_name); ?>"
	        id="">
		<option value=""><?php esc_html_e( 'Choose value', 'woocommerce-builder-elementor' ) ?></option>
		<?php foreach ( $options as $l => $v ): ?>
			<?php if ( is_array( $options ) && !empty($l) && !empty($v) ): ?>
				<option
					value="<?php echo esc_attr($v); ?>"
					<?php
					if ( isset( $dropdown_field ) )
						selected( $v, $dropdown_field )
					?>
					><?php echo esc_html($l); ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
</p>