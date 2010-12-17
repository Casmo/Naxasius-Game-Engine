var mapHtml = '';
function popup(url) {
	//mapHtml = $('div#theMap').html();
	//$('div#theMap').text('');
	$('div#popup_container').show(0); // ('fast');
	$('div#popup').show();
	$('div#popup').load(url, function(){
		 // ('fast');
	});
	$('div#popup_container').click(function() {
		hidePopup();
	});
}

function hidePopup() {
	$('div#popup_container').hide(0); // ('fast');
	$('div#popup').html('&nbsp;');
	$('div#popup').hide(0,function() {
	//$('div#theMap').html(mapHtml);
	});
}