<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
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
global $m_mwb_m_obj;
$m_genaral_settings = apply_filters( 'm_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="m-secion-wrap">
	<table class="form-table m-settings-table">
		<?php
			$m_general_html = $m_mwb_m_obj->mwb_m_plug_generate_html( $m_genaral_settings );
			echo esc_html( $m_general_html );
		?>
	</table>
</div>
