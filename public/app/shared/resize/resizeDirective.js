angular.module('treeresize', []).directive('resizer', ['$document',function($document) {

	return function($scope, $element, $attrs) {
		// show scroll  
		$('#tree-file').css({
			width: 300 + 'px'
		});

		$element.on('mousedown', function(event) {
			event.preventDefault();
			$document.on('mousemove', mousemove);
			$document.on('mouseup', mouseup);
		});
		
		function mousemove(event) {

				$('#tree-file').unbind();

				// Handle vertical resizer
				var x = event.pageX - 50;
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