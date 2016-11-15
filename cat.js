jQuery( document ).on( 'click', '.cat-button', function() {
	var post_id = jQuery(this).data('id');
	var category_name = jQuery(this).data('category');
	jQuery.ajax({
		url : categoryname.ajax_url,
		type : 'post',
		data : {
			action : 'ajax_category_add_category',
			post_id : post_id,
			category_name : category_name
		},
		success : function( response ) {
			jQuery('#cat-count').html( response );
		}
	});

	return false;
})