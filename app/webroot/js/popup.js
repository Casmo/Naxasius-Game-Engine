function popup(url) {
	$('#popup_c').fadeIn('fast');
	$('#popup').load(url, function(){
		$('#popup').fadeIn('fast');
	});
	$('#popup_c').click(function() {
		hidePopup();
	});
}

function hidePopup() {
	$('#popup_c').fadeOut('fast');
	$('#popup').fadeOut('fast', function() {
	$(this).html('&nbsp;');
	});
}