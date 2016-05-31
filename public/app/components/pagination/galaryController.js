
var galaryModule = angular.module('galary');

galaryModule.controller('GalaryController',['$scope','PaginationService',function($scope,PaginationService) {
    var galaryCtrl = this;

//    var obj = { foo: "bar", baz: 42 };
// console.log(Object.values(obj)); // ['bar', 42]
	// var object = {1:1,2:2};
	console.log(jQuery.param({ tagsIds: [ 2, 3, 4 ] }));
	// var str = jQuery.param( params );

   	// console.log();
   	
    galaryCtrl.getGalleryWitTagsIds = function()
    {
    	var myObject = {tagsIds: galaryCtrl.tagsIds};
    	 PaginationService.get(1, myObject).then(function(data){
            galaryCtrl.items = data.galary.data;
            $scope.$broadcast('pagination', data);
        });
    }
}]);
