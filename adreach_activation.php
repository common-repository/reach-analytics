<?php 
/*
Plugin Name: Reach Analytics
Plugin URI: 
Description: This plugin is for 1 click sign up with http://www.adreach.io. Please check your admin account email to access your dashboard.
Version: 1.0
Author: Govind Soni
Author URI: http://www.adreach.io
*/
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function adreach_plugin_activation()
{
  
  global $wpdb;
  $q = "SELECT user_email FROM {$wpdb->prefix}users WHERE ID=1";
  $admin_email = $wpdb->get_var($q);
  $email = sanitize_email($admin_email);
  $domain = esc_url(get_site_url());
    // $name = $_POST['name'];
    // $phone = $_POST['phone'];

    $service_url = "http://www.adreach.io/v1/users";
    $curl = curl_init($service_url);
    $curl_post_data = array(
          'email' => $email,
          'user_domains' => array (
               array ('domain' => $domain)
            )
    );
    curl_setopt_array($curl, array(
      CURLOPT_POST => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
      ),
      CURLOPT_POSTFIELDS => json_encode($curl_post_data)
    ));

    $curl_response = curl_exec($curl);
    // echo $curl_response;
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
        curl_close($curl);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response, true);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }
    $result_data = array(
      'email' => $decoded['email'],
      'user_domains' => $decoded['user_domains']
    );
    if($result)
    {
    }
}
register_activation_hook(__FILE__,'adreach_plugin_activation');

function adreach_client_js_dependency()
{
  include('adreach-client-js-dependency.php');
}

! is_admin() and add_action( 'init', 'adreach_client_js_dependency' );
