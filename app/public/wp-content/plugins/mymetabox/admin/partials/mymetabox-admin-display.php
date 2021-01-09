<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mymetabox
 * @subpackage Mymetabox/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $m_mwb_m_obj;
$m_active_tab   = isset( $_GET['m_tab'] ) ? sanitize_key( $_GET['m_tab'] ) : 'mymetabox-general';
$m_default_tabs = $m_mwb_m_obj->mwb_m_plug_default_tabs();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-m-main-wrapper">
	<div class="mwb-m-go-pro">
		<div class="mwb-m-go-pro-banner">
			<div class="mwb-m-inner-container">
				<div class="mwb-m-name-wrapper">
					<p><?php esc_html_e( 'mymetabox', 'mymetabox' ); ?></p></div>
					<div class="mwb-m-static-menu">
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
							<?php $m_plugin_pro_link = apply_filters( 'm_pro_plugin_link', '' ); ?>
							<?php if ( isset( $m_plugin_pro_link ) && '' != $m_plugin_pro_link ) { ?>
								<li class="mwb-m-main-menu-button">
									<a id="mwb-m-go-pro-link" href="<?php echo esc_url( $m_plugin_pro_link ); ?>" class="" title="" target="_blank"><?php esc_html_e( 'GO PRO NOW', 'mymetabox' ); ?></a>
								</li>
							<?php } else { ?>
								<li class="mwb-m-main-menu-button">
									<a id="mwb-m-go-pro-link" href="#" class="" title=""><?php esc_html_e( 'GO PRO NOW', 'mymetabox' ); ?></a>
								</li>
							<?php } ?>
							<?php $m_plugin_pro = apply_filters( 'm_pro_plugin_purcahsed', 'no' ); ?>
							<?php if ( isset( $m_plugin_pro ) && 'yes' == $m_plugin_pro ) { ?>
								<li>
									<a id="mwb-m-skype-link" href="<?php echo esc_url( 'https://join.skype.com/invite/IKVeNkLHebpC' ); ?>" target="_blank">
										<img src="<?php echo esc_url( MYMETABOX_DIR_URL . 'admin/images/skype_logo.png' ); ?>" style="height: 15px;width: 15px;" ><?php esc_html_e( 'Chat Now', 'mymetabox' ); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="mwb-m-main-template">
			<div class="mwb-m-body-template">
				<div class="mwb-m-navigator-template">
					<div class="mwb-m-navigations">
						<?php
						if ( is_array( $m_default_tabs ) && ! empty( $m_default_tabs ) ) {

							foreach ( $m_default_tabs as $m_tab_key => $m_default_tabs ) {

								$m_tab_classes = 'mwb-m-nav-tab ';

								if ( ! empty( $m_active_tab ) && $m_active_tab === $m_tab_key ) {
									$m_tab_classes .= 'm-nav-tab-active';
								}
								?>
								
								<div class="mwb-m-tabs">
									<a class="<?php echo esc_attr( $m_tab_classes ); ?>" id="<?php echo esc_attr( $m_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=mymetabox_menu' ) . '&m_tab=' . esc_attr( $m_tab_key ) ); ?>"><?php echo esc_html( $m_default_tabs['title'] ); ?></a>
								</div>

								<?php
							}
						}
						?>
					</div>
				</div>

				<div class="mwb-m-content-template">
					<div class="mwb-m-content-container">
						<?php
							// if submenu is directly clicked on woocommerce.
						if ( empty( $m_active_tab ) ) {

							$m_active_tab = 'mwb_m_plug_general';
						}

							// look for the path based on the tab id in the admin templates.
						$m_tab_content_path = 'admin/partials/' . $m_active_tab . '.php';

						$m_mwb_m_obj->mwb_m_plug_load_template( $m_tab_content_path );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
