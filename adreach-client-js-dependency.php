<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// echo "<script type='text/javascript'>alert('Setting Saved');</script>";
function adreach_script_that_requires_jquery() {
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    wp_register_script( 'script-with-dependency', 'http://www.adreach.io/v1/client-js?id='.urlencode($actual_link), array( 'jquery' ), '1.0.0', false );
    wp_enqueue_script( 'script-with-dependency' );
}
add_action( 'wp_enqueue_scripts', 'adreach_script_that_requires_jquery' );
?>
