<?php

namespace MapyCZ;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function get_maps_ajax() {

  	if ( isset( $_POST["maps"] ) ) {
      
      foreach($_POST["maps"] as $map_id => $map_post_id) {
        //$response[$map_id]['id'] = get_post_meta($map_post_id, '_mapy-cz-map_id', true);
        $response[$map_id]['lat'] = get_post_meta($map_post_id, '_mapy-cz-map_lat', true);
        $response[$map_id]['lon'] = get_post_meta($map_post_id, '_mapy-cz-map_lon', true);
      }
      
      // send the response back to the front end
      echo json_encode($response);
      die();
    }
}

?>