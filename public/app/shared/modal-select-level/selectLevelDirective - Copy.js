/**
 * Select level asset
 *
 * @author Thanh Tuan <tuan@httsolution.com>
 *
 * @type {Void}
 */
var selectLevel = angular.module('modalSelectLevel', []);
'use strict';
var version = 3;

selectLevel.directive("modalSelectLevel", ['$timeout', '$filter', '$modal', '$parse', function($timeout, $filter, $modal, $parse) {
    return {
        require: '?ngModel',
        restrict: 'EA',
        scope: {
            items: '=',
            itemSelected:'=',
            type: '@',
            onClick: '&',
            ngModel: '='
        },
        templateUrl: baseUrl + '/app/shared/modal-select-level/view.html?v=' + new Date().getTime(),
        link: function($scope, element, attrs, ngModel) {
            // Text of asset
            $scope.text = '';
            
            $scope.$watch('ngModel',function(newVal, oldVal) {
                if(angular.isDefined(newVal) && newVal != null) {
                    $(element).find('.text-asset').text(window.listMapIdAssets[newVal].name);                    
                }
            });

            // At the first load, if asset is selected then set text for asset
            if ($scope.itemSelected != '') {
                $(element).find('.text-asset').text(window.listMapIdAssets[$scope.itemSelected].name);
            }

            // Function call modal show all asset
            $scope.callModal = function () {
                var teamplate = '/app/shared/modal-select-level/select.html?v=' + new Date().getTime();
                var modalInstance = $modal.open({
                    templateUrl: window.baseUrl + teamplate,
                    controller: 'SelectLevelController',
                    size: null,
                    resolve: {

                        itemSelected: function() { // asset selected
                            return angular.copy($scope.itemSelected);
                        },
                        type: function() {
                            return $scope.type;
                        }
                    }

                });
                modalInstance.result.then(function (item) {
                    // When user choose asset then set text for asset
                    $(element).find('.text-asset').text(item.name);
                    // Set ngmodel for asset with item selected
                    $scope.itemSelected =  item._id;
                    ngModel.$setViewValue(item._id);
                    ngModel.$render();
                    $scope.onClick();
                }, function () {

                   });
            }
        }

    }
}]);
selectLevel.controller('SelectLevelController', ['$scope', '$modalInstance', '$timeout', 'itemSelected', '$timeout', 'type', function ($scope, $modalInstance, $timeout, itemSelected, $timeout, type) {
    // Item need active
    var itemIdNeedActived = '';

    $timeout(function() {
        // Toggle off
        $("#select-level li:has(ul)").children("ul").addClass('off'); // hide the li UL
        $("#select-level li a i").addClass('fa fa-folder');

        $scope.listsId = [];

        // Show all sub selected
        $scope.showSubSelect = function(value, event) {
            if (angular.isDefined(event)) {
                event.preventDefault();
                $(event.currentTarget).parent().find("ul:first").toggleClass("off");
                $(event.currentTarget).find('i').toggleClass('fa fa-folder-open fa');
                $(event.currentTarget).find('i').addClass(' fa-folder');
                event.stopPropagation();
            } else {
                $('.show-sub-select-' + value._id).parent().find("ul:first").toggleClass("off");
                $('.show-sub-select-' + value._id).find('i').toggleClass('fa fa-folder-open fa');
                $('.show-sub-select-' + value._id).find('i').addClass(' fa-folder');
            }

            // how to hide previously clicked submenus?
            $scope.value = value;
            var temp = _.find($scope.listAssetWithFirstLevel, function(obj) { return obj._id == value._id });
            if (angular.isUndefined(temp)) return;
            $scope.value.subFolder = temp.subFolder;
        }

    });

    $timeout(function() {

        $scope.listMapIdAssets = angular.copy(window.listMapIdAssets);

        // If not item selected then stop
        if(angular.isUndefined(itemSelected) || !itemSelected) return;

        // Get item selected and set to data
        var itemActivated = $scope.listMapIdAssets[itemSelected];

        // If not item selected then return
        if (angular.isUndefined(itemActivated)) return;

        var data = {
            _id: itemActivated._id,
            name: itemActivated.name,
            ancestor_ids: itemActivated.ancestor_ids
        };

        // Call function active item selected and expand all parent item
        $scope.selectedItem(data);
    });

    // Contain lists asset
    $scope.items = [];
    $timeout(function(){
        $scope.listAssetWithFirstLevel = window.listAssetFolderContainFirstLevel;
        var assetRoot = _.find( $scope.listAssetWithFirstLevel, function(obj) { return obj.parent_id == '0' });
        if (angular.isDefined(type)) {
            // Get asset with type input for show
            $scope.items.push(_.find($scope.listAssetWithFirstLevel, function(obj) {return obj.name == type}));
        } else {
            $scope.items = assetRoot.subFolder;
        }
    });

    $scope.test = function ($array) {
        angular.forEach(item['ancestor_ids'], function(value, key) {
           var temp = window.listMapIdAssets[value];
        })
    }

    // "56cf5c94d6479131128b4578"
    // "56c499aad6479171778b4567"
    // "56c499a8d6479169778b4567"
    // "0"

    $scope.selectedItem = function(item, $event) {


        $timeout(function(){

            $scope.showSubSelect($('.show-sub-select-56c499aad6479171778b4567').data('value'));
            var assetRoot = _.find( $scope.listAssetWithFirstLevel, function(obj) { return obj.parent_id == '0' });
            console.log(assetRoot.subFolder, 'assetRoot');
            // angular.forEach(assetRoot.subFolder, function(value, key) {
            //     if (value._id == $scope.value._id) {
            //         value = $scope.value;
            //         $scope.items = [];
            //         $scope.items = assetRoot.subFolder;
            //         console.log($scope.items, '123123');
            //     }

            // })

            if (angular.isDefined($event)) {
                $event.preventDefault();
            }

            // If item is folder then not set active
            if (angular.isDefined(item.subFolder) && item.subFolder.length > 0) return;
            if ($('.show-sub-select-' + item['_id']).find('i').hasClass('fa-folder')) return;

            // Expand parent ul of item selected (item activated)
            angular.forEach(item['ancestor_ids'], function(value, key) {
                $('.parrent-select-' + value).removeClass("off");
            });

            // Expand all nested parent of item selected
            angular.forEach(item['ancestor_ids'], function(value, key) {
                $('.show-sub-select-' + value).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
            });

            // Item need active
            itemIdNeedActived = item;

            // Active item selected
            $(".show-sub-select").removeClass('active');
            $(".show-sub-select-" + itemIdNeedActived['_id']).addClass('active');
        })
    }

    $scope.submit = function () {
        var result = {};
        result._id = itemIdNeedActived._id;
        result.name = itemIdNeedActived.name;
        $modalInstance.close(result);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
}]);
