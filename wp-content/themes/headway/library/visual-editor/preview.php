<?php
class HeadwayVisualEditorPreview {


public static function remove_preview_options() {

		if ( !HeadwayCapabilities::can_user_visually_edit() )
			return;

		//Fetch all options in wp_options and remove the preview-specific options
		foreach ( wp_load_alloptions() as $option => $option_value ) {
						
			//This if statement is incredibly important and must not be tampered with and needs to be triple-checked if changed.
			if ( preg_match('/^headway_(.*)?_preview$/', $option) && strpos($option, 'headway_') === 0 && strpos($option, '_preview') !== false ) {
				delete_option($option);
			}
			
		}

	}



}