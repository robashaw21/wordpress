<?php

if ( !is_admin() )
{
    echo 'Direct access not allowed.';
    exit;
}

if (!defined('CP_CALENDAR_ID'))
    define ('CP_CALENDAR_ID',intval($_GET["cal"]));

global $wpdb;

$current_user = wp_get_current_user();

if (true) {   // (cpabc_appointment_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) {
    
    $event = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE id=".esc_sql($_GET["edit"]) );
    $event = $event[0];
       
    if ($event->reference != '')
    {
        $form_data = json_decode(cpabc_appointment_cleanJSON(cpabc_get_option('form_structure', CPABC_APPOINTMENTS_DEFAULT_form_structure))); 
        
        $org_booking = $wpdb->get_results( "SELECT buffered_date FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".$event->reference );
        $params = unserialize($org_booking[0]->buffered_date);
        unset($params["QUANTITY"]);
        unset($params["DATE"]);
        unset($params["TIME"]);       
    }
    else
        $params["description"] = $event->description;
        
    if (count($_POST) > 0) 
    {
       $datatime = $_POST["datatime"]." ".$_POST["datatime_hour"].":".$_POST["datatime_minutes"].":00";
       if (cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME) == '0') $format = "g:i A"; else $format = "H:i";
       $calendar_dformat = cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT);
       if ($calendar_dformat == '2') 
           $format = "d.m.Y ".$format; 
       else if ($calendar_dformat == '1')
           $format = "d/m/Y ".$format;
       else 
           $format = "m/d/Y ".$format; 
  
       
       // save quantity
       // save title
       // save buffered_date en original table
       // save description in destination table
       // track who editied the item
       
       $military_time = cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME);
       if (cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME) == '0') $format_t = "g:i A"; else $format_t = "H:i";
      
       $calendar_dformat = cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT);
       if ($calendar_dformat == '2') 
           $format_d = "d.m.Y "; 
       else if ($calendar_dformat == '1')
           $format_d = "d/m/Y ";
       else 
           $format_d = "m/d/Y "; 
        
    
       $params_new = array(
                   'DATE' => date($format_d,strtotime($_POST["datatime"])),
                   'TIME' => date($format_t,strtotime($_POST["datatime_hour"].":".$_POST["datatime_minutes"])),
                   'QUANTITY' => $_POST['quantity']
                 );
       foreach ($params as $item => $value)
           $params_new[$item] = $_POST[$item];
          
       $description = cpabc_get_option('uname','').'<br />'.date($format, strtotime($datatime)).'<br />';
       foreach ($params_new as $item => $value)
           if ($value != '' && $item != 'DATE' && $item != 'TIME' && $item != 'QUANTITY')
           {
               $name = cpabc_appointments_get_field_name($item,$form_data[0]); 
               if ($name == 'ADULTS')
                   $name = cpabc_get_option('quantity_field_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL);
               else if ($name == 'JUNIORS')
                   $name = cpabc_get_option('quantity_field_two_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL_TWO);         
               $description .= $name.': '.$value.'<br />';
           }    
       
       if ($event->reference == '')  $description = $_POST["description"];
       
       $data1 = array(
                        'datatime' => $datatime,
                        'quantity' => $_POST['quantity'],
                        'title' => $_POST["title"],
                        'description' => $description,
                        'who_edited' => $current_user->ID
                     );
       
       $data2 = array(
                        'booked_time_unformatted' => $datatime,
                        'booked_time' => date($format, strtotime($datatime)),
                        'quantity' => $_POST['quantity'],
                        'buffered_date' => serialize($params_new)
                     );
       
       
       $wpdb->update ( CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME, $data1, array( 'id' => $_GET["edit"] ));
       if ($event->reference != '') $wpdb->update ( CPABC_APPOINTMENTS_TABLE_NAME, $data2, array( 'id' => $event->reference ));
       
       echo '<script type="text/javascript">  document.location = "admin.php?page=cpabc_appointments&cal='.$_GET["cal"].'&list=1&message=Item updated&r="+Math.random();</script>';
       exit;
    }    
    
    $date = date("Y-m-d", strtotime($event->datatime));
    $hour = intval (date("G", strtotime($event->datatime)));
    $minute = intval(date("i", strtotime($event->datatime)));
    if (strlen($minute)==2 && $minute[0] == '0') $minute = $minute[1];
    
?>

<div class="wrap">
<h2>Edit Booking</h2>

<form method="post" name="dexeditfrm" action=""> 

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Appointment Data</span></h3>
  <div class="inside">  
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Date</th>
        <td><input type="text" name="datatime" id="datatime" size="40" value="<?php echo $date; ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Time</th>
        <td>
          <select name="datatime_hour">
           <?php for ($i=0;$i<24;$i++) echo '<option'.($i==$hour?' selected':'').'>'.($i<10?'0':'').$i.'</option>'; ?>
          </select> :
          <select name="datatime_minutes">
           <?php for ($i=0;$i<60;$i+=5) echo '<option'.($i==$minute?' selected':'').'>'.($i<10?"0":"").$i.'</option>'; ?>
          </select>
        </td>
        </tr>
        <tr valign="top">
        <th scope="row">Appointment Title</th>
        <td><input type="text" name="title" size="40" value="<?php echo esc_attr($event->title); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Quantity</th>
        <td>
          <select name="quantity">
           <?php for ($i=1;$i<$event->quantity+20;$i++) { ?>
             <option <?php if (intval($event->quantity)==$i) echo ' selected'; ?>><?php echo $i; ?></option>
           <?php } ?>
          </select>
        </td>
        </tr>
        <?php foreach ($params as $item => $value) { ?>
        <tr valign="top">
        <th scope="row"><?php 
                           $name = cpabc_appointments_get_field_name($item,$form_data[0]); 
                           if ($name == 'ADULTS')
                               echo cpabc_get_option('quantity_field_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL);
                           else if ($name == 'JUNIORS')
                               echo cpabc_get_option('quantity_field_two_label',CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD_LABEL_TWO);
                           else
                               echo $name;    
        ?></th>
        <td>
          <?php if (strpos($value,"\n") > 0 || strlen($value) > 80) { ?>
          <textarea cols="85" name="<?php echo $item; ?>"><?php echo ($value); ?></textarea>
          <?php } else { ?>
          <input type="text" name="<?php echo $item; ?>" value="<?php echo esc_attr($value); ?>" />
          <?php } ?>
        </td>
        </tr>
        <?php } ?>
     </table>         
  </div>
 </div>       



<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save"  />  &nbsp; <input type="button" value="Cancel" onclick="javascript:gobackapp();"></p>



</form>

</div>

<script type="text/javascript">
 var $j = jQuery.noConflict();
 $j(function() {
 	$j("#datatime").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 }); 	
 });
 function gobackapp()
 {
     document.location = 'admin.php?page=cpabc_appointments&cal=<?php echo $_GET["cal"]; ?>&list=1&r='+Math.random();
 }
</script>


<?php } else { ?>
  <br />
  The current user logged in doesn't have enough permissions to edit this item. Please log in as administrator to get full access.

<?php } ?>








