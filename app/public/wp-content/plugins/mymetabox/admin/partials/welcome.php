<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the welcome html.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mymetabox
 * @subpackage Mymetabox/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-m-main-wrapper">
	<div class="mwb-m-go-pro">
		<div class="mwb-m-go-pro-banner">
			<div class="mwb-m-inner-container">
				<div class="mwb-m-name-wrapper" id="mwb-m-page-header">
					<h3><?php esc_html_e( 'Welcome To MakeWebBetter', 'mymetabox' ); ?></h4>
					</div>
				</div>
			</div>
			<div class="mwb-m-inner-logo-container">
				<div class="mwb-m-main-logo">
					<img src="<?php echo esc_url( MYMETABOX_DIR_URL . 'admin/images/logo.png' ); ?>">
					<h2><?php esc_html_e( 'We make the customer experience better', 'mymetabox' ); ?></h2>
					<h3><?php esc_html_e( 'Being best at something feels great. Every Business desires a smooth buyer’s journey, WE ARE BEST AT IT.', 'mymetabox' ); ?></h3>
				</div>
				<div class="mwb-m-active-plugins-list">
					<?php
					$mwb_m_all_plugins = get_option( 'mwb_all_plugins_active', false );
					if ( is_array( $mwb_m_all_plugins ) && ! empty( $mwb_m_all_plugins ) ) {
						?>
						<table class="mwb-m-table">
							<thead>
								<tr class="mwb-plugins-head-row">
									<th><?php esc_html_e( 'Plugin Name', 'mymetabox' ); ?></th>
									<th><?php esc_html_e( 'Active Status', 'mymetabox' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ( is_array( $mwb_m_all_plugins ) && ! empty( $mwb_m_all_plugins ) ) { ?>
									<?php foreach ( $mwb_m_all_plugins as $m_plugin_key => $m_plugin_value ) { ?>
										<tr class="mwb-plugins-row">
											<td><?php echo esc_html( $m_plugin_value['plugin_name'] ); ?></td>
											<?php if ( isset( $m_plugin_value['active'] ) && '1' != $m_plugin_value['active'] ) { ?>
												<td><?php esc_html_e( 'NO', 'mymetabox' ); ?></td>
											<?php } else { ?>
												<td><?php esc_html_e( 'YES', 'mymetabox' ); ?></td>
											<?php } ?>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
						<?php
					}
					?>
				</div>
			</div>
		</div>
