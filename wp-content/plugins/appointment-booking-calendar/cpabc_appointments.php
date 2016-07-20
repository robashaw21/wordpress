<?php
/*
Plugin Name: Appointment Booking Calendar
Plugin URI: http://wordpress.dwbooster.com/calendars/appointment-booking-calendar
Description: This plugin allows you to easily insert appointments forms into your WP website.
Version: 7.11
Author: CodePeople.net
Author URI: http://codepeople.net
License: GPL
*/


/* initialization / install / uninstall functions */

define('CPABC_APPOINTMENTS_DEFAULT_ON_CANCEL_REDIRECT_TO', '/'); // Undocumented feature: Return address for the cancellation link.

define('CPABC_APPOINTMENTS_AUTO_FILL_LOGGED_USER_DATA', true); // Auto-fill email field with logged in user's email address. Works only in predefined classic form.

define('CPABC_APPOINTMENTS_IDENTIFY_PRICES', false);  // Undocumented feature: Currently disabled. Still in beta version.

define('CPABC_APPOINTMENTS_ACTIVATECC', false);  // CCF activate, not available yet

define('CPABC_DISCOUNT_FIELDS', 0); // Undocumented, disabled, future feature not fully tested yet

define('CPABC_APPOINTMENTS_ICAL_OBSERVE_DAYLIGHT', true);  // Undocumented, disabled as default
define('CPABC_APPOINTMENTS_ICAL_DAYLIGHT_ZONE', 'Europe');  // Undocumented, valid valued: Europe, USA

define('CPABC_APPOINTMENTS_ADV_DUPLICITY_VERIFICATION', false);

define('CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD', 0);
define('CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL', 'Quantity');
define('CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_TWO', 0);
define('CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_TWO_LABEL', 'Juniors');
define('CPABC_APPOINTMENTS_ENABLE_AJAX_PRICE', '0');

define('CPABC_APPOINTMENTS_DEFAULT_DEFER_SCRIPTS_LOADING', (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',"1") == "1"?true:false));

define('CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL','$');
define('CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL',chr(163));
define('CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A','EUR ');
define('CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B',chr(128));

define('CPABC_EMAIL_REPORT_ENABLED',false); // beta feature, do not enable
define('CPABC_EMAIL_REPORT_TO',''); // if empty the notification for each calendar will be used
define('CPABC_EMAIL_REPORT_SUBJECT','Appointment for today...'); 
define('CPABC_EMAIL_REPORT_MESSAGE','CSV file attached.');

define('CPABC_APPOINTMENTS_ENABLE_PG_STRIPE', false);
define('CPABC_APPOINTMENTS_ENABLE_PG_AUTHORIZE', false);

define('CPABC_APPOINTMENTS_DEFAULT_form_structure', '[[{"name":"email","index":0,"title":"Email","ftype":"femail","userhelp":"","csslayout":"","required":true,"predefined":"","size":"medium"},{"name":"subject","index":1,"title":"Subject","required":true,"ftype":"ftext","userhelp":"","csslayout":"","predefined":"","size":"medium"},{"name":"message","index":2,"size":"large","required":true,"title":"Message","ftype":"ftextarea","userhelp":"","csslayout":"","predefined":""}],[{"title":"","description":"","formlayout":"top_aligned"}]]');

define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_OPTION_YES', 'Pay with PayPal.');
define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_OPTION_NO', 'Pay later.');

define('CPABC_APPOINTMENTS_SEND_REMINDER_ADMIN', true);

define('CPABC_APPOINTMENTS_TZONE', false);
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_LANGUAGE', 'EN');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT', '0');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME', '1');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY', '0');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE', 'today');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE', '');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_PAGES', 3);

define('CPABC_APPOINTMENTS_DEFAULT_cu_user_email_field', 'email');
define('CPABC_APPOINTMENTS_DEFAULT_email_format', 'text');
define('CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL', 1);
define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL','put_your@email_here.com');
define('CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME','Consultation');
define('CPABC_APPOINTMENTS_DEFAULT_COST','25');
define('CPABC_APPOINTMENTS_DEFAULT_OK_URL',get_site_url());
define('CPABC_APPOINTMENTS_DEFAULT_CANCEL_URL',get_site_url());
define('CPABC_APPOINTMENTS_DEFAULT_CURRENCY','USD');
define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_LANGUAGE','EN');

define('CPABC_APPOINTMENTS_DEFAULT_ENABLE_REMINDER', 0);
define('CPABC_APPOINTMENTS_DEFAULT_REMINDER_HOURS', 24);
define('CPABC_APPOINTMENTS_DEFAULT_REMINDER_SUBJECT', 'Appointment reminder...');
define('CPABC_APPOINTMENTS_DEFAULT_REMINDER_CONTENT', "This is a reminder for your appointment with the following information:\n\n%INFORMATION%\n\nThank you.\n\nBest regards.");

define('CPABC_APPOINTMENTS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL', 'Thank you for your request...');
define('CPABC_APPOINTMENTS_DEFAULT_CONFIRMATION_EMAIL', "We have received your request with the following information:\n\n%INFORMATION%\n\nThank you.\n\nBest regards.");
define('CPABC_APPOINTMENTS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL','New appointment requested...');
define('CPABC_APPOINTMENTS_DEFAULT_NOTIFICATION_EMAIL', "New appointment made with the following information:\n\n%INFORMATION%\n\nBest regards.");

define('CPABC_APPOINTMENTS_DEFAULT_CP_CAL_CHECKBOXES',"");
define('CPABC_APPOINTMENTS_DEFAULT_EXPLAIN_CP_CAL_CHECKBOXES',"1.00 | Service 1 for us$1.00\n5.00 | Service 2 for us$5.00\n10.00 | Service 3 for us$10.00");

// tables

define('CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX', "cpabc_appointments");
define('CPABC_APPOINTMENTS_TABLE_NAME', @$wpdb->prefix . CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX);

define('CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX', "cpabc_appointment_calendars_data");
define('CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME', @$wpdb->prefix ."cpabc_appointment_calendars_data");

define('CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX', "cpabc_appointment_calendars");
define('CPABC_APPOINTMENTS_CONFIG_TABLE_NAME', @$wpdb->prefix ."cpabc_appointment_calendars");

define('CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX', "cpabc_appointments_discount_codes");
define('CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME', @$wpdb->prefix ."cpabc_appointments_discount_codes");

// calendar constants

define("CPABC_TDEAPP_DEFAULT_CALENDAR_ID","1");
define("CPABC_TDEAPP_DEFAULT_CALENDAR_LANGUAGE","EN");

define("CPABC_TDEAPP_CAL_PREFIX", "cal");
define("CPABC_TDEAPP_CONFIG",CPABC_APPOINTMENTS_CONFIG_TABLE_NAME);
define("CPABC_TDEAPP_CONFIG_ID","id");
define("CPABC_TDEAPP_CONFIG_TITLE","title");
define("CPABC_TDEAPP_CONFIG_USER","uname");
define("CPABC_TDEAPP_CONFIG_PASS","passwd");
define("CPABC_TDEAPP_CONFIG_LANG","lang");
define("CPABC_TDEAPP_CONFIG_CPAGES","cpages");
define("CPABC_TDEAPP_CONFIG_TYPE","ctype");
define("CPABC_TDEAPP_CONFIG_MSG","msg");
define("CPABC_TDEAPP_CONFIG_WORKINGDATES","workingDates");
define("CPABC_TDEAPP_CONFIG_RESTRICTEDDATES","restrictedDates");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0","timeWorkingDates0");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1","timeWorkingDates1");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2","timeWorkingDates2");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3","timeWorkingDates3");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4","timeWorkingDates4");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5","timeWorkingDates5");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6","timeWorkingDates6");
define("CPABC_TDEAPP_CALDELETED_FIELD","caldeleted");

define("CPABC_TDEAPP_CALENDAR_DATA_TABLE",CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME);
define("CPABC_TDEAPP_DATA_ID","id");
define("CPABC_TDEAPP_DATA_IDCALENDAR","appointment_calendar_id");
define("CPABC_TDEAPP_DATA_DATETIME","datatime");
define("CPABC_TDEAPP_DATA_TITLE","title");
define("CPABC_TDEAPP_DATA_DESCRIPTION","description");
// end calendar constants

define('CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha', 'true');
define('CPABC_TDEAPP_DEFAULT_dexcv_width', '180');
define('CPABC_TDEAPP_DEFAULT_dexcv_height', '60');
define('CPABC_TDEAPP_DEFAULT_dexcv_chars', '5');
define('CPABC_TDEAPP_DEFAULT_dexcv_font', 'font-1.ttf');
define('CPABC_TDEAPP_DEFAULT_dexcv_min_font_size', '25');
define('CPABC_TDEAPP_DEFAULT_dexcv_max_font_size', '35');
define('CPABC_TDEAPP_DEFAULT_dexcv_noise', '200');
define('CPABC_TDEAPP_DEFAULT_dexcv_noise_length', '4');
define('CPABC_TDEAPP_DEFAULT_dexcv_background', 'ffffff');
define('CPABC_TDEAPP_DEFAULT_dexcv_border', '000000');
define('CPABC_TDEAPP_DEFAULT_dexcv_text_enter_valid_captcha', 'Please enter a valid captcha code.');

define('CPABC_APPOINTMENTS_DEFAULT_vs_text_is_required', 'This field is required.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_is_email', 'Please enter a valid email address.');

define('CPABC_APPOINTMENTS_DEFAULT_vs_text_datemmddyyyy', 'Please enter a valid date with this format(mm/dd/yyyy)');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_dateddmmyyyy', 'Please enter a valid date with this format(dd/mm/yyyy)');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_number', 'Please enter a valid number.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_digits', 'Please enter only digits.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_max', 'Please enter a value less than or equal to {0}.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_min', 'Please enter a value greater than or equal to {0}.');




register_activation_hook(__FILE__,'cpabc_appointments_install');

