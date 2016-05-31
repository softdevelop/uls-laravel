
angular.module('treeresizer', []).directive('resizer', ['$document',function($document) {

	return function($scope, $element, $attrs) {

		function autoHeight () {
			var h = $(window).outerHeight();

			var hNav = $('.navibar-uls').outerHeight();
			var hTop = $('.top-content').outerHeight();

			$('.content').height(h - (hNav + hTop + 19));
		}
		autoHeight();
		$(window).resize(autoHeight);

		$element.on('mousedown', function(event) {
			event.preventDefault();
			$document.on('mousemove', mousemove);
			$document.on('mouseup', mouseup);
		});
		
		function mousemove(event) {
				var Wsidebar = $('#sidebar').outerWidth();
				$('#resize-left').unbind();

				// Handle vertical resizer
				var x = event.pageX - Wsidebar;
				if ($attrs.resizerMax && x > $attrs.resizerMax) {
					x = parseInt($attrs.resizerMax);
				}
				$element.css({
					left: x + 'px'
				});

				$($attrs.resizerLeft).css({
					width: x + 'px'
				});

				$($attrs.resizerRight).css({
					left: (x + parseInt($attrs.resizerWidth)) + 'px'
				});
		}
		function mouseup() {
			$document.unbind('mousemove', mousemove);
			$document.unbind('mouseup', mouseup);
		}
	};
}]);