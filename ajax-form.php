<?php
/**
 * Plugin Name: Ajax Form
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
		wp_enqueue_style( 'cat', plugins_url( '/form.css', __FILE__ ) );
	}

	wp_enqueue_script( 'cat', plugins_url( '/form.js', __FILE__ ), array('jquery'), '1.0', true );

	wp_localize_script( 'cat', 'categoryname', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));

}

add_filter( 'the_content', 'ajax_category_display', 99 );
function ajax_category_display( $content ) {
	$love_text = '';

	if ( is_single() ) {
		
?>

<form class="form" id="ajax-contact-form" action="#">                            
        <input type="text" name="name" id="name"  placeholder="Name" required="">
        <button type="submit" class="btn">Submit</button>
</form>

<?php


		$love = get_post_meta( get_the_ID(), 'post_cat', true );
		$love = ( empty( $love ) ) ? 0 : $love;
		$category_name = 'cat';
		$love_text = '<p class="cat-received"><a class="cat-button" href="' . admin_url( 'admin-ajax.php?action=ajax_category_add_category&post_id=' . get_the_ID() ) . '&category_name='. $category_name .'" data-id="' . get_the_ID() .'" data-category="' . $category_name . '">Add Category</a><span id="cat-count">' . $love . '</span></p>'; 
	
	}

	return $content . $love_text;

}

add_action('wp_ajax_contact_form', 'contact_form');
add_action('wp_ajax_nopriv_contact_form', 'contact_form');

function contact_form()
{
echo $_POST['name'];    
}