jQuery(document).ready(function($) {

jQuery('#ajax-contact-form').submit(function(e){
    var cat_name = jQuery("select#cat_name option:selected").val();
    var post_id = jQuery("#post_id").val();
    jQuery.ajax({ 
         url: catform.ajax_url,         
		 type: 'post',
         data: {
         		action: 'contact_form', 
         		cat_name:cat_name,
         		post_id:post_id,
         		security: catform.ajax_nonce
         },
         success: function(response) {
              jQuery('#cat-form-output').html( response ); //should print out the name since you sent it along

        }
    });

    return false;

});

});