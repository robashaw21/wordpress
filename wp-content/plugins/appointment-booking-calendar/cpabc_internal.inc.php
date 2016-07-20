<?php if ( !defined('CPABC_AUTH_INCLUDE') ) { echo 'Direct access not allowed.'; exit; } ?>
<link href="<?php echo plugins_url('css/stylepublic.css', __FILE__); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo plugins_url('css/cupertino/jquery-ui-1.8.20.custom.css', __FILE__); ?>" type="text/css" rel="stylesheet" />
<form class="cpp_form" id="cp_contactformpp_pform" name="FormEdit" action="<?php get_site_url(); ?>" method="post" onsubmit="return doValidate(this);" enctype="multipart/form-data"><input name="cpabc_appointments_post" type="hidden" id="1" /><input type="hidden" name="form_structure_hidden" id="form_structure_hidden"  value="" />
<?php echo $quant_buffer; ?>
<div <?php if (count($myrows) < 2) echo 'style="display:none"'; ?>>
  <?php _e("Calendar",'cpabc').":"; ?><br />
  <select name="cpabc_item" id="cpabc_item" onchange="cpabc_updateItem()"><?php echo $calendar_items; ?></select><br /><br />
</div>
<?php
  _e("Select date and time",'cpabc').":";
  foreach ($myrows as $item)
  {
      echo '<div id="calarea_'.$item->id.'" style="display:none"><input name="tzonelistcal'.$item->id.'" type="hidden" id="tzonelistcal'.$item->id.'" /><input name="selDaycal'.$item->id.'" type="hidden" id="selDaycal'.$item->id.'" /><input name="selMonthcal'.$item->id.'" type="hidden" id="selMonthcal'.$item->id.'" /><input name="selYearcal'.$item->id.'" type="hidden" id="selYearcal'.$item->id.'" /><input name="selHourcal'.$item->id.'" type="hidden" id="selHourcal'.$item->id.'" /><input name="selMinutecal'.$item->id.'" type="hidden" id="selMinutecal'.$item->id.'" /><div class="appContainer"><div style="z-index:1000;" class="appContainer2"><div id="cal'.$item->id.'Container"></div></div></div> <div style="clear:both;"></div><div id="listcal'.$item->id.'"></div></div>';
?><input name="cclanguage<?php echo $item->id; ?>" type="hidden" id="cclanguage<?php echo $item->id; ?>" value="<?php echo $item->calendar_language; ?>" /><input name="ccpages<?php echo $item->id; ?>" type="hidden" id="ccpages<?php echo $item->id; ?>" value="<?php echo $item->calendar_pages; ?>" /><input name="ccpabc_global_date_format<?php echo $item->id; ?>" type="hidden" id="ccpabc_global_date_format<?php echo $item->id; ?>" value="<?php echo $item->calendar_dateformat; ?>" /><input name="ccpabc_global_military_time<?php echo $item->id; ?>" type="hidden" id="ccpabc_global_military_time<?php echo $item->id; ?>" value="<?php echo $item->calendar_militarytime; ?>" /><input name="ccpabc_global_start_weekday<?php echo $item->id; ?>" type="hidden" id="ccpabc_global_start_weekday<?php echo $item->id; ?>" value="<?php echo $item->calendar_weekday; ?>" /><input name="cmintime<?php echo $item->id; ?>" type="hidden" id="cmintime<?php echo $item->id; ?>" value="<?php if ($item->calendar_mindate != '') echo date("n/j/Y", strtotime($item->calendar_mindate));?>" /><input name="cmaxtime<?php echo $item->id; ?>" type="hidden" id="cmaxtime<?php echo $item->id; ?>" value="<?php if ($item->calendar_maxdate != '') echo date("n/j/Y", strtotime($item->calendar_maxdate));?>" />            <input name="ccpabc_global_gmt_enabled<?php echo $item->id; ?>" type="hidden" id="ccpabc_global_gmt_enabled<?php echo $item->id; ?>" value="<?php if ($item->gmt_enabled == 'yes' && CPABC_APPOINTMENTS_TZONE) echo 'true'; else echo 'false'; ?>" /><input name="ccpabc_global_gmt<?php echo $item->id; ?>" type="hidden" id="ccpabc_global_gmt<?php echo $item->id; ?>" value="<?php if ($item->gmt_diff != '') echo intval($value); else echo '0'; ?>" /><input name="ccpabc_global_close_on_select<?php echo $item->id; ?>" type="hidden" id="ccpabc_global_close_on_select<?php echo $item->id; ?>" value="<?php if ($item->close_fpanel == '' || $item->close_fpanel == 'yes') echo 'true'; else echo 'false'; ?>" /><input name="ccpabc_global_pagedate<?php echo $item->id; ?>" type="hidden" id="ccpabc_global_pagedate<?php echo $item->id; ?>" value="<?php
                                                                                                                                                  $sm = $item->calendar_startmonth;
                                                                                                                                                  $sy = $item->calendar_startyear;
                                                                                                                                                  if ($sm=='0' || $sm=='') $sm = date("n");
                                                                                                                                                  if ($sy=='0' || $sy=='') $sy = date("Y");
                                                                                                                                                  echo $sm."/".$sy;
                                                                                                                                              ?>" /><?php
  }    
