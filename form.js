jQuery('#ajax-contact-form').submit(function(e){
    var name = jQuery("#name").val();
    jQuery.ajax({ 
         url: catform.ajax_url,
		 type: 'post',
         data: {
         		action: 'contact_form', 
         		name:name
         },
         success: function(response) {
              jQuery('#cat-count').html( response ); //should print out the name since you sent it along

        }
    });

    return false;

});