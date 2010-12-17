var chat_type = 'general';
var chat_loading = false;
$(document).ready(function() {
	setTimeout("initChat();", 500);
});
function initChat() {
	setInterval("loadChat();", 2000);
	// Tabs
	tabs = new Array();
	tablinks = new Array();
	tabs[0] = 'General';
	tabs[1] = 'Trade';
	tabs[2] = 'Map';
	tabs[3] = 'Private';
	tabs[4] = 'Combat';
	tablinks[0] = url + 'game/chats/index/general';
	tablinks[1] = url + 'game/chats/index/trade';
	tablinks[2] = url + 'game/chats/index/map';
	tablinks[3] = url + 'game/chats/index/private';
	tablinks[4] = url + 'game/chats/index/combat';
	initTabs(tabs, tablinks, 'div#chat_c', 'chat', 'div#chat');
	//setTimeout("$('div#quests_c, div#quest_detail_c').borders({background_image: url + 'img/game/interfaces/' + interface +'/borders/background_dark.jpg'});", 10);
	$('input#chat').bind('keyup', function(e) {
		code = (e.keyCode ? e.keyCode : e.which);
		if(code == 13) {
			message = escape($('input#chat').val());
			message = message.replace(/\//, '%2F');
			message = message.replace(/%3A/, 'code.colon');
			message = message.replace(/%3F/, 'code.question');
			message = message.replace(/%2F/, 'code.slash');
			message = message.replace(/\./, 'code.dot');
			$.post(url + 'game/chats/talk/' + chat_type +'/', { 'data[Chat][message]': message });
			value = $('input#chat').val();
			value = value.replace(/(@[a-z0-9]+( ))?(.*)?/gi,'$1');
			$('input#chat').val(value);
		}
	});
}
function loadChat() {
	if(chat_loading == false) {
		chat_loading = true;
		$.get(url + 'game/chats/index/' + chat_type, function(data){
			chat_loading = false;
			if(data != '') {
				$('div#chat').html($('div#chat').html() + data);
			}
			$('div#chat').attr({scrollTop: $('div#chat').attr("scrollHeight")});
		});
	}
}