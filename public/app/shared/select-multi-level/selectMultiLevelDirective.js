var selectMenu = angular.module('uls');
'use strict';
var version = 2;

selectMenu.directive("selectMultiLevel", ['$timeout', '$filter', function($timeout, $filter) {
        return {
            require: '?ngModel',
            restrict: 'E',
            scope: {
                items: '=',
                itemExits: '=',
                text: '@',
                title: '@',
                ngModel: '=',
                placeholder: '@',
                index: '='
            },
            replace: true,
            templateUrl: baseUrl + '/app/shared/select-multi-level/view/view.html?v=' + version,
            link: function($scope, element, attrs, ngModel) {

                $scope.selections = [];

                $scope.toggleSelectLabel = function(id, index, $event)
                {

                   angular.element('.icon-' + index).toggleClass("hide");

                   angular.element('.color-label-' + index).toggleClass("color-label");

                   var idx = $scope.selections.indexOf(id);

                    if (idx > -1) {

                        $scope.selections.splice(idx, 1);
                    }
                    else {

                        $scope.selections.push(id);
                    }
                   $event.stopPropagation();
                   
                }

                $scope.toggleSubLabel = function(id, key, index, $event)
                {
                    angular.element('.icon-sub-' + key + '-' + index).toggleClass("hide");

                    angular.element('.color-label-sub-' + key + '-' + index).toggleClass("color-label");

                    var idx = $scope.selections.indexOf(id);

                    if (idx > -1) {

                        $scope.selections.splice(idx, 1);
                    }
                    else {

                        $scope.selections.push(id);
                    }  
                    $event.stopPropagation();               
                }

                $(document).on('click', function closeMenu (e){

                      angular.element(e.target).closest('tr').siblings().find('#select-multil-level-modal-' + $scope.index).slideUp();
                      if(angular.element("#select-multil-level-modal-" + $scope.index).has(e.target).length === 0){
                        angular.element("#select-multil-level-modal-" + $scope.index).prev(".text-show-action").removeClass('active');
                        angular.element("#select-multil-level-modal-" + $scope.index).slideUp();
                      } else {
                        angular.element(document).one('click', closeMenu);
                      }
                });

                // $('#select-multil-level-modal').click(function(event){

                //     event.stopPropagation();
                // });

                $scope.toggleSelectMenu = function($event)
                {
                    if ( angular.element( "#select-multil-level-modal-" + $scope.index ).is( ":hidden" ) ) {
                        angular.element("#select-multil-level-modal-" + $scope.index).show( "slow" );
                        angular.element("#select-multil-level-modal-" + $scope.index).prev(".text-show-action").addClass('active');
                      } else {
                        angular.element("#select-multil-level-modal-" + $scope.index).slideUp();
                        angular.element("#select-multil-level-modal-" + $scope.index).prev(".text-show-action").removeClass('active');
                      }
                    $event.stopPropagation();
                }  

                $scope.closed = function($event)
                {
                    angular.element("#select-multil-level-modal-" + $scope.index).slideUp();

                    ngModel.$setViewValue($scope.selections);
                    angular.element("#select-multil-level-modal-" + $scope.index).prev(".text-show-action").removeClass('active');
                    $event.stopPropagation();         
                }
                
            }
       
        }
    }
])