function cpabc_plugin_init() {
  load_plugin_textdomain( 'cpabc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'cpabc_plugin_init');

function cpabc_appointments_install($networkwide)  {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
	                $old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				_cpabc_appointments_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	_cpabc_appointments_install();
}

function _cpabc_appointments_install() {
    global $wpdb;


    $table_name = $wpdb->prefix . CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX;

    $sql = "CREATE TABLE ".$wpdb->prefix.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         cal_id mediumint(9) NOT NULL DEFAULT 1,
         code VARCHAR(250) DEFAULT '' NOT NULL,
         discount VARCHAR(250) DEFAULT '' NOT NULL,
         expires datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         availability int(10) unsigned NOT NULL DEFAULT 0,
         used int(10) unsigned NOT NULL DEFAULT 0,
         UNIQUE KEY id (id)
         );";
    $wpdb->query($sql);

    $sql = "CREATE TABLE $table_name (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         booked_time VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_customer VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_unformatted VARCHAR(250) DEFAULT '' NOT NULL,
         name VARCHAR(250) DEFAULT '' NOT NULL,
         email VARCHAR(250) DEFAULT '' NOT NULL,
         phone VARCHAR(250) DEFAULT '' NOT NULL,
         question mediumtext,
         quantity VARCHAR(25) DEFAULT '1' NOT NULL,
         quantity_a VARCHAR(25) DEFAULT '1' NOT NULL,
         quantity_s VARCHAR(25) DEFAULT '1' NOT NULL,
         buffered_date text,
         who_added  VARCHAR(50) DEFAULT '' NOT NULL,
         UNIQUE KEY id (id)
         );";
    $wpdb->query($sql);
    $sql = "ALTER TABLE  $table_name ADD `calendar` INT NOT NULL AFTER  `id`;";
    $wpdb->query($sql);

    $sql = "CREATE TABLE `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` (`".CPABC_TDEAPP_CONFIG_ID."` int(10) unsigned NOT NULL auto_increment, `".CPABC_TDEAPP_CONFIG_TITLE."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_USER."` varchar(100) default NULL,`".CPABC_TDEAPP_CONFIG_PASS."` varchar(100) default NULL,`".CPABC_TDEAPP_CONFIG_LANG."` varchar(5) default NULL,`".CPABC_TDEAPP_CONFIG_CPAGES."` tinyint(3) unsigned default NULL,`".CPABC_TDEAPP_CONFIG_TYPE."` tinyint(3) unsigned default NULL,`".CPABC_TDEAPP_CONFIG_MSG."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_WORKINGDATES."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_RESTRICTEDDATES."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6."` text,`".CPABC_TDEAPP_CALDELETED_FIELD."` tinyint(3) unsigned default NULL,PRIMARY KEY (`".CPABC_TDEAPP_CONFIG_ID."`)); ";
    $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `conwer` INT NOT NULL AFTER  `id`;";

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `form_structure` mediumtext AFTER  `id`;";     $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `specialDates` text AFTER  `id`;";     $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `enable_paypal_option_yes` VARCHAR(250) DEFAULT '' NOT NULL AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `enable_paypal_option_no` VARCHAR(250) DEFAULT '' NOT NULL  AFTER  `id`;";     $wpdb->query($sql);
    
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `stripe_key` VARCHAR(250) DEFAULT '' NOT NULL  AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `stripe_secretkey` VARCHAR(250) DEFAULT '' NOT NULL  AFTER  `id`;";     $wpdb->query($sql);
    
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `authorizenet_api_id` VARCHAR(250) DEFAULT '' NOT NULL  AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `authorizenet_tra_key` VARCHAR(250) DEFAULT '' NOT NULL  AFTER  `id`;";     $wpdb->query($sql);
 
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_use_validation` VARCHAR(10) DEFAULT '' NOT NULL      AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_is_required` VARCHAR(250) DEFAULT '' NOT NULL   AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_is_email` VARCHAR(250) DEFAULT '' NOT NULL      AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_datemmddyyyy` VARCHAR(250) DEFAULT '' NOT NULL  AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_dateddmmyyyy` VARCHAR(250) DEFAULT '' NOT NULL  AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_number` VARCHAR(250) DEFAULT '' NOT NULL        AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_digits` VARCHAR(250) DEFAULT '' NOT NULL        AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_max` VARCHAR(250) DEFAULT '' NOT NULL           AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_min` VARCHAR(250) DEFAULT '' NOT NULL           AFTER  `id`;";     $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `vs_text_submitbtn` VARCHAR(250) DEFAULT '' NOT NULL           AFTER  `id`;";     $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `conwer` INT NOT NULL AFTER  `id`;";     $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_language` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_dateformat` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_pages` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_militarytime` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_weekday` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_mindate` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_maxdate` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_startmonth` VARCHAR(20) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_startyear` VARCHAR(20) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_theme` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `gmt_enabled` VARCHAR(20) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `gmt_diff` VARCHAR(20) DEFAULT '' NOT NULL;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `min_slots` VARCHAR(10) DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `max_slots` VARCHAR(10) DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `close_fpanel` VARCHAR(10) DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `quantity_field` VARCHAR(10) DEFAULT '0' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `quantity_field_two` VARCHAR(10) DEFAULT '0' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `quantity_field_label` VARCHAR(250) DEFAULT '".CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL."' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `quantity_field_two_label` VARCHAR(250) DEFAULT '".CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_TWO_LABEL."' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `ajax_load_enabled` VARCHAR(10) DEFAULT '".CPABC_APPOINTMENTS_ENABLE_AJAX_PRICE."' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_mode` VARCHAR(10) DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `enable_paypal` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_email` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `request_cost` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `request_cost_st` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_price_field` VARCHAR(50) DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_product_name` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `currency` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `url_ok` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `url_cancel` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_language` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `cu_user_email_field` VARCHAR(250) DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `notification_from_email` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `notification_destination_email` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_subject_confirmation_to_user` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_confirmation_to_user` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_subject_notification_to_admin` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_notification_to_admin` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `enable_reminder` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `reminder_hours` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `reminder_subject` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `reminder_content` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);


    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_enable_captcha` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_width` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_height` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_chars` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_min_font_size` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_max_font_size` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_noise` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_noise_length` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_background` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_border` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_font` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `cv_text_enter_valid_captcha` VARCHAR(250) DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `cp_cal_checkboxes` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `nuser_emailformat` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `nadmin_emailformat` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `nremind_emailformat` text AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "CREATE TABLE `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME."` (`".CPABC_TDEAPP_DATA_ID."` int(10) unsigned NOT NULL auto_increment,`".CPABC_TDEAPP_DATA_IDCALENDAR."` int(10) unsigned default NULL,`".CPABC_TDEAPP_DATA_DATETIME."`datetime NOT NULL default '0000-00-00 00:00:00',`".CPABC_TDEAPP_DATA_TITLE."` varchar(250) default NULL,`".CPABC_TDEAPP_DATA_DESCRIPTION."` mediumtext,PRIMARY KEY (`".CPABC_TDEAPP_DATA_ID."`)) ;";
    $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `reminder` VARCHAR(1) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `reference` VARCHAR(20) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `quantity` VARCHAR(25) DEFAULT '1' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `quantity_a` VARCHAR(25) DEFAULT '1' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `quantity_s` VARCHAR(25) DEFAULT '1' NOT NULL;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `who_added` VARCHAR(25) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `who_edited` VARCHAR(25) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `who_cancelled` VARCHAR(25) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `is_cancelled` VARCHAR(25) DEFAULT '0' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `cancelled_reason` TEXT;"; $wpdb->query($sql);

    $sql = 'INSERT INTO `'.$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` (conwer,`form_structure`,`'.CPABC_TDEAPP_CONFIG_ID.'`,`'.CPABC_TDEAPP_CONFIG_TITLE.'`,`'.CPABC_TDEAPP_CONFIG_USER.'`,`'.CPABC_TDEAPP_CONFIG_PASS.'`,`'.CPABC_TDEAPP_CONFIG_LANG.'`,`'.CPABC_TDEAPP_CONFIG_CPAGES.'`,`'.CPABC_TDEAPP_CONFIG_TYPE.'`,`'.CPABC_TDEAPP_CONFIG_MSG.'`,`'.CPABC_TDEAPP_CONFIG_WORKINGDATES.'`,`'.CPABC_TDEAPP_CONFIG_RESTRICTEDDATES.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6.'`,`'.CPABC_TDEAPP_CALDELETED_FIELD.'`) '.
                                                                                ' VALUES(0,"'.esc_sql(CPABC_APPOINTMENTS_DEFAULT_form_structure).'","1","cal1","Calendar Item 1","","ENG","1","3","Please, select your appointment.","1,2,3,4,5","","","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","","0");';
    $wpdb->query($sql);

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    //dbDelta($sql);

}



/* Filter for placing the maps into the contents */



function cpabc_appointments_filter_content($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
	), $atts ) );
    if ($calendar != '')
        define ('CPABC_CALENDAR_FIXED_ID',$calendar);
    else if ($user != '')
    {
        $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." WHERE user_login='".esc_sql($user)."'" );
        if (isset($users[0]))
            define ('CPABC_CALENDAR_USER',$users[0]->ID);
        else
            define ('CPABC_CALENDAR_USER',0);
    }
    else
        define ('CPABC_CALENDAR_USER',0);
    ob_start();
    cpabc_appointments_get_public_form();
    $buffered_contents = ob_get_contents();
    ob_end_clean();
    return $buffered_contents;
}


function cpabc_appointments_filter_edit($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
	), $atts ) );
	$buffered_contents = '';
	$current_user = wp_get_current_user();
	$myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." where conwer<>'' AND conwer='".esc_sql($current_user->ID )."'" );
    if (count($myrows))
    {
        if (!defined('CP_CALENDAR_ID'))
            define ('CP_CALENDAR_ID',$myrows[0]->id);
        define ('CPABC_CALENDAR_ON_PUBLIC_WEBSITE',true);
        ob_start();
        @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int.inc.php';
        $buffered_contents = ob_get_contents();
        ob_end_clean();
    }
    return $buffered_contents;
}


function cpabc_appointments_filter_list($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
		'group' => 'no',
		'fields' => 'DATE,TIME,NAME',
		'from' => "today",
		'to' => "today +30 days",
	), $atts ) );

	$from = date("Y-m-d 00:00:00", strtotime($from));
	$to = date("Y-m-d 23:59:59", strtotime($to));
	$group = strtolower($group);

	$CPABC_CALENDAR_FIXED_ID = '';
	$CPABC_CALENDAR_USER = '';

    if ($calendar != '')
        $CPABC_CALENDAR_FIXED_ID = $calendar;
    else if ($user != '')
    {
        $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." WHERE user_login='".esc_sql($user)."'" );
        if (isset($users[0]))
            $CPABC_CALENDAR_USER = $users[0]->ID;
        else
            $CPABC_CALENDAR_USER = 0;
    }
    else
        $CPABC_CALENDAR_USER = 0;

    if ($CPABC_CALENDAR_USER != '' && $CPABC_CALENDAR_USER != 0)
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE conwer=".$CPABC_CALENDAR_USER );
    else if ($CPABC_CALENDAR_FIXED_ID != '')
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=".$CPABC_CALENDAR_FIXED_ID );
    else
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME );

    $CP_CALENDAR_ID = '';
    foreach($myrows as $item)
        $CP_CALENDAR_ID .= ($CP_CALENDAR_ID==''?'':',').$item->id;

    ob_start();
    echo '<link rel="stylesheet" type="text/css" href="'.plugins_url('TDE_AppCalendar/'.cpabc_get_option('calendar_theme','').'all-css.css', __FILE__).'" />';
    $fields = explode(",",$fields);
    $last_date = '';
    $mycalendarrows = $wpdb->get_results( "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE .
                                  " INNER JOIN  ".CPABC_APPOINTMENTS_TABLE_NAME." on  ".CPABC_APPOINTMENTS_TABLE_NAME.".id=".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".reference " .
                                  " INNER JOIN  ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." on  ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".id=".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".appointment_calendar_id " .
                                  "WHERE datatime>='".$from."' AND datatime<='".$to."' AND appointment_calendar_id in (".$CP_CALENDAR_ID.") ORDER BY datatime ASC");
    for($f=0; $f<count($mycalendarrows); $f++) {
        $params = unserialize($mycalendarrows[$f]->buffered_date);
        $params["CALENDAR"] = $mycalendarrows[$f]->uname;
        $params["WEEKDAY"] = date("l",strtotime($mycalendarrows[$f]->booked_time_unformatted));
        $newline = ($last_date != $mycalendarrows[$f]->booked_time_unformatted);
        if ($group != 'yes' || $newline)
        {
            echo '<div class="cpabc_field_clear"></div>';
        }
        for ($k=0; $k < count($fields); $k++)
        {
            $fieldname = trim($fields[$k]);
            if ($group == 'yes')
            {
                if ($newline || ($fieldname != "DATE" && $fieldname != "TIME"))
                {
                    echo '<div class="cpabc_field_'.$k.'">';
                    echo (@$params[$fieldname]);
                    if ($fieldname != "DATE" && $fieldname != "TIME")
                    {
                        while ($f<count($mycalendarrows) && @$mycalendarrows[$f+1]->booked_time_unformatted == @$mycalendarrows[$f]->booked_time_unformatted)
                        {
                            $f++;
                            $params = unserialize($mycalendarrows[$f]->buffered_date);
                            echo ", ".@$params[$fieldname];
                        }
                        $k = count($fields);
                    }
                    echo '</div>';
                }
            }
            else
                echo '<div class="cpabc_field_'.$k.'">'.(@$params[$fieldname]).'&nbsp;</div>';
        }
        $last_date = $mycalendarrows[$f]->booked_time_unformatted;
    }
    echo '<div class="cpabc_field_clear"></div>';
    $buffered_contents = ob_get_contents();
    ob_end_clean();
    return $buffered_contents;
}



function cpabc_appointments_get_public_form() {

    global $wpdb;

    if (defined('CPABC_CALENDAR_USER') && CPABC_CALENDAR_USER != 0)
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE conwer=".CPABC_CALENDAR_USER." AND caldeleted=0" );
    else if (defined('CPABC_CALENDAR_FIXED_ID'))
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=".CPABC_CALENDAR_FIXED_ID." AND caldeleted=0" );
    else
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE caldeleted=0" );

    define ('CP_CALENDAR_ID',$myrows[0]->id);

    $button_label = cpabc_get_option('vs_text_submitbtn', 'Continue');
    $button_label = ($button_label==''?'Continue':$button_label);

    $previous_label = __("Previous",'cpabc');
    $next_label = __("Next",'cpabc');


    if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1")
    {
        if (CPABC_APPOINTMENTS_DEFAULT_DEFER_SCRIPTS_LOADING)
        {
            wp_deregister_script('query-stringify');
            wp_register_script('query-stringify', plugins_url('/js/jQuery.stringify.js', __FILE__));

            wp_deregister_script('cp_abc_validate_script');
            wp_register_script('cp_abc_validate_script', plugins_url('/js/jquery.validate.js', __FILE__));

            wp_enqueue_script( 'cp_contactformpp_buikder_script',
            plugins_url('/js/fbuilder-loader-public.php', __FILE__),array("jquery","jquery-ui-core","jquery-ui-button","jquery-ui-datepicker","jquery-ui-widget","jquery-ui-position","jquery-ui-tooltip","query-stringify","cp_abc_validate_script"), false, true );

            wp_localize_script('cp_contactformpp_buikder_script', 'cp_contactformpp_fbuilder_config', array('obj'  	=>
'{"pub":true,"messages": {
"required": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_is_required', CPABC_APPOINTMENTS_DEFAULT_vs_text_is_required)).'",
"email": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_is_email', CPABC_APPOINTMENTS_DEFAULT_vs_text_is_email)).'",
"datemmddyyyy": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_datemmddyyyy', CPABC_APPOINTMENTS_DEFAULT_vs_text_datemmddyyyy)).'",
"dateddmmyyyy": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_dateddmmyyyy', CPABC_APPOINTMENTS_DEFAULT_vs_text_dateddmmyyyy)).'",
"number": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_number', CPABC_APPOINTMENTS_DEFAULT_vs_text_number)).'",
"digits": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_digits', CPABC_APPOINTMENTS_DEFAULT_vs_text_digits)).'",
"max": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_max', CPABC_APPOINTMENTS_DEFAULT_vs_text_max)).'",
"min": "'.str_replace(array('"'),array('\\"'),cpabc_get_option('vs_text_min', CPABC_APPOINTMENTS_DEFAULT_vs_text_min)).'",
"previous": "'.str_replace(array('"'),array('\\"'),$previous_label).'",
"next": "'.str_replace(array('"'),array('\\"'),$next_label).'"
}}'
    	    ));
        } else {
            wp_enqueue_script( "jquery" );
            wp_enqueue_script( "jquery-ui-core" );
            wp_enqueue_script( "jquery-ui-datepicker" );
        }
    }
    else
        wp_enqueue_script( 'jquery' );

    $calendar_items = '';
    foreach ($myrows as $item)
      $calendar_items .=  '<option value='.$item->id.'>'.$item->uname.'</option>';

    $cpabc_buffer = "";
    $services = explode("\n",cpabc_get_option('cp_cal_checkboxes', CPABC_APPOINTMENTS_DEFAULT_CP_CAL_CHECKBOXES));
    foreach ($services as $item)
        if (trim($item) != '')
            $cpabc_buffer .= '<option value="'.esc_attr(trim($item)).'">'.trim(substr($item,strpos($item,"|")+1)).'</option>';

    $codes = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME.' WHERE `cal_id`='.CP_CALENDAR_ID);

    $quant_buffer = '';
    $qant_value = cpabc_get_option('quantity_field','0');
    $qant_value_two = '0';
    if ($qant_value != '0' && $qant_value != '')
    {
        $qant_value = intval($qant_value);
        $quant_buffer = __(cpabc_get_option('quantity_field_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL),'cpabc').':<br /><select id="abc_capacity_a" name="abc_capacity_a" onchange="apc_clear_date();">';
        for ($i=1; $i<=$qant_value; $i++)
            $quant_buffer .= '<option'.($i==1?' selected="selected"':'').'>'.$i.'</option>';
        $quant_buffer .= '</select><br />';

        $qant_value_two = cpabc_get_option('quantity_field_two','0');
        if ($qant_value_two != '0' && $qant_value_two != '')
        {
            $quant_buffer .= __(cpabc_get_option('quantity_field_two_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_TWO_LABEL),'cpabc').':<br /><select id="abc_capacity_s" name="abc_capacity_s" onchange="apc_clear_date();">';
            for ($i=0; $i<=$qant_value_two; $i++)
                $quant_buffer .= '<option'.($i==0?' selected="selected"':'').'>'.$i.'</option>';
            $quant_buffer .= '</select><br />';
        }

        $quant_buffer .= '<input type="hidden" id="abc_capacity" name="abc_capacity" value="1">';
    }

    ?>
</p> <!-- this p tag fixes a IE bug -->
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_AppCalendar/'.cpabc_get_option('calendar_theme','').'all-css.css', __FILE__); ?>" />
<script>
var pathCalendar = "<?php echo cpabc_appointment_get_site_url(); ?>";
var cpabc_global_date_format = '<?php echo cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT); ?>';
var cpabc_global_military_time = '<?php echo cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME); ?>';
var cpabc_global_start_weekday = '<?php echo cpabc_get_option('calendar_weekday', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY); ?>';
var cpabc_global_mindate = '<?php $value = cpabc_get_option('calendar_mindate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE); if ($value != '') echo date("n/j/Y", strtotime($value)); ?>';
var cpabc_global_maxdate = '<?php $value = cpabc_get_option('calendar_maxdate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE); if ($value != '') echo date("n/j/Y",strtotime($value)); ?>';
var cpabc_global_gmt_enabled = <?php $value = cpabc_get_option('gmt_enabled', 'no'); if ($value == 'yes' && CPABC_APPOINTMENTS_TZONE) echo 'true'; else echo 'false'; ?>;
var cpabc_global_gmt = <?php $value = cpabc_get_option('gmt_diff', '0'); if ($value != '') echo intval($value); else echo '0'; ?>;
var cpabc_global_close_on_select = <?php $value = cpabc_get_option('close_fpanel', 'yes'); if ($value == '' || $value == 'yes') echo 'true'; else echo 'false'; ?>;
var cpabc_global_cancel_text = '<?php _e("Cancel",'cpabc'); ?>';
var cpabc_global_pagedate = '<?php
    $sm = cpabc_get_option('calendar_startmonth', date("n"));
    $sy = cpabc_get_option('calendar_startyear', date("Y"));
    if ($sm=='0' || $sm=='') $sm = date("n");
    if ($sy=='0' || $sy=='') $sy = date("Y");
    echo $sm."/".$sy;
?>';
</script>
<script type="text/javascript" src="<?php echo plugins_url('TDE_AppCalendar/all-scripts.js', __FILE__); ?>"></script>
<script type="text/javascript">
 var cpabc_current_calendar_item;
 var abc_last_date = '';
 var abc_cost = '';
 function apc_clear_date()
 {
    document.getElementById("selDaycal"+cpabc_current_calendar_item ).value = "";
    <?php if ($qant_value != '0' && $qant_value != '') { ?>
        var adults = document.FormEdit.abc_capacity_a.options.selectedIndex+1;
        <?php if ($qant_value_two != '0' && $qant_value_two != '') { ?>
            var students = document.FormEdit.abc_capacity_s.options.selectedIndex;
        <?php } else { ?>
            var students = 0;
        <?php } ?>
        document.FormEdit.abc_capacity.value = adults + students;
    <?php } ?>
    cpabc_updateItem();
 }
 function cpabc_updateItem()
 {
    document.getElementById("calarea_"+cpabc_current_calendar_item).style.display = "none";
    var i = document.FormEdit.cpabc_item.options.selectedIndex;
    var selecteditem = document.FormEdit.cpabc_item.options[i].value;
    cpabc_do_init(selecteditem);
 }
 function cpabc_do_init(id)
 {                                                      
    cpabc_current_calendar_item = id;
    document.getElementById("calarea_"+cpabc_current_calendar_item).style.display = "";
    cpabc_global_date_format = document.getElementById("ccpabc_global_date_format"+id).value;
    cpabc_global_military_time = document.getElementById("ccpabc_global_military_time"+id).value;
    cpabc_global_start_weekday = document.getElementById("ccpabc_global_start_weekday"+id).value;
    cpabc_global_mindate = document.getElementById("cmintime"+id).value;
    cpabc_global_maxdate = document.getElementById("cmaxtime"+id).value;
    if (document.getElementById("ccpabc_global_gmt_enabled"+id).value == 'true') 
        cpabc_global_gmt_enabled = true;
    else
        cpabc_global_gmt_enabled = false;    
    cpabc_global_gmt = document.getElementById("ccpabc_global_gmt"+id).value;
    if (document.getElementById("ccpabc_global_close_on_select"+id).value == 'true') 
        cpabc_global_close_on_select = true;
    else
        cpabc_global_close_on_select = false;    
    cpabc_global_pagedate = document.getElementById("ccpabc_global_pagedate"+id).value;    
    initAppCalendar("cal"+cpabc_current_calendar_item,document.getElementById("ccpages"+id).value,2,document.getElementById("cclanguage"+id).value,{m1:"<?php _e('Please select the appointment time.','cpabc'); ?>"});
 }
 function force_updatedate() {
     abc_last_date = "";
     updatedate();
 }
 function updatedate()
 {
<?php      
     if (cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '3' || cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '4')
         $ajax_enabled_value = '1';
     else
         $ajax_enabled_value = cpabc_get_option('ajax_load_enabled',CPABC_APPOINTMENTS_ENABLE_AJAX_PRICE);     
    if ($ajax_enabled_value != '0' && $ajax_enabled_value != '') { ?>
    if (document.getElementById("selDaycal"+cpabc_current_calendar_item ).value == '')
       document.getElementById("abccost").innerHTML = '';
    if (document.getElementById("selDaycal"+cpabc_current_calendar_item ).value != '')
    {
        if (document.getElementById("selDaycal"+cpabc_current_calendar_item ).value != abc_last_date)
        {
            document.getElementById("abccost").innerHTML = '';
            abc_last_date = document.getElementById("selDaycal"+cpabc_current_calendar_item ).value;
            var services = "";
            try { services = document.FormEdit.services.options[document.FormEdit.services.options.selectedIndex].value; } catch (e) {}
            <?php if ($qant_value != '0' && $qant_value != '') { ?>var adults = document.FormEdit.abc_capacity_a.options.selectedIndex+1;<?php } else { ?>var adults = 1;<?php } ?>
            <?php if ($qant_value_two != '0' && $qant_value_two != '') { ?>var students = document.FormEdit.abc_capacity_s.options.selectedIndex;<?php } else { ?>var students = 0;<?php } ?>
            abc_cost = '';
            $dexQuery = jQuery.noConflict();
            $dexQuery.ajax({
                      type: "GET",
                      url: "<?php echo cpabc_appointment_get_site_url(); ?>/?dex_abc=getcost"+String.fromCharCode(38)
                      +"inAdmin=1"+String.fromCharCode(38)
                      +"cpabc_item="+cpabc_current_calendar_item+""+String.fromCharCode(38)
                      +"selDaycal"+cpabc_current_calendar_item+"="+abc_last_date+""+String.fromCharCode(38)<?php if ($qant_value != '0' && $qant_value != '') { ?>+"abc_capacity="+(adults+students)+String.fromCharCode(38)<?php } ?><?php if ($qant_value != '0' && $qant_value != '') { ?>+"abc_capacity_a="+adults+String.fromCharCode(38)<?php } ?><?php if ($qant_value_two != '0' && $qant_value_two != '') { ?> +"abc_capacity_s="+students+String.fromCharCode(38)<?php } ?><?php if ($cpabc_buffer != '') { ?>+"services="+services+""+String.fromCharCode(38)<?php } ?>,
                    }).done(function( html ) {
                        document.getElementById("abccost").innerHTML = '';
                        abc_cost = html;
                        $dexQuery("#abccost").append('<b><?php _e("Cost",'cpabc'); ?>:</b> <?php echo cpabc_get_option('currency', CPABC_APPOINTMENTS_DEFAULT_CURRENCY); ?> '+html);
                    });
        }
    } 
    else abc_last_date = ""; 
<?php } ?>
 }
 </script>
    <?php
    $current_user = wp_get_current_user();
    define('CPABC_AUTH_INCLUDE', true);
    if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1")
    {
        @include dirname( __FILE__ ) . '/cpabc_internal.inc.php';
        if (!CPABC_APPOINTMENTS_DEFAULT_DEFER_SCRIPTS_LOADING) {
        ?>
        <?php $plugin_url = plugins_url('', __FILE__); ?>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/jquery.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/jquery.ui.core.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/jquery.ui.widget.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/jquery.ui.position.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/jquery.ui.tooltip.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo plugins_url('js/jQuery.stringify.js', __FILE__); ?>'></script>
<script type='text/javascript' src='<?php echo plugins_url('js/jquery.validate.js', __FILE__); ?>'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var cp_contactformpp_fbuilder_config = {"obj":"{\"pub\":true,\"messages\": {\n    \t                \t\"required\": \"This field is required.\",\n    \t                \t\"email\": \"Please enter a valid email address.\",\n    \t                \t\"datemmddyyyy\": \"Please enter a valid date with this format(mm\/dd\/yyyy)\",\n    \t                \t\"dateddmmyyyy\": \"Please enter a valid date with this format(dd\/mm\/yyyy)\",\n    \t                \t\"number\": \"Please enter a valid number.\",\n    \t                \t\"digits\": \"Please enter only digits.\",\n    \t                \t\"max\": \"Please enter a value less than or equal to {0}.\",\n    \t                \t\"min\": \"Please enter a value greater than or equal to {0}.\",\"previous\": \"Previous\",\"next\": \"Next.\"\n    \t                }}"};
/* ]]> */
</script>
<script type='text/javascript' src='<?php echo plugins_url('js/fbuilder-loader-public.php', __FILE__); ?>'></script>
        <?php
        }
    }
    else
        @include dirname( __FILE__ ) . '/cpabc_scheduler.inc.php';
}


function cpabc_appointments_show_booking_form($id = "")
{
    if ($id != '')
        define ('CPABC_CALENDAR_FIXED_ID',$id);
    define('CPABC_AUTH_INCLUDE', true);
    cpabc_appointments_get_public_form();
}

/* Code for the admin area */

if ( is_admin() ) {
    add_action('media_buttons', 'set_cpabc_apps_insert_button', 100);
    add_action('admin_enqueue_scripts', 'set_cpabc_apps_insert_adminScripts', 1);
    add_action('admin_menu', 'cpabc_appointments_admin_menu');

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_".$plugin, 'cpabc_customAdjustmentsLink');
    add_filter("plugin_action_links_".$plugin, 'cpabc_settingsLink');
    add_filter("plugin_action_links_".$plugin, 'cpabc_helpLink');

    function cpabc_appointments_admin_menu() {
        add_options_page('Appointment Booking Calendar Options', 'Appointment Booking Calendar', 'manage_options', 'cpabc_appointments', 'cpabc_appointments_html_post_page' );
        add_menu_page( 'Appointment Booking Calendar Options', 'Appointment Booking Calendar', 'edit_pages', 'cpabc_appointments', 'cpabc_appointments_html_post_page' );
    }
}
else
{
    add_shortcode( 'CPABC_APPOINTMENT_CALENDAR', 'cpabc_appointments_filter_content' );
    add_shortcode( 'CPABC_EDIT', 'cpabc_appointments_filter_edit' );
    add_shortcode( 'CPABC_APPOINTMENT_LIST', 'cpabc_appointments_filter_list' );
}

function cpabc_settingsLink($links) {
    $settings_link = '<a href="options-general.php?page=cpabc_appointments">'.__('Settings','cpabc').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}


function cpabc_helpLink($links) {
    $help_link = '<a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar">'.__('Help','cpabc').'</a>';
	array_unshift($links, $help_link);
	return $links;
}

function cpabc_customAdjustmentsLink($links) {
    $customAdjustments_link = '<a href="http://wordpress.dwbooster.com/contact-us">'.__('Request custom changes','cpabc').'</a>';
	array_unshift($links, $customAdjustments_link);
	return $links;
}

function cpabc_appointments_html_post_page() {
    if (isset($_GET["cal"]) && $_GET["cal"] != '')
    {
        if (isset($_GET["list"]) && $_GET["list"] == '1')
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_bookings_list.inc.php';
        else if (isset($_GET["edit"]) && $_GET["edit"] != '')
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_edit_booking.inc.php';
        else
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int.inc.php';
    }
    else
        @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_calendar_list.inc.php';
}

function set_cpabc_apps_insert_button() {
    global $wpdb;
    $options = '';
    $calendars = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX);
    foreach($calendars as $item)
        $options .= '<option value="'.$item->id.'">'.$item->uname.'</option>';

    wp_enqueue_style('wp-jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-dialog');
    ?>
    <script type="text/javascript">
      var cpabc_appointments_fpanel = function($){
        var cpabc_counter = 0;
      	function loadWindow(){
      	    cpabc_counter++;
      		$(' <div title="Appointment Booking Calendar"><div style="padding:20px;">'+
      		   'Select Calendar:<br /><select id="cpabc_calendar_sel'+cpabc_counter+'" name="cpabc_calendar_sel'+cpabc_counter+'"><?php echo $options; ?></select>'+
      		   '</div></div>'
      		  ).dialog({
      			dialogClass: 'wp-dialog',
                  modal: true,
                  closeOnEscape: true,
                  buttons: [
                      {text: "Insert", click: function() {
      						if(send_to_editor){
      							var id = $('#cpabc_calendar_sel'+cpabc_counter)[0].options[$('#cpabc_calendar_sel'+cpabc_counter)[0].options.selectedIndex].value;
                                send_to_editor('[CPABC_APPOINTMENT_CALENDAR calendar="'+id+'"]');
      						}
      						$(this).dialog("close");
      				}}
                  ]
              });
      	}
      	var obj = {};
      	obj.open = loadWindow;
      	return obj;
      }(jQuery);
     </script>
    <?php

    print '<a href="javascript:cpabc_appointments_fpanel.open()" title="'.__('Insert Appointment Booking Calendar','cpabc').'"><img hspace="5" src="'.plugins_url('/images/cpabc_apps.gif', __FILE__).'" alt="'.__('Insert  Appointment Booking Calendar','cpabc').'" /></a>';
}

function set_cpabc_apps_insert_adminScripts($hook) {
    if (isset($_GET["cal"]) && $_GET["cal"] != '')
    {
        if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1")
        {
            wp_deregister_script('query-stringify');
            wp_register_script('query-stringify', plugins_url('/js/jQuery.stringify.js', __FILE__));
            if (CPABC_APPOINTMENTS_ACTIVATECC) wp_enqueue_script( 'cp_apc_buikder_script_caret', plugins_url('/js/jquery.caret.js', __FILE__),array("jquery") );
            wp_enqueue_script( 'cp_contactformpp_buikder_script', plugins_url('/js/fbuilder-loader-admin.php', __FILE__),array("jquery","jquery-ui-core","jquery-ui-sortable","jquery-ui-tabs","jquery-ui-droppable","jquery-ui-button","jquery-ui-datepicker","query-stringify") );
        }
        else
        {
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
        }
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }
    if( 'post.php' != $hook  && 'post-new.php' != $hook )
        return;
}

function cpabc_export_iCal() {
    global $wpdb;
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=events".date("Y-M-D_H.i.s").".ics");

    define('CPABC_CAL_TIME_ZONE_MODIFY',get_option('CPABC_CAL_TIME_ZONE_MODIFY_SET'," +2 hours"));
    define('CPABC_CAL_TIME_SLOT_SIZE'," +".get_option('CPABC_CAL_TIME_SLOT_SIZE_SET',"15")." minutes");

/**    echo "BEGIN:VCALENDAR\n";
    echo "PRODID:-//CodePeople//Appointment Booking Calendar for WordPress//EN\n";
    echo "VERSION:2.0\n";
    echo "CALSCALE:GREGORIAN\n";
    echo "METHOD:PUBLISH\n";
    echo "X-WR-CALNAME:Bookings\n";
    echo "X-WR-TIMEZONE:Europe/London\n";
    echo "BEGIN:VTIMEZONE\n";
    echo "TZID:Europe/Stockholm\n";
    echo "X-LIC-LOCATION:Europe/London\n";
    echo "BEGIN:DAYLIGHT\n";
    echo "TZOFFSETFROM:+0000\n";
    echo "TZOFFSETTO:+0100\n";
    echo "TZNAME:CEST\n";
    echo "DTSTART:19700329T020000\n";
    echo "RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU\n";
    echo "END:DAYLIGHT\n";
    echo "BEGIN:STANDARD\n";
    echo "TZOFFSETFROM:+0100\n";
    echo "TZOFFSETTO:+0000\n";
    echo "TZNAME:CET\n";
    echo "DTSTART:19701025T030000\n";
    echo "RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU\n";
    echo "END:STANDARD\n";
    echo "END:VTIMEZONE\n";
    
*/
    echo "BEGIN:VCALENDAR\n";
    echo "PRODID:-//CodePeople//Appointment Booking Calendar for WordPress//EN\n";
    echo "VERSION:2.0\n";    

    $events = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE appointment_calendar_id=".intval($_GET["id"])." ORDER BY datatime ASC" );
    foreach ($events as $event)
    {
        if (CPABC_APPOINTMENTS_ICAL_OBSERVE_DAYLIGHT) 
        {
            $full_date = gmdate("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY));
            $year = substr($full_date,0,4);
            if (strtoupper(CPABC_APPOINTMENTS_ICAL_DAYLIGHT_ZONE) == 'EUROPE')
            {            
                $dst_start = strtotime('last Sunday GMT', strtotime("1 April $year GMT"));
                $dst_stop = strtotime('last Sunday GMT', strtotime("1 November $year GMT"));        
            } else { // USA
                $dst_start = strtotime('first Sunday GMT', strtotime("1 April $year GMT"));          
                $dst_stop = strtotime('last Sunday GMT', strtotime("1 November $year GMT"));        
            }  
            if ($full_date >= gmdate("Ymd",$dst_start) && $full_date < gmdate("Ymd",$dst_stop))            
                $event->datatime = date("Y-m-d H:i",strtotime($event->datatime." -1 hour"));                        
        }        
        
        echo "BEGIN:VEVENT\n";
        echo "DTSTART:".gmdate("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".gmdate("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "DTEND:".gmdate("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY.CPABC_CAL_TIME_SLOT_SIZE))."T".gmdate("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY.CPABC_CAL_TIME_SLOT_SIZE))."Z\n";
        //echo "DTSTAMP:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "DTSTAMP:".gmdate("Ymd")."T".gmdate("His")."Z\n";
        echo "UID:uid".$event->id."@".$_SERVER["SERVER_NAME"]."\n";
        //echo "CREATED:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "DESCRIPTION:".str_replace("<br>",'\n',str_replace("<br />",'\n',str_replace("\r",'',str_replace("\n",'\n',$event->description)) ))."\n";
        //echo "LAST-MODIFIED:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "LAST-MODIFIED:".gmdate("Ymd")."T".gmdate("His")."Z\n";
        echo "LOCATION:\n";
        echo "SEQUENCE:0\n";
        echo "STATUS:CONFIRMED\n";
        echo "SUMMARY:Booking from ".str_replace("\n",'\n',$event->title)."\n";
        echo "TRANSP:OPAQUE\n";
        echo "END:VEVENT\n";


    }
    echo 'END:VCALENDAR';
    exit;
}


/* hook for checking posted data for the admin area */


add_action( 'init', 'cpabc_appointments_check_posted_data', 11 );

function cpabc_appointments_check_posted_data()
{
    global $wpdb;

    if (isset($_GET["dex_abc"]) && $_GET["dex_abc"] == 'getcost')
        foreach($_GET as $item => $value)
        {
            $_POST[$item] = $value;
        }

    cpabc_appointments_check_reminders();
    cpabc_appointments_check_CSV_reminders();

    if(isset($_GET) && array_key_exists('cpabc_app',$_GET)) {
        if ( $_GET["cpabc_app"] == 'calfeed' )
        {            
            if ($_GET["id"] != '' && substr(md5($_GET["id"].$_SERVER["DOCUMENT_ROOT"]),0,10) == $_GET["verify"])
                cpabc_export_iCal();
            else
            {
                echo 'Access denied - verify value is not correct.';
                exit;
            }                   
        }    

        if ($_GET["cpabc_app"] == 'captcha')
        {
            @include_once dirname( __FILE__ ) . '/captcha/captcha.php';
            exit;
        }

        if ( $_GET["cpabc_app"] == 'cpabc_loadcoupons')
            cpabc_appointments_load_discount_codes();
    }

    if (isset( $_GET['cpabc_appointments_csv'] ) && is_admin() )
    {
        cpabc_appointments_export_csv();
        return;
    }

    if (isset($_GET["cpabc_c"]) && $_GET['cpabc_c'] == '1')
    {
        cpabc_process_cancel_go_appointment();
    }

    if (!defined('CP_CALENDAR_ID') && isset($_POST["cpabc_item"]))
        define ('CP_CALENDAR_ID', $_POST["cpabc_item"]);

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post_options'] ) && (is_admin() || cpabc_appointments_user_access_to(CP_CALENDAR_ID) ))
    {
        cpabc_appointments_save_options();
        return;
    }
    
    if (isset($_GET["abc_verifydate"]) && $_GET['abc_verifydate'] != '')
    {
        
        $times =   explode(";",str_replace(",","-",$_GET["abc_verifydate"]));
        array_shift($times);
        foreach ($times as $itemtime) {
            $result = $wpdb->get_results( "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE.
                  " WHERE appointment_calendar_id=".intval($_GET["cal"]).
                  " AND datatime='".date("Y-m-d H:i:s", strtotime($itemtime))."'");        
            if (count($result)) // capacity verification is missing
            {
                echo 'failed';
                exit;
            }
        }
        echo 'ok';    
        exit;
     }
    
    if (@$_GET["abcc_authorize"] == '2')
        cpabc_process_authorize();

    if (!isset($_POST["dex_abc"])) {
        // if this isn't the expected post and isn't the captcha verification then nothing to do
	    if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['cpabc_appointments_post'] ) )
	    	if ( 'GET' != $_SERVER['REQUEST_METHOD'] || !isset( $_GET['hdcaptcha'] ) )
	    	    return;


        @session_start();

        if (!isset($_GET["hdcaptcha"]) || $_GET['hdcaptcha'] == '') $_GET['hdcaptcha'] = @$_POST['hdcaptcha'];
        if (
               (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') &&
               ( (strtolower($_GET['hdcaptcha']) != strtolower($_SESSION['rand_code'])) ||
                 ($_SESSION['rand_code'] == '')
               )
               &&
               ( (md5(strtolower($_GET['hdcaptcha'])) != ($_COOKIE['rand_code'])) ||
                 ($_COOKIE['rand_code'] == '')
               )
           )
        {
            $_SESSION['rand_code'] = '';
            echo 'captchafailed';
            exit;
        }

	    // if this isn't the real post (it was the captcha verification) then echo ok and exit
        if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['cpabc_appointments_post'] ) )
	    {
	        if (!isset($_GET["abcc"]))
	            return;
	        echo 'ok';
            exit;
	    }

        $_SESSION['rand_code'] = '';
    }
    $selectedCalendar = $_POST["cpabc_item"];

    $_POST["dateAndTime"] =   explode(";",str_replace(",","-",$_POST["selDaycal".$selectedCalendar]));
    array_shift($_POST["dateAndTime"]);
    
    if (@$_POST["tzonelistcal".$selectedCalendar] == '')
       $_POST["tzonelistcal".$selectedCalendar] = $_POST["selDaycal".$selectedCalendar];
           
    $_POST["dateAndTime_customer"] =   explode(";",str_replace(",","-",@$_POST["tzonelistcal".$selectedCalendar]));
    array_shift($_POST["dateAndTime_customer"]);

    $military_time = cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME);
    if (cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME) == '0') $format = "g:i A"; else $format = "H:i";
    $calendar_dformat = cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT);
    if ($calendar_dformat == '2') 
        $format = "d.m.Y ".$format; 
    else if ($calendar_dformat == '1')
        $format = "d/m/Y ".$format;
    else 
        $format = "m/d/Y ".$format;     
    for($n=0;$n<count($_POST["dateAndTime"]); $n++)
    {
        $_POST["dateAndTime"][$n] = date("Y-m-d H:i:s",strtotime($_POST["dateAndTime"][$n]));
        $_POST["Date"][$n] = date($format,strtotime($_POST["dateAndTime"][$n]));
        
        $_POST["dateAndTime_customer"][$n] = date("Y-m-d H:i:s",strtotime(@$_POST["dateAndTime_customer"][$n]));
        $_POST["Date_customer"][$n] = date($format,strtotime($_POST["dateAndTime_customer"][$n]));
    }

    $services_formatted = explode("|",@$_POST["services"]);

    {
        $price = explode(";",cpabc_get_option('request_cost', CPABC_APPOINTMENTS_DEFAULT_COST));
        foreach ($price as $item => $value)
           $price[$item] = trim(str_replace(',','', str_replace(CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL,'',
                                                     str_replace(CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL,'',
                                                     str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A, '',
                                                     str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B,'', $value )))) ));        
        if (isset($price[count($_POST["dateAndTime"])-1]))
            $price = $price[count($_POST["dateAndTime"])-1];
        else
            $price = $price[0] * count($_POST["dateAndTime"]);

        $qant_value_two = cpabc_get_option('quantity_field_two','0');
        if ($qant_value_two != '0' && $qant_value_two != '') {
            $price2 = explode(";",cpabc_get_option('request_cost_st', CPABC_APPOINTMENTS_DEFAULT_COST));
            foreach ($price2 as $item => $value)
               $price2[$item] = trim(str_replace(',','', str_replace(CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL,'',
                                                        str_replace(CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL,'',
                                                        str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A, '',
                                                        str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B,'', $value )))) ));
            if (isset($price2[count($_POST["dateAndTime"])-1]))
                $price2 = $price2[count($_POST["dateAndTime"])-1];
            else
                $price2 = $price2[0] * count($_POST["dateAndTime"]);
        } else {
            $price2 = 0;
        }
    }

    $_POST["abc_capacity"] = intval( (@$_POST["abc_capacity"]!=''?$_POST["abc_capacity"]:'1') );
    $_POST["abc_capacity_a"] = intval( (@$_POST["abc_capacity_a"]!=''?$_POST["abc_capacity_a"]:'1') );
    $_POST["abc_capacity_s"] = intval( (@$_POST["abc_capacity_s"]!=''?$_POST["abc_capacity_s"]:'0') );

    $price = round($price * $_POST["abc_capacity_a"] + $price2 * $_POST["abc_capacity_s"], 2);

    if (isset($_GET["services"]) && $_GET["services"] != '')
        $_POST["services"] = $_GET["services"];

    if (@$_POST["services"])
    {
        $price += trim($services_formatted[0]) * count($_POST["dateAndTime"]);
        $price2 += trim($services_formatted[0]) * count($_POST["dateAndTime"]);
    }

    $price_updated = $price;
    $last_vs = '0';
    for ($k=CPABC_DISCOUNT_FIELDS; $k>=1; $k--) {
        $vs = cpabc_get_option('discountslots'.$k, '0');
        $vp = cpabc_get_option('discountvalue'.$k, '0');
        if (intval($vs) <= count($_POST["dateAndTime"]) && $vp != '0' && $vp != '' && $vs != '' && intval($last_vs) < intval($vs))
        {
            $last_vs = $vs;
            $price_updated = round( $price - $price*$vp/100, 2);
            $k = 0;
        }
    }
    $price = $price_updated;

    if (isset($_POST["dex_abc"]))
    {
        echo number_format($price, 2);exit;
    }

    $params = array();
    $params["QUANTITY"] = @$_POST["abc_capacity"];
    $params["ADULTS"] = @$_POST["abc_capacity_a"];
    $params["JUNIORS"] = @$_POST["abc_capacity_s"];
    $params["SERVICES"] = (@$_POST["services"]?"\nService: ".trim($services_formatted[1]):"");
    $params["IP"] = $_SERVER["REMOTE_ADDR"];

    // get form info
    //---------------------------
    if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1")
    {
        // get form info
        //---------------------------
        $form_data = json_decode(cpabc_appointment_cleanJSON(cpabc_get_option('form_structure', CPABC_APPOINTMENTS_DEFAULT_form_structure)));
        $fields = array();
        foreach ($form_data[0] as $item)
        {
            $fields[$item->name] = $item->title;
            
            if ($item->ftype == 'fPhone') // join fields for phone fields
            {
                $_POST[$item->name] = '';
                for($i=0; $i<=substr_count($item->dformat," "); $i++)
                    $_POST[$item->name] .= ($_POST[$item->name."_".$i]!=''?($i==0?'':'-').$_POST[$item->name."_".$i]:'');
            }
            else if (CPABC_APPOINTMENTS_IDENTIFY_PRICES && ($item->ftype == 'fcheck' || $item->ftype == 'fradio' || $item->ftype == 'fdropdown'))
            {
                $value = ( is_array($_POST[$item->name]) ? implode(", ",$_POST[$item->name]) : $_POST[$item->name] );
                $matches_default = array();
                preg_match_all ('/(\\'.CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL.'[0-9,]+(\.[0-9]{2})?)/', $value, $matches_default);
                $matches_gbp = array();
                preg_match_all ('/(\\'.CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL.'[0-9,]+(\.[0-9]{2})?)/', $value, $matches_gbp);
                $matches_eur_a = array();
                preg_match_all ('/(\\'.CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A.'[0-9,]+(\.[0-9]{2})?)/', $value, $matches_eur_a);
                $matches_eur_b = array();
                preg_match_all ('/(\\'.CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B.'[0-9,]+(\.[0-9]{2})?)/', $value, $matches_eur_b);
                $matches = array_merge($matches_default[0], $matches_gbp[0], $matches_eur_a[0], $matches_eur_b[0]);
                foreach ($matches as $item)
                {
                    $item = trim(str_replace(',','', str_replace(CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL,'',
                                                     str_replace(CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL,'',
                                                     str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A, '',
                                                     str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B,'', $item )))) ));
                    if (is_numeric($item))
                        $price += $item;
                }
            }
        }

        // grab posted data
        //---------------------------
        $buffer = "";
        $excluded_field = explode (",",@$_POST["form_structure_hidden".$_POST["cp_calculatedfieldsf_pform_psequence"]]);
        foreach ($_POST as $item => $value)
            if (isset($fields[$item]) && !in_array($item, $excluded_field) )
            {
                $buffer .= $fields[$item] . ": ". (is_array($value)?(implode(", ",$value)):($value)) . "\n\n";
                $params[$item] = $value;
            }

        foreach ($_FILES as $item => $value)
            if (isset($fields[$item]) && cpabc_appointments_check_upload($_FILES[$item]) && !in_array($item, $excluded_field) )
            {
                $buffer .= $fields[$item] . ": ". $value["name"] . "\n\n";
                $params[$item] = $value["name"];
                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                $movefile = wp_handle_upload( $_FILES[$item], array( 'test_form' => false ) );
                if ( $movefile )
                {
                    @$params[$item."_link"] = $movefile["file"]; // cp_contactformpp_process_upload($_FILES[$item]);
                    @$params[$item."_url"] = $movefile["url"];
                }
                // else {print_r($movefile);exit;}    // un-comment this line if the uploads aren't working
            }

        $buffer_A = trim($buffer);
        $buffer_A .= (@$_POST["services"]?"\nService: ".trim($services_formatted[1])."\n\n":"");

        $to = cpabc_get_option('cu_user_email_field', CPABC_APPOINTMENTS_DEFAULT_cu_user_email_field);
    }
    else
    {

        $params["NAME"] = $_POST["name"];
        $params["EMAIL"] = $_POST["email"];
        $params["PHONE"] = $_POST["phone"];
        $params["COMMENTS"] = $_POST["question"];

        $buffer_A = $_POST["question"].(@$_POST["services"]?"\nService: ".trim($services_formatted[1]):"");
                                      //.($coupon?"\nCoupon code: ".$coupon->code.$discount_note:"");
        $to = "email";
    }

    if (CPABC_APPOINTMENTS_ACTIVATECC) {
        $added_cost = @$_POST[cpabc_get_option('paypal_price_field', '').$sequence];
        if (is_numeric($added_cost))
            $price += $added_cost;
        else
        {
            $matches_default = array();
            preg_match_all ('/(\\'.CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL.'[0-9,]+(\.[0-9]{2})?)/', $added_cost, $matches_default);
            $matches_gbp = array();
            preg_match_all ('/(\\'.CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL.'[0-9,]+(\.[0-9]{2})?)/', $added_cost, $matches_gbp);
            $matches_eur_a = array();
            preg_match_all ('/(\\'.CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A.'[0-9,]+(\.[0-9]{2})?)/', $added_cost, $matches_eur_a);
            $matches_eur_b = array();
            preg_match_all ('/(\\'.CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B.'[0-9,]+(\.[0-9]{2})?)/', $added_cost, $matches_eur_b);
            $matches = array_merge($matches_default[0], $matches_gbp[0], $matches_eur_a[0], $matches_eur_b[0]);
            foreach ($matches as $item)
            {
                $item = trim(str_replace(',','', str_replace(CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL,'',
                                                 str_replace(CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL,'',
                                                 str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A, '',
                                                 str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B,'', $item )))) ));
                if (is_numeric($item))
                    $price += $item;
            }
        }
    }

    // check discount codes
    //-------------------------------------------------
    $discount_note = "";
    $coupon = false;    
    $codes = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME." WHERE ((dc_times>used) OR dc_times='0') AND code='".esc_sql(@$_POST["couponcode"])."' AND expires>='".date("Y-m-d")." 00:00:00' AND `cal_id`=".CP_CALENDAR_ID);
    if (count($codes))
    {
        $coupon = $codes[0];
        if ($coupon->availability==1)
        {
            $price = number_format (floatval ($price) - $coupon->discount,2);
            $discount_note = " (".cpabc_get_option('currency', CP_CONTACTFORMPP_DEFAULT_CURRENCY)." ".$coupon->discount." discount applied)";
        }    
        else
        {
            $price = number_format (floatval ($price) - $price*$coupon->discount/100,2);
            $discount_note = " (".$coupon->discount."% discount applied)";
        }        
        //$price = number_format (floatval ($price) - $price*$coupon->discount/100,2);
        //$discount_note = " (".$coupon->discount."% discount applied)";
    }

    $params["PRICE"] = $price;
    $params["COUPONCODE"] = ($coupon?"\nCoupon code:".$coupon->code.$discount_note."\n":"");
    $params["coupon"] = ($coupon?$coupon->code:"");
    $buffer_A .= ($coupon?"\nCoupon code: ".$coupon->code.$discount_note:"");

    if (isset($_POST["bccf_payment_option_paypal"]) && $_POST["bccf_payment_option_paypal"] == '0')
        $params["payment_type"] = 'Other';
    else    
        $params["payment_type"] = 'PayPal';
        
        
    $qant_value = cpabc_get_option('quantity_field','0');
    if ($qant_value != '0' && $qant_value != '') $buffer_A .= "\n".cpabc_get_option('quantity_field_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL).": ".$_POST["abc_capacity_a"];
    $qant_value_two = cpabc_get_option('quantity_field_two','0');
    if ($qant_value_two != '0' && $qant_value_two != '') $buffer_A .= "\n".cpabc_get_option('quantity_field_two_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_TWO_LABEL)." quantity: ".$_POST["abc_capacity_s"];


    // insert into database
    //---------------------------
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_TABLE_NAME, 'quantity', "VARCHAR(25) DEFAULT '1' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_TABLE_NAME, 'quantity_a', "VARCHAR(25) DEFAULT '1' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_TABLE_NAME, 'quantity_s', "VARCHAR(25) DEFAULT '1' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_TABLE_NAME, 'booked_time_customer', "VARCHAR(250) DEFAULT '1' NOT NULL");

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_TABLE_NAME, 'who_added', "VARCHAR(50) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify($wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX, 'who_added', "VARCHAR(50) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify($wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX, 'who_edited', "VARCHAR(50) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify($wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX, 'who_cancelled', "VARCHAR(50) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify($wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX, 'is_cancelled', "VARCHAR(50) DEFAULT '0' NOT NULL");
    cpabc_appointments_add_field_verify($wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX, 'cancelled_reason', "TEXT");

    $current_user = wp_get_current_user();
    for ($n=0; $n<count($_POST["dateAndTime"]); $n++)
    {
        $params["DATE"] = trim( substr($_POST["Date"][$n], 0, strpos($_POST["Date"][$n],' ') ) );
        $params["TIME"] = trim( substr($_POST["Date"][$n], strpos($_POST["Date"][$n],' ') ) );
        $params["DATE_CUSTOMER"] = trim( substr($_POST["Date_customer"][$n], 0, strpos($_POST["Date_customer"][$n],' ') ) );
        $params["TIME_CUSTOMER"] = trim( substr($_POST["Date_customer"][$n], strpos($_POST["Date_customer"][$n],' ') ) );
        $rows_affected = $wpdb->insert( CPABC_APPOINTMENTS_TABLE_NAME, array( 'calendar' => $selectedCalendar,
                                                                        'time' => current_time('mysql'),
                                                                        'booked_time' => $_POST["Date"][$n],
                                                                        'booked_time_customer' => $_POST["Date_customer"][$n],
                                                                        'booked_time_unformatted' => $_POST["dateAndTime"][$n],                                                                        
                                                                        'name' => @$_POST["name"],
                                                                        'email' => @$_POST[$to],
                                                                        'phone' => @$_POST["phone"],
                                                                        'question' => $buffer_A,
                                                                        'quantity' => (isset($_POST["abc_capacity"])?$_POST["abc_capacity"]:1),
                                                                        'quantity_a' => (isset($_POST["abc_capacity_a"])?$_POST["abc_capacity_a"]:0),
                                                                        'quantity_s' => (isset($_POST["abc_capacity_s"])?$_POST["abc_capacity_s"]:0),
                                                                        'buffered_date' => serialize($params),
                                                                        'who_added' => $current_user->ID
                                                                         ) );
        if (!$rows_affected)
        {
            echo 'Error saving data! Please try again.';
            echo '<br /><br />Error debug information: '.mysql_error();
            $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX."` ADD `booked_time_unformatted` text;"; $wpdb->query($sql);
            exit;
        }

        //$myrows = $wpdb->get_results( "SELECT MAX(id) as max_id FROM ".CPABC_APPOINTMENTS_TABLE_NAME );

 	    // save data here
        $item_number[] = $wpdb->insert_id;
    }
    $item_number = implode(";", $item_number);

    $paypal_option = cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL);
    $paypal_optional = (($paypal_option == '2') || ($paypal_option == '3') || ($paypal_option == '4'));
    
    if ($paypal_option == '3' && @$_POST["bccf_payment_option_paypal"] == '0')
    {        
        require_once dirname( __FILE__ ) . '/stripe-php-1.10.1/lib/Stripe.php';
        Stripe::setApiKey( cpabc_get_option('stripe_secretkey','') );

        // Get the credit card details submitted by the form
        $token = $_POST['stptok'];
        
        // Create the charge on Stripe's servers - this will charge the user's card
        try {
        $charge = Stripe_Charge::create(array(
          "amount" => $price * 100, // amount in cents, again
          "currency" => cpabc_get_option('currency', CPABC_APPOINTMENTS_DEFAULT_CURRENCY),
          "card" => $token,
          "description" => cpabc_get_option('paypal_product_name', CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME)." - Item Number: ".$item_number)
        );
        } catch(Stripe_CardError $e) {
          // The card has been declined
          echo 'Transaction failed. The card has been declined. Please <a href="javascript:window.history.back();">go back and try again</a>.';
        }
    }
    
    if (cpabc_get_option('paypal_mode','production') == "sandbox")
        $ppurl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    else
        $ppurl = 'https://www.paypal.com/cgi-bin/webscr';    

    if (floatval($price) > 0 && $paypal_option && ( !$paypal_optional || (@$_POST["bccf_payment_option_paypal"] == '1') ))
    {
?>
<html>
<head><title>Redirecting to Paypal...</title></head>
<body>
<form action="<?php echo $ppurl; ?>" name="ppform3" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo cpabc_get_option('paypal_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL); ?>" />
<input type="hidden" name="item_name" value="<?php echo cpabc_get_option('paypal_product_name', CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME).(@$_POST["services"]?": ".trim($services_formatted[1]):"").$discount_note; ?>" />
<!--<input type="hidden" name="item_number" value="<?php echo $item_number; ?>" />-->
<input type="hidden" name="amount" value="<?php echo $price; ?>" />
<input type="hidden" name="page_style" value="Primary" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return" value="<?php echo cpabc_get_option('url_ok', CPABC_APPOINTMENTS_DEFAULT_OK_URL); ?>">
<input type="hidden" name="cancel_return" value="<?php echo cpabc_get_option('url_cancel', CPABC_APPOINTMENTS_DEFAULT_CANCEL_URL); ?>" />
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="currency_code" value="<?php echo strtoupper(cpabc_get_option('currency', CPABC_APPOINTMENTS_DEFAULT_CURRENCY)); ?>" />
<input type="hidden" name="lc" value="<?php echo cpabc_get_option('paypal_language', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_LANGUAGE); ?>" />
<input type="hidden" name="bn" value="NetFactorSL_SI_Custom" />
<input type="hidden" name="notify_url" value="<?php echo cpabc_appointment_get_FULL_site_url(); ?>/?cpabc_ipncheck=1&itemnumber=<?php echo $item_number; ?>" />
<input type="hidden" name="ipn_test" value="1" />
<input class="pbutton" type="hidden" value="Buy Now" /></div>
</form>
<script type="text/javascript">
document.ppform3.submit();
</script>
</body>
</html>
<?php
        exit();
    }
    else
    {
        cpabc_process_ready_to_go_appointment($item_number);

        header("Location: ".cpabc_get_option('url_ok', CPABC_APPOINTMENTS_DEFAULT_OK_URL));
        exit;
    }

}


