<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$document_types = DTWCBE_Admin::get_document_types();

$types = DTWCBE_Admin::get_template_label_by_type('get_types');

$selected = get_query_var( 'dtwcbe_woo_library_type' );

?>
<script type="text/template" id="tmpl-elementor-new-template">
	<div id="elementor-new-template__description">
		<div id="elementor-new-template__description__title"> 
			<?php echo esc_html__( 'Templates Help You', 'woocommerce-builder-elementor')?> <span><?php echo esc_html__( 'Work Efficiently', 'woocommerce-builder-elementor')?></span>
		</div>
		<div id="elementor-new-template__description__content"><?php echo esc_html__( 'Use templates to create the different pieces of your site, and reuse them with one click whenever needed.', 'woocommerce-builder-elementor' ); ?></div>
	</div>
	<form id="elementor-new-template__form" action="<?php esc_url( admin_url( '/edit.php' ) ); ?>">
		<input type="hidden" name="post_type" value="dtwcbe_woo_library">
		<input type="hidden" name="action" value="dtwcbe_woo_new_post">
		<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'dtwcbe_woo_action_new_post' ); ?>">
		<div id="elementor-new-template__form__title"><?php echo esc_html__( 'Choose Template Type', 'woocommerce-builder-elementor' ); ?></div>
		<div id="elementor-new-template__form__template-type__wrapper" class="elementor-form-field">
			<label for="elementor-new-template__form__template-type" class="elementor-form-field__label"><?php echo esc_html__( 'Select the type of template you want to work on', 'woocommerce-builder-elementor' ); ?></label>
			<div class="elementor-form-field__select__wrapper">
				<select id="elementor-new-template__form__template-type" class="elementor-form-field__select" name="template_type" required>
					<option value=""><?php echo esc_html__( 'Select', 'woocommerce-builder-elementor' ); ?>...</option>
					<?php
					foreach ( $types as $value => $type_title ) {
						printf( '<option value="%1$s" %2$s>%3$s</option>', $value, selected( $selected, $value, false ), $type_title );
					}
					?>
				</select>
			</div>
		</div>
		

		<div id="elementor-new-template__form__post-title__wrapper" class="elementor-form-field">
			<label for="elementor-new-template__form__post-title" class="elementor-form-field__label">
				<?php echo esc_html__( 'Name your template', 'woocommerce-builder-elementor' ); ?>
			</label>
			<div class="elementor-form-field__text__wrapper">
				<input type="text" placeholder="<?php echo esc_attr__( 'Enter template name (optional)', 'woocommerce-builder-elementor' ); ?>" id="elementor-new-template__form__post-title" class="elementor-form-field__text" name="post_data[post_title]">
			</div>
		</div>
		<button id="elementor-new-template__form__submit" class="elementor-button elementor-button-success"><?php echo esc_html__( 'Create Template', 'woocommerce-builder-elementor' ); ?></button>
	</form>
</script>
