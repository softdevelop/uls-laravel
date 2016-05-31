<!DOCTYPE Html>
<html>
	<meta charset="UTF-8">
	<title>Rowboat test angular js</title>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
	<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
	<style>
		
		.error span{
			display: block;
			color: red;
		}

	</style>
</html>
<body ng-app="myApp">
<form name="checkMinOrMaxLength">
	<div ng-controller="myController">
		<div class="row-input">
			<input type="text" name="checkMinlength" id="check_minlength" 
			       ng-model="rowboat.checkMinlength" 
			       rowboat-min-length=5 
				   placeholder="Enter a text in here">	
		</div>
	</div>
</form>
</body>
<script>
	var app = angular.module('myApp',[]);
	(function() {
	    'use strict';

	    app.directive('rowboatMinLength', ['$compile', function($compile) {
	        return {
	            restrict: 'A',

	            require: 'ngModel',

	            scope: {
	                rowboatMinLength: '@',
	                model: '=ngModel'
	            },

	            link: function($scope, $element, $attrs, ngModel) {
	                $scope.$watch('model', function() {
	                	var content = '';
	                	var value = $element.val();

	                	if(!$element.hasClass('ng-dirty') && (!value || value == null)) return;

	                    var isValid = (value.length >= $scope.rowboatMinLength);

						if (isValid) {
							$element.parent().find('span').remove();
							$element.parent().removeClass('error');
						} else {
							if ($element.parent().find('span').length == 0) {
								$element.parent().addClass('error');
								var content = '<span class="control-label">Min length is '+$scope.rowboatMinLength+'</span>';
								$element.parent().append(content);
							}
						}
						ngModel.$setValidity($attrs.ngModel, isValid);
	                    
					});
					$element.on('blur', function() {
                        var content = '';
	                	var value = $element.val();

                        if ($element.parent().find('span').length == 0 || !value) {
		                	$element.parent().find('span').remove();
							$element.parent().removeClass('error');

		                	if (!value) {
		                		$element.parent().addClass('error');
		                		var content = '<span class="control-label">This field is require</span>';
								$element.parent().append(content);
			                	ngModel.$setValidity($attrs.ngModel, false);
		                	}
		                }
					});
				}
	        }
	    }]);
	})();
	app.controller('myController', ['$scope', function($scope) {
		// $scope.checkMinLength = function(validate) {
		// 	if (validate) {
  //               return;
		// 	}

		// 	$scope.notice = 'success'
		// }
	}]);
</script>