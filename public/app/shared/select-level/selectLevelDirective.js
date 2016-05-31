var selectLevel = angular.module('selectLevel', []);
'use strict';
var version = 5;
selectLevel.directive("selectLevel", ['$timeout', '$filter', function($timeout, $filter) {
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
            canChooseFolder: '='
        },
        replace: true,
        templateUrl: baseUrl + '/app/shared/select-level/view.html?v=' + new Date().getTime(),
        link: function($scope, element, attrs, ngModel) {
            // Wrap json
            function swap(json){
                var ret = {};
                angular.forEach(json, function(value, key) {
                    ret[value] = key;
                })
                return ret;
            }

            $scope.currentIndex = {value: 0};

            if ($scope.type == 'Asset') {  
                $scope.items = window.assets;
            } 
            // If user edit asset then not show toogle 
            $scope.$watch('selectedItems', function(newVal, oldVal) {
                if (angular.isDefined(newVal) && newVal != null) {
                    $timeout(function() {
                        var data = {
                            _id: newVal['selectedItemId'],
                            name: newVal['selectedItemName'],
                            parentIds: newVal['parentIds']
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

            var countSelectedAsset = 0;

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
                // If user selected item and countSelectedAsset <= 2 and typeSelect is Asset
                if (item._id != '' && $scope.typeSelect == 'Assets' && countSelectedAsset <= 2) {
                    if (Object.keys(item.parentIds).length == 1) {
                        angular.forEach($scope.items, function(value, key) { // Each item
                            if (value._id == item._id) { // If type of item selected == type of item in $scope.items then set item for scope items
                                $scope.items = [];
                                $scope.items.push(value);
                            }
                        });
                    } else {
                        angular.forEach($scope.items, function(value, key) { // Each item
                            // If type of item selected == type of item in $scope.items then set item for scope items
                            if (value._id == item.parentIds[Object.keys(item.parentIds).length - 1]) {
                                $scope.items = [];
                                $scope.items.push(value);
                            }
                        });
                    }
                }

                countSelectedAsset += 1;

                //Select level when edit page draft (show page) then not allow select current page
                if (angular.isDefined($scope.currentPage) && angular.isDefined(item) && (item._id == $scope.currentPage._id)) return;

                if (angular.isDefined($event)) {
                    $event.preventDefault();
                }
                // change text show selected
                if ((angular.isDefined(item.parentIds) || angular.isDefined(item.parentId) || angular.isDefined(item.parent_id)) && item.name !='') {
                    $scope.text = item.name;
                } else {
                    $scope.text = $filter('trans')('select-folder', 'directive-select-level');
                }

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
                // if (angular.isDefined($('.select-level'))) {
                //     $timeout(function(){
                //         $scope.itemsTmp = $scope.items;
                //     });
                //     $scope.isLoading = function(){
                //         if (angular.isUndefined($scope.itemsTmp)) return true;
                //         if ($scope.currentIndex.value != ($scope.itemsTmp.length - 1)) return true;
                //         return false;
                //     }
                // }

                // If user edit asset then not show toogle 
                if ($scope.disableClick == 'disabled') {
                    return;
                }

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
                        // Change icon folder to folder open of item parent of item selected
                        if ($scope.type == 'Link') {
                            var listsIdsMapPageAndContentNew = swap(window.listsIdsMapPageAndContent);
                            angular.forEach(itemIdNeedActived['parentIds'], function(value, key) {
                                $('.show-sub-select-' + listsIdsMapPageAndContentNew[value]).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
                            });
                        } else {
                            angular.forEach(itemIdNeedActived['parentIds'], function(value, key) {
                                if (itemIdNeedActived._id != value) {
                                    $('.show-sub-select-' + value).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
                                }
                            });
                        }
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
