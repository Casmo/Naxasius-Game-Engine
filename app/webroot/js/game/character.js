function changeStat(type, amount, amount_max) {
	$('span#char_' + type).text(amount);
	$('span#char_'+ type +'_max').text(amount_max);
	// Procent uitrekenen
	// procent = xp_needed / 100 * xp
	procent = Math.ceil((100 / amount_max) * amount);
	$('div#'+ type +'_bar').animate({width: procent + '%'}, 2000);
}

function ding() {
	$('div#ding_bar').animate({width: '100%'}, 1000, function() {
		setTimeout("$('div#ding_bar').animate({width: '0%'}, 1000);", 1000);
	});
}
function updateCharacterInfo(callbackFunction) {
	$.get(url + 'game/characters/stats', {}, function(data) {
	$('div#x').html(data);
		changeStat('xp', stat_xp_real, stat_xp_needed);
		changeStat('hp', stat_hp, stat_hp_max);
		prev_level = $('span#character_level').text();
		new_level = stat_level;
		if(prev_level != new_level && prev_level > 0) {
			// Ding!
			ding();
		}
		$('span#character_level').text(new_level);
		// @todo, stats
		if(callbackFunction != undefined) {
			callbackFunction();
		}
	});
}

function updateCharacterSheet() {
	$('span#char_stat_hp').text(stat_hp + '/' + stat_hp_max);
	$('span#char_stat_damage').text(stat_min_damage + '-' + stat_max_damage);
	if(stat_armor == undefined) {
		stat_armor = '0';
	}
	$('span#char_stat_armor').text(stat_armor);
}