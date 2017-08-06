<?php

namespace MapyCZ;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Admin {
  
  function __construct() {
    
    $this->worker_list = array (
    
      // action => worker [ file, class ]
      'save_post_mapy-cz-map' => array ( 'file' => 'edit-map.php', 'class' => 'EditMapScreen' ),
      'add_meta_boxes' => array ( 'file' => 'edit-map.php', 'class' => 'EditMapScreen' ),
      
    );
    
    $loader = array ( $this, 'load' );
    
    add_action( 'save_post_mapy-cz-map', $loader );
    add_action( 'add_meta_boxes', $loader );
    
  }
  
  function load() {
    
    $action = current_filter();
    
    include_once($this->worker_list[$action]['file']);
    
    $class_name = 'MapyCZ\\' . $this->worker_list[$action]['class'];
    
    new $class_name($action);

  }
  
  /**
  * Creates admin menu
  */
  /*function register_admin_menu() {
    
    $this->title = 'Mapy.cz';
    $this->main_menu_slug = 'mapy-cz';
    $capability = 'edit_others_posts';
    
    $this->admin_page_list = [
      'toplevel_page_' . $this->main_menu_slug => [
          'title' => 'All maps',
          'slug' => $this->main_menu_slug,
          'render' => 'view-all-maps.php',
      ],
      'mapy-cz_page_' . $this->main_menu_slug . '-add' => [
          'title' => 'Add new map',
          'slug' => $this->main_menu_slug . '-add',
          'render' => 'add-new-map.php',
      ],
    ];
    
    // main menu
    add_menu_page( $this->title, $this->title,
                   $capability,
                   $this->main_menu_slug,
                   [ $this, 'admin_page' ], // callback
                   plugins_url( 'img/mapy-cz.png', __FILE__ ) // menu icon
    );
    
    // generate submenus
    foreach($this->admin_page_list as $subpage) {
      
      add_submenu_page (
        $this->main_menu_slug,                    // parent menu
        $subpage['title'] . ' ‹ ' . $this->title, // page <title>
        $subpage['title'],                        // title in menu
        $capability,                              // who can see it
        $subpage['slug'],                         // this menu item slug
        [ $this, 'admin_page' ]                   // callback
      );
      
    }
    
  }
  
  function admin_page() {
    
    $id = get_current_screen()->id;
    
    // header (tabs) ?>
<div class="wrap">
  <h2 class="nav-tab-wrapper"><?php
    echo $this->title; ?> &nbsp;<?php
    
    foreach($this->admin_page_list as $page_id => $subpage) {
      ?><a href="<?php menu_page_url($subpage['slug']) ?>" class="nav-tab<?php
      
      if ($page_id == $id)
        echo ' nav-tab-active';
      
      ?>"><?php echo $subpage['title']; ?></a><?php
      
    }
    
    ?>
  </h2><?php // <- end of header
    
    // content
    require_once plugin_dir_path( __FILE__ ) . $this->admin_page_list[$id]['render'];
    
    // footer ?>
</div> <?php

  }*/
}

?>