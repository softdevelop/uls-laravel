
var addCloseToogleModule = angular.module('addCloseToogleModule', []);

addCloseToogleModule.directive('addCloseToogle', ['$modal', '$parse', function($modal, $parse){
  return {
    restrict: 'A',
    link: function(scope, element, attr){

      $(attr.target).on('hide.bs.collapse', function () {
        element.find('i').attr('class','').attr('class','fa fa-plus');
        element.find('span').text('Add');

        // element.html('<i class="fa fa-plus"> </i> Add');
      });

       $(attr.target).on('show.bs.collapse', function () {
        element.find('i').attr('class','').attr('class','fa fa-minus');
        element.find('span').text('Close');
      })

    }
  }
}])