function cpabc_process_authorize() {   
    global $wpdb;
    require_once dirname( __FILE__ ) . '/anet_php_sdk/AuthorizeNet.php';
    $transaction = new AuthorizeNetAIM( cpabc_get_option('authorizenet_api_id',''), cpabc_get_option('authorizenet_tra_key',''));    
    $fields = array(
                     'description' => str_replace(",","-",$_POST["d"]),
                     'email' => $_POST['e']
                    );
    $transaction->setFields($fields);
    $transaction->amount = $_POST["cost"];
    $transaction->card_num = $_POST["cc"];
    $transaction->exp_date = $_POST["em"].'/'.$_POST["ey"];;
    
    $response = $transaction->authorizeAndCapture();
    
    if ($response->approved) {
      echo "OK";      
    } else {
      echo $response->response_reason_text;
    }
    exit;
}


function cpabc_appointments_check_upload($uploadfiles) {
    $filetmp = $uploadfiles['tmp_name'];
    //clean filename and extract extension
    $filename = $uploadfiles['name'];
    // get file info
    $filetype = wp_check_filetype( basename( $filename ), null );

    if ( in_array ($filetype["ext"],array("php","asp","aspx","cgi","pl","perl","exe")) )
        return false;
    else
        return true;
}

function cpabc_appointments_user_access_to($calendar) {
    global $wpdb;
	$current_user = wp_get_current_user();
	$myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." where id='".$calendar."' AND conwer<>'' AND conwer='".esc_sql($current_user->ID)."'" );
	return count($myrows);
}

