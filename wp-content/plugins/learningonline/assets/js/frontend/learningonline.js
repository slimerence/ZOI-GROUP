/**
 * @author JwsTheme
 * @package LearningOnline/Javascript
 * @version 1.0
 */
;if (typeof window.LP == 'undefined') {
	window.LP = {};
}
;(function ($) {
	"use strict";
	LP = $.extend({
		setUrlx   : function (url, title) {

			if (url) {
				history.pushState({}, title, url);
			}
		},
		reload    : function (url) {
			if (!url) {
				url = window.location.href;
			}
			window.location.href = url;
		},
		parseJSON : function (data) {
			var m = data.match(/<-- LP_AJAX_START -->(.*)<-- LP_AJAX_END -->/);
			try {
				if (m) {
					data = $.parseJSON(m[1]);
				} else {
					data = $.parseJSON(data);
				}
			} catch (e) {
				data = {};
			}
			return data;
		},
		toElement : function (element, args) {
			args = $.extend({
				delay   : 300,
				duration: 'slow',
				offset  : 50,
				callback: null
			}, args || {});
			$('body, html')
				.fadeIn(10)
				.delay(args.delay)
				.animate({
					scrollTop: $(element).offset().top - args.offset
				}, args.duration, args.callback);
		},
		showMessages: function (messages, target, code) {
			$(target).find('.learning-online-error, .learning-online-notice, .learning-online-message').fadeOut();
			if ($.isArray(messages)) {
				for (var i = messages.length - 1; i >= 0; i--) {
					var $message = $(messages[i]).hide();
					$(target).prepend($message.fadeIn());
				}
			} else {
				var $message = $(messages).hide();
				$(target).prepend($message.fadeIn());
			}
			LP.Hook.doAction('learningonline_show_message', messages, target, code);
		}
	}, LP);


})(jQuery);