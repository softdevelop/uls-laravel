var selectLevelAsset = angular.module('selectLevelAsset', []);
'use strict';
selectLevelAsset.directive("selectLevelAsset", ['$timeout', '$filter', function($timeout, $filter) {
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
            type: '='
        },
        replace: true,
        templateUrl: baseUrl + '/app/shared/select-level-asset/view.html?v=' + new Date().getTime(),
        link: function($scope, element, attrs, ngModel) {
            var listAssetWithFirstLevel = window.window.listAssetFolderContainFirstLevel;

            $scope.$watch('selectedItems', function(newVal, oldVal) {
                if (angular.isDefined(newVal)) {
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

                $scope.showSubSelect = function(event, value) {
                    event.preventDefault();
                    $(event.currentTarget).parent().find("ul:first").toggleClass("off");
                    $(event.currentTarget).find('i').addClass('fa fa-folder');
                    $(event.currentTarget).find('i').toggleClass('fa fa-folder-open fa');
                    event.stopPropagation();
                    // how to hide previously clicked submenus?
                    $scope.value = value;
                    var temp = _.find(listAssetWithFirstLevel, function(obj) { return obj._id == value._id });
                    if (angular.isUndefined(temp)) return;
                    $scope.value.subFolder = temp.subFolder;
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
                if (angular.isDefined($event)) {
                    $event.preventDefault();
                }
                // change text show selected
                if ((angular.isDefined(item.ancestor_ids) || angular.isDefined(item.ancestor_ids)) && item.name !='') {
                    $scope.text = item.name;
                } else {
                    $scope.text = $filter('trans')('select-asset', 'directive-select-level');;
                }
                // set value ngModel
                ngModel.$setViewValue(item._id);

                $("#select-level-modal").find('.name-select.active').removeClass('active');
                $("#select-level-modal").find('.item-' + item['_id']).addClass('active');
                if (angular.isDefined($event)) {
                    $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('hide');
                }
                itemIdNeedActived = item;
            }

            /**
             * [toggle Select Menu description]
             * @author minh than
             * @param  {[type]} $event [description]
             * @return {[type]}        [description]
             */
            $scope.toggleSelectMenu = function($event) {
                $timeout(function(){
                    var assetRoot = _.find( listAssetWithFirstLevel, function(obj) { return obj.parent_id == '0' });
                    $scope.itemsTmp = assetRoot.subFolder;
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
                        $('.show-sub-select-' + itemIdNeedActived._id).addClass('active');
                        // Change icon folder to folder open of item parent of item selected
                        angular.forEach(itemIdNeedActived['ancestor_ids'], function(value, key) {
                            $('.show-sub-select-' + value).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
                        });
                    }
                    // Collaspe all
                    $("#select-level-modal-" + $scope.key + '-' + $scope.index).collapse('toggle');
                })
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
