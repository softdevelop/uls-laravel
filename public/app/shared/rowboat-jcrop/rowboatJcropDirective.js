
var rowboatJcrop = angular.module('rowboatJcrop', []);

rowboatJcrop.directive('rowboatJcrop', ['$parse', function($parse){
  return {
    restrict: 'A',
    require: '?ngModel',
    scope:{
        rowboatJcrop:'=',
        config: '=',
        ratio: '=',
        size: '='
    },
    templateUrl: window.baseUrl + '/app/shared/rowboat-jcrop/views/index.html?v='+new Date().getTime(),
    link: function($scope, element, attr, ngModel){
        console.log($scope.config, 'dsfdsfdsf');
        // var result = [];
        var elementImg = $(element).find('img');
        // console.log(element);
        // The variable jcrop_api will hold a reference to the
        // Jcrop API once Jcrop is instantiated.
        var jcropApi;

        // In this example, since Jcrop may be attached or detached
        // at the whim of the user, I've wrapped the call into a function
        initJcrop();

         // The function is pretty simple
        function initJcrop()//{{{
        {
          // Hide any interface elements that require Jcrop
          // (This is for the local user interface portion.)
          // $('.requiresjcrop').hide();

          // Invoke Jcrop in typical fashion
          $(elementImg).Jcrop({
                onChange:   showCoords,
                onSelect:   showCoords,
                allowResize:$scope.config.allowResize,
                aspectRatio: $scope.config.aspectRatio,
                minSize: $scope.config.minSize,
                maxSize: $scope.config.maxSize
          },function(){

            jcropApi = this;
            jcropApi.animateTo([100,100,400,300]);

            // // Setup and dipslay the interface for "enabled"
            // $('#can_click,#can_move,#can_size').attr('checked','checked');
            // $('#ar_lock,#size_lock,#bg_swap').attr('checked',false);
            // $('.requiresjcrop').show();

          });

        };

        function showCoords(c)
        {
            // result = [c.x, c.y, c.x2, c.y2, c.w, c.h];
            ngModel.$setViewValue([c.x, c.y, c.x2, c.y2, c.w, c.h]);
        };
        $scope.$watch('ratio', function(newVal, oldVal){
            if (angular.isUndefined(newVal) || angular.isUndefined(jcropApi)) return;
            console.log(jcropApi);
            ratioValue = newVal.split(':');
            jcropApi.setOptions({
                aspectRatio:parseInt(ratioValue[0]) / parseInt(ratioValue[1])
            });
            jcropApi.focus();
        });

        $scope.$watch('size', function(newVal, oldVal){
            if (angular.isUndefined(newVal) || angular.isUndefined(jcropApi)) return;
            sizeValue = newVal.split('x');
            jcropApi.setOptions({
                minSize: [ parseInt(sizeValue[0]), parseInt(sizeValue[1]) ],
                maxSize: [ parseInt(sizeValue[0]), parseInt(sizeValue[1]) ]
            });
            jcropApi.focus();
        });

    }
  }
}])
