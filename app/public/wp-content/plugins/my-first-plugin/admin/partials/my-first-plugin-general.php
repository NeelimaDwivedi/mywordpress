<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
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
global $mfp_mwb_mfp_obj;
$mfp_genaral_settings = apply_filters( 'mfp_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="mfp-secion-wrap">
	<table class="form-table mfp-settings-table">
		<?php
			$mfp_general_html = $mfp_mwb_mfp_obj->mwb_mfp_plug_generate_html( $mfp_genaral_settings );
			echo esc_html( $mfp_general_html );
		?>
	</table>
</div>
