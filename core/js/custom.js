var URL = $(location).attr('href');

//alert(URL);
jQuery('.main li a').each(function() {
	var current = $(this).attr('href');
	
	if( current == URL ){
		$(this).parent().addClass('current_page');
	}else{
		$(this).parent().removeClass('current_page');

	}
});