?>
<script type="text/javascript">
 cpabc_do_init(<?php echo $myrows[0]->id; ?>);
 setInterval('updatedate()',200);
 function doValidate(form)
 {
    $dexQuery = jQuery.noConflict();
    var selst = ""+$dexQuery("#selDaycal"+cpabc_current_calendar_item).val();
    if (selst == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please select date and time','cpabc')); ?>.');
        return false;
    }
    selst = selst.match(/;/g);selst = selst.length;
    if (selst < <?php $opt = cpabc_get_option('min_slots', '1'); if ($opt == '') $opt = '1'; echo $opt; ?>)
    {
        var almsg = '<?php echo str_replace("'","\'",__('Please select at least %1 time-slots. Currently selected: %2 time-slots.','cpabc')); ?>';
        almsg = almsg.replace('%1','<?php echo $opt; ?>');
        almsg = almsg.replace('%2',selst);
        alert(almsg);
        return false;
    }
    if (selst > <?php $opt = cpabc_get_option('max_slots', '1'); if ($opt == '') $opt = '1'; echo $opt; ?>)
    {
        var almsg = '<?php echo str_replace("'","\'",__('Please select a maximum of %1 time-slots. Currently selected: %2 time-slots.','cpabc')); ?>';
        almsg = almsg.replace('%1','<?php echo $opt; ?>');
        almsg = almsg.replace('%2',selst);
        alert(almsg);
        return false;
    }    
    <?php if (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?> if ($dexQuery("#hdcaptcha").val() == '')
    {
        alert('<?php echo str_replace("'","\'",cpabc_get_option('cv_text_enter_valid_captcha', CPABC_TDEAPP_DEFAULT_dexcv_text_enter_valid_captcha)); ?>');
        return false;
    }
    var result = $dexQuery.ajax({
        type: "GET",
        url: "<?php echo cpabc_appointment_get_site_url(); ?>?inAdmin=1"+String.fromCharCode(38)+"abcc=1"+String.fromCharCode(38)+"hdcaptcha="+$dexQuery("#hdcaptcha").val(),
        async: false,
    }).responseText;
    if (result.indexOf("captchafailed") != -1)
    {
        $dexQuery("#captchaimg").attr('src', $dexQuery("#captchaimg").attr('src')+String.fromCharCode(38)+Date());
        alert('<?php echo str_replace("'","\'",cpabc_get_option('cv_text_enter_valid_captcha', CPABC_TDEAPP_DEFAULT_dexcv_text_enter_valid_captcha)); ?>');
        return false;
    }
    else <?php } ?>
    { 
        <?php if (CPABC_APPOINTMENTS_ADV_DUPLICITY_VERIFICATION) { ?>var result = $dexQuery.ajax({
           type: "GET",
           url: "<?php echo cpabc_appointment_get_site_url(); ?>?cal="+cpabc_current_calendar_item+String.fromCharCode(38)+"abc_verifydate="+$dexQuery("#selDaycal"+cpabc_current_calendar_item).val(),
           async: false
        }).responseText;
        if (result == "failed")
        {
            alert('<?php _e("Time-slot already reserved. Please select a different time.",'cpabc'); ?>');
            return false;
        } <?php } /** end CPABC_APPOINTMENTS_ADV_DUPLICITY_VERIFICATION */ ?>
        <?php if (cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '3') { ?>
            if (!cpabc_stripe_handler_paid && $dexQuery("input[name='bccf_payment_option_paypal']:checked").val() == '0')
            {
                if (abc_cost == '') return false;
                cpabc_stripe_handler.open({
                          name: '<?php echo str_replace("'","\'",cpabc_get_option('paypal_product_name', CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME)); ?>',
                          description: '',
                          amount: abc_cost*100
                        });
                return false;        
            } else            
        <?php } else if (CPABC_APPOINTMENTS_ENABLE_PG_AUTHORIZE && cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '4') { ?> 
             if (abc_cost == '') return false;
             var emfield = '#<?php echo cpabc_get_option('cu_user_email_field', CPABC_APPOINTMENTS_DEFAULT_cu_user_email_field); ?>';
             if ($dexQuery(emfield).val() == '') return false;
             if (document.getElementById("cp_authorizeanswer").value == 'OK') return true;             
             $dexQuery.ajax({
                 type: 'POST',
                 async: false,
                 url: '<?php echo cpabc_appointment_get_site_url(); ?>/?inAdmin=1'+String.fromCharCode(38)+'abcc_authorize=2',                 
                 data: { cost:  abc_cost, 
                            cpabc_item: cpabc_current_calendar_item,
                            cc : $dexQuery("#cfpp_customer_credit_card_number").val(),
                            em : $dexQuery("#cfpp_cc_expiration_month").val(),
                            ey : $dexQuery("#cfpp_cc_expiration_year").val(),
                            e : $dexQuery(emfield).val(),
                            d: '<?php echo str_replace("'","\'",cpabc_get_option('paypal_product_name', CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME)); ?>'+$dexQuery("#selDaycal"+cpabc_current_calendar_item).val()
                          },    
                 success: function(datareturn)
                 {             
                    if (datareturn == 'OK')
                        document.getElementById("cp_authorizeanswer").value = 'OK';
                    else {
                        alert(datareturn);
                        document.getElementById("cp_authorizeanswer").value = 'NO';                        
                    }    
                 }
             });
            if (document.getElementById("cp_authorizeanswer").value != 'OK')  
                return false; 
            else 
        <?php } ?>return true;
    }    
 }
