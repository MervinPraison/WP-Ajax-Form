<?php
/**
 * Plugin Name: Ajax Categories
 * Plugin URI: https://mer.vin
 * Description: Allow users to change the category
 * Version: 1.0.0
 * Author: Mervin Praison
 * Author URI: https://mer.vin
 * License: GPL2
 */

add_action( 'wp_enqueue_scripts', 'ajax_category_enqueue_scripts' );
function ajax_category_enqueue_scripts() {
	if( is_single() ) {
		wp_enqueue_style( 'cat', plugins_url( '/cat.css', __FILE__ ) );
	}

	wp_enqueue_script( 'cat', plugins_url( '/cat.js', __FILE__ ), array('jquery'), '1.0', true );

	wp_localize_script( 'cat', 'categoryname', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));

}

add_filter( 'the_content', 'ajax_category_display', 99 );
function ajax_category_display( $content ) {
	$love_text = '';

	if ( is_single() ) {
		
		$love = get_post_meta( get_the_ID(), 'post_cat', true );
		$love = ( empty( $love ) ) ? 0 : $love;
		$category_name = 'cat';
		$love_text = '<p class="cat-received"><a class="cat-button" href="' . admin_url( 'admin-ajax.php?action=ajax_category_add_category&post_id=' . get_the_ID() ) . '&category_name='. $category_name .'" data-id="' . get_the_ID() .'" data-category="' . $category_name . '">Add Category</a><span id="cat-count">' . $love . '</span></p>'; 
	
	}

	return $content . $love_text;

}

add_action( 'wp_ajax_nopriv_ajax_category_add_category', 'ajax_category_add_category' );
add_action( 'wp_ajax_ajax_category_add_category', 'ajax_category_add_category' );

function ajax_category_add_category() {
	$love = get_post_meta( $_REQUEST['post_id'], 'post_cat', true );
	//$love = $_REQUEST['category_name'];
	$love = $love+2;
	update_post_meta( $_REQUEST['post_id'], 'post_cat', $love );
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
		echo $love;
		die();
	}
	else {
		wp_redirect( get_permalink( $_REQUEST['post_id'] ) );
		exit();
	}
}