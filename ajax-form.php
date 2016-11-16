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
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));

}

add_filter( 'the_content', 'ajax_form_display', 99 );
function ajax_form_display( $content ) {
	$value = '';

	if ( is_single() ) {
		


$value =<<<EOT
<form class="form" method="post" id="ajax-contact-form" action="/aah/wp-admin/admin-ajax.php?action=contact_form">
<input type="text" name="name" id="name"  placeholder="Name" required="">
<button type="submit" class="btn">Submit</button></form>
EOT;

$value .= '<br /><span id="form-output">Output</span>';

	}

	return $content . $value;

}

add_action('wp_ajax_contact_form', 'contact_form');
add_action('wp_ajax_nopriv_contact_form', 'contact_form');

function contact_form()
{
echo $_REQUEST['name'];   
die(); 
}