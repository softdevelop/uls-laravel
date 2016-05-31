var selectLevel = angular.module('helpEditorDirective', []);
'use strict';
var version = 5;
selectLevel.directive("helpEditorDirective", ['$timeout', '$filter', function($timeout, $filter) {

    return {
        require: '?ngModel',
        restrict: 'EA',
        scope: {
            items: '=',
            text: '@',
            selectedItems: '=selectedItem',
            onClick: '&',
        },
        replace: true,
        templateUrl: baseUrl + '/app/components/user/help-editor/view/view-help.html?v=' + new Date().getTime(),
        link: function($scope, element, attrs, ngModel) {
            $scope.description = '';

            // Recursive get description of child
            $scope.recursiveGetDescription = function (sub) {
                angular.forEach(sub, function(value, key) {
                    value.parent = false;
                    $scope.description += '<strong class="space-topic" id="_' + value._id + '">' + value.name + '</strong>' + value.description;
                    if (value.subFolder.length > 0) {
                        $scope.recursiveGetDescription(value['subFolder']);
                    }
                });
            }
            
            $scope.getDesctiption = function() {
                angular.forEach($scope.items, function(value,key) {
                    value.parent = true;
                    $scope.description += '<h4 id="_'+value._id+'" class="c-primary">' + value.name + '</h4>' +
                                          '<div class="space-area user-ad-area">' + value.description;
                    $scope.recursiveGetDescription(value['subFolder']);
                    $scope.description += '</div>'
                });
            }
            
            $scope.getDesctiption();

		    // Scroll to element with id
		    $scope.goToAnchorWithId = function(value){
		        window.location.href = '#'+value;
		        $('#fix-modal-top').scrollTop(0);
		    }

            // Active first
            $timeout(function () {
            	$('.sub-select-' + $scope.items[0]._id).addClass('in');
        	});   
        }

    }

}])
