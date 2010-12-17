/* Fellicht borders
 * Version 0.1
 * Author Mathieu de Ruiter
 * Website: http://www.fellicht.nl/
 */
(function($){
	$.fn.borders = function (options) {
		// Setting default options
		var defaults = {
			border_w: 5, // The width of the borders
			border_h: 5, // The height of the borders,
			corner_s: 9,
			offset: 2, // The offset to the outside
			left_image: url + 'img/game/interfaces/'+ interface +'/borders/l.png',
			right_image: url + 'img/game/interfaces/'+ interface +'/borders/r.png',
			top_image: url + 'img/game/interfaces/'+ interface +'/borders/t.png',
			bottom_image: url + 'img/game/interfaces/'+ interface +'/borders/b.png',
			topleft_image: url + 'img/game/interfaces/'+ interface +'/borders/tl.png',
			topright_image: url + 'img/game/interfaces/'+ interface +'/borders/tr.png',
			bottomright_image: url + 'img/game/interfaces/'+ interface +'/borders/br.png',
			bottomleft_image: url + 'img/game/interfaces/'+ interface +'/borders/bl.png',
			background_image: url + 'img/game/interfaces/'+ interface +'/borders/background.jpg'
		}

		var options = $.extend(defaults, options);
		// Loop through the different elements
		return this.each(function(){
			var element = this;
			var width = $(element).outerWidth();
			width = width - (2 * options.corner_s) + (2 * options.offset);
			var height = $(element).outerHeight();
			height = height - (2 * options.corner_s) + (2 * options.offset);
			var position = $(element).css('position');
			// Set the position relative so we can add absolute elements in it
			$(element).css('position', 'relative');
			if(options.left_image != '') {
				number = Math.floor(Math.random()*101)
				var $borderleft = $('<div class="f_borders" style="z-index: 99;position: absolute;top:'+ (options.corner_s - options.offset) +'px;left:-'+ options.offset +'px;width: '+ options.border_w +'px; height: '+ height +'px;background-image:url('+ options.left_image +');background-repeat:repeat-y;background-position: 0% '+ number +'%"></div>');
				$(element).append($borderleft);
			}
			if(options.right_image != '') {
				number = Math.floor(Math.random()*101)
				var $borderright = $('<div class="f_borders" style="z-index: 99;right:-'+ options.offset +'px;top:'+ (options.corner_s - options.offset) +'px;position: absolute;width: '+ options.border_w +'px; height: '+ height +'px;background-image:url('+ options.right_image +');background-repeat: repeat-y;background-position: 0% '+ number +'%"></div>');
				$(element).append($borderright);
			}
			if(options.top_image != '') {
				number = Math.floor(Math.random()*101)
				var $bordertop = $('<div class="f_borders" style="z-index: 99;top:-'+ options.offset +'px;left:'+ (options.corner_s - options.offset) +'px;position: absolute;height: '+ options.border_h +'px; width: '+ width +'px;background-image:url('+ options.top_image +');background-repeat: repeat-x;background-position: '+ number +'% 0%"></div>');
				$(element).append($bordertop);
			}
			if(options.bottom_image != '') {
				number = Math.floor(Math.random()*101)
				var $borderbottom = $('<div class="f_borders" style="z-index: 99;position: absolute;left: '+ (options.corner_s - options.offset) +'px;bottom:-'+ options.offset +'px;height: '+ options.border_h +'px; width: '+ width +'px;background-image:url('+ options.bottom_image +');background-repeat: repeat-x;background-position: '+ number +'% 0%"></div>');
				$(element).append($borderbottom);
			}
			if(options.topleft_image != '') {
				var $topleft = $('<img class="f_borders" style="z-index: 100;position: absolute;left:-'+ options.offset +'px;top:-'+ options.offset +'px;" src="'+ options.topleft_image +'" />');
				$(element).append($topleft);
			}
			if(options.topright_image != '') {
				var $topright = $('<img class="f_borders" style="z-index: 100;position: absolute;right:-'+ options.offset +'px;top:-'+ options.offset +'px;" src="'+ options.topright_image +'" />');
				$(element).append($topright);
			}
			if(options.bottomright_image != '') {
				var $bottomright = $('<img class="f_borders" style="z-index: 100;position: absolute;right:-'+ options.offset +'px;bottom:-'+ options.offset +'px;" src="'+ options.bottomright_image +'" />');
				$(element).append($bottomright);
			}
			if(options.bottomleft_image != '') {
				var $bottomleft = $('<img class="f_borders" style="z-index: 100;position: absolute;left:-'+ options.offset +'px;bottom:-'+ options.offset +'px;" src="'+ options.bottomleft_image +'" />');
				$(element).append($bottomleft);
			}
			if(options.background_image != '') {
				$(element).css('background-image', 'url(' + options.background_image +')');
			}
			if(position != 'static') {
				$(element).css('position', position); // reset the original position
			}
		});
	}
})(jQuery);