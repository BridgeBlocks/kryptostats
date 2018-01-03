<?php



function cryptoassets_scripts() {


    wp_enqueue_style( 'main', '/wp-content/plugins/cryptostats/assets/style.css', NULL, '1.0', 'all' );
  	wp_enqueue_script('vendor', '/wp-content/plugins/cryptostats/assets/vendor.js', NULL, '1.0', TRUE);
  	wp_enqueue_script('main', '/wp-content/plugins/cryptostats/assets/main.js', array('vendor'), '1.0', TRUE);

}

add_action( 'wp_enqueue_scripts', 'cryptoassets_scripts' );

function crypto_assets_api_init_function() {

  $baseUrl = trailingslashit(plugin_dir_url( __FILE__ ));
  $init_coins = wp_remote_get( 'https://min-api.cryptocompare.com/data/all/coinlist');

  if( is_wp_error( $init_coins ) ) {
    return false; // Bail early
  }

  $init_body = wp_remote_retrieve_body( $init_coins );
  $init_data = json_decode( $init_body, TRUE );

  if( ! empty( $init_data ) ) {
    wp_localize_script( 'main', 'coins', $init_data );
  }

  wp_localize_script('main', 'baseurl', $baseUrl);

}

add_action( 'wp_enqueue_scripts', 'crypto_assets_api_init_function' );
