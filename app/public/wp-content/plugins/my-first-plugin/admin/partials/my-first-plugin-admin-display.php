<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    My_First_Plugin
 * @subpackage My_First_Plugin/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $mfp_mwb_mfp_obj;
$mfp_active_tab   = isset( $_GET['mfp_tab'] ) ? sanitize_key( $_GET['mfp_tab'] ) : 'my-first-plugin-general';
$mfp_default_tabs = $mfp_mwb_mfp_obj->mwb_mfp_plug_default_tabs();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-mfp-main-wrapper">
	<div class="mwb-mfp-go-pro">
		<div class="mwb-mfp-go-pro-banner">
			<div class="mwb-mfp-inner-container">
				<div class="mwb-mfp-name-wrapper">
					<p><?php esc_html_e( 'my first plugin', 'my-first-plugin' ); ?></p></div>
					<div class="mwb-mfp-static-menu">
						<ul>
							<li>
								<a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/' ); ?>" target="_blank">
									<span class="dashicons dashicons-phone"></span>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/hubspot-woocommerce-integration/' ); ?>" target="_blank">
									<span class="dashicons dashicons-media-document"></span>
								</a>
							</li>
							<?php $mfp_plugin_pro_link = apply_filters( 'mfp_pro_plugin_link', '' ); ?>
							<?php if ( isset( $mfp_plugin_pro_link ) && '' != $mfp_plugin_pro_link ) { ?>
								<li class="mwb-mfp-main-menu-button">
									<a id="mwb-mfp-go-pro-link" href="<?php echo esc_url( $mfp_plugin_pro_link ); ?>" class="" title="" target="_blank"><?php esc_html_e( 'GO PRO NOW', 'my-first-plugin' ); ?></a>
								</li>
							<?php } else { ?>
								<li class="mwb-mfp-main-menu-button">
									<a id="mwb-mfp-go-pro-link" href="#" class="" title=""><?php esc_html_e( 'GO PRO NOW', 'my-first-plugin' ); ?></a>
								</li>
							<?php } ?>
							<?php $mfp_plugin_pro = apply_filters( 'mfp_pro_plugin_purcahsed', 'no' ); ?>
							<?php if ( isset( $mfp_plugin_pro ) && 'yes' == $mfp_plugin_pro ) { ?>
								<li>
									<a id="mwb-mfp-skype-link" href="<?php echo esc_url( 'https://join.skype.com/invite/IKVeNkLHebpC' ); ?>" target="_blank">
										<img src="<?php echo esc_url( MY_FIRST_PLUGIN_DIR_URL . 'admin/images/skype_logo.png' ); ?>" style="height: 15px;width: 15px;" ><?php esc_html_e( 'Chat Now', 'my-first-plugin' ); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="mwb-mfp-main-template">
			<div class="mwb-mfp-body-template">
				<div class="mwb-mfp-navigator-template">
					<div class="mwb-mfp-navigations">
						<?php
						if ( is_array( $mfp_default_tabs ) && ! empty( $mfp_default_tabs ) ) {

							foreach ( $mfp_default_tabs as $mfp_tab_key => $mfp_default_tabs ) {

								$mfp_tab_classes = 'mwb-mfp-nav-tab ';

								if ( ! empty( $mfp_active_tab ) && $mfp_active_tab === $mfp_tab_key ) {
									$mfp_tab_classes .= 'mfp-nav-tab-active';
								}
								?>
								
								<div class="mwb-mfp-tabs">
									<a class="<?php echo esc_attr( $mfp_tab_classes ); ?>" id="<?php echo esc_attr( $mfp_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=my_first_plugin_menu' ) . '&mfp_tab=' . esc_attr( $mfp_tab_key ) ); ?>"><?php echo esc_html( $mfp_default_tabs['title'] ); ?></a>
								</div>

								<?php
							}
						}
						?>
					</div>
				</div>

				<div class="mwb-mfp-content-template">
					<div class="mwb-mfp-content-container">
						<?php
							// if submenu is directly clicked on woocommerce.
						if ( empty( $mfp_active_tab ) ) {

							$mfp_active_tab = 'mwb_mfp_plug_general';
						}

							// look for the path based on the tab id in the admin templates.
						$mfp_tab_content_path = 'admin/partials/' . $mfp_active_tab . '.php';

						$mfp_mwb_mfp_obj->mwb_mfp_plug_load_template( $mfp_tab_content_path );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