function cpabc_appointments_load_discount_codes() {
    global $wpdb;

    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$_GET["cpabc_item"]);

    if ( ! current_user_can('edit_pages') && !cpabc_appointments_user_access_to(CP_CALENDAR_ID) ) // prevent loading coupons from outside admin area
    {
        echo 'No enough privilegies to load this content.';
        exit;
    }
    
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME ,"dc_times", "varchar(10) DEFAULT '0' NOT NULL");

    if (isset($_GET["add"]) && $_GET["add"] == "1")
        $wpdb->insert( CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME, array('cal_id' => CP_CALENDAR_ID,
                                                                         'code' => $_GET["code"],
                                                                         'discount' => $_GET["discount"],
                                                                         'availability' => $_GET["discounttype"],
                                                                         'dc_times' => $_GET["tm"],
                                                                         'expires' => $_GET["expires"],
                                                                         ));
    if (isset($_GET["delete"]) && $_GET["delete"] == "1")
        $wpdb->query( $wpdb->prepare( "DELETE FROM ".CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME." WHERE id = %d", $_GET["code"] ));

    $codes = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME.' WHERE `cal_id`='.CP_CALENDAR_ID);
    if (count ($codes))
    {
        echo '<table>';
        echo '<tr>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">Cupon Code</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">Discount</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">Type</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;" nowrap>Can be used?</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;" nowrap>Used so far</th>';        
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">Valid until</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">Options</th>';
        echo '</tr>';
        foreach ($codes as $value)
        {
           echo '<tr>';
           echo '<td>'.$value->code.'</td>';
           echo '<td>'.$value->discount.'</td>';
           echo '<td>'.($value->availability==1?"Fixed Value":"Percent").'</td>';
           echo '<td nowrap>'.($value->dc_times=='0'?'Unlimited':$value->dc_times.' times').'</td>';
           echo '<td nowrap>'.$value->used.' times</td>';           
           echo '<td>'.substr($value->expires,0,10).'</td>';
           echo '<td>[<a href="javascript:cpabc_delete_coupon('.$value->id.')">Delete</a>]</td>';
           echo '</tr>';
        }
        echo '</table>';
    }
    else
        echo 'No discount codes listed for this calendar yet.';
    exit;
}

