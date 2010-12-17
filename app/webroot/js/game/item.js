var itemLoading = false;
function showMouseInfo(sUrl) {
	if(itemLoading == false) {
		itemLoading = true;
		$('div#mouseInfo').html('&nbsp;');
		$('div#mouseInfo').fadeIn(100);
		$.get(sUrl, function(data) {
			itemLoading = false;
			$('div#mouseInfo').html(data);
			$('div#mouseInfo').borders();
		});
	}
	else {
		return false;
	}
}
function hideMouseInfo() {
	$('div#mouseInfo').fadeOut(250, function(){$('div#mouseInfo').html('')});
}