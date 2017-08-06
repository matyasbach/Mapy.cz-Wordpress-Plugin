<?php

namespace MapyCZ;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Front {
  const APIURL = 'https://api4.mapy.cz/loader.js';
  
  /**
  * [mcz_map id=<ID>]
  */
  function mcz_map_shortcode( $atts ) {
    
    // Attributes
    extract( shortcode_atts(
      array(
        'id' => null,
        'class' => '',
      ), $atts )
    );
    
    if(is_null($id))
      return '<!-- map id unspecified -->';
    
    //
    // TODO sanitize $id
    //
    $args = array ( 'post_type'  => 'mapy-cz-map',
                    'meta_value' => $id,
                  );
    $posts = get_posts($args);
    
    if( isset( $posts[0] ) ) {
      
      if( $class != '' )
        $class .= ' ';
      
      $class .= 'mcz_map mcz_map_' . $id;
      
      if(isset($this->map_id_count[$id])) {
        $this->map_id_count[$id]++;
        $id .= '_' . (string)$this->map_id_count[$id];
      }
      else
        $this->map_id_count[$id] = 1;
      
      $id = 'mcz_map_' . $id;
      $this->maps_to_load[$id] = $posts[0]->ID;
      
      if( ! isset( $this->loaded ) )
        $this->load();
      
      return '<div id="' . $id . '" class="' . $class . '" tabindex="-1"></div>';
      
    }
    else
      return '<!-- cannot find map with id: ' . $id . ' -->';
    
  }
  
  function load() {
    
    wp_enqueue_style( 'mcz-style', plugins_url( '../css/mapy-cz.css', __FILE__ ) );
    wp_enqueue_script( 'mapy-cz-loader', self::APIURL, null, null, true);
    wp_enqueue_script( 'mcz-script', plugins_url( '../js/mapy-cz.js', __FILE__ ) , array( 'jquery','mapy-cz-loader' ), null, true);
    wp_localize_script( 'mcz-script',
                        'mcz_map_ajax',
                        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
                      );
    
    add_action('wp_footer', function() {
      wp_localize_script( 'mcz-script', 'mcz_load_maps', $this->maps_to_load );
    });
    
    $this->loaded = true;
    
  }
}

?>