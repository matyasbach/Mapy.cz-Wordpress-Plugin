<?php

namespace MapyCZ;

defined ( 'ABSPATH' ) or die ( 'No script kiddies please!' );

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
		include_once ( $this->worker_list[ $action ]['file'] );
		$class_name = 'MapyCZ\\' . $this->worker_list[ $action ]['class'];
		new $class_name ( $action );
	}
}