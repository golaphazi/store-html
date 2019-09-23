<?php
$check_field = get_user_meta( get_current_user_id(), $field_name, TRUE );
?>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="reg_<?php echo esc_attr( $field_name ); ?>">
        <?php echo esc_html( $label ); ?>
        <?php if( $required == 'yes' ) : ?>
            <span class="required">*</span>
        <?php endif; ?>
    </label>
    <?php foreach( $options as $l => $v ): ?>
        <?php if( is_array( $options ) && !empty($l) && !empty($v) ): ?>

            <input type="checkbox"
                   name="<?php echo esc_attr($field_name); ?>"
                   value="<?php echo esc_attr($v); ?>"
	               <?php
	               if( isset($check_field) )
	                    checked( $v, $check_field)
	               ?>
	            >&nbsp; <?php echo esc_html($l) ?>
            <br/>

        <?php endif; ?>
    <?php endforeach; ?>

</p>