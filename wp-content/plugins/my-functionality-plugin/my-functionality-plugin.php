<?php
/*
Plugin Name: Functionality Plugin for Skydive K-State
Plugin URI: http://www.doitwithwp.com/create-functions-plugin/
Description: Moves non-theme-specific functions away from functions.php for clarity and portability.
Author: Dave Clements
Version: 1.0
Author URI: http://www.theukedge.com
License: GPL2
*/



// ENTER SNIPPET NAME HERE AND CAPITALISE FOR QUICK REFERENCE //



// DISABLE CERTAIN FIELDS

function enqueue_gf_disable() {
	wp_enqueue_script( 'gf_disable', plugins_url( '/my-functionality-plugin/scripts/gravity-forms-disable.js', dirname(__FILE__) ) );
}

add_action( 'wp_enqueue_scripts', 'enqueue_gf_disable' );

// populate Event Date Time
add_filter('gform_field_value_scDateTime', 'scGetDateTime');
function scGetDateTime(){
    global $post; 
    return sc_get_event_date($post->ID) . ' at ' . sc_get_event_start_time($post->ID) ;
}
add_filter('gform_field_value_scEventList','scGetEventDate');
add_filter('gform_field_value_scEventDate','scGetEventDate');
function scGetEventDate(){
    global $post; 
    return date_i18n( "Y.m.d", sc_get_event_date($post->ID, false));
}

// populate FJC events
// SECOND SNIPPET NAME HERE //

// Add a custom field button to the advanced to the field editor
add_filter( 'gform_add_field_buttons', 'wps_add_EventList_field' );
function wps_add_EventList_field( $field_groups ) {
    foreach( $field_groups as &$group ){
        if( $group["name"] == "advanced_fields" ){ // to add to the Advanced Fields
		//if( $group["name"] == "standard_fields" ){ // to add to the Standard Fields
		//if( $group["name"] == "post_fields" ){ // to add to the Standard Fields
            $group["fields"][] = array(
				"class"=>"button",
				"value" => __("Event List", "gravityforms"),
				"onclick" => "StartAddField('eList');"
			);
            break;
        }
    }
    return $field_groups;
}

// Adds title to GF custom field
add_filter( 'gform_field_type_title' , 'wps_eList_title' );
function wps_eList_title( $type ) {
	if ( $type == 'eList' )
		return __( 'Event List' , 'gravityforms' );
}

// Adds the input area to the external side
add_action( "gform_field_input" , "wps_eList_field_input", 10, 5 );
function wps_eList_field_input ( $input, $field, $value, $lead_id, $form_id ){

    if ( $field["type"] == "eList" ) {
		$max_chars = "";
		if(!IS_ADMIN && !empty($field["maxLength"]) && is_numeric($field["maxLength"]))
			$max_chars = self::get_counter_script($form_id, $field_id, $field["maxLength"]);

		$input_name = $form_id .'_' . $field["id"];
		$css = isset( $field['cssClass'] ) ? $field['cssClass'] : '';
		
		return sprintf(sc_get_events_radio_list($field["id"],null, 10));
		
    }

    return $input;
}

// Now we execute some javascript technicalitites for the field to load correctly
add_action( "gform_editor_js", "wps_gform_editor_js" );
function wps_gform_editor_js(){
?>

<script type='text/javascript'>

	jQuery(document).ready(function($) {
		//Add all textarea settings to the "eList" field plus custom "eList_setting"
		// fieldSettings["eList"] = fieldSettings["textarea"] + ", .eList_setting"; // this will show all fields that Paragraph Text field shows plus my custom setting

		// from forms.js; can add custom "tos_setting" as well
		fieldSettings["eList"] = ".label_setting, .description_setting, .css_class_setting, .visibility_setting, .eList_setting, .prepopulate_field_setting"; //this will show all the fields of the Paragraph Text field minus a couple that I didn't want to appear.

		//binding to the load field settings event to initialize the checkbox
		$(document).bind("gform_load_field_settings", function(event, field, form){
			jQuery("#field_eList").attr("checked", field["field_eList"] == true);
			$("#field_tos_value").val(field["eList"]);
		});
	});

</script>
<?php
}

function sc_get_events_radio_list($fieldID, $category = null, $number = 5) {
	global $post,$field;
	
	$event_args = array(
		'post_type' => 'sc_event',
		'posts_per_page' => $number,
		'meta_key' => 'sc_event_date_time',
		'orderby' => 'meta_value_num',
		'order' => 'asc',
		'post_status' => 'publish'
	);
	
	$display == 'upcoming';
	$event_args['meta_compare'] = '>=';

	$event_args['meta_value'] = time();
	
	if( !is_null($category) )
		$event_args['sc_event_category'] = $category;
		
	$events = get_posts( apply_filters('sc_event_list_query', $event_args) );
	
	ob_start();
	
		$optionNum = 0;
		
		if ( $events ) {
			
			echo "<div class='ginput_container'><ul class='gfield_radio' id='input_" . $fieldID . "'>";
			foreach( $events as $event ) {
				echo "	<li class='gchoice_" . $fieldID . "_".$optionNum."'>";
				//echo "eventID: ".$event->ID."    postID: ".$post->ID."  ";
				
				echo"		<input name='input_" . $fieldID . "' type='radio' value='".date_i18n( "Y.m.d", sc_get_event_date($event->ID, false))."'";
				if(date_i18n( "Y.m.d", sc_get_event_date($event->ID, false)) == apply_filters('gform_field_value_scEventDate', '')) { 
					echo "checked='checked'"; 
				}
				echo " id='choice_" . $fieldID . "_".$optionNum."'".GFCommon::get_tabindex()." disabled='disabled' >";
				echo (date_i18n( "Y.m.d", sc_get_event_date($post->ID, false)) == date_i18n( "Y.m.d", sc_get_event_date($event->ID, false))) ? 'true' : 'false';
				echo"		<label for='choice_" . $fieldID . "_".$optionNum++."'>".sc_get_event_date($event->ID)."</label>";
				echo"	</li>";

			}
			echo"</ul></div>";
		}
	return ob_get_clean();
}

// THIRD SNIPPET NAME //
// SECOND SNIPPET NAME HERE //

function mailpoet_enable_wpmail(){
  if(class_exists('WYSIJA')){
    $model_config = WYSIJA::get('config','model');
    $model_config->save(array('allow_wpmail' => true));
  }
}
add_action('init', 'mailpoet_enable_wpmail');
// repeat this format for however many snippets you have //