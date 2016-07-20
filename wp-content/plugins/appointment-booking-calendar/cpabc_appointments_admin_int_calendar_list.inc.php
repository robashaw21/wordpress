<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;

cpabc_appointments_add_field_verify($wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX, 'is_cancelled', "VARCHAR(50) DEFAULT '0' NOT NULL");

$message = "";
if (isset($_GET['a']) && $_GET['a'] == '1')
{
    $sql .= 'INSERT INTO `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` (conwer,`'.CPABC_TDEAPP_CONFIG_TITLE.'`,`'.CPABC_TDEAPP_CONFIG_USER.'`,`'.CPABC_TDEAPP_CONFIG_PASS.'`,`'.CPABC_TDEAPP_CONFIG_LANG.'`,`'.CPABC_TDEAPP_CONFIG_CPAGES.'`,`'.CPABC_TDEAPP_CONFIG_TYPE.'`,`'.CPABC_TDEAPP_CONFIG_MSG.'`,`'.CPABC_TDEAPP_CONFIG_WORKINGDATES.'`,`'.CPABC_TDEAPP_CONFIG_RESTRICTEDDATES.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6.'`,`'.CPABC_TDEAPP_CALDELETED_FIELD.'`) '.
            ' VALUES(0,"","'.$_GET["name"].'","","ENG","1","3","Please, select your appointment.","1,2,3,4,5","","","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","","0");';
            
    $wpdb->query($sql);       
    $results = $wpdb->get_results('SELECT `'.CPABC_TDEAPP_CONFIG_ID.'` FROM `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` ORDER BY `'.CPABC_TDEAPP_CONFIG_ID.'` DESC LIMIT 0,1');        
    $wpdb->query('UPDATE `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` SET `'.CPABC_TDEAPP_CONFIG_TITLE.'`="cal'.$results[0]->id.'" WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.$results[0]->id);           
    $message = "Item added";
} 
else if (isset($_GET['u']) && $_GET['u'] != '')
{
    $wpdb->query('UPDATE `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` SET conwer='.intval($_GET["owner"]).',`'.CPABC_TDEAPP_CALDELETED_FIELD.'`='.$_GET["public"].',`'.CPABC_TDEAPP_CONFIG_USER.'`="'.$_GET["name"].'" WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.intval($_GET['u']));
    $message = "Item updated";        
}
else if (isset($_GET['d']) && $_GET['d'] != '')
{
    $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.intval($_GET['d']));       
    $message = "Item deleted";
} 
else if (isset($_GET['c']) && $_GET['c'] != '')
{
    $myrows = $wpdb->get_row( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE `".CPABC_TDEAPP_CONFIG_ID."`=".intval($_GET['c']), ARRAY_A);    
    unset($myrows[CPABC_TDEAPP_CONFIG_ID]);
    $myrows[CPABC_TDEAPP_CONFIG_USER] = 'Cloned: '.$myrows[CPABC_TDEAPP_CONFIG_USER];
    $wpdb->insert( CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, $myrows);
    $message = "Item duplicated/cloned";
} 
else if (isset($_GET['ac']) && $_GET['ac'] == 'st')
{   
    update_option( 'CPABC_CAL_TIME_ZONE_MODIFY_SET', $_GET["ict"] );
    update_option( 'CPABC_CAL_TIME_SLOT_SIZE_SET', $_GET["ics"] );
    
    update_option( 'CPABC_APPOINTMENTS_LOAD_SCRIPTS', ($_GET["scr"]=="1"?"1":"2") );   
    update_option( 'CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR', ($_GET["ccf"]=="1"?"1":"2") );
    if ($_GET["chs"] != '')
    {
        $target_charset = esc_sql($_GET["chs"]);
        $tables = array( $wpdb->prefix.CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX, $wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX
                         , $wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX, $wpdb->prefix.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX );                
        foreach ($tables as $tab)
        {  
            $myrows = $wpdb->get_results( "DESCRIBE {$tab}" );                                                                                 
            foreach ($myrows as $item)
	        {
	            $name = $item->Field;
		        $type = $item->Type;
		        if (preg_match("/^varchar\((\d+)\)$/i", $type, $mat) || !strcasecmp($type, "CHAR") || !strcasecmp($type, "TEXT") || !strcasecmp($type, "MEDIUMTEXT"))
		        {
	                $wpdb->query("ALTER TABLE {$tab} CHANGE {$name} {$name} {$type} COLLATE {$target_charset}");	            
	            }
	        }
        }
    }
    $message = "Troubleshoot settings updated";
}


if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h2>Appointment Booking Calendar</h2>

<script type="text/javascript">
 function cp_addItem()
 {
    var calname = document.getElementById("cp_itemname").value;
    document.location = 'admin.php?page=cpabc_appointments&a=1&r='+Math.random()+'&name='+encodeURIComponent(calname);       
 }
 
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    var is_public = (document.getElementById("calpublic_"+id).checked?"0":"1");
    document.location = 'admin.php?page=cpabc_appointments&u='+id+'&r='+Math.random()+'&public='+is_public+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=cpabc_appointments&cal='+id+'&r='+Math.random();
 }
 
 function cp_cloneItem(id)
 {
    document.location = 'admin.php?page=cpabc_appointments&c='+id+'&r='+Math.random();  
 }  
 
 function cp_BookingsList(id)
 {
    document.location = 'admin.php?page=cpabc_appointments&cal='+id+'&list=1&r='+Math.random();
 }
 
 function cp_deleteItem(id)
 {
    if (confirm('Are you sure that you want to delete this item?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments&d='+id+'&r='+Math.random();
    }
 }
 
 function cp_updateConfig()
 {
    if (confirm('Are you sure that you want to update these settings?'))
    {        
        var scr = document.getElementById("ccscriptload").value;    
        var chs = document.getElementById("cccharsets").value;    
        var ccf = document.getElementById("ccformrender").value; 
        var ict = document.getElementById("icaltimediff").value; 
        var ics = document.getElementById("icaltimeslotsize").value; 
        document.location = 'admin.php?page=cpabc_appointments&ac=st&scr='+scr+'&chs='+chs+'&ccf='+ccf+'&ict='+ict+'&ics='+ics+'&r='+Math.random();
    }    
 } 
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="2"> 
   <tr>
    <th align="left">ID</th><th align="left">Calendar Name</th><th align="left">Owner</th><th align="left">Published?</th><th align="left">iCal Link</th><th align="left">&nbsp; &nbsp; Options</th><th align="left">Shortcode</th>
   </tr> 
<?php  

  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     

  $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME );                                                                     
  foreach ($myrows as $item)   
      if (cpabc_appointment_is_administrator() || ($current_user->ID == $item->conwer))
      {
?>
   <tr> 
    <td nowrap><?php echo $item->id; ?></td>
    <td nowrap><input type="text" <?php if (!cpabc_appointment_is_administrator()) echo ' readonly '; ?>name="calname_<?php echo $item->id; ?>" id="calname_<?php echo $item->id; ?>" value="<?php echo esc_attr($item->uname); ?>" /></td>
    
    <?php if (cpabc_appointment_is_administrator()) { ?>
    <td nowrap>
      <select name="calowner_<?php echo $item->id; ?>" id="calowner_<?php echo $item->id; ?>">
       <option value="0"<?php if (!$item->conwer) echo ' selected'; ?>></option>
       <?php foreach ($users as $user) { 
       ?>
          <option value="<?php echo $user->ID; ?>"<?php if ($user->ID."" == $item->conwer) echo ' selected'; ?>><?php echo $user->user_login; ?></option>
       <?php  } ?>
      </select>
    </td>    
    <?php } else { ?>
        <td nowrap>
        <?php echo $current_user->user_login; ?>
        </td>
    <?php } ?>
    
    <td nowrap align="center">
       <?php if (cpabc_appointment_is_administrator()) { ?> 
         &nbsp; &nbsp; <input type="checkbox" name="calpublic_<?php echo $item->id; ?>" id="calpublic_<?php echo $item->id; ?>" value="1" <?php if (!$item->caldeleted) echo " checked "; ?> />
       <?php } else { ?>  
         <?php if (!$item->caldeleted) echo "Yes"; else echo "No"; ?> 
       <?php } ?>   
    </td>
    <td nowrap><a href="<?php get_site_url(); ?>?cpabc_app=calfeed&id=<?php echo $item->id; ?>&verify=<?php echo substr(md5($item->id.$_SERVER["DOCUMENT_ROOT"]),0,10); ?>">iCal Feed</a></td>
    <td nowrap>&nbsp; &nbsp; 
                             <?php if (cpabc_appointment_is_administrator()) { ?> 
                               <input style="font-size:11px;" type="button" name="calupdate_<?php echo $item->id; ?>" value="Update" onclick="cp_updateItem(<?php echo $item->id; ?>);" /> &nbsp; 
                             <?php } ?>    
                             <input style="font-size:11px;" type="button" name="calmanage_<?php echo $item->id; ?>" value="Manage Settings" onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> &nbsp; 
                             <input style="font-size:11px;" type="button" name="calbookings_<?php echo $item->id; ?>" value="Bookings List" onclick="cp_BookingsList(<?php echo $item->id; ?>);" /> &nbsp; 
                             <?php if (cpabc_appointment_is_administrator()) { ?> 
                               <input type="button" name="calclone_<?php echo $item->id; ?>" value="Clone" onclick="cp_cloneItem(<?php echo $item->id; ?>);" /> &nbsp; 
                               <input style="font-size:11px;" type="button" name="caldelete_<?php echo $item->id; ?>" value="Delete" onclick="cp_deleteItem(<?php echo $item->id; ?>);" />
                             <?php } ?>  
    </td>
     <td nowrap style="font-size:10px;">[CPABC_APPOINTMENT_CALENDAR calendar="<?php echo $item->id; ?>"]</td>
   </tr>
<?php  
      } 
?>   
     
  </table> 
    
    
   
  </div>    
 </div> 
 
<?php if (cpabc_appointment_is_administrator()) { ?> 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>New Calendar / Item</span></h3>
  <div class="inside"> 
   
    <form name="additem">
      Item Name:<br />
      <input type="text" name="cp_itemname" id="cp_itemname"  value="" /> <input type="button" onclick="cp_addItem();" name="gobtn" value="Add" />
      <br /><br />
      
    </form>

  </div>    
 </div>



 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Form Builder Settings & Troubleshoot Area</span></h3>
  <div class="inside"> 
    <p><strong>Important!</strong>: Use this area <strong>only</strong> if you want to activate the form builder or if you are experiencing conflicts with third party plugins, with the theme scripts or with the character encoding.</p>
    <form name="updatesettings">
    
      Form rendering:<br />
       <select id="ccformrender" name="ccformrender">
        <option value="1" <?php if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") == "1") echo 'selected'; ?>>Use classic predefined form</option>
        <option value="2" <?php if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1") echo 'selected'; ?>>Use visual form builder</option>
       </select><br />
       <em>* Classic predefined form is already configured.</em>
      
      <br /><br />
          
    
      Script load method:<br />
       <select id="ccscriptload" name="ccscriptload">
        <option value="1" <?php if (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',"1") == "1") echo 'selected'; ?>>Classic (Recommended)</option>
        <option value="2" <?php if (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',"1") != "1") echo 'selected'; ?>>Direct</option>
       </select><br />
       <em>* Change the script load method if the form doesn't appear in the public website.</em>
      
      <br /><br />
      Character encoding:<br />
       <select id="cccharsets" name="cccharsets">
        <option value="">Keep current charset (Recommended)</option>
        <option value="utf8_general_ci">UTF-8 (try this first)</option>
        <option value="latin1_swedish_ci">latin1_swedish_ci</option>
       </select><br />
       <em>* Update the charset if you are getting problems displaying special/non-latin characters. After updated you need to edit the special characters again.</em>
      
       
       <br /><br />
       iCal timezone difference vs server time:<br /> 
       <select id="icaltimediff" name="icaltimediff">
        <?php for ($i=-23;$i<24; $i++) { ?>        
        <option value="<?php $text = " ".($i<=0?"":"+").$i." hours"; echo urlencode($text); ?>" <?php if (get_option('CPABC_CAL_TIME_ZONE_MODIFY_SET'," +2 hours") == $text) echo ' selected'; ?>><?php echo $text; ?></option>
        <?php } ?>
       </select><br />
       <em>* Update this, if needed, to match the desired timezone. The difference is calculated referred to the server time.</em>
       
       <br /><br />
       iCal timeslot size in minutes:<br />
        <input type="text" size="2" name="icaltimeslotsize" id="icaltimeslotsize" value="<?php echo get_option('CPABC_CAL_TIME_SLOT_SIZE_SET',"15"); ?>" /> minutes
        <br />
       <em>* Update this, if needed, to have a specific slot time in the exported iCal file.</em>
      
        <br /><br />         
       <input type="button" onclick="cp_updateConfig();" name="gobtn" value="UPDATE" />
      <br /><br />      
    </form>

  </div>    
 </div> 

  
<?php } ?>  
  
</div> 


[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar" target="_blank">Help</a>]
</form>
</div>