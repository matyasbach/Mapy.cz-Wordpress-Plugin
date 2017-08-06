<?php
/**
 * Plugin Name: Mapy.cz
 * Plugin URI: https://github.com/matyasbach/Mapy.cz-Wordpress-Plugin
 * Version: 0.1
 * Author: Matyáš Bach
 * Author URI: mailto://matyasbach@centrum.cz
 * Description: A plugin to display mapy.cz map
 * License: Unlicense + mapy.cz API license
 * License URI: https://api.mapy.cz/
 * Text Domain: mapy-cz
 */

namespace MapyCZ;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class MapyCZ {
  
  function __construct() {
    
    $inc_path = plugin_dir_path( __FILE__ ) . '/inc/';
    $admin_path = plugin_dir_path( __FILE__ ) . '/admin/';
    
    $this->inc_list = [
      'admin' => $admin_path . 'admin.php',
      'front' => $inc_path . 'front.php',
      'map_ajax' => $inc_path . 'map_ajax.php',
    ];
    
  }
  
  public function init() {
    
    add_action( 'init', array ( $this, 'register_map_post_type' ) );
    
    /*add_action( 'admin_menu', function() {
      
      include_once $this->inc_list['admin'];
      $this->admin = new Admin();
      $this->admin->register_admin_menu();
      
    } );*/
    
    add_action( 'admin_init', function() {
      
      include_once $this->inc_list['admin'];
      new Admin;
      
    } );
    
    add_shortcode( 'mcz_map', function( $atts ) {
      
      include_once $this->inc_list['front'];
      if( !isset( $this->front ) )
        $this->front = new Front;
      return $this->front->mcz_map_shortcode( $atts );
       
    } );
    
    add_action( 'wp_ajax_mapy-cz-get-map', array ( $this, 'get_maps' ) );
    add_action( 'wp_ajax_nopriv_mapy-cz-get-map', array ( $this, 'get_maps' ) );
    
  }
  
  function get_maps() {
    include_once $this->inc_list['map_ajax'];
    get_maps_ajax();
  }
  
  /**
  * Registers a Custom Post Type: map
  */
  function register_map_post_type() {
    register_post_type( 'mapy-cz-map', array(
      'labels' => array(
        'name'               => _x( 'Mapy.cz Maps', 'post type general name', 'mapy-cz' ),
        'singular_name'      => _x( 'Mapy.cz Map', 'post type singular name', 'mapy-cz' ),
        'menu_name'          => _x( 'Mapy.cz', 'admin menu', 'mapy-cz' ),
        'name_admin_bar'     => _x( 'Mapy.cz Map', 'add new on admin bar', 'mapy-cz' ),
        'add_new'            => _x( 'Add new', 'sub menu', 'mapy-cz' ),
        'add_new_item'       => __( 'Add new map', 'mapy-cz' ),
        'new_item'           => __( 'New Map', 'mapy-cz' ),
        'edit_item'          => __( 'Edit Map', 'mapy-cz' ),
        'view_item'          => __( 'View Map', 'mapy-cz' ),
        'all_items'          => __( 'All Maps', 'mapy-cz' ),
        'search_items'       => __( 'Search Maps', 'mapy-cz' ),
        'parent_item_colon'  => __( 'Parent Maps:', 'mapy-cz' ),
        'not_found'          => __( 'No maps found.', 'mapy-cz' ),
        'not_found_in_trash' => __( 'No maps found in Trash.', 'mapy-cz' ),
      ),
       
      // Frontend
      'has_archive'        => false,
      'public'             => false,
      'publicly_queryable' => false,
       
      // Admin
      'capability_type' => 'post',
      'show_ui'         => true,
      'menu_position'   => 100,
      'menu_icon'       => plugins_url( 'admin/img/mapy-cz.png', __FILE__ ),
      'supports'        => array(
        'title',
        'author',
        'custom_fields',
        'revisions'
      ),
    ) );    
  }
  
}

$mapyCZ = new MapyCZ();
$mapyCZ->init();

?>