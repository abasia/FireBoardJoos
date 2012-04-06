(function($) {
$.fn.inputHintBox = function(options) {
	options = $.extend({}, $.inputHintBoxer.defaults, options);
	this.each(function(){
		new $.inputHintBoxer(this,options);
	});
	return this;
}
$.inputHintBoxer = function(input, options) {
	var $guideObject,$input = $guideObject = $(input), box, boxMouseDown = false;
	if ( ($input.attr('type') == 'radio' || $input.attr('type') == 'checkbox') && $input.parent().is('label') ) {
		$guideObject = $( $input.parent() );
	}
	function init() {
		var boxHtml = options.html != ''?options.html:
			options.source == 'attr'?$input.attr(options.attr): '';		
		if (typeof boxHtml === "undefined") boxHtml = '';
		box = options.div != '' ? options.div.clone() : $("<div/>").addClass(options.className);
		box = box.css('display','none').addClass('_hintBox').appendTo(options.attachTo);
		if (options.div_sub == '') box.html(boxHtml);
		else $(options.div_sub,box).html(boxHtml);
		$input.focus(function() {
			$('body').mousedown(global_mousedown_listener);
			show();
		}).blur(function(){
			prepare_hide();
		});
	}
	function align() {
		var offsets = $guideObject.position(),
			left = offsets.left + $guideObject.width() + options.incrementLeft + 5 + ($.browser.safari?5:($.browser.msie?10:($.browser.mozilla?6:0))),
			top = offsets.top + options.incrementTop + ($.browser.msie?14:($.browser.mozilla?8:0));
		box.css({position:"absolute",top:top,left:left});
	}
	function show() {
		align();
		box.fadeIn('slow');
	}
	function prepare_hide() {
		$('body').click(global_click_listener);
		if (boxMouseDown) return;
		$.inputHintBoxer.mostRecentHideTimer = setTimeout(function(){hide()},300);
	}
	var global_click_listener = function(e) {
		var $e = $(e.target),c='._hintBox';
		clearTimeout($.inputHintBoxer.mostRecentHideTimer);
		if ($e.parents(c).length == 0 && $e.is(c) == false) hide();
	};
	var global_mousedown_listener = function(e) {
		var $e = $(e.target),c='._hintBox';
		boxMouseDown = ($e.parents(c).length != 0 || $e.is(c) != false);
	}
	function hide() {
		$('body').unbind('click',global_click_listener);
		$('body').unbind('mousedown',global_mousedown_listener);
		align();
		box.fadeOut('slow');
	}
	init();
	return {}
};
$.inputHintBoxer.mostRecentHideTimer = 0;
$.inputHintBoxer.defaults = {
	div: '',
	className: 'input_hint_box',
	source: 'attr',
	div_sub: '',
	attr: 'title',
	html: '',
	incrementLeft: 5,
	incrementTop: 0,
	attachTo: 'body'
}
})(jQuery);