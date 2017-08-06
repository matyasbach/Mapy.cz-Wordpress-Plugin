<?php

namespace MapyCZ;

defined ( 'ABSPATH' ) or die ( 'No script kiddies please!' );

class EditMapScreen {

	function __construct( $caller ) {
		$this->post_id = get_the_ID();

		if ( $caller == 'add_meta_boxes' ) {
			$this->register_meta_boxes();
		}
		elseif ( $caller == 'save_post_mapy-cz-map' ) {
			$this->save_meta_boxes();
		}
	}
  
	function register_meta_boxes() {
		add_meta_box(
			'mcz-map-mbox-general',               // id
			__('Map options', 'mapy-cz'),         // title
			[ $this, 'render_mbox_general' ],     // callback
			'mapy-cz-map',                        // screen
			'normal',
			'high'
		);
	}
  
	function render_mbox_general() {
		$id        = get_post_meta ( $this->post_id, '_mapy-cz-map_id',  true );
		$latitude  = get_post_meta ( $this->post_id, '_mapy-cz-map_lat', true );
		$longitude = get_post_meta ( $this->post_id, '_mapy-cz-map_lon', true );
		?>
<label for="mcz-id"><?php _e('Map ID', 'mapy-cz'); ?></label>
<input type="text" name="map-id" id="mcz-id" value="<?php echo esc_attr( $id ); ?>" />
<label for="mcz-lat"><?php _e('Latitude', 'mapy-cz'); ?></label>
<input type="text" name="latitude" id="mcz-lat" value="<?php echo esc_attr( $latitude ); ?>" />
<label for="mcz-lon"><?php _e('Longitude', 'mapy-cz'); ?></label>
<input type="text" name="longitude" id="mcz-lon" value="<?php echo esc_attr( $longitude ); ?>" />
		<?php
	}
  
	/**
	 * Saves the meta boxes field data
	 *
	 * @param int $post_id Post ID
	 */
	function save_meta_boxes() {
		// Check the logged in user has permission to edit this post
		if ( ! current_user_can ( 'edit_post', $this->post_id ) ) {
			return $this->$post_id;
		}

		// OK to save meta data
		if ( isset ( $_POST['map-id'] ) ) {
			$id = sanitize_text_field ( $_POST['map-id'] );
			update_post_meta ( $this->post_id, '_mapy-cz-map_id', $id );
		}
		if ( isset ( $_POST['latitude'] ) ) {
			$latitude = sanitize_text_field ( $_POST['latitude'] );
			update_post_meta ( $this->post_id, '_mapy-cz-map_lat', $latitude );
		}
		if ( isset( $_POST['longitude'] ) ) {
			$longitude = sanitize_text_field( $_POST['longitude'] );
			update_post_meta( $this->post_id, '_mapy-cz-map_lon', $longitude );
		}
	}
}