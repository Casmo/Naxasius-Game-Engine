var mouse_x = 0;
var mouse_y = 0;
var messageTimeout;
$(document).ready(function() {
	setTimeout("initUi();", 100);
	$(document).mousemove(function(e){
		mouse_x = e.pageX;
		mouse_y = e.pageY;
		$('div#mouseInfo').css('left', (mouse_x + 20) + 'px');
		$('div#mouseInfo').css('top', (mouse_y + 20) + 'px');
	});
});

function showMessage(message) {
	clearTimeout(messageTimeout);
	$('div#message').html(message);
	$('div#message').fadeIn(500);
	$('div#message').borders();
	messageTimeout = setTimeout("$('div#message').fadeOut(500);", 10000);
}

function initUi() {
	$('div.borders').borders();
	$('div.menu_item').borders({
		corner_s: 5,
		offset: 3,
		left_image: '',
		right_image: url + 'img/game/interfaces/'+ interface +'/borders/r.png',
		top_image: '',
		bottom_image: '',
		topleft_image: '',
		topright_image: '',
		bottomright_image: '',
		bottomleft_image: '',
		background_image: ''
	});
	$('div.menu_c').borders({
		background_image: url + 'img/game/interfaces/' + interface +'/borders/background_menu.jpg'
	});
	$('div.talk_c').borders({
		left_image: '',
		right_image: '',
		top_image: url + 'img/game/interfaces/'+ interface +'/borders/t.png',
		bottom_image: '',
		topleft_image: url + 'img/game/interfaces/'+ interface +'/borders/tlm_c.png',
		topright_image:  url + 'img/game/interfaces/'+ interface +'/borders/trm_c.png',
		bottomright_image: '',
		bottomleft_image: '',
		background_image: ''
	});
	$('div.chat_input').borders({
		left_image: url + 'img/game/interfaces/'+ interface +'/borders/l.png',
		right_image: '',
		top_image: '',
		bottom_image: '',
		topleft_image: url + 'img/game/interfaces/'+ interface +'/borders/tl_c.png',
		topright_image: '',
		bottomright_image: '',
		bottomleft_image: url + 'img/game/interfaces/'+ interface +'/borders/bl_c.png',
		background_image: ''
	});
	$('div#avatar_c').borders({bottomright_image: url + 'img/game/interfaces/'+ interface +'/borders/br2_c.png'});
	$('div#characterinfo_c').borders({left_image:'',bottomleft_image:url +'img/game/interfaces/' + interface +'/borders/blm2_c.png',topleft_image:url + 'img/game/interfaces/'+ interface +'/borders/tlm_c.png'});
	$('div#minimapinfo_c').borders({right_image:'',bottomright_image:url +'img/game/interfaces/' + interface +'/borders/brm2_c.png',topright_image:url + 'img/game/interfaces/'+ interface +'/borders/trm_c.png'});
	$('div#minimap_c').borders({bottomleft_image: url + 'img/game/interfaces/'+ interface +'/borders/bl2_c.png'});

	$('div#hp_bar_c').borders({
		left_image: '',
		right_image: '',
		top_image: url +'img/game/interfaces/'+ interface +'/borders/t.png',
		bottom_image: url +'img/game/interfaces/'+ interface +'/borders/b.png',
		topleft_image: url +'img/game/interfaces/'+ interface +'/borders/tlm_c.png',
		topright_image: url +'img/game/interfaces/'+ interface +'/borders/trm_c.png',
		bottomright_image: url +'img/game/interfaces/'+ interface +'/borders/brm_c.png',
		bottomleft_image: url +'img/game/interfaces/'+ interface +'/borders/blm_c.png'
	});
}
function showPopup(target_url, icon) {
	$('#popup_container').width($(document).width());
	$('#popup_container').height($(document).height());
	$('div#popup').text('');
	$('div#popup').load(target_url, function(){
	$('#popup_container').fadeIn(250);
		$('div#popup').fadeIn(250, function() {
			initPopup(icon);
		});
	});

	$('#popup_container').click(function() {
		closePopup();
	});
}

function closePopup() {
	$('#popup_container').fadeOut(250);
	$('div#popup').fadeOut(250, function() {
		setTimeout("$('div#popup').text('');", 100);
	});
}