add_action( 'init', 'cpabc_appointments_check_IPN_verification', 11 );

function cpabc_appointments_check_IPN_verification() {

    global $wpdb;

	if ( ! isset( $_GET['cpabc_ipncheck'] ) || $_GET['cpabc_ipncheck'] != '1' ||  ! isset( $_GET["itemnumber"] ) )
		return;

    $item_name = $_POST['item_name'];
    //$item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $payment_type = $_POST['payment_type'];

    /**
	if ($payment_status != 'Completed' && $payment_type != 'echeck')
	    return;

	if ($payment_type == 'echeck' && $payment_status == 'Completed')
	    return;
    */
    $itemnumber = explode(";",$_GET["itemnumber"]);
    $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." WHERE reference=".$itemnumber[0] );
    if (count($myrows))
    {
        echo 'OK - Already processed';
        exit;
    }

    cpabc_process_ready_to_go_appointment($_GET["itemnumber"], $payer_email);

    echo 'OK';

    exit();

}

function cpabc_process_cancel_go_appointment()
{
    global $wpdb;
    $itemnumber = base64_decode($_GET["i"]);
    if (is_numeric($itemnumber))
    {
        $wpdb->query( "DELETE FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." WHERE id=".$itemnumber );
        header("Location: ".CPABC_APPOINTMENTS_DEFAULT_ON_CANCEL_REDIRECT_TO);
        exit;
    }
}

function cpabc_process_ready_to_go_appointment($itemnumber, $payer_email = "")
{
   global $wpdb;

   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity', "VARCHAR(25) DEFAULT '1' NOT NULL");
   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity_a', "VARCHAR(25) DEFAULT '1' NOT NULL");
   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity_s', "VARCHAR(25) DEFAULT '1' NOT NULL");
   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'reminder', "VARCHAR(1) DEFAULT '' NOT NULL");
   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'reference', "VARCHAR(20) DEFAULT '' NOT NULL");
   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'description_customer');

   $itemnumber = explode(";",$itemnumber);
   $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".$itemnumber[0] );
   $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.$myrows[0]->calendar);
   $reminder_timeline = date( "Y-m-d H:i:s", strtotime (date("Y-m-d H:i:s")." +".$mycalendarrows[0]->reminder_hours." hours") );
   if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$myrows[0]->calendar);

   $SYSTEM_EMAIL = trim(cpabc_get_option('notification_from_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL));
   $SYSTEM_RCPT_EMAIL = cpabc_get_option('notification_destination_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL);
   $pos = strpos($SYSTEM_EMAIL, " ");
   if ($pos === false)
       $SYSTEM_EMAIL = '"'.$SYSTEM_EMAIL.'" <'.$SYSTEM_EMAIL.'>';


   $email_subject1 = cpabc_get_option('email_subject_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL);
   $email_content1 = cpabc_get_option('email_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_CONFIRMATION_EMAIL);
   $email_subject2 = cpabc_get_option('email_subject_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL);
   $email_content2 = cpabc_get_option('email_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_NOTIFICATION_EMAIL);

   $email_content1 = str_replace("%CALENDAR%", $mycalendarrows[0]->uname, $email_content1);
   $email_content2 = str_replace("%CALENDAR%", $mycalendarrows[0]->uname, $email_content2);
   
   $email_subject1 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_subject1);
   $email_subject2 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_subject2);           
   $email_content1 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_content1);
   $email_content2 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_content2);   

   $params = unserialize($myrows[0]->buffered_date);
   
   if ($params["coupon"] != '')
      $wpdb->query( "UPDATE ".CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME." SET used=used+1 WHERE code='".esc_sql(@$params["coupon"])."' AND expires>='".date("Y-m-d")." 00:00:00' AND `cal_id`=".$myrows[0]->calendar);  
   
   $attachments = array();
   foreach ($params as $item => $value)
   {
       $email_content1 = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content1);
       $email_content2 = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content2);
       $email_content1 = str_replace('%'.$item.'%',(is_array($value)?(implode(", ",$value)):($value)),$email_content1);
       $email_content2 = str_replace('%'.$item.'%',(is_array($value)?(implode(", ",$value)):($value)),$email_content2);
       if (strpos($item,"_link"))
           $attachments[] = $value;
   }
   for ($i=0;$i<500;$i++)
   {
        $email_content1 = str_replace('<%fieldname'.$i.'%>',"",$email_content1);   
        $email_content2 = str_replace('<%fieldname'.$i.'%>',"",$email_content2);   
   }        
   $buffered_dates = array();
   $buffered_dates_customer = array();
   for ($n=0;$n<count($itemnumber);$n++)
   {
       $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".$itemnumber[$n] );
       $buffered_dates[] = $myrows[0]->booked_time;
       $buffered_dates_customer[] = $myrows[0]->booked_time_customer;
       $information = $mycalendarrows[0]->uname."\n".
                      $myrows[0]->booked_time."\n".
                      ($myrows[0]->name?$myrows[0]->name."\n":"").
                      $myrows[0]->email."\n".
                      ($myrows[0]->phone?$myrows[0]->phone."\n":"").
                      $myrows[0]->question."\n";
       $information_customer = $mycalendarrows[0]->uname."\n".
                      $myrows[0]->booked_time_customer."\n".
                      ($myrows[0]->name?$myrows[0]->name."\n":"").
                      $myrows[0]->email."\n".
                      ($myrows[0]->phone?$myrows[0]->phone."\n":"").
                      $myrows[0]->question."\n";

       if ($reminder_timeline > date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted)))
           $reminder = '1';
       else
           $reminder = '';

       $rows_affected = $wpdb->insert( CPABC_TDEAPP_CALENDAR_DATA_TABLE, array( 'appointment_calendar_id' => $myrows[0]->calendar,
                                                                            'datatime' => date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted)),
                                                                            'title' => $myrows[0]->email,
                                                                            'reminder' => $reminder,
                                                                            'quantity' =>  (isset($myrows[0]->quantity)?$myrows[0]->quantity:1),
                                                                            'quantity_a' =>  (isset($myrows[0]->quantity_a)?$myrows[0]->quantity_a:1),
                                                                            'quantity_s' =>  (isset($myrows[0]->quantity_s)?$myrows[0]->quantity_s:1),
                                                                            'description' => str_replace("\n","<br />", $information),
                                                                            'description_customer' => str_replace("\n","<br />", $information_customer),
                                                                            'reference' => $itemnumber[$n],
                                                                            'who_added' => $myrows[0]->who_added
                                                                             ) );
       // SEND EMAILS START
       if ($n == count($itemnumber)-1) // send emails only once
       {

           $base_information = ($myrows[0]->name?$myrows[0]->name."\n":"").
                  $myrows[0]->email."\n".
                  ($myrows[0]->phone?$myrows[0]->phone."\n":"").
                  $myrows[0]->question."\n";

           $information = $mycalendarrows[0]->uname."\n".
                  implode(" - ",$buffered_dates)."\n".
                  $base_information;
          
           $information_customer = $mycalendarrows[0]->uname."\n".
                  implode(" - ",$buffered_dates_customer)."\n".
                  $base_information;

           $email_content1 = str_replace("%INFORMATION%", $information_customer, $email_content1);
           $email_content2 = str_replace("%INFORMATION%", $information, $email_content2);
           
           $email_content1 = str_replace("%ALLDATES%", implode(" - ",$buffered_dates), $email_content1);
           $email_content2 = str_replace("%ALLDATES%", implode(" - ",$buffered_dates_customer), $email_content2);           

           $itemnumberdb = $wpdb->insert_id;
           $cancel_link = cpabc_appointment_get_FULL_site_url().'/?cpabc_c=1&i='.base64_encode($itemnumberdb).'&a=1';

           $email_content1 = str_replace("%CANCEL%", $cancel_link, $email_content1);
           $email_content2 = str_replace("%CANCEL%", $cancel_link, $email_content2);
           
           $email_subject1 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_subject1);
           $email_subject2 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_subject2);           
           $email_content1 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_content1);
           $email_content2 = str_replace("%ITEMNUMBER%", $itemnumber[0], $email_content2);

           // SEND EMAIL TO USER
           if ('html' == cpabc_get_option('nuser_emailformat', CPABC_APPOINTMENTS_DEFAULT_email_format)) $content_type = "Content-Type: text/html; charset=utf-8\n"; else $content_type = "Content-Type: text/plain; charset=utf-8\n";
           wp_mail($myrows[0]->email, $email_subject1, $email_content1,
                    "From: $SYSTEM_EMAIL\r\n".
                    $content_type.
                    "X-Mailer: PHP/" . phpversion());

           if ($payer_email && strtolower($payer_email) != strtolower($myrows[0]->email))
               wp_mail($payer_email , $email_subject1, $email_content1,
                        "From: $SYSTEM_EMAIL\r\n".
                        $content_type.
                        "X-Mailer: PHP/" . phpversion());

           $replyto = $myrows[0]->email;

           // SEND EMAIL TO ADMIN
           if ('html' == cpabc_get_option('nadmin_emailformat', CPABC_APPOINTMENTS_DEFAULT_email_format)) $content_type = "Content-Type: text/html; charset=utf-8\n"; else $content_type = "Content-Type: text/plain; charset=utf-8\n";
           $to = explode(",",$SYSTEM_RCPT_EMAIL);
           foreach ($to as $item)
                if (trim($item) != '')
                {
                    wp_mail(trim($item), $email_subject2, $email_content2,
                        "From: $SYSTEM_EMAIL\r\n".
                        ($replyto!=''?"Reply-To: \"$replyto\" <".$replyto.">\r\n":'').
                        $content_type.
                        "X-Mailer: PHP/" . phpversion(), $attachments);
                }
       }
       // SEND EMAILS END
   }
}

