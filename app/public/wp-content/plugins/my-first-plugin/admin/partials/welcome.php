<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the welcome html.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    My_First_Plugin
 * @subpackage My_First_Plugin/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-mfp-main-wrapper">
	<div class="mwb-mfp-go-pro">
		<div class="mwb-mfp-go-pro-banner">
			<div class="mwb-mfp-inner-container">
				<div class="mwb-mfp-name-wrapper" id="mwb-mfp-page-header">
					<h3><?php esc_html_e( 'Welcome To MakeWebBetter', 'my-first-plugin' ); ?></h4>
					</div>
				</div>
			</div>
			<div class="mwb-mfp-inner-logo-container">
				<div class="mwb-mfp-main-logo">
					<img src="<?php echo esc_url( MY_FIRST_PLUGIN_DIR_URL . 'admin/images/logo.png' ); ?>">
					<h2><?php esc_html_e( 'We make the customer experience better', 'my-first-plugin' ); ?></h2>
					<h3><?php esc_html_e( 'Being best at something feels great. Every Business desires a smooth buyer’s journey, WE ARE BEST AT IT.', 'my-first-plugin' ); ?></h3>
				</div>
				<div class="mwb-mfp-active-plugins-list">
					<?php
					$mwb_mfp_all_plugins = get_option( 'mwb_all_plugins_active', false );
					if ( is_array( $mwb_mfp_all_plugins ) && ! empty( $mwb_mfp_all_plugins ) ) {
						?>
						<table class="mwb-mfp-table">
							<thead>
								<tr class="mwb-plugins-head-row">
									<th><?php esc_html_e( 'Plugin Name', 'my-first-plugin' ); ?></th>
									<th><?php esc_html_e( 'Active Status', 'my-first-plugin' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ( is_array( $mwb_mfp_all_plugins ) && ! empty( $mwb_mfp_all_plugins ) ) { ?>
									<?php foreach ( $mwb_mfp_all_plugins as $mfp_plugin_key => $mfp_plugin_value ) { ?>
										<tr class="mwb-plugins-row">
											<td><?php echo esc_html( $mfp_plugin_value['plugin_name'] ); ?></td>
											<?php if ( isset( $mfp_plugin_value['active'] ) && '1' != $mfp_plugin_value['active'] ) { ?>
												<td><?php esc_html_e( 'NO', 'my-first-plugin' ); ?></td>
											<?php } else { ?>
												<td><?php esc_html_e( 'YES', 'my-first-plugin' ); ?></td>
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
