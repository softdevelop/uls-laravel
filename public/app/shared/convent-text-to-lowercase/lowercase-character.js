var lowercaseCharater = angular.module('lowercaseCharater', []);


lowercaseCharater.directive('conventTextToLowercase', ['$compile', '$parse', '$filter', function($compile, $parse, $filter) {
    return {
      restrict: 'A',
      require:'?ngModel',

      link: function(scope, element, attr, ctr) {
        var patt = /\s+/g;
        element.bind("keypress", function (event) {
            if(patt.test(element.val())) {
                var lowercase = $filter('lowercase')(element.val());
                ctr.$setViewValue(lowercase);
                ctr.$render();
                return;
            }
          
        });

        ctr.$viewChangeListeners.push(function(){
            if(patt.test(element.val())) {
                var lowercase = $filter('lowercase')(element.val());
                ctr.$setViewValue(lowercase);
                ctr.$render();
            }
        })
      }
    }
}]);