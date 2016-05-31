/**
 * This directive change date time when user input the date greater than date limit
 *
 * @author Thanhtuan <tuan@httsolution.com>
 */
'use strict';
(function($) {
    angular.module('checkLimitAndChangeDateTimeDirectiveApp', [])
    .directive('checkLimitAndChangeDateTimeDirective', ['$timeout', '$filter', function ($timeout, $filter){
		return {
			restrict: 'EA',
			scope: {
				items : '=',
				itemsAssigned : '=',
				requiredItem: '=',
				placeholder:'@'
			},
			require: "?ngModel",
			templateUrl: '',
			link: function($scope, elem, attrs, ngModel, ctrl){
				elem.bind('blur', function(){
		            var newValue = ngModel.$modelValue;
		            //Check value is date 
	               	if (angular.isDefined(newValue) && (newValue instanceof Date) == true) {
	               		// This date limit of input date time
	               		var maxDate = $filter('date')(new Date('2038-01-18'), 'yyyy-MM-dd');
	               		var minDate = $filter('date')(new Date('1970-01-01'), 'yyyy-MM-dd');
	               		// This date user input
	               		var dateInput = $filter('date')(new Date(newValue), 'yyyy-MM-dd');
	               		// This date when user input date time greater than date limit then set this date for input date time
	               		var toDate = $filter('date')(new Date(), 'yyyy-MM-dd')
	               		// If new value user input greater than the day '2038-01-18' or lass than the day '1970-01-01'  then set value is today
	               		if (dateInput > maxDate || dateInput < minDate) {
	               			// Set value and render value asigned for view
	               			ngModel.$setViewValue(toDate);
			                ngModel.$render();
			                $scope.$apply(); 
	               		}
	               	}
		        })
			}
		};

	}]);
})(jQuery);