</script><div id="abccost"></div>
<input type="hidden" name="form_structure" id="form_structure" size="180" value="<?php echo str_replace('"','&quot;',str_replace("\r","",str_replace("\n","",esc_attr(cpabc_appointment_cleanJSON(cpabc_get_option('form_structure', DEX_BCCF_DEFAULT_form_structure)))))); ?>" />
  <div id="fbuilder">
      <div id="formheader"></div>
      <div id="fieldlist"></div>
  </div>
<div id="cpcaptchalayer">  
<?php      
 if (count($codes))
 {
     _e('Coupon code (optional)','cpabc'); 
     echo ':<br /><input type="text" name="couponcode" value=""><br />';
 } 
 if ($cpabc_buffer != '') 
 {
    _e('Service','cpabc');
    echo ':<br /><select name="services" onchange="force_updatedate();">'.$cpabc_buffer.'</select><br /><br />';
 }   
?>
<?php if (cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '2' || cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '3') { ?>
      <div class="fields" id="field-c0">
         <label><?php echo $l_payment_options; ?></label>
         <div class="dfield">
           <input type="radio" name="bccf_payment_option_paypal" value="1" checked> <?php echo __(cpabc_get_option('enable_paypal_option_yes',CPABC_APPOINTMENTS_DEFAULT_PAYPAL_OPTION_YES),'cpabc'); ?><br />
           <input type="radio" name="bccf_payment_option_paypal" value="0"> <?php echo  __(cpabc_get_option('enable_paypal_option_no',CPABC_APPOINTMENTS_DEFAULT_PAYPAL_OPTION_NO),'cpabc'); ?>
         </div>
         <div class="clearer"></div>
      </div>
      <?php if (cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '3') { ?>
      <script src="https://checkout.stripe.com/checkout.js"></script>            
      <script>
         var cpabc_stripe_handler_paid = false;
         var cpabc_stripe_handler = StripeCheckout.configure({
           key: '<?php echo cpabc_get_option('stripe_key',''); ?>',
           image: '',
           token: function(token, args) {
             /** Use the token to create the charge with a server-side script. */
             document.getElementById("stptok").value = token.id;
             cpabc_stripe_handler_paid = true;
             $dexQuery = jQuery.noConflict();             
             $dexQuery( ".pbSubmit" ).trigger( "click" );
           }
         });
      </script>
      <input type="hidden" name="stptok" id="stptok" value="" />
      <?php } ?>  
<?php } ?>  
<?php if (CPABC_APPOINTMENTS_ENABLE_PG_AUTHORIZE && cpabc_get_option('enable_paypal',CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL) == '4') { ?>
     <input type="hidden" name="cp_authorizeanswer" id="cp_authorizeanswer" value="" />
     <div class="fields" id="field-c5">
         <label><?php _e("Credit Card Number",'cpabc'); ?>:</label>
         <div class="dfield">
           <input type="text" name="cfpp_customer_credit_card_number" id="cfpp_customer_credit_card_number" value="" /> 
         </div>
         <div class="clearer"></div>
      </div>
     <div class="fields" id="field-c6">
         <label><?php _e("Expiration Date",'cpabc'); ?>:</label>
         <div class="dfield">
          <select name="cfpp_cc_expiration_month" id="cfpp_cc_expiration_month">                              
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
         </select> /
         <select name="cfpp_cc_expiration_year" id="cfpp_cc_expiration_year">   
         <?php $d= intval(date("Y")); for($i=$d;$i<$d+10;$i++) echo '<option value="'.$i.'">'.$i.'</option>'; ?>
         </select>
         </div>
         <div class="clearer"></div>
      </div>       
<?php } ?>  
<?php if (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?>
  <?php _e('Please enter the security code:','cpabc'); ?><br />
  <img src="<?php echo cpabc_appointment_get_site_url().'/?cpabc_app=captcha&inAdmin=1&width='.cpabc_get_option('dexcv_width', CPABC_TDEAPP_DEFAULT_dexcv_width).'&height='.cpabc_get_option('dexcv_height', CPABC_TDEAPP_DEFAULT_dexcv_height).'&letter_count='.cpabc_get_option('dexcv_chars', CPABC_TDEAPP_DEFAULT_dexcv_chars).'&min_size='.cpabc_get_option('dexcv_min_font_size', CPABC_TDEAPP_DEFAULT_dexcv_min_font_size).'&max_size='.cpabc_get_option('dexcv_max_font_size', CPABC_TDEAPP_DEFAULT_dexcv_max_font_size).'&noise='.cpabc_get_option('dexcv_noise', CPABC_TDEAPP_DEFAULT_dexcv_noise).'&noiselength='.cpabc_get_option('dexcv_noise_length', CPABC_TDEAPP_DEFAULT_dexcv_noise_length).'&bcolor='.cpabc_get_option('dexcv_background', CPABC_TDEAPP_DEFAULT_dexcv_background).'&border='.cpabc_get_option('dexcv_border', CPABC_TDEAPP_DEFAULT_dexcv_border).'&font='.cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font); ?>"  id="captchaimg" alt="security code" border="0"  />
  <br />
  <?php _e('Security Code (lowercase letters):','cpabc'); ?><br />
  <div class="dfield">
  <input type="text" size="20" name="hdcaptcha" id="hdcaptcha" value="" />
  <div class="error message" id="hdcaptcha_error" generated="true" style="display:none;position: absolute; left: 0px; top: 25px;"></div>
  </div>
  <br />
<?php } ?>
</div>
<div id="cp_subbtn" class="cp_subbtn"><?php _e($button_label,'cpabc'); ?></div>
</form>


