var ajaxLoading = false; // For chat

$(document).ready(function() {
	$('div#map').load(url + 'maps');
	setTimeout("initChat();", 500);
	setTimeout("initBags();", 1000);
	setTimeout("initChar();", 1500);
});