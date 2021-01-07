<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
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
// Template for showing information about system status.
global $mfp_mwb_mfp_obj;
$mfp_default_status = $mfp_mwb_mfp_obj->mwb_mfp_plug_system_status();
$mfp_wordpress_details = is_array( $mfp_default_status['wp'] ) && ! empty( $mfp_default_status['wp'] ) ? $mfp_default_status['wp'] : array();
$mfp_php_details = is_array( $mfp_default_status['php'] ) && ! empty( $mfp_default_status['php'] ) ? $mfp_default_status['php'] : array();
?>
<div class="mwb-mfp-table-wrap">
	<div class="mwb-mfp-table-inner-container">
		<table class="mwb-mfp-table" id="mwb-mfp-wp">
			<thead>
				<tr>
					<th><?php esc_html_e( 'WP Variables', 'my-first-plugin' ); ?></th>
					<th><?php esc_html_e( 'WP Values', 'my-first-plugin' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $mfp_wordpress_details ) && ! empty( $mfp_wordpress_details ) ) { ?>
					<?php foreach ( $mfp_wordpress_details as $wp_key => $wp_value ) { ?>
						<?php if ( isset( $wp_key ) && 'wp_users' != $wp_key ) { ?>
							<tr>
								<td><?php echo esc_html( $wp_key ); ?></td>
								<td><?php echo esc_html( $wp_value ); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="mwb-mfp-table-inner-container">
		<table class="mwb-mfp-table" id="mwb-mfp-php">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Sysytem Variables', 'my-first-plugin' ); ?></th>
					<th><?php esc_html_e( 'System Values', 'my-first-plugin' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $mfp_php_details ) && ! empty( $mfp_php_details ) ) { ?>
					<?php foreach ( $mfp_php_details as $php_key => $php_value ) { ?>
						<tr>
							<td><?php echo esc_html( $php_key ); ?></td>
							<td><?php echo esc_html( $php_value ); ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