function cpabc_appointments_add_field_verify ($table, $field, $type = "text")
{
    global $wpdb;
    $results = $wpdb->get_results("SHOW columns FROM `".$table."` where field='".$field."'");
    if (!count($results))
    {
        $sql = "ALTER TABLE  `".$table."` ADD `".$field."` ".$type;
        $wpdb->query($sql);
    }
}

function cpabc_appointments_save_options()
{
    global $wpdb;
    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$_POST["cpabc_item"]);

    if ( ! current_user_can('edit_pages') && !cpabc_appointments_user_access_to(CP_CALENDAR_ID) ) // prevent loading coupons from outside admin area
    {
        echo 'No enough privilegies to load this content.';
        exit;
    }

    foreach ($_POST as $item => $value)
        $_POST[$item] = @stripcslashes($value);

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'form_structure');

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_use_validation');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_is_required');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_is_email');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_datemmddyyyy');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_dateddmmyyyy');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_number');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_digits');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_max');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_min');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'vs_text_submitbtn');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'cu_user_email_field');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'cv_text_enter_valid_captcha');

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'nuser_emailformat');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'nadmin_emailformat');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'nremind_emailformat');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_nremind_emailformat');

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'enable_reminder');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'reminder_hours');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'reminder_subject');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'reminder_content');
    
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'enable_fu_reminder');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_reminder_hours');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_reminder_subject');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_reminder_content');    
    
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'reminder', "VARCHAR(1) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'fu_reminder', "VARCHAR(1) DEFAULT '' NOT NULL");
    
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity', "VARCHAR(25) DEFAULT '1' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity_a', "VARCHAR(25) DEFAULT '1' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity_s', "VARCHAR(25) DEFAULT '1' NOT NULL");

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'min_slots');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'max_slots');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'close_fpanel');

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'quantity_field', "VARCHAR(10) DEFAULT '0' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'quantity_field_two', "VARCHAR(10) DEFAULT '0' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'quantity_field_label', "VARCHAR(250) DEFAULT '".CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL."' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'quantity_field_two_label', "VARCHAR(250) DEFAULT '".CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_TWO_LABEL."' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'ajax_load_enabled', "VARCHAR(10) DEFAULT '".CPABC_APPOINTMENTS_ENABLE_AJAX_PRICE."' NOT NULL");


    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'calendar_startyear', "VARCHAR(20) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'calendar_startmonth', "VARCHAR(20) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'gmt_enabled', "VARCHAR(20) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'gmt_diff', "VARCHAR(20) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'calendar_theme');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'paypal_mode');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'paypal_price_field', "VARCHAR(50) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'request_cost_st');
    
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, "enable_paypal_option_yes", "varchar(250) DEFAULT '' NOT NULL");  
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, "enable_paypal_option_no", "varchar(250) DEFAULT '' NOT NULL");   
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, "stripe_key", "varchar(250) DEFAULT '' NOT NULL");   
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, "stripe_secretkey", "varchar(250) DEFAULT '' NOT NULL");   
    
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, "authorizenet_api_id", "varchar(250) DEFAULT '' NOT NULL");   
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, "authorizenet_tra_key", "varchar(250) DEFAULT '' NOT NULL");
    

    for ($i=1;$i<=CPABC_DISCOUNT_FIELDS;$i++)
    {
       cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'discountslots'.$i, "VARCHAR(10) DEFAULT '1' NOT NULL");
       cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'discountvalue'.$i, "VARCHAR(10) DEFAULT '1' NOT NULL");
    }

    $_POST["request_cost"] = '';
    for ($k=1;$k <= intval($_POST["max_slots"]); $k++)
        $_POST["request_cost"] .= ($k!=1?";":"").$_POST["request_cost_".$k];

    $_POST["request_cost_st"] = '';
    for ($k=1;$k <= intval($_POST["max_slots"]); $k++)
        $_POST["request_cost_st"] .= ($k!=1?";":"").@$_POST["request_cost_st_".$k];

    $data = array(
         'form_structure' => $_POST['form_structure'],
         'calendar_language' => $_POST["calendar_language"],
         'calendar_dateformat' => $_POST["calendar_dateformat"],
         'calendar_pages' => $_POST["calendar_pages"],
         'calendar_militarytime' => $_POST["calendar_militarytime"],
         'calendar_weekday' => $_POST["calendar_weekday"],
         'calendar_mindate' => $_POST["calendar_mindate"],
         'calendar_maxdate' => $_POST["calendar_maxdate"],
         'min_slots' => $_POST["min_slots"],
         'max_slots' => $_POST["max_slots"],
         'close_fpanel' => $_POST["close_fpanel"],

         'quantity_field' => @$_POST["quantity_field"],
         'quantity_field_two' => @$_POST["quantity_field_two"],
         'quantity_field_label' => @$_POST["quantity_field_label"],
         'quantity_field_two_label' => @$_POST["quantity_field_two_label"],
         'ajax_load_enabled' => @$_POST["ajax_load_enabled"],
         'paypal_mode' => @$_POST["paypal_mode"],

         'calendar_startyear' => $_POST["calendar_startyear"],
         'calendar_startmonth' => $_POST["calendar_startmonth"],
         'calendar_theme' => $_POST["calendar_theme"],
         
         'gmt_enabled' => @$_POST["gmt_enabled"],
         'gmt_diff' => @$_POST["gmt_diff"],
         
         'enable_fu_reminder' => @$_POST["enable_fu_reminder"],
         'fu_reminder_hours' => @$_POST["fu_reminder_hours"],
         'fu_reminder_subject' => @$_POST["fu_reminder_subject"],
         'fu_nremind_emailformat' => @$_POST["fu_nremind_emailformat"],
         'fu_reminder_content' => @$_POST["fu_reminder_content"],        

         'enable_paypal' => @$_POST["enable_paypal"],
         'paypal_email' => $_POST["paypal_email"],
         'request_cost' => $_POST["request_cost"],
         'request_cost_st' => $_POST["request_cost_st"],
         'paypal_price_field' => @$_POST["paypal_price_field"],
         'paypal_product_name' => $_POST["paypal_product_name"],
         'currency' => $_POST["currency"],
         'url_ok' => $_POST["url_ok"],
         'url_cancel' => $_POST["url_cancel"],
         'paypal_language' => $_POST["paypal_language"],
         
         'enable_paypal_option_yes' => (@$_POST['enable_paypal_option_yes']?$_POST['enable_paypal_option_yes']:CPABC_APPOINTMENTS_DEFAULT_PAYPAL_OPTION_YES),
         'enable_paypal_option_no' => (@$_POST['enable_paypal_option_no']?$_POST['enable_paypal_option_no']:CPABC_APPOINTMENTS_DEFAULT_PAYPAL_OPTION_NO),         
         'stripe_key' => @$_POST["stripe_key"],
         'stripe_secretkey' => @$_POST["stripe_secretkey"],
         
         'authorizenet_api_id' => @$_POST["authorizenet_api_id"],
         'authorizenet_tra_key' => @$_POST["authorizenet_tra_key"],

         'nuser_emailformat' => $_POST["nuser_emailformat"],
         'nadmin_emailformat' => $_POST["nadmin_emailformat"],
         'nremind_emailformat' => $_POST["nremind_emailformat"],

         'vs_use_validation' => $_POST['vs_use_validation'],
         'vs_text_is_required' => $_POST['vs_text_is_required'],
         'vs_text_is_email' => $_POST['vs_text_is_email'],
         'vs_text_datemmddyyyy' => $_POST['vs_text_datemmddyyyy'],
         'vs_text_dateddmmyyyy' => $_POST['vs_text_dateddmmyyyy'],
         'vs_text_number' => $_POST['vs_text_number'],
         'vs_text_digits' => $_POST['vs_text_digits'],
         'vs_text_max' => $_POST['vs_text_max'],
         'vs_text_min' => $_POST['vs_text_min'],
         'vs_text_submitbtn' => $_POST['vs_text_submitbtn'],

         'cu_user_email_field' => @$_POST["cu_user_email_field"],

         'notification_from_email' => $_POST["notification_from_email"],
         'notification_destination_email' => $_POST["notification_destination_email"],
         'email_subject_confirmation_to_user' => $_POST["email_subject_confirmation_to_user"],
         'email_confirmation_to_user' => $_POST["email_confirmation_to_user"],
         'email_subject_notification_to_admin' => $_POST["email_subject_notification_to_admin"],
         'email_notification_to_admin' => $_POST["email_notification_to_admin"],

         'enable_reminder' => @$_POST["enable_reminder"],
         'reminder_hours' => @$_POST["reminder_hours"],
         'reminder_subject' => @$_POST["reminder_subject"],
         'reminder_content' => @$_POST["reminder_content"],

         'dexcv_enable_captcha' => $_POST["dexcv_enable_captcha"],
         'dexcv_width' => $_POST["dexcv_width"],
         'dexcv_height' => $_POST["dexcv_height"],
         'dexcv_chars' => $_POST["dexcv_chars"],
         'dexcv_min_font_size' => $_POST["dexcv_min_font_size"],
         'dexcv_max_font_size' => $_POST["dexcv_max_font_size"],
         'dexcv_noise' => $_POST["dexcv_noise"],
         'dexcv_noise_length' => $_POST["dexcv_noise_length"],
         'dexcv_background' => $_POST["dexcv_background"],
         'dexcv_border' => $_POST["dexcv_border"],
         'dexcv_font' => $_POST["dexcv_font"],
         'cv_text_enter_valid_captcha' => $_POST['cv_text_enter_valid_captcha'],
         'cp_cal_checkboxes' => @$_POST["cp_cal_checkboxes"]
	);

    for ($i=1;$i<=CPABC_DISCOUNT_FIELDS;$i++)
    {
       $data["discountslots".$i] = @$_POST["discountslots".$i];
       $data["discountvalue".$i] = @$_POST["discountvalue".$i];
    }

    $wpdb->update ( CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, $data, array( 'id' => CP_CALENDAR_ID ));
}

