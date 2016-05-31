/**
 * Select level database 
 *
 * @author Thanh Tuan <tuan@httsolution.com
 * 
 * @type {Directive}
 */
var selectLevel = angular.module('selectLevelDatabase', []);
'use strict';
var version = 2;

selectLevel.directive("selectLevelDatabase", ['$timeout', '$filter', function($timeout, $filter) {
    return {
        require: '?ngModel',
        restrict: 'EA',
        scope: {
            items: '=',
            text: '@',
            title: '@',
            textFilter: '@',
            index: '=',
            key: '=',
            itemChoose: '=',
        },
        replace: true,
        templateUrl: baseUrl + '/app/shared/select-level-database/view.html?v=' + version,
        link: function($scope, element, attrs, ngModel) {

            var itemIdNeedActived = "";
            var level = 0;

            // check index undefined
            if (typeof $scope.index == 'undefined') {
                $scope.index = 0;
            }
            if(typeof $scope.key == 'undefined'){
                $scope.key = 0;
            }

            $timeout(function() {
                // event clicl document
                $(document).on('click', function closeMenu(e) {
                    if ($('#select-level-modal-' + $scope.key + '-' + $scope.index).hasClass('in') && !$(".js-filterable-field").is(":focus")) {
                        $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('hide');
                        $('.show-sub-select i').removeClass('fa fa-folder-open fa').addClass('fa fa-folder fa');
                    }

                });

                // Toggle off
                $("#select-level li:has(ul)").children("ul").addClass('off'); // hide the li UL
                $("#select-level li a i").addClass('fa fa-folder');

                $scope.listsId = [];

                $scope.showSubSelect = function(event, item) {
                    event.preventDefault();

                    $(event.currentTarget).parent().find("ul:first").toggleClass("off");

                    $(event.currentTarget).children().find('i').addClass('fa fa-folder fa');
                    $(event.currentTarget).find('i').toggleClass('fa fa-folder-open fa');
                    event.stopPropagation();
                    // how to hide previously clicked submenus?
                    
                    if(angular.isDefined(item) && angular.isDefined(item.subFolder)) {
                        $scope.selectedItem(item);
                    }
                }

            });


            $scope.focusInput = function($event) {
                $event.stopPropagation();
            }

            var countSelectedAsset = 0;

            /**
             * Select Item
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @param  {Object} item    Item selected
             * @param  {Event}  $event  Event
             *
             * @return {Void}
             */
            $scope.selectedItem = function(item, $event) {

                // If item has subfolder then stop
                if(item.subFolder) return;

                if (angular.isDefined($event)) {
                    $event.preventDefault();
                }

                // set value ngModel
                ngModel.$setViewValue(item);
                
                $(".show-sub-select").removeClass('active');
                $(".show-sub-select-" + item['key']).addClass('active');

                // Item active
                itemIdNeedActived = item;

                // Set text for select
                $scope.text = item.name;

                if (angular.isDefined($event)) {
                    $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('hide');
                }
            }

            $scope.listsItem = [];
            
            /**
             * Toggle select all menu
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             * 
             * @param  {Event} $event Event
             * 
             * @return {Void}        
             */
            $scope.toggleSelectMenu = function($event) {

                // If user edit asset then not show toogle 
                if ($scope.disableClick == 'disabled') {
                    return;
                }

                // Toggle off all ul and close all icon folder
                $("#select-level li a i").removeClass('fa fa-folder-open fa').addClass('fa fa-folder');
                $('.parrent-select').addClass('off');

                // If isset item need active
                if (itemIdNeedActived) {
                    // Expanded all child
                    angular.forEach($('.item-' + itemIdNeedActived['key']).parents('ul'), function(value, key) {
                        $(value).removeClass('off');
                    });
                    // Open icon folder
                    $('.show-sub-select-' + itemIdNeedActived['parent']).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
                }

                $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('toggle');

            }

        }

    }
}])
