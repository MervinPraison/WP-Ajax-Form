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

add_action( 'wp_enqueue_scripts', 'ajax_form_enqueue_scripts' );
function ajax_form_enqueue_scripts() {
	if( is_single() ) {
		wp_enqueue_style( 'formset', plugins_url( '/form.css', __FILE__ ) );
	}

	wp_enqueue_script( 'formset', plugins_url( '/form.js', __FILE__ ), array('jquery'), '1.0', true );

	wp_localize_script( 'formset', 'catform', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
  		'ajax_nonce' => wp_create_nonce('name_of_nonce_field'),
	));

}

add_filter( 'the_content', 'ajax_form_display', 99 );
function ajax_form_display( $content ) {
	$value = '';

	if ( is_single() ) {
		

$prev_cat_id = get_post_meta( get_the_ID(), 'form_cat', true );
$term = get_term($prev_cat_id);

$args = array(
	'show_option_all'    => '',
	'show_option_none'   => '',
	'option_none_value'  => '-1',
	'orderby'            => 'ID',
	'order'              => 'ASC',
	'show_count'         => 0,
	'hide_empty'         => 1,
	'child_of'           => 0,
	'exclude'            => '',
	'include'            => '',
	'echo'               => 0,
	'selected'           => $prev_cat_id,
	'hierarchical'       => 0,
	'name'               => 'cat_name',
	'id'                 => 'cat_name',
	'class'              => 'cat_name',
	'depth'              => 0,
	'tab_index'          => 0,
	'taxonomy'           => 'category',
	'hide_if_empty'      => false,
	'value_field'	     => 'term_id',
);

$value ='
<form class="form" method="post" id="ajax-contact-form" action="/aah/wp-admin/admin-ajax.php">
<input type="hidden" name="action" value="contact_form">
<input type="hidden" name="post_id" id="post_id" value="'.get_the_ID().'">';
$value .= wp_dropdown_categories($args);
//$value .= wp_nonce_field( 'contact_form_nonce_2', 'name_of_nonce_field' );
$value .= '<button type="submit" class="btn">Submit</button></form>';




$value .= '<br /><span id="cat-form-output">'.$term->name.'</span>';

	}

	return $content . $value;

}

add_action('wp_ajax_contact_form', 'contact_form');
add_action('wp_ajax_nopriv_contact_form', 'contact_form');

function contact_form()
{

    if (
    	!wp_verify_nonce( $_REQUEST['security'], 'name_of_nonce_field')
    	) {

        exit('The form is not valid'); 
    }
 
    // ... Processing further


	$cat_name = $_REQUEST['cat_name']; 
	$post_id = $_REQUEST['post_id'];
	$term = get_term($cat_name);

	// $prev_cat_name = get_post_meta( $post_id, 'form_cat', true );

	if($cat_name&&$post_id) {
		update_post_meta( $post_id, 'form_cat', $cat_name );
		wp_set_post_categories( $post_id, $cat_name, false );
	}

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
		echo $term->name. ' <span style="color:LightGreen;" >Updated</span>';
		die();
	}
	else {
		wp_redirect( get_permalink( $_REQUEST['post_id'] ) );
		exit();
	}
}