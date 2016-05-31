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
            ngModel: '=',
            isDisabled: '='
        },
        templateUrl: baseUrl + '/app/shared/modal-select-level/view.html?v=' + version,
        link: function($scope, element, attrs, ngModel) {
            // Text of asset
            $scope.text = '';
            if(angular.isDefined($scope.isDisabled) && $scope.isDisabled){
                $('.form-control').addClass('no-drop');
            } 
            $scope.$watch('ngModel',function(newVal, oldVal) {
                if(angular.isDefined(newVal) && newVal != null) {
                    $(element).find('.text-asset').text(window.listsAsset[newVal]);                    
                }
            });

            // At the first load, if asset is selected then set text for asset
            if ($scope.itemSelected != '') {
                $(element).find('.text-asset').text(window.listsAsset[$scope.itemSelected]);
            }

            // Function call modal show all asset
            $scope.callModal = function () {
                if ($scope.isDisabled) {
                    return;
                }
                var teamplate = '/app/shared/modal-select-level/select.html';
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
    // Contain lists asset
    $scope.items = [];
    if (angular.isDefined(type)) {
        // Get asset with type input for show
        $scope.items.push(_.find(window.assets, function(obj) {return obj.name == type}));
    } else {
        $scope.items = window.assets;
    }

    // Item need active
    var itemIdNeedActived = '';

    $timeout(function() {
        // If not item selected then stop
        if(angular.isUndefined(itemSelected) || !itemSelected) return;

        // Get item selected and set to data
        var itemActivated = $('.show-sub-select-' + itemSelected).data("asset");

        // If not item selected then return
        if (angular.isUndefined(itemActivated)) return;

        var data = {
            _id: itemActivated._id,
            name: itemActivated.name,
            parentIds: itemActivated.parentIds
        };

        // Call function active item selected and expand all parent item
        $scope.selectedItem(data);
    }, 500)

    $timeout(function() {
        // Toggle off
        $("#select-level li:has(ul)").children("ul").addClass('off'); // hide the li UL
        $("#select-level li a i").addClass('fa fa-folder');

        $scope.listsId = [];

        // Show all sub selected
        $scope.showSubSelect = function(event, id) {
            event.preventDefault();
            $(event.currentTarget).parent().find("ul:first").toggleClass("off");
            $(event.currentTarget).find('i').toggleClass('fa fa-folder-open fa');
            $(event.currentTarget).find('i').addClass(' fa-folder');
            event.stopPropagation();
        }

    });

    $scope.selectedItem = function(item, $event) {

        if (angular.isDefined($event)) {
            $event.preventDefault();
        }

        // If item is folder then not set active
        if (angular.isDefined(item.subFolder) && item.subFolder.length > 0) return;
        if ($('.show-sub-select-' + item['_id']).find('i').hasClass('fa-folder')) return;

        // Expand parent ul of item selected (item activated)
        angular.forEach($('.item-' + item['_id']).parents('ul'), function(value, key) {
            $(value).removeClass('off');
        });

        // Expand all nested parent of item selected
        angular.forEach(item['parentIds'], function(value, key) {
            $('.show-sub-select-' + value).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
        });

        // Item need active
        itemIdNeedActived = item;

        // Active item selected
        $(".show-sub-select").removeClass('active');
        $(".show-sub-select-" + itemIdNeedActived['_id']).addClass('active');
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