function initPopup(icon) {
	someHtml = $('div#popup').html();
	closeHtml = '<img src="'+ url + 'img/game/interfaces/'+ interface +'/borders/close.png" alt="close" style="position: absolute; right: -2px; top: -2px; z-index: 101; cursor: pointer;" onclick="closePopup();" />';
	$('div#popup').html(someHtml + ' ' + closeHtml);
	if(icon == undefined) {
		$('div#popup').borders();
	}
	else {
		$('div#popup').html(' <img src="' + icon +'" style="position: absolute; width: 32px; height: 32px; top: 0px; left: 0px;"' + $('div#popup').html());
		$('div#popup').borders({
			topleft_image: url + 'img/game/interfaces/'+ interface +'/borders/icon_popup.png'
		});
	}
}

function tabsPopup(tabs, tablinks, icon) {
	tabshtml = '<div class="tab_c">';
	for(i=0;i<tabs.length;i++) {
		selected = '';
		if(i == 0) {
			selected = ' selected';
		}
		tabshtml = tabshtml + '<div id="tab_'+ i +'" onclick="loadPopupTab(\''+ tablinks[i] +'\', '+ i +');" class="tab'+ selected +'" style="margin-right: 10px;">'+ tabs[i] +'</div>';
	}
	tabshtml = tabshtml + '</div>';
	html = $('div#popup').html();
	$('div#popup').html(tabshtml + html);
	if(icon != ''){
		initPopup(icon);
	}
	setTimeout("$('div.tab').borders({bottom_image:'',bottomright_image:url + 'img/game/interfaces/' + interface +'/borders/br_c.png',bottomleft_image:url + 'img/game/interfaces/' + interface +'/borders/bl_c.png'});", 1);
}

function loadPopupTab(target_url, i) {
	$('div#popup').load(target_url, function(data){
		$('div.tab').removeClass('selected');
		$('div#tab_' + i).addClass('selected');
	});
}

function initTabs(tabs, tablinks, target, type, target_load) {
	tabshtml = '<div class="tab_c">';
	for(i=0;i<tabs.length;i++) {
		selected = '';
		if(i == 0) {
			selected = ' selected';
		}
		tabshtml = tabshtml + '<div id="tab_'+ type +'_'+ i +'" onclick="loadTab(\''+ tablinks[i] +'\', '+ i +', \''+ target_load +'\', \''+ type +'\');" class="tab_' + type + selected +'" style="margin-right: 10px;">'+ tabs[i] +'</div>';
	}
	tabshtml = tabshtml + '</div>';
	html = $(target).html();
	$(target).html(tabshtml + html);
	$('div.tab_' + type).borders({bottom_image:'',bottomright_image:url + 'img/game/interfaces/' + interface +'/borders/br_c.png',bottomleft_image:url + 'img/game/interfaces/' + interface +'/borders/bl_c.png'});
}

function loadTab(target_url, i, target, type) {
	$(target).load(target_url, function(data){
		$('div.tab_' + type).removeClass('selected');
		$('div#tab_' + type + '_' + i).addClass('selected');
		$(target).animate({ scrollTop: $(target).attr("scrollHeight") }, 250);
		if(type == 'chat') {
			chat_type = $('div#tab_' + type + '_' + i).text().toLowerCase();
		}
	});
}

/* Function to enable borders for the action frame under the map */
function actionBorders() {
	$('div.action_actions').borders({
		left_image: url +'img/game/interfaces/'+ interface +'/borders/l.png',
		right_image: '',
		top_image: '',
		bottom_image: '',
		topleft_image: url +'img/game/interfaces/'+ interface +'/borders/tl_c.png',
		topright_image: '',
		bottomright_image: '',
		bottomleft_image: url +'img/game/interfaces/'+ interface +'/borders/bl_c.png'
	});
	$('div.action_icon').borders({
		left_image: '',
		right_image: url +'img/game/interfaces/'+ interface +'/borders/r.png',
		top_image: '',
		bottom_image: '',
		topleft_image: '',
		topright_image: url +'img/game/interfaces/'+ interface +'/borders/tr_c.png',
		bottomright_image: url +'img/game/interfaces/'+ interface +'/borders/br_c.png',
		bottomleft_image: ''
	});
}