function cpabc_appointments_get_field_name ($fieldid, $form)
{
    if (is_array($form))
        foreach($form as $item)
            if ($item->name == $fieldid)
                return $item->title;
    return $fieldid;
}

function cpabc_appointments_export_csv ()
{
    if (!is_admin())
        return;
    global $wpdb;

    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',intval($_GET["cal"]));

    $form_data = json_decode(cpabc_appointment_cleanJSON(cpabc_get_option('form_structure', CPABC_APPOINTMENTS_DEFAULT_form_structure)));

    if (@$_GET["cancelled_by"] != '')
        $cond = '';
    else
        $cond = " AND (is_cancelled<>'1')";
    if ($_GET["search"] != '') $cond .= " AND (buffered_date like '%".esc_sql($_GET["search"])."%')";
    if ($_GET["dfrom"] != '') $cond .= " AND (`booked_time_unformatted` >= '".esc_sql($_GET["dfrom"])."')";
    if ($_GET["dto"] != '') $cond .= " AND (`booked_time_unformatted` <= '".esc_sql($_GET["dto"])." 23:59:59')";

    if (@$_GET["added_by"] != '') $cond .= " AND (who_added >= '".esc_sql($_GET["added_by"])."')";
    if (@$_GET["edited_by"] != '') $cond .= " AND (who_edited >= '".esc_sql($_GET["edited_by"])."')";
    if (@$_GET["cancelled_by"] != '') $cond .= " AND (is_cancelled='1' AND who_cancelled >= '".esc_sql($_GET["cancelled_by"])."')";

    if (CP_CALENDAR_ID != 0) $cond .= " AND calendar=".CP_CALENDAR_ID;

    $events = $wpdb->get_results( "SELECT ".CPABC_APPOINTMENTS_TABLE_NAME.".*,".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".uname FROM ".CPABC_APPOINTMENTS_TABLE_NAME." INNER JOIN ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." ON ".CPABC_APPOINTMENTS_TABLE_NAME.".calendar=".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".id INNER JOIN  ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." on  ".CPABC_APPOINTMENTS_TABLE_NAME.".id=".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".reference  WHERE 1=1 ".$cond." ORDER BY ".$_GET["orderby"]."" );

    $fields = array("Calendar ID","Calendar Name", "Time");
    $values = array();
    foreach ($events as $item)
    {
        $value = array($item->calendar, $item->uname, $item->time);

        $data = array();
        $data = unserialize($item->buffered_date);

        $end = count($fields);
        for ($i=0; $i<$end; $i++)
            if (isset($data[$fields[$i]]) ){
                $value[$i] = $data[$fields[$i]];
                unset($data[$fields[$i]]);
            }

        foreach ($data as $k => $d)
        {
           $fields[] = $k;
           $value[] = $d;
        }
        $values[] = $value;
    }


    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=export.csv");

    $end = count($fields);
    for ($i=0; $i<$end; $i++)
        echo '"'.str_replace('"','""', cpabc_appointments_get_field_name($fields[$i],@$form_data[0])).'",';
    echo "\n";
    foreach ($values as $item)
    {
        for ($i=0; $i<$end; $i++)
        {
            if (!isset($item[$i]))
                $item[$i] = '';
            if (is_array($item[$i]))
                $item[$i] = implode($item[$i],',');
            echo '"'.str_replace('"','""', $item[$i]).'",';
        }
        echo "\n";
    }

    exit;
}

// new feature to send CSV remiders for the appointments of the current day.
function cpabc_appointments_check_CSV_reminders() {
    global $wpdb;
    if (!CPABC_EMAIL_REPORT_ENABLED) // if not enabled nothing to do
        return;
    $last_verified = get_option('cp_abc_last_verified','');
    $current_date = date("Y-m-d");
    if ( $last_verified == '' || $last_verified != $current_date )  // verification to check once at day
    {
        update_option('cp_abc_last_verified',$current_date);
        // check all calendars separately
        $calendars = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME );                                                                     
        foreach ($calendars as $calendar) {
            $form_data = json_decode(cpabc_appointment_cleanJSON($calendar->form_structure));
            $events = $wpdb->get_results( "SELECT ".CPABC_APPOINTMENTS_TABLE_NAME.".*,".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".uname FROM ".CPABC_APPOINTMENTS_TABLE_NAME." INNER JOIN ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." ON ".CPABC_APPOINTMENTS_TABLE_NAME.".calendar=".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".id INNER JOIN  ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." on  ".CPABC_APPOINTMENTS_TABLE_NAME.".id=".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".reference  WHERE booked_time_unformatted like '".$current_date."%'" );
            $fields = array("Calendar ID","Calendar Name", "Received on");
            $values = array();    
            // get the data        
            foreach ($events as $item) 
            {
                $value = array($item->calendar, $item->uname, $item->time);
                $data = array();
                $data = unserialize($item->buffered_date);                
                $end = count($fields);
                for ($i=0; $i<$end; $i++)
                    if (isset($data[$fields[$i]]) ){
                        $value[$i] = $data[$fields[$i]];
                        unset($data[$fields[$i]]);
                    }
                foreach ($data as $k => $d)
                {
                   $fields[] = $k;
                   $value[] = $d;
                }
                $values[] = $value;
            }
            // if something to send
            if (count($values))
            {
                // build the CSV
                $buffer = '';
                $end = count($fields);
                for ($i=0; $i<$end; $i++)
                    $buffer.= '"'.str_replace('"','""', cpabc_appointments_get_field_name($fields[$i],@$form_data[0])).'",';
                $buffer.= "\n";
                foreach ($values as $item)
                {
                    for ($i=0; $i<$end; $i++)
                    {
                        if (!isset($item[$i]))
                            $item[$i] = '';
                        if (is_array($item[$i]))
                            $item[$i] = implode($item[$i],',');
                        $buffer.= '"'.str_replace('"','""', $item[$i]).'",';
                    }
                    $buffer.= "\n";
                }
                // save the CSV to be able to attach it
                $text = "- ".substr_count($csv,",\n\"").' submissions from '.$form->form_name."\n";
                $filename = 'Appointments_'.date("m_d_y");
                $filename = WP_CONTENT_DIR . '/uploads/'.$filename .'.csv';
                $handle = fopen($filename, 'w');
                fwrite($handle,$buffer);
                fclose($handle);
                $attachments = array($filename);
                // send the email
                if (CPABC_EMAIL_REPORT_TO == '')
                    $to = $calendar->notification_destination_email;
                else  
                    $to = CPABC_EMAIL_REPORT_TO;   
                wp_mail( $to, CPABC_EMAIL_REPORT_SUBJECT, CPABC_EMAIL_REPORT_MESSAGE,
                                    "From: \"".$calendar->notification_from_email."\" <".$calendar->notification_from_email.">\r\n".
                                    $content_type.
                                    "X-Mailer: PHP/" . phpversion(),
                                    $attachments);
            }    
        }
    }
}


