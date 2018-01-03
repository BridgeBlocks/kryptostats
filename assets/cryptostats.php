<?php

/**
 * When posting a new post or updating, a js file will load and run on the client.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function markets_function($atts) {

  $return_results = '<div id="app"></div>';

  return $return_results;

}

add_shortcode( 'markets', 'markets_function' );

?>
