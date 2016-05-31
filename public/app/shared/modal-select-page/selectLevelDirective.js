/**
 * Select level page
 *
 * @author Thanh Tuan <tuan@httsolution.com>
 *
 * @type {Void}
 */
var selectLevel = angular.module('modalSelectPage', []);
'use strict';
var version = 3;

selectLevel.directive("modalSelectPage", ['$timeout', '$filter', '$modal', '$parse', function($timeout, $filter, $modal, $parse) {
    return {
        require: '?ngModel',
        restrict: 'EA',
        scope: {
            items: '=',
            itemSelected:'=',
            onClick: '&',
            ngModel: '=',
            isDisabled: '='
        },
        templateUrl: baseUrl + '/app/shared/modal-select-page/view.html?v=' + version,
        link: function($scope, element, attrs, ngModel) {
            // Text of page
            $scope.text = '';
            if(angular.isDefined($scope.isDisabled) && $scope.isDisabled){
                $('.form-control').addClass('no-drop');
            } 
            $scope.$watch('ngModel',function(newVal, oldVal) {
                if(angular.isDefined(newVal) && newVal != null) {
                    $(element).find('.text-page').text(window.listsPageMap[newVal]);
                }
            });
            
            // At the first load, if page is selected then set text for page
            if ($scope.itemSelected != '') {
                for (var key in window.listsPageMap) {
                    if (key == $scope.itemSelected) {
                        $(element).find('.text-page').text(window.listsPageMap[key]);
                        break;
                    }
                }
            }

            // Function call modal show all page
            $scope.callModal = function () {
                if ($scope.isDisabled) {
                    return;
                }
                var teamplate = '/app/shared/modal-select-page/select.html';
                var modalInstance = $modal.open({
                    templateUrl: window.baseUrl + teamplate,
                    controller: 'SelectLevelLinkController',
                    size: null,
                    resolve: {

                        itemSelected: function() { // page selected
                            return angular.copy($scope.itemSelected);
                        }
                    }

                });
                modalInstance.result.then(function (item) {
                    // When user choose page then set text for page
                    $(element).find('.text-page').text(item.name);
                    // Set ngmodel for page with item selected
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
selectLevel.controller('SelectLevelLinkController', ['$scope', '$modalInstance', '$timeout', 'itemSelected', '$timeout', function ($scope, $modalInstance, $timeout, itemSelected, $timeout) {
    // List tree items
    $scope.items = window.listpages;

    $scope.listsIdsMapPageAndContent = window.listsIdsMapPageAndContent;

    // Item need active
    var itemIdNeedActived = '';

    $timeout(function() {
        // If not item selected then stop
        if(angular.isUndefined(itemSelected) || itemSelected == null) return;
        // Get item selected and set to data
        var itemActivated = $('.show-sub-select-' + window.listsIdsMapPageAndContent[itemSelected]).data("page");
        
        if(angular.isDefined(itemActivated)) {

            var data = {
                _id: itemActivated._id,
                name: itemActivated.name,
                parentIds: itemActivated.parentIds,
                folderId: itemActivated.folder_id
            };
            // Call function active item selected and expand all parent item
            $scope.selectedItem(data);
        }
    }, 500)

    $timeout(function() {
        // Toggle off
        $(".parrent-select").addClass('off'); // hide the li UL
        $("#select-level li a i").addClass('fa fa-folder');

        $scope.listsId = [];

        // Show all sub selected
        $scope.showSubSelect = function(event, id) {
            event.preventDefault();
            $(event.currentTarget).parent().find("ul:first").toggleClass("off");
            $(event.currentTarget).find('i').toggleClass('fa fa-folder-open fa');
            $(event.currentTarget).find('i').addClass(' fa-folder');
            event.stopPropagation();
            // how to hide previously clicked submenus?
        }

    });

    $scope.selectedItem = function(item, $event) {
        if (angular.isDefined($event)) {
            $event.preventDefault();
        }

        // Expand parent ul of item selected (item activated)
        angular.forEach($('.item-' + item['_id']).parents('ul'), function(value, key) {
            $(value).removeClass('off');
        });

        // Expand all nested parent of item selected
        angular.forEach(item['parentIds'], function(value, key) {
            // console.log(value, 'value');
            $('.show-sub-select-' + value).find('i').removeClass('fa fa-folder').addClass('fa fa-folder-open fa');
        });

        // Item need active
        itemIdNeedActived = item;

        console.log(itemIdNeedActived, 'itemIdNeedActived');

        // Active item selected
        $(".show-sub-select").removeClass('active');
        $(".show-sub-select-" + window.listsIdsMapPageAndContent[itemIdNeedActived['_id']]).addClass('active');

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
