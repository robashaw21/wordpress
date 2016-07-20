<?php

function register_odocs_menu_page() {
   $icon_url = WP_PLUGIN_DIR.'/optimum-documents/icon-16x16.png';
   $position = NULL;
   add_options_page('Optimum Documents Options',
   				 'Optimum Documents','manage_options',
   				 'optimum-documents/optimum-documents.php',
   				 'odocs_options', 
   				 $icon_url, 
   				 $position);
}

function odocs_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page. OD' ) );
	}
	
	echo '<div class="wrap optimum">
		  <style type="text/css">
		  	.optimum fieldset {
				width: 700px;
				padding: 5px 20px;
				background: #f5f5f5;
				border: 1px solid #EEE;
				margin: 20px 0;
		  	}
		  	.optimum fieldset legend {
				font-weight: bold;
				font-size: 14px;
				padding: 5px;
				border: 1px solid #EEE;
				background: #FFF;
		  	}
		  </style>
		 ';
	echo '<p><strong>Thank you for downloading Optimum Documents!</strong></p>';
	echo '<p>Below are some simple instructions on how to get started:</p>';
	
	echo '<p>The first step to getting started with <strong>Optimum Documents</strong> is to make sure that your document has been uploaded to the 
				<a href="/wp-admin/media-new.php">Media</a> section in Wordpress.</p>';
	echo '<p>YOUR_DOCUMENT_URL below is the url path to the document that you uploaded.</p>';
	echo '<fieldset>
			<legend>Office Viewer</legend>';
	echo '<p>To add a <strong>Office Web Apps Document Viewer</strong> to any page or post type, add the following shortcode into the editor:</p>';
	echo '<code>[add-office url="YOUR_DOCUMENT_URL" width="CUSTOM_WIDTH" height="CUSTOM_HEIGHT"]</code>';
	echo '<p>This is good for viewing Word (DOCX), Power Point (PPTX) and Excel (XLSX) files. *Does not support PDFs.</p>';
	echo '</fieldset>
	      <fieldset>
	      	<legend>Google Viewer</legend>';
	echo '<p>To add a <strong>Google Document Viewer</strong> to any page or post type, add the following shortcode into the editor:</p>';
	echo '<code>[add-google url="YOUR_DOCUMENT_URL" width="CUSTOM_WIDTH" height="CUSTOM_HEIGHT"]</code>';
	echo '<p>This is best for PDFs and also works well for PPT files. </p>';
	echo '<p>Height and Width can be specified in pixels (ex. px) or percent (ex. 90%).</p>';
	echo '</fieldset>';
	
	echo '</div>';
	
}

?>