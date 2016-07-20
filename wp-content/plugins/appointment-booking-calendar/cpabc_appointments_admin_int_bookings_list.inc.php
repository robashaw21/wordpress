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

//  $wpdb->query('ALTER TABLE `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` CHANGE `reference` `reference` VARCHAR(20)  NOT NULL');  

$message = "";

$current_page = intval($_GET["p"]);
if (!$current_page) $current_page = 1;
$records_per_page = 50; 

if (isset($_GET['delmark']) && $_GET['delmark'] != '')
{
    for ($i=0; $i<=$records_per_page; $i++)
    if (isset($_GET['c'.$i]) && $_GET['c'.$i] != '')   
        $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE id='.intval($_GET['c'.$i]));       
    $message = "Marked items deleted";
}
else if (isset($_GET['ld']) && $_GET['ld'] != '')
{
    $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE id='.$_GET['ld']);       
    $message = "Item deleted";
} 
else if (isset($_GET['cancel']) && $_GET['cancel'] != '')
{    
    $wpdb->query("UPDATE `".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME."` SET who_cancelled='".$current_user->ID."',is_cancelled='1',cancelled_reason='".esc_sql($_GET["reason"])."' WHERE id=".$_GET['cancel']);           
    $message = "Item cancelled";
}
else if (isset($_GET['nocancel']) && $_GET['nocancel'] != '')
{    
    $wpdb->query("UPDATE `".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME."` SET who_edited='".$current_user->ID."',is_cancelled='0' WHERE id=".$_GET['nocancel']);           
    $message = "Item un-cancelled";
}
else if (isset($_GET['del']) && $_GET['del'] == 'all')
{    
    if (CP_CALENDAR_ID == '' || CP_CALENDAR_ID == '0')
        $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'`');           
    else
        $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE appointment_calendar_id='.CP_CALENDAR_ID);           
    $message = "All items deleted";
} 
else if (isset($_GET["message"]))
    $message = $_GET["message"];

if (CP_CALENDAR_ID == '' || CP_CALENDAR_ID == '0')
    $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME );
else
    $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.CP_CALENDAR_ID);

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post_options'] ) )
    echo "<div id='setting-error-settings_updated' class='updated settings-error'> <p><strong>Settings saved.</strong></p></div>";

$current_user = wp_get_current_user();

