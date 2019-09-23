<?php
defined( 'ABSPATH' ) || exit;

if( class_exists('WC_Memberships_Members_Area') ){
	class DTWCBE_WC_Memberships_Members_Area extends WC_Memberships_Members_Area{
		
		public function __construct() {
			parent::__construct();
		}
		
		/**
		 * Renders the members area content.
		 *
		 * @internal
		 *
		 * @since 1.9.0
		 */
		public function output_members_area() {
		
			$the_content = '';
		
			$user_id         = get_current_user_id();
			$user_membership = $this->get_members_area_user_membership();
	
			// check if membership exists and the current logged in user is an active or at least a delayed member.
			if (    ( $user_membership && ( $user_id === $user_membership->get_user_id() ) )
				&& ( wc_memberships_is_user_active_member( $user_id, $user_membership->get_plan() ) || wc_memberships_is_user_delayed_member( $user_id, $user_membership->get_plan() ) ) ) {
	
					// sections for this membership defined in admin
					$sections     = (array) $user_membership->get_plan()->get_members_area_sections();
					$members_area = array_intersect_key( wc_memberships_get_members_area_sections(), array_flip( $sections ) );
	
					// Members Area should have at least one section enabled
					if ( ! empty( $members_area ) ) {
	
						ob_start();
	
						// Get the section to display, or use the first designated section as fallback:
						$section = $this->get_members_area_section();
						$section = ! empty( $section ) && array_key_exists( $section, $members_area ) ? $section : $sections[0];
						// Get a paged request for the given section:
						$paged   = $this->get_members_area_section_page();
	
						?>
						<div
							class="my-membership-section <?php echo sanitize_html_class( $section ); ?>"
							id="wc-memberships-members-area-section"
							data-section="<?php echo esc_attr( $section ); ?>"
							data-page="<?php echo esc_attr( $paged ); ?>">
							<?php $this->get_template( $section, array(
								'user_membership' => $user_membership,
								'user_id'         => $user_id,
								'paged'           => $paged,
							) ); ?>
						</div>
						<?php
	
						// grab everything that was output above while processing any shortcode in between
						$the_content = do_shortcode( ob_get_clean() );
					}
	
				} else {
					wc_get_template( 'myaccount/my-memberships.php', array(
						'customer_memberships' => wc_memberships_get_user_memberships(),
						'user_id'              => get_current_user_id(),
					) );
				}
	
			echo ( $the_content );
		}
	}
}