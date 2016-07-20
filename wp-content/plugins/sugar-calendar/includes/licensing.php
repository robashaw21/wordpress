<?php

function sc_license_menu() {
  add_submenu_page( 'edit.php?post_type=sc_event', __( 'Plugin License', 'pippin_sc' ), __( 'Plugin License', 'pippin_sc' ), 'manage_options', 'sc-license', 'sc_license_page' );
}
add_action('admin_menu', 'sc_license_menu');

function sc_license_page() {
  $license  = get_option( 'sc_license_key' );
  $status   = get_option( 'sc_license_status' );
  ?>
  <div class="wrap">
    <h2><?php _e( 'Sugar Event Calendar License Key', 'pippin_sc' ); ?></h2>
    <form method="post" action="options.php">
      <p><?php _e( 'Please enter and activate your license key in order to get automatic updates and support', 'pippin_sc' ); ?></p>
      <?php settings_fields( 'sc_license' ); ?>

      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row" valign="top">
              <?php _e( 'License Key' ); ?>
            </th>
            <td>
              <input id="sc_license_key" name="sc_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
              <label class="description" for="sc_license_key"><?php _e( 'Enter your license key', 'pippin_sc' ); ?></label>
            </td>
          </tr>
          <?php if ( false !== $license ) { ?>
            <tr valign="top">
              <th scope="row" valign="top">
                <?php _e( 'Activate License' ); ?>
              </th>
              <td>
                <?php if ( $status !== false && $status == 'valid' ) { ?>
                  <span style="color:green;"><?php _e( 'active' ); ?></span>
                  <?php wp_nonce_field( 'sc_nonce', 'sc_nonce' ); ?>
                  <input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e( 'Deactivate License', 'pippin_sc' ); ?>"/>
                <?php } else { ?>
                  <?php wp_nonce_field( 'sc_nonce', 'sc_nonce' ); ?>
                  <input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e( 'Activate License', 'pippin_sc' ); ?>"/>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php submit_button(); ?>

    </form>
  <?php
}

function sc_register_option() {
  // creates our settings in the options table
  register_setting( 'sc_license', 'sc_license_key', 'edd_sanitize_license' );
}
add_action( 'admin_init', 'sc_register_option' );

function edd_sanitize_license( $new ) {
  $old = get_option( 'sc_license_key' );
  if ( $old && $old != $new ) {
    delete_option( 'sc_license_status' ); // new license has been entered, so must reactivate
  }
  return $new;
}



/************************************
* this illustrates how to activate
* a license key
*************************************/

function sc_activate_license() {

  // listen for our activate button to be clicked
  if ( isset( $_POST['edd_license_activate'] ) ) {

    // run a quick security check
    if ( ! check_admin_referer( 'sc_nonce', 'sc_nonce' ) )
      return; // get out if we didn't click the Activate button

    // retrieve the license from the database
    $license = trim( get_option( 'sc_license_key' ) );


    // data to send in our API request
    $api_params = array(
      'edd_action'=> 'activate_license',
      'license'   => $license,
      'item_name' => urlencode( SEC_PLUGIN_NAME ) // the name of our product in EDD
    );

    // Call the custom API.
    $response = wp_remote_post( add_query_arg( $api_params, 'http://pippinsplugins.com' ), array( 'timeout' => 15, 'sslverify' => false ) );

    // make sure the response came back okay
    if ( is_wp_error( $response ) )
     return false;

    // decode the license data
    $license_data = json_decode( wp_remote_retrieve_body( $response ) );

    //print_r( $license_data ); exit;

    update_option( 'sc_license_status', $license_data->license );

  }
}
add_action( 'admin_init', 'sc_activate_license' );


function sc_deactivate_license() {

  // listen for our activate button to be clicked
  if ( isset( $_POST['edd_license_deactivate'] ) ) {

    // run a quick security check
    if ( ! check_admin_referer( 'sc_nonce', 'sc_nonce' ) )
      return; // get out if we didn't click the Activate button

    // retrieve the license from the database
    $license = trim( get_option( 'sc_license_key' ) );


    // data to send in our API request
    $api_params = array(
      'edd_action'=> 'deactivate_license',
      'license'   => $license,
      'item_name' => urlencode( SEC_PLUGIN_NAME ) // the name of our product in EDD
    );

    // Call the custom API.
    $response = wp_remote_post( add_query_arg( $api_params, 'http://pippinsplugins.com' ), array( 'timeout' => 15, 'sslverify' => false ) );

    // make sure the response came back okay
    if ( is_wp_error( $response ) )
      return false;

    // decode the license data
    $license_data = json_decode( wp_remote_retrieve_body( $response ) );
    // $license_data->license will be either "deactivated" or "failed"
   if ( $license_data->license == 'deactivated' )
      delete_option( 'sc_license_status' );

  }
}
add_action( 'admin_init', 'sc_deactivate_license' );