function cpabc_appointments_check_reminders() {
    global $wpdb;
    
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'description_customer');
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'fu_reminder');
    
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_nremind_emailformat');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_reminder_subject');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_reminder_content');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'enable_fu_reminder');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'fu_reminder_hours');       
    
    
    // INITIAL BLOCK: REMINDER
    // *********************************************************************
    
    $query = "SELECT nremind_emailformat,notification_from_email,description_customer,reminder_subject,reminder_content,uname,".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".* FROM ".
              CPABC_TDEAPP_CALENDAR_DATA_TABLE." INNER JOIN ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." ON ".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".appointment_calendar_id=".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".id ".
              " WHERE (is_cancelled<>'1') AND enable_reminder=1 AND reminder<>'1' AND datatime<DATE_ADD(now(),INTERVAL reminder_hours HOUR) AND datatime>'".date("Y-m-d H:i:s")."'";
    $apps = $wpdb->get_results( $query);
    foreach ($apps as $app) {
        // mark as sent
        $wpdb->query("UPDATE ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." SET reminder='1' WHERE id=".$app->id);   
    }    
    foreach ($apps as $app) {
        // send email
        if ('html' == $app->nremind_emailformat) $content_type = "Content-Type: text/html; charset=utf-8\n"; else $content_type = "Content-Type: text/plain; charset=utf-8\n";
        $email_content = str_replace('%INFORMATION%',str_replace('<br />',"\n",$app->description_customer),$app->reminder_content);

        $app_source = $wpdb->get_results( "SELECT buffered_date FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".$app->reference);
        $params = unserialize($app_source[0]->buffered_date);
        foreach ($params as $item => $value)
        {
            $email_content = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content);
            $email_content = str_replace('%'.$item.'%',(is_array($value)?(implode(", ",$value)):($value)),$email_content);
        }
        $email_content = str_replace("%CALENDAR%", $app->uname, $email_content);
        wp_mail($app->title, $app->reminder_subject, $email_content,
                "From: \"".$app->notification_from_email."\" <".$app->notification_from_email.">\r\n".
                $content_type.
                "X-Mailer: PHP/" . phpversion());
        if (CPABC_APPOINTMENTS_SEND_REMINDER_ADMIN)        
        {
            $SYSTEM_RCPT_EMAIL = cpabc_get_option('notification_destination_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL);
            $to = explode(",",$SYSTEM_RCPT_EMAIL);
            foreach ($to as $item)
                 if (trim($item) != '')
                 {
                     wp_mail(trim($item), "Copy: ".$app->reminder_subject, $email_content,
                    "From: \"".$app->notification_from_email."\" <".$app->notification_from_email.">\r\n".
                    $content_type.
                    "X-Mailer: PHP/" . phpversion());
                 }                   
        }
    }
    
    // INITIAL BLOCK: REMINDER
    // *********************************************************************
    
    $query = "SELECT ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".fu_nremind_emailformat,notification_from_email,description_customer,".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".fu_reminder_subject,".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".fu_reminder_content,uname,".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".* FROM ".
              CPABC_TDEAPP_CALENDAR_DATA_TABLE." INNER JOIN ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." ON ".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".appointment_calendar_id=".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".id ".
              " WHERE (is_cancelled<>'1') AND ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".enable_fu_reminder=1 AND fu_reminder<>'1' AND now()>DATE_ADD(datatime,INTERVAL ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".fu_reminder_hours HOUR) AND now()<DATE_ADD(datatime,INTERVAL 360 HOUR)"; // 360 hours = 15 days
                
    $apps = $wpdb->get_results( $query);
    foreach ($apps as $app) {
        // mark as sent
        $wpdb->query("UPDATE ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." SET fu_reminder='1' WHERE id=".$app->id);   
    }    
    foreach ($apps as $app) {
        // send email
        if ('html' == $app->fu_nremind_emailformat) $content_type = "Content-Type: text/html; charset=utf-8\n"; else $content_type = "Content-Type: text/plain; charset=utf-8\n";
        $email_content = str_replace('%INFORMATION%',str_replace('<br />',"\n",$app->description_customer),$app->fu_reminder_content);

        $app_source = $wpdb->get_results( "SELECT buffered_date FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".$app->reference);
        $params = unserialize($app_source[0]->buffered_date);
        foreach ($params as $item => $value)
        {
            $email_content = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content);
            $email_content = str_replace('%'.$item.'%',(is_array($value)?(implode(", ",$value)):($value)),$email_content);
        }
        $email_content = str_replace("%CALENDAR%", $app->uname, $email_content);
        wp_mail($app->title, $app->fu_reminder_subject, $email_content,
                "From: \"".$app->notification_from_email."\" <".$app->notification_from_email.">\r\n".
                $content_type.
                "X-Mailer: PHP/" . phpversion());
       
        if (CPABC_APPOINTMENTS_SEND_REMINDER_ADMIN) 
        {  
            $SYSTEM_RCPT_EMAIL = cpabc_get_option('notification_destination_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL);
            $to = explode(",",$SYSTEM_RCPT_EMAIL);
            foreach ($to as $item)
                 if (trim($item) != '')
                 {
                     wp_mail(trim($item), "Copy: ".$app->fu_reminder_subject, $email_content,
                    "From: \"".$app->notification_from_email."\" <".$app->notification_from_email.">\r\n".
                    $content_type.
                    "X-Mailer: PHP/" . phpversion());
                 }                  
        }        
    }    
        
}


add_action( 'init', 'cpabc_appointments_calendar_load', 11 );
add_action( 'init', 'cpabc_appointments_calendar_load2', 11 );
add_action( 'init', 'cpabc_appointments_calendar_update', 11 );
add_action( 'init', 'cpabc_appointments_calendar_update2', 11 );

function cpabc_appointments_calendar_load() {
    global $wpdb;
	if ( ! isset( $_GET['cpabc_calendar_load'] ) || $_GET['cpabc_calendar_load'] != '1' )
		return;	
    //@ob_clean();
    @header("Cache-Control: no-store, no-cache, must-revalidate");
    @header("Pragma: no-cache");
    $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
    $query = "SELECT * FROM ".CPABC_TDEAPP_CONFIG." where ".CPABC_TDEAPP_CONFIG_ID."='".esc_sql($calid)."'";
    $row = $wpdb->get_results($query,ARRAY_A);
    if ($row[0])
    {
        // New header to mark init of calendar output
        echo '--***--***--***---!';
        // START:: new code to clean corrupted data 
        $working_dates = explode(",",$row[0][CPABC_TDEAPP_CONFIG_WORKINGDATES]);
        for($i=0;$i<count($working_dates); $i++)
            if (is_numeric($working_dates[$i]))
                $working_dates[$i] = intval($working_dates[$i]);
            else            
                $working_dates[$i] = ''; 
        if ($working_dates[0] === '')
            unset($working_dates[0]);                
        $working_dates = array_unique($working_dates);        
        $working_dates = implode(",",$working_dates); 
        while (!(strpos($working_dates,",,") === false))
            $working_dates = str_replace(",,",",",$working_dates);       
        echo $working_dates.";";
        // END:: new code to clean corrupted data
        echo $row[0][CPABC_TDEAPP_CONFIG_RESTRICTEDDATES].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6].";";
        echo $row[0]["specialDates"];
    }

    exit();
}

function cpabc_appointments_calendar_load2() {
    global $wpdb;
	if ( ! isset( $_GET['cpabc_calendar_load2'] ) || $_GET['cpabc_calendar_load2'] != '1' )
		return;
    //@ob_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
    $query = "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."='".esc_sql($calid)."'";
    $row_array = $wpdb->get_results($query,ARRAY_A);
    foreach ($row_array as $row)
    if (@$row["is_cancelled"] != '1')
    {
        echo $row[CPABC_TDEAPP_DATA_ID]."\n";
        $dn =  explode(" ", $row[CPABC_TDEAPP_DATA_DATETIME]);
        $d1 =  explode("-", $dn[0]);
        $d2 =  explode(":", $dn[1]);

        echo intval($d1[0]).",".intval($d1[1]).",".intval($d1[2])."\n";
        echo intval($d2[0]).":".($d2[1])."\n";
        echo ($row["quantity"]?$row["quantity"]:'1')."\n";
        //echo $row[CPABC_TDEAPP_DATA_TITLE]."\n";
        echo "Booked\n";
        //echo $row[CPABC_TDEAPP_DATA_DESCRIPTION]."\n*-*\n";
        echo "Do not edit! Go to the Bookings List area for edition.\n*-*\n";
    }

    exit();
}

function cpabc_appointments_calendar_update() {
    global $wpdb, $user_ID;

	if ( ! isset( $_GET['cpabc_calendar_update'] ) || $_GET['cpabc_calendar_update'] != '1' )
		return;

    $calid = intval(str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]));
    if ( ! current_user_can('edit_pages') && !cpabc_appointments_user_access_to($calid) )
        return;

    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CONFIG, 'specialDates');

    //@ob_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    if ( $user_ID )
        $wpdb->query("update  ".CPABC_TDEAPP_CONFIG." set specialDates='".$_POST["specialDates"]."',".CPABC_TDEAPP_CONFIG_WORKINGDATES."='".$_POST["workingDates"]."',".CPABC_TDEAPP_CONFIG_RESTRICTEDDATES."='".$_POST["restrictedDates"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0."='".$_POST["timeWorkingDates0"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1."='".$_POST["timeWorkingDates1"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2."='".$_POST["timeWorkingDates2"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3."='".$_POST["timeWorkingDates3"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4."='".$_POST["timeWorkingDates4"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5."='".$_POST["timeWorkingDates5"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6."='".$_POST["timeWorkingDates6"]."'  where ".CPABC_TDEAPP_CONFIG_ID."=".$calid);


    exit();
}

function cpabc_appointments_calendar_update2() {
    global $wpdb, $user_ID;

	if ( ! isset( $_GET['cpabc_calendar_update2'] ) || $_GET['cpabc_calendar_update2'] != '1' )
		return;

    $calid = intval(str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]));
    if ( ! current_user_can('edit_pages') && !cpabc_appointments_user_access_to($calid) )
        return;

    //@ob_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    if ( $user_ID )
    {
        if ($_GET["act"]=='del')
            $wpdb->query("delete from ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".$calid." and ".CPABC_TDEAPP_DATA_ID."=".intval($_POST["sqlId"]));
        else if ($_GET["act"]=='edit')
        {
            $data = explode("\n", $_POST["appoiments"]);
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = $d1[0]."-".$d1[1]."-".$d1[2]." ".$d2[0].":".$d2[1];
	        $capacity = $data[2];
	        $title = $data[3];
            $description = "";
            for ($j=4;$j<count($data);$j++)
            {
                $description .= $data[$j];
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            // ,".CPABC_TDEAPP_DATA_TITLE."='".esc_sql($title)."',".CPABC_TDEAPP_DATA_DESCRIPTION."='".esc_sql($description)."'
            $wpdb->query("update  ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." set ".CPABC_TDEAPP_DATA_DATETIME."='".$datetime."',quantity='".$capacity."' where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".$calid." and ".CPABC_TDEAPP_DATA_ID."=".$_POST["sqlId"]);
        }
        else if ($_GET["act"]=='add')
        {
            $data = explode("\n", $_POST["appoiments"]);
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = $d1[0]."-".$d1[1]."-".$d1[2]." ".$d2[0].":".$d2[1];
	        $capacity = $data[2];
	        $title = $data[3];
            $description = "";
            for ($j=4;$j<count($data);$j++)
            {
                $description .= $data[$j];
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            $wpdb->query("insert into ".CPABC_TDEAPP_CALENDAR_DATA_TABLE."(".CPABC_TDEAPP_DATA_IDCALENDAR.",".CPABC_TDEAPP_DATA_DATETIME.",".CPABC_TDEAPP_DATA_TITLE.",".CPABC_TDEAPP_DATA_DESCRIPTION.",quantity) values(".$calid.",'".$datetime."','".esc_sql($title)."','".esc_sql($description)."','".$capacity."') ");
            echo  $wpdb->insert_id;

        }
    }

    exit();
}

function cpabc_appointment_cleanJSON($str)
{
    $str = str_replace('&qquot;','"',$str);
    $str = str_replace('	',' ',$str);
    $str = str_replace("\n",'\n',$str);
    $str = str_replace("\r",'',$str);
    return $str;
}



function cpabc_appointment_get_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin ) 
        $url = get_admin_url( $blog );	
    else 
        $url = get_home_url( $blog );	

    $url = parse_url($url);
    $url = rtrim(@$url["path"],"/");
    return $url;
}


function cpabc_appointment_get_FULL_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin ) 
        $url = get_admin_url( $blog );	
    else 
        $url = get_home_url( $blog );
            
    $url = parse_url($url);
    $url = rtrim(@$url["path"],"/");
    $pos = strpos($url, "://");
    if ($pos === false)
        $url = 'http://'.$_SERVER["HTTP_HOST"].$url;
    if (!empty($_SERVER['HTTPS']))     
        $url = str_replace("http://","https://",$url);        
    return $url;
}


// cpabc_cpabc_get_option:
$cpabc_option_buffered_item = false;
$cpabc_option_buffered_id = -1;

function cpabc_get_option ($field, $default_value)
{
    global $wpdb, $cpabc_option_buffered_item, $cpabc_option_buffered_id;
    if (!defined('CP_CALENDAR_ID'))
        $id = 0;
    else
        $id = CP_CALENDAR_ID;
    if ($cpabc_option_buffered_id == $id)
        $value = @$cpabc_option_buffered_item->$field;
    else
    {

       $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=".$id );
       $value = @$myrows[0]->$field;
       $cpabc_option_buffered_item = @$myrows[0];
       $cpabc_option_buffered_id  = $id;
    }
    if ($value == '' && @$cpabc_option_buffered_item->calendar_language == '')
        $value = $default_value;
    return $value;
}

function cpabc_appointment_is_administrator()
{
    return current_user_can('manage_options');
}


// WIDGET CODE BELOW

class CPABC_App_Widget extends WP_Widget
{
  function CPABC_App_Widget()
  {
    $widget_ops = array('classname' => 'CPABC_App_Widget', 'description' => 'Displays a booking form' );
    $this->WP_Widget('CPABC_App_Widget', 'Appointment Booking Calendar', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

    if (!empty($title))
      echo $before_title . $title . $after_title;;

    // WIDGET CODE GOES HERE
    define('CPABC_AUTH_INCLUDE', true);
    cpabc_appointments_get_public_form();

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("CPABC_App_Widget");') );


?>