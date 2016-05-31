var filterHtml = angular.module('fomatHtml', []);


filterHtml.directive('formBuilder', ['$compile', '$parse', function($compile, $parse) {
    return {
      restrict: 'E',
      link: function(scope, element, attr) {
        scope.$watch(attr.content, function() {
          var content =  angular.element('<div>'+$parse(attr.content)(scope) + '</div>') ;
          // console.log('content ', content);
          if(attr.fieldName != '' && angular.isDefined(attr.fieldName)){
            var oldNgmodel = content.find('[ng-model]').attr('ng-model');

            content.find('[ng-model]').attr('ng-model', attr.fieldName);
            content.find('[item-selected]').attr('item-selected', attr.fieldName);

            if (angular.isDefined(content.find('[ng-change]'))) {
                var oldNgChange = content.find('[ng-change]').attr('ng-change');
                if (angular.isDefined(oldNgChange)) {
                    content.find('[ng-change]').attr('ng-change', oldNgChange.replace(oldNgmodel, attr.fieldName));
                }
            }
          }
          
          element.html(content.html());
          // console.log('content ', content.html(), $parse(attr.content)(scope));

          $compile(element.contents())(scope);
        }, true);
      }
    }
}]).filter('htmlize', ['$sce', function($sce){
        return function(val) {
            return $sce.trustAsHtml(val);
        };
}])
.directive('compile', [ '$compile' ,function($compile) {
      // directive factory creates a link function
      return function(scope, element, attrs) {
        scope.$watch(
          function(scope) {
             // watch the 'compile' expression for changes
            return scope.$eval(attrs.compile);
          },
          function(value) {
            // when the 'compile' expression changes
            // assign it into the current DOM
            element.html(value);

            // compile the new DOM and link it to the current
            // scope.
            // NOTE: we only compile .childNodes so that
            // we don't get into infinite loop compiling ourselves
            $compile(element.contents())(scope);
          }
        );
      };
}]);