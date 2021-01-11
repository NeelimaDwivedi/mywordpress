<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Metaglobal
 * @subpackage Metaglobal/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Template for showing information about system status.
global $m_mwb_m_obj;
$m_default_status = $m_mwb_m_obj->mwb_m_plug_system_status();
$m_wordpress_details = is_array( $m_default_status['wp'] ) && ! empty( $m_default_status['wp'] ) ? $m_default_status['wp'] : array();
$m_php_details = is_array( $m_default_status['php'] ) && ! empty( $m_default_status['php'] ) ? $m_default_status['php'] : array();
?>
<div class="mwb-m-table-wrap">
	<div class="mwb-m-table-inner-container">
		<table class="mwb-m-table" id="mwb-m-wp">
			<thead>
				<tr>
					<th><?php esc_html_e( 'WP Variables', 'metaglobal' ); ?></th>
					<th><?php esc_html_e( 'WP Values', 'metaglobal' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $m_wordpress_details ) && ! empty( $m_wordpress_details ) ) { ?>
					<?php foreach ( $m_wordpress_details as $wp_key => $wp_value ) { ?>
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
	<div class="mwb-m-table-inner-container">
		<table class="mwb-m-table" id="mwb-m-php">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Sysytem Variables', 'metaglobal' ); ?></th>
					<th><?php esc_html_e( 'System Values', 'metaglobal' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $m_php_details ) && ! empty( $m_php_details ) ) { ?>
					<?php foreach ( $m_php_details as $php_key => $php_value ) { ?>
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
