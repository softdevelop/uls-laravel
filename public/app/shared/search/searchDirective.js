var searchModule = angular.module('uls');
searchModule.directive("search", ['UserService','$timeout', '$filter',
    function(UserService, $timeout, $filter) {
        return {
            require: '?ngModel',
            restrict: 'EA',
            scope: {
                type: '=',
                userId: '=',
                component: '@',
                ngModel: '=',
                onChange: '&',
                placeholder: '@',
                items:'='
            },
            replace: true,
            templateUrl: baseUrl + '/app/shared/search/views/search.html?v=1',
            link: function($scope, element, attrs, ngModel) {
                 element.find('.search-people').select2({
                    placeholder: $scope.placeholder,
                    // allowClear: true,
                    templateResult: function(user){
                        console.log(user.id,'fdsf');
                        // console.log(user);
                        if (!user.id) { return '<span>' + user.text + '</span>'; }
                        var userId = user.id.split('number:')[1];

                         userInfo = UserService.getUserById(userId);
                        if(typeof userInfo !== 'undefined' && userInfo.deleted_at == null){
                            var $user = $('<span><img style="width:30px; height:30px;" class="img-search img-circle" src="'+userInfo.avatar+'" /> ' + user.text + '</span>');
                            return $user;
                        }
                    }
                });
                 
                 if($scope.onChange){

                    $scope.$watch('ngModel',function(){

                        $scope.onChange({value: $scope.ngModel});
                    }) 
                 }
                 
                 $scope.$watch(function(scope){
                    return scope.placeholder;
                 }, function(newValue, oldValue){
                    angular.element('.search-people .select2-chosen').text(newValue);
                 });
               
                $scope.changeSelect = function(){
                    angular.element('#search-pw').removeClass('in');
                }
                
                $scope.showListSelect = function(){

                    element.find('.search-people').select2('open');
                }            
            }
       
        }
    }
])