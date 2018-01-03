<?php

/**
 * When posting a new post or updating, a js file will load and run on the client.
 */

//if ( ! defined( 'ABSPATH' ) ) exit;

if(!defined(ABSPATH)){
		$pagePath = explode('/wp-content/', dirname(__FILE__));
		include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
	}

$post_data = json_decode(file_get_contents('php://input'));
$data = $post_data->body;
$coin_id = $data;

$request = wp_remote_get( 'https://www.cryptocompare.com/api/data/coinsnapshotfullbyid/?id=' . $coin_id );

if( is_wp_error( $request ) ) {
  return false; // Bail early
}

$body = wp_remote_retrieve_body( $request );

$response = json_decode( $body );
$return_results = '';

if( ! empty( $response ) ) {

  $return_results .= '<ul class="cryptostats__exchanges-list">';
  $return_results .= '<li class="cryptostats__exchanges-list-item cryptostats__exchanges-list-item--header"><b>Exchange - Coinpair</b>';

  foreach( $response->Data->Subs as $coin_results) {
    $re = '/\b([A-Za-z]+)\b.\b([A-Za-z1-9]+)\b.\b([A-Za-z1-9]+)\b/';
    $str = $coin_results;

    preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

    $return_results .= '<li class="cryptostats__exchanges-list-item">' . $matches[0][1] . ' ' . $matches[0][2] .  ' ' . $matches[0][3] . '</li>';
  }

  $return_results .= '</ul>';
}

$final_response = array(
	"coinMarkets" => $return_results,
);

echo json_encode($final_response);

?>
