<?php
/* Plugin Name: qstring-parameter
Plugin URI: http://phpbase.in/free-scripts/qstring-wordpress-plugin/
Description: A plugin to allow to access get parameters from query string or URL
Author: Satish Kumar Sharma
Version: 1.0
Author URI: https://www.facebook.com/sakush100
*/

function load_qstrings() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
$urlx_qstring = $pageURL;
$datax_qstring=explode("?",$urlx_qstring);
$get_qstring=explode("&",$datax_qstring[1]);
foreach($get_qstring as $string){
$strx=explode('=',$string);
$key=$strx[0];
$value=$strx[1];
$qstring[$key]=$value;
}

return $qstring;
}

?>