if (cpabc_appointment_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) {
                                                                                 

$cond = '';
if ($_GET["search"] != '') $cond .= " AND (title like '%".esc_sql($_GET["search"])."%' OR description LIKE '%".esc_sql($_GET["search"])."%')";
if ($_GET["dfrom"] != '') $cond .= " AND (datatime >= '".esc_sql($_GET["dfrom"])."')";
if ($_GET["dto"] != '') $cond .= " AND (datatime <= '".esc_sql($_GET["dto"])." 23:59:59')";

if ($_GET["added_by"] != '') $cond .= " AND (who_added >= '".esc_sql($_GET["added_by"])."')";
if ($_GET["edited_by"] != '') $cond .= " AND (who_edited >= '".esc_sql($_GET["edited_by"])."')";
if ($_GET["cancelled_by"] != '') $cond .= " AND (is_cancelled='1' AND who_cancelled >= '".esc_sql($_GET["cancelled_by"])."')";

$orderby = @$_GET["orderby"];
if ($orderby == '')
    $orderby = 'datatime DESC';

if (CP_CALENDAR_ID == '' || CP_CALENDAR_ID == '0')
    $events = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE 1=1".$cond." ORDER BY ".$orderby." " );
else
    $events = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE appointment_calendar_id=".CP_CALENDAR_ID.$cond." ORDER BY ".$orderby." " );    
$total_pages = ceil(count($events) / $records_per_page);

$users_arr = array();
$users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     
foreach ($users as $user)
    $users_arr["id".$user->ID] = $user;

if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>

<script type="text/javascript">
 function cp_deleteMessageItem(id)
 {
    if (confirm('Are you sure that you want to delete this item?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments&cal=<?php echo $_GET["cal"]; ?>&list=1&ld='+id+'&r='+Math.random();
    }
 }
 function cp_editItem(id, cal)
 {
     document.location = 'admin.php?page=cpabc_appointments&cal='+cal+'&edit='+id+'&r='+Math.random();
 }
 function cp_uncancelItem(id)
 {
    if (confirm('Are you sure that you want to un-cancel this item?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments&cal=<?php echo $_GET["cal"]; ?>&list=1&nocancel='+id+'&r='+Math.random();
    }
 }
 function cp_cancelItem(id)
 {
        var reason;
        if (reason = prompt('Please enter cancellation reason:'))
        {
                document.location = 'admin.php?page=cpabc_appointments&cal=<?php echo $_GET["cal"]; ?>&list=1&cancel='+id+'&reason='+reason;
        }
 }
 function do_dexapp_deleteall()
 {
    if (confirm('Are you sure that you want to delete ALL bookings for this calendar?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments&cal=<?php echo $_GET["cal"]; ?>&list=1&del=all&r='+Math.random();
    }    
 }
</script>
<div class="wrap">
<h2>Appointment Booking Calendar - Bookings List</h2>

<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=cpabc_appointments';">


<div id="normal-sortables" class="meta-box-sortables">
 <hr />
 <?php if (CP_CALENDAR_ID != '' && CP_CALENDAR_ID != '0') { ?>
 <h3>This booking list applies only to: <?php echo $mycalendarrows[0]->uname; ?></h3>
 <?php } else { ?>
 <h3>This booking list contains the bookings from ALL calendars.</h3>
 <?php } ?>
</div>



<form action="admin.php" method="get">
 <input type="hidden" name="page" value="cpabc_appointments" />
 <input type="hidden" name="list" value="1" />
 <table>
  <tr>
   <td align="right">Search for:</td>
   <td><input type="text" name="search" value="<?php echo esc_attr($_GET["search"]); ?>" /></td>
   <td align="right">From:</td>
   <td><input type="text" id="dfrom" name="dfrom" value="<?php echo esc_attr($_GET["dfrom"]); ?>" /></td> 
   <td align="right">To:</td>
   <td><input type="text" id="dto" name="dto" value="<?php echo esc_attr($_GET["dto"]); ?>" /></td>
  </tr> 
  <tr>
   <td align="right">Added by:</td>
   <td><select name="added_by"><option value="">--- all users ---</option><?php foreach ($users as $user) echo '<option value="'.$user->ID.'"'.($user->ID==$_GET["added_by"]?' selected':'').'>'.$user->user_login.'</option>'; ?></select></td>
   <td align="right">Edited by:</td>
   <td><select name="edited_by"><option value="">--- all users ---</option><?php foreach ($users as $user) echo '<option value="'.$user->ID.'"'.($user->ID==$_GET["edited_by"]?' selected':'').'>'.$user->user_login.'</option>'; ?></select></td>
   <td align="right">Cancelled by:</td>
   <td><select name="cancelled_by"><option value="">--- all users ---</option><?php foreach ($users as $user) echo '<option value="'.$user->ID.'"'.($user->ID==$_GET["cancelled_by"]?' selected':'').'>'.$user->user_login.'</option>'; ?></select></td>
  </tr>
  <tr>
   <td align="right">Calendar</td>
   <td>
     <select name="cal">
      <option value="0">--- all calendars ---</option>
      <?php 
        $calendars = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME ); 
        $calendars_id = array();
        foreach ($calendars as $item)
        {
            echo '<option value="'.$item->id.'"'.($_GET["cal"]==$item->id?' selected':'').'>'.$item->uname.'</option>';
            $calendars_id["id".$item->id] = $item->uname;
        }
      ?>
     </select>
   </td>  
   <td align="right">Order By</td>
   <td colspan="2">     
     <select name="orderby">
      <option value="id DESC" <?php if ($orderby == 'id DESC') echo ' selected'; ?>>Submission time - desc</option>
      <option value="id ASC" <?php if ($orderby == 'id ASC') echo ' selected'; ?>>Submission time - asc</option>
      <option value="datatime DESC" <?php if ($orderby == 'datatime DESC') echo ' selected'; ?>>Appointment time - desc</option>
      <option value="datatime ASC" <?php if ($orderby == 'datatime ASC') echo ' selected'; ?>>Appointment time - asc</option>
     </select>     
     <span class="submit"><input type="submit" name="ds" value="Filter" /></span> &nbsp; &nbsp; &nbsp; 
     <span class="submit"><input type="submit" name="cpabc_appointments_csv" value="Export to CSV" /></span>
   </td>
  </tr>
 </table>
  
</form>

<br />
                             
<?php


echo paginate_links(  array(
    'base'         => 'admin.php?page=cpabc_appointments&cal='.CP_CALENDAR_ID.'&list=1%_%&dfrom='.urlencode($_GET["dfrom"]).'&dto='.urlencode($_GET["dto"]).'&search='.urlencode($_GET["search"]),
    'format'       => '&p=%#%',
    'total'        => $total_pages,
    'current'      => $current_page,
    'show_all'     => False,
    'end_size'     => 1,
    'mid_size'     => 2,
    'prev_next'    => True,
    'prev_text'    => '&laquo; '.__('Previous','cpabc'),
    'next_text'    => __('Next','cpabc').' &raquo;',
    'type'         => 'plain',
    'add_args'     => False
    ) );

?>


<div id="cpabc_printable_contents">
<form name="dex_table_form" id="dex_table_form" action="admin.php" method="get">
 <input type="hidden" name="page" value="cpabc_appointments" />
 <input type="hidden" name="cal" value="<?php echo $_GET["cal"]; ?>" />
 <input type="hidden" name="list" value="1" />
 <input type="hidden" name="delmark" value="1" />
<table class="wp-list-table widefat fixed pages" cellspacing="0">
	<thead>
	<tr>
	  <th width="30"></th>
	  <?php if (CP_CALENDAR_ID == '' || CP_CALENDAR_ID == '0') { ?>
	  <th style="padding-left:7px;font-weight:bold;">Calendar</th>
	  <?php } ?>
	  <th style="padding-left:7px;font-weight:bold;">Date</th>
	  <th style="padding-left:7px;font-weight:bold;">Title</th>
	  <th style="padding-left:7px;font-weight:bold;">Description</th>
	  <th style="padding-left:7px;font-weight:bold;">Quantity</th>
	  <th style="padding-left:7px;font-weight:bold;">Options</th>
	</tr>
	</thead>
	<tbody id="the-list">
	 <?php for ($i=($current_page-1)*$records_per_page; $i<$current_page*$records_per_page; $i++) if (isset($events[$i])) { ?>
	  <tr class='<?php if (!($i%2)) { ?>alternate <?php } ?>author-self status-draft format-default iedit' valign="top">
	    <td width="1%"><input type="checkbox" name="c<?php echo $i-($current_page-1)*$records_per_page; ?>" value="<?php echo $events[$i]->id; ?>" /></td>
	    <?php if (CP_CALENDAR_ID == '' || CP_CALENDAR_ID == '0') { ?>
	    <td><?php echo $calendars_id["id".$events[$i]->appointment_calendar_id]; ?></td>
	    <?php } ?>
		<td <?php if ($events[$i]->is_cancelled == '1') { ?>style="color:#faabbb;"<?php } ?>><?php echo substr($events[$i]->datatime,0,16); ?></td>
		<td <?php if ($events[$i]->is_cancelled == '1') { ?>style="color:#faabbb;"<?php } ?>><?php echo $events[$i]->title; ?></td>
		<td <?php if ($events[$i]->is_cancelled == '1') { ?>style="color:#faabbb;"<?php } ?>><?php echo $events[$i]->description; ?></td>
		<td <?php if ($events[$i]->is_cancelled == '1') { ?>style="color:#faabbb;"<?php } ?>><?php echo $events[$i]->quantity; ?></td>
		<td <?php if ($events[$i]->is_cancelled == '1') { ?>style="color:#faabbb;"<?php } ?>>
		  <input type="button" name="caledit_<?php echo $events[$i]->id; ?>" value="Edit" onclick="cp_editItem(<?php echo $events[$i]->id; ?>,<?php echo $events[$i]->appointment_calendar_id; ?>);" />
		  <?php if ($events[$i]->is_cancelled == '1') { ?>
		  <input type="button" name="calcancel_<?php echo $events[$i]->id; ?>" value="Un-Cancel" onclick="cp_uncancelItem(<?php echo $events[$i]->id; ?>);" />
		  <?php } else { ?>
		  <input type="button" name="calcancel_<?php echo $events[$i]->id; ?>" value="Cancel" onclick="cp_cancelItem(<?php echo $events[$i]->id; ?>);" />
		  <?php } ?>
		  <input type="button" name="caldelete_<?php echo $events[$i]->id; ?>" value="Delete" onclick="cp_deleteMessageItem(<?php echo $events[$i]->id; ?>);" />
		  <span style="font-style:italic;font-size:11px;">
		  <?php
		    if (isset($users_arr["id".$events[$i]->who_added]))
		        echo '<br />Added by: <strong>'.$users_arr["id".$events[$i]->who_added]->user_login.'</strong>';
		    if (isset($users_arr["id".$events[$i]->who_edited]))
		        echo '<br />Edited by: <strong>'.$users_arr["id".$events[$i]->who_edited]->user_login.'</strong>';
		    if (isset($users_arr["id".$events[$i]->who_cancelled]) && $events[$i]->is_cancelled == '1')
		        echo '<br />Cancelled by: <strong>'.$users_arr["id".$events[$i]->who_cancelled]->user_login.'</strong>';    
		    
		    if ($events[$i]->cancelled_reason != '' && $events[$i]->is_cancelled == '1')
		        echo '<br />Cancelled reason: <strong>'.$events[$i]->cancelled_reason.'</strong>';
		                
		  ?>
		  </SPAN>
		</td>		
      </tr>
     <?php } ?>
	</tbody>
</table>
</form>
</div>

<br /><input type="button" name="pbutton" value="Print" onclick="do_dexapp_print();" />
<div style="clear:both"></div>
<p class="submit" style="float:left;"><input type="button" name="pbutton" value="Delete marked items" onclick="do_dexapp_deletemarked();" /> &nbsp; &nbsp; &nbsp; </p>

<p class="submit" style="float:left;"><input type="button" name="pbutton" value="Delete All Bookings" onclick="do_dexapp_deleteall();" /></p>

</div>


<script type="text/javascript">
 function do_dexapp_print()
 {
      w=window.open();
      w.document.write("<style>table{border:2px solid black;width:100%;}th{border-bottom:2px solid black;text-align:left}td{padding-left:10px;border-bottom:1px solid black;}</style>"+document.getElementById('cpabc_printable_contents').innerHTML);
      w.print();     
 }
 function do_dexapp_deletemarked()
 {
    document.dex_table_form.submit();
 } 
 var $j = jQuery.noConflict();
 $j(function() {
 	$j("#dfrom").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 	$j("#dto").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 });
 
</script>


<?php } else { ?>
  <br />
  The current user logged in doesn't have enough permissions to edit this calendar. This user can edit only his/her own calendars. Please log in as administrator to get access to all calendars.

<?php } ?>








