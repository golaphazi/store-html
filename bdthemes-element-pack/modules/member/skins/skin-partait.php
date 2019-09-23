<?php
namespace ElementPack\Modules\Member\Skins;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Partait extends Elementor_Skin_Base {
	public function get_id() {
		return 'bdt-partait';
	}

	public function get_title() {
		return __( 'Partait', 'bdthemes-element-pack' );
	}

	public function render() {
		$partait_id = 'partait' . $this->parent->get_id();
		$settings   = $this->parent->get_settings();

		?>
		<div class="bdt-member bdt-member-skin-partait">
			<div class="bdt-grid bdt-grid-collapse bdt-child-width-1-2@m" bdt-grid>
		<?php
				if ( ! empty( $settings['photo']['url'] ) ) :
					$photo_hover_animation = ( '' != $settings['photo_hover_animation'] ) ? ' bdt-transition-scale-'.$settings['photo_hover_animation'] : ''; ?>

					<div class="bdt-member-photo-wrapper">

						<?php if(($settings['member_alternative_photo']) and ( ! empty( $settings['alternative_photo']['url']))) : ?>
							<div class="bdt-position-relative bdt-overflow-hidden" bdt-toggle="target: > .bdt-member-photo-flip; mode: hover; animation: bdt-animation-fade; queued: true; duration: 300;">

						<div class="bdt-member-photo-flip bdt-position-absolute bdt-position-z-index">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'alternative_photo' ); ?>
						</div>
						<?php endif; ?>

						<div class="bdt-member-photo">
							<div class="<?php echo ($photo_hover_animation); ?>">
								<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'photo' ); ?>
							</div>
						</div>

						<?php if(($settings['member_alternative_photo']) and ( ! empty( $settings['alternative_photo']['url']))) : ?>
							</div>
						<?php endif; ?>

					</div>
					
				<?php endif; ?>

				<div class="bdt-member-desc bdt-position-relative">
					<div class="bdt-position-center bdt-text-center">
						<div class="bdt-member-description">
							<?php if ( ! empty( $settings['name'] ) ) : ?>
								<span class="bdt-member-name"><?php echo $settings['name']; ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $settings['role'] ) ) : ?>
								<span class="bdt-member-role"><?php echo $settings['role']; ?></span>
							<?php endif; ?>
							
							<?php if ( ! empty( $settings['description_text'] ) ) : ?>
								<div class="bdt-member-text bdt-content-wrap"><?php echo $settings['description_text']; ?></div>
							<?php endif; ?>
						</div>

						<div class="bdt-member-icons">
							<?php 
							foreach ( $settings['social_link_list'] as $link ) :
								$tooltip = ( 'yes' == $settings['social_icon_tooltip'] ) ? ' title="'.esc_attr( $link['social_link_title'] ).'" bdt-tooltip' : '';
							?>
								<a href="<?php echo esc_url( $link['social_link'] ); ?>" class="bdt-member-icon elementor-repeater-item-<?php echo $link['_id']; ?>" target="_blank"<?php echo $tooltip; ?>>
									<i class="fa-fw <?php echo esc_attr( $link['social_icon'] ); ?>"></i>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>				
			</div>
		</div>
		<?php
	}
}

