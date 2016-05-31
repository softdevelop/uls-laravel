var selectMenu = angular.module('uls');
'use strict';
var version = 1;

selectMenu.directive("selectMenu", ['UserService','$timeout', '$filter','TicketService', function(UserService, $timeout, $filter,TicketService) {
        return {
            require: '?ngModel',
            restrict: 'E',
            scope: {
                text: '@',
                icon: '@',
                type: '@',
                userId: '=',
                ngModel: '=',
                placeholder: '@',
                items:'=',
                title: '@',
                onClick: '&',
                onChange: '&',
                listTicket: '='
            },
            replace: true,
            templateUrl: baseUrl + '/app/shared/select-menu/view/view.html?v=' + version,
            link: function($scope, element, attrs, ngModel) {

                $scope.toggleSelectMenu = function($event)
                {
                    if($scope.type == 'assign'){

                        angular.element('#select-menu-modal-invite').removeClass("active-navigation-container");
                        // angular.element('#select-menu-modal-' + $scope.type).toggleClass("active-navigation-container");

                    } else if($scope.type == 'assign-list'){
                        console.log($scope.listTicket,'listTicket');
                        if(typeof $scope.listTicket == 'undefined' || $scope.listTicket.length <= 0) {
                            alert($filter('trans')('alert-tickets-more', 'dircetive-select-menu'));
                            $event.preventDefault();
                            return;
                        } else {
                            var typeTicket = $scope.listTicket[0].type_id;

                            //check list ticket is not unique type
                            for(i in $scope.listTicket) {
                                if($scope.listTicket[i].type_id != typeTicket) {
                                    alert($filter('trans')('alert-tickets-reassigned', 'dircetive-select-menu'));
                                    return;
                                }
                            }
                        }

                    } else {
                        angular.element('#select-menu-modal-assign').removeClass("active-navigation-container");
                    }
                    
                    angular.element('#select-menu-modal-' + $scope.type).toggleClass("active-navigation-container");

                    if($scope.type == 'assign-list') {
                        TicketService.getUsersOfTicket($scope.listTicket[0].id).then(function(data) {
                            $scope.items = data;
                        });
                    }

                    $event.stopPropagation();
                }            
                      
                $(document).on('click', function closeMenu (e){

                    $(e.target).closest('div').siblings().find('#select-menu-modal').removeClass('active-navigation-container');

                    if($('.select-menu-modal-holder').hasClass('active-navigation-container')){

                        $('.select-menu-modal-holder').removeClass('active-navigation-container');
                    }

                });

                $('.select-menu-modal-holder').click(function(event){

                    event.stopPropagation();
                });  

                $scope.assign = function(id, $event)
                {   
                    angular.element('#select-menu-modal-' + $scope.type).removeClass('active-navigation-container');
                    ngModel.$setViewValue(id);
                    $scope.onClick();
                    $event.stopPropagation();

                }

                $scope.closed = function($event)
                {
                    angular.element('#select-menu-modal-' + $scope.type).removeClass('active-navigation-container');
                    $event.stopPropagation();         
                }
                
            }
       
        }
    }
])