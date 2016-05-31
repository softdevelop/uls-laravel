var selectLevelHelp = angular.module('selectLevelHelp', []);
'use strict';
var version = 5;
selectLevelHelp.directive("selectLevelHelp", ['$timeout', '$filter', function($timeout, $filter) {
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
            selectedItems: '=selectedItem',
            onClick: '&',
            currentPage: '=',
            showIcon: '=',
            typeSelect: '=',
            disableClick: '=',
            notSelectCurrent: '=',
            chageType: '=',
            type: '=',
        },
        replace: true,
        templateUrl: baseUrl + '/app/components/user/help-editor/view/view.html?v=' + new Date().getTime(),
        link: function($scope, element, attrs, ngModel) {
            
            $scope.$watch('selectedItems', function(newVal, oldVal) {
                if (angular.isDefined(newVal) && newVal != null) {
                    $timeout(function() {
                        var data = {
                            _id: newVal['selectedItemId'],
                            name: newVal['selectedItemName'],
                            ancestor_ids: newVal['ancestor_ids']
                        };

                        $scope.selectedItem(data);
                    });
                }
            });

            var itemIdNeedActived = "";

            // check index undefined
            if (typeof $scope.index == 'undefined') {
                $scope.index = 0;
            }
            if(typeof $scope.key == 'undefined'){
                $scope.key = 0;
            }

            $timeout(function() {
                // event click document
                $(document).on('click', function closeMenu(e) {
                    if ($('#select-level-modal-' + $scope.key + '-' + $scope.index).hasClass('in') && !$(".js-filterable-field").is(":focus")) {
                        $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('hide');
                        $('.show-sub-select i').removeClass('fa fa-folder-open fa').addClass('fa fa-folder');
                    }

                });

                // Toggle off
                $("#select-level li:has(ul)").children("ul").addClass('off'); // hide the li UL
                $("#select-level li a i").addClass('fa fa-folder');

                $scope.listsId = [];

                $scope.showSubSelect = function(event, id) {
                    event.preventDefault();
                    $(event.currentTarget).parent().find("ul:first").toggleClass("off");
                    $(event.currentTarget).find('i').addClass('fa fa-folder');
                    $(event.currentTarget).find('i').toggleClass('fa fa-folder-open fa');
                    event.stopPropagation();
                    // how to hide previously clicked submenus?
                }

                if (typeof $scope.itemChoose != 'undefined') {
                    itemsChoose($scope.items);
                }
                
            });

            $scope.focusInput = function($event) {
                $event.stopPropagation();
            }

            /**
             * Select value
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @param  {Object} item    Item selected
             * @param  {Event}  $event  Event
             *
             * @return {Void}
             */
            $scope.selectedItem = function(item, $event) {
                $scope.text = item.name;

                // set value ngModel
                ngModel.$setViewValue(item._id);

                // If change type of page
                if ($scope.chageType) {

                    $scope.onClick({pageId:item._id});
                }

                $("#select-level-modal-" + $scope.key + '-' + $scope.index).find('.name-select.active').removeClass('active');

                itemIdNeedActived = item;

                // $scope.parentId = item.parentId;
                $("#select-level-modal-" + $scope.key + '-' + $scope.index).find('.item-' + itemIdNeedActived['_id']).addClass('active');
                
                if (angular.isDefined($event)) {
                    $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('hide');
                }
            }

            /**
             * [toggleSelectMenu description]
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param  {Event} $event Event
             * @return {Void}        
             */
            $scope.toggleSelectMenu = function($event) {
                $timeout(function(){
                    $scope.itemsTmp = $scope.items;
                });

                $timeout(function(){
                    // Remove all class active
                    $('.show-sub-select').removeClass('active');

                    // Remove icon folder open to folder
                    $("#select-level li a i").removeClass('fa fa-folder-open fa').addClass('fa fa-folder');

                    // Hide all ul child
                    $('.parrent-select').addClass('off');

                    if (itemIdNeedActived) {
                        angular.forEach($('.item-' + itemIdNeedActived['_id']).parents('ul'), function(value, key) {
                            $(value).removeClass('off');
                        });

                        // Active item selected
                        $('.show-sub-select-'+itemIdNeedActived._id).addClass('active');

                        angular.forEach(itemIdNeedActived['ancestor_ids'], function(value, key) {
                            if (itemIdNeedActived._id != value) {
                                $('.show-sub-select-' + value).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
                            }
                        });
                    }
                    // Collaspe all
                    $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('toggle');
                })
            }
            /**
             * [closed description]
             * @author minh than
             * @param  {[type]} $event [description]
             * @return {[type]}        [description]
             */
            $scope.closed = function($event) {

                $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('hide');

            }
            /**
             * [itemChoose description]
             * @return {[type]} [description]
             */
            var itemsChoose = function(items) {
                
                // for item choose
                for (var i in items) {

                    // exits sub folder
                    if (items[i].subFolder) {
                        itemsChoose(items[i].subFolder);
                    }

                    // equal id item vs id choose
                    if (items[i]['_id'] == $scope.itemChoose) {
                        $scope.text = items[i]['name'];
                        break;
                    }

                }

            }

        }

    }
}])
