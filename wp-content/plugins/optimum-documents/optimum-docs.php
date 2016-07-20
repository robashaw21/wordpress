<?php
/*
Plugin Name: Optimum Documents
Plugin URI: http://cookworks.co/optimum-docs
Description: Allows a user to attach documents with Microsoft's Office Web Viewer or Google Document Viewer
Version: 1.0
Author: Dallas Cook
Author URI: http://cookworks.co
License: GPL2
*/

include(WP_PLUGIN_DIR.'/optimum-documents/admin.php');

function add_office_viewer( $atts ) {
	extract( shortcode_atts( array(
		'url' => '0',
		'width' => '500',
		'height' => '450'
	), $atts ) );
	return "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src={$url}' width='{$width}' height='{$height}' frameborder='0'></iframe>";
}
add_shortcode( 'add-office', 'add_office_viewer' );

function add_google_viewer( $atts ) {
	extract( shortcode_atts( array(
		'url' => '0',
		'width' => '600',
		'height' => '450'
	), $atts ) );
	$url = urlencode($url);
	return '<iframe src="http://docs.google.com/viewer?url='.$url.'&embedded=true" width="'.$width.'" height="'.$height.'" style="border: none;"></iframe>';
}
add_shortcode( 'add-google', 'add_google_viewer' );



global $wpdb;
$wpdb->show_errors();
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'register_odocs_menu_page');
} else {
}
$wpdb->hide_errors(); 
?>