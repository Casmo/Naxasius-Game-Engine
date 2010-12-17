var itemLoading = false;
var mouse_x = 0;
var mouse_y = 0;
function showItem(element) {
	if(itemLoading == false) {
		$('div#mouseInfo').html('');
		$('div#mouseInfo').show();
		itemLoading = true;
		type = typeof(element);
		if(type == 'object') {
			item_name = escape($(element).html());
		}
		else {
			item_name = escape(element);
		}
		$.get(url + 'items/view/' + item_name, function(data) {
			itemLoading = false;
			$('div#mouseInfo').html(data);
			$('div#mouseInfo').borders();
		});
	}
	else {
		return false;
	}
}
function hideItem() {
	$('div#mouseInfo').hide();
	$('div#mouseInfo').html('');
}

function initSite() {
	$('input#UserUsername').focus();
	$('div.c, div.login_c, .borders').borders();
	$('div.menu').borders({top_image: '', topleft_image: url + 'img/game/interfaces/'+ interface +'/borders/tl_c.png', topright_image: url + 'img/game/interfaces/'+ interface +'/borders/tr_c.png'});
	$('div.news_c').borders({offset:12, background_image:'',topleft_image: url + 'img/game/interfaces/'+ interface +'/borders/tlm_c.png', topright_image: url + 'img/game/interfaces/'+ interface +'/borders/trm_c.png', left_image: '', right_image:'', bottom_image:'', bottomleft_image: '', bottomright_image: ''});
	headers();
}
function headers() {
	waittime = 7500;
	highest_index = 0;
	$.each($('img.header'), function(index, value){
		setTimeout("$('div#header_text_" + index +"').animate({left: '20px',opacity:0.8}, 1000)", (waittime * index));
		setTimeout("$('div#header_text_" + index +"').animate({left: '330px',opacity:0}, 1000)", (waittime * (index + 1)));
		setTimeout("$('img#header_" + index +"').fadeIn()", (waittime * index));
		setTimeout("$('img#header_" + index +"').fadeOut()", (waittime * (index + 1)));
		highest_index = index;
	});
	setTimeout("headers()", (waittime * (highest_index + 1)));
}

$(document).ready(function() {
	setTimeout("initSite();", 200);
	$(document).mousemove(function(e){
		mouse_x = e.pageX;
		mouse_y = e.pageY;
		$('div#mouseInfo').css('left', (mouse_x + 20) + 'px');
		$('div#mouseInfo').css('top', (mouse_y + 20) + 'px');
	});
});