/**
 * Tag content directive
 *
 * @author Thanh Tuan <tuan@httsolution.com>
 *
 */
var tagContentDirective = angular.module('tagContentDirective', []);
'use strict';
var version = 1; 

tagContentDirective.directive("tagContentDirective", ['$timeout', '$filter', function($timeout, $filter) {
    return {
        require: '?ngModel',
        restrict: 'EA',
        scope: {
            items: '=',
            text: '@',
            title: '@',
            textFilter: '@',
            index: '=',
            itemChoose: '=',
            currentPage: '=',
            selectedItems: '=selectedItem',
            allTags: '=',
            onClick: '&',
            itemSelected: '='
        },
        replace: true,
        templateUrl: baseUrl + '/app/shared/tag-content-directive/view/view.html?v=7',
        link: function($scope, element, attrs, ngModel) {


            // Set tag default to contain value of tag tree
            var tagsDefault = $scope.items;

            // Placeholder for input search
            $scope.placeholder = 'Search Tag...';

            // check index undefined
            if (typeof $scope.index == 'undefined') {
                $scope.index = 0;
            }

            $timeout(function() {
                // event click document Then close modal tag content
                $(document).on('click', function closeMenu(e) {
                    if ($('#select-level-modal-' + $scope.index).hasClass('in') && !$(".js-filterable-field").is(":focus")) {
                        $("#select-level-modal-" + $scope.index).collapse('hide');
                        $("#select-level-modal-" + $scope.index).removeClass('opened');
                        $('.show-sub-select i').removeClass('ti-minus').addClass('ti-plus');
                    }
                });

                // Toggle off all child ul of tag li and add class ti-plus for all tag i
                $("#select-level li:has(ul)").children("ul").addClass('off'); // hide the li UL
                $("#select-level li a i").addClass('ti-plus');

                /**
                 * Show sub item of item select
                 *
                 * @author Thanh Tuan <tuan@httsolution.com>
                 *
                 * @param  {Event} event Envent click
                 * @param  {String} id    id of tag
                 *
                 * @return {Void}
                 */
                $scope.showSubSelect = function(event, id) {
                    event.preventDefault();
                    // When user click tag i then toogle tag ul in current tag a
                    $(event.currentTarget).parent().parent().find("ul:first").toggleClass("off");
                    $(event.currentTarget).addClass('ti-plus');
                    $(event.currentTarget).toggleClass('ti-minus');
                    event.stopPropagation();
                }
            });

            /**
             * Search tag
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @param  {String} newVal  Value search new
             * @param  {String}  oldVal Value search old
             *
             * @return {Void}
             */
            $scope.$watch('searchName', function(newVal, oldVal) {

                // Set null for array tag contain valid tag search
                var tagValidWithSearch = [];

                // Set null for array tag contain first level of tag seached
                var firstLevelOfTagSearched = [];

                // Then user input value for search
                if (angular.isDefined(newVal) && newVal != '') {

                    // Declare pattern to check valid name
                    var check = ".*" + newVal + ".*";
                    var pattern = new RegExp(check, 'gi');

                    // Check each tag, if tag same with tag search then push tag to array tagValidWithSearch
                    for (var key in allTags) {
                        if(allTags[key].name.match(pattern)) {
                            tagValidWithSearch.push(allTags[key]);
                        }
                    }

                    // Get first level tags of tags searched
                    firstLevelOfTagSearched = $scope.getFirstLevelOfTagSearched(tagValidWithSearch);

                    // Set new value tag to scope to show in tag content modal
                    $scope.itemsTmp = {};
                    $scope.itemsTmp = _.uniq(firstLevelOfTagSearched);

                    $scope.setValueDefaultForTag();

                    // console.log(tagValidWithSearch, 'tagValidWithSearch');
                    angular.forEach(tagValidWithSearch, function(value, key) {
                        $scope.expandAllChildTagWithTagIds(value.parentIds);
                    })

                    angular.forEach($scope.tags, function(value, key) {
                        $timeout(function() {
                            // Call function expand all parent
                            // Checked for checkbox of tag activated
                            $('.tag-content-' + value).prop('checked', true);
                            // Set active
                            $('.show-sub-select-' + value).addClass('active');
                        })
                    });

                } else if(newVal == '') {

                    // If value search is null then set default value of tag to show
                    $scope.itemsTmp = tagsDefault;

                    // Format tag
                    $scope.setValueDefaultForTag();
                    $scope.toggleAllChildTag();
                }
            });

            /**
             * Get tags in first level of tags searched
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             * 
             * @param  {Array} tagValidWithSearch Array tags
             * 
             * @return {Array}                    Array tags in first level of tags searched
             */
            $scope.getFirstLevelOfTagSearched = function (tagValidWithSearch) {

                // Contain first level of tags valid with tags search
                var firstLevelOfTagSearched = [];

                // Each tag
                angular.forEach(tagValidWithSearch, function(value, key) {
                    // If tag seached is first level
                    if(value['parent_id'] == '0') {
                        firstLevelOfTagSearched.push(_.find(tagsDefault, function(obj) {return obj._id == value['_id']})
                        );
                    } else {
                        firstLevelOfTagSearched.push(_.find(tagsDefault, function(obj) {
                                return obj._id == value['parentIds'][value['parentIds'].length - 1] 
                            })
                        );
                    }
                }); 

                return firstLevelOfTagSearched;
            }

            /**
             * Select and active tag
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @param  {array} item   Tags
             * @param  {event} $event Event click
             *
             * @return {void}
             */
            $scope.selectedItem = function(item, $event) {

                // Set value selected for ng-model
                ngModel.$setViewValue(item._id);

                // Item user selected is active it
                itemIdNeedActived = item;

                // If current selected has class active then remove class active
                if ($('.show-sub-select-' + itemIdNeedActived['_id']).hasClass('active')) {
                    $('.show-sub-select-' + itemIdNeedActived['_id']).removeClass('active');
                    // Checked for checkbox of tag activated
                    $('.tag-content-' + itemIdNeedActived['_id']).prop('checked', false);
                } else { // Add class active if it not active
                    $('.show-sub-select-' + itemIdNeedActived['_id']).addClass('active');
                    // Checked for checkbox of tag activated
                    $('.tag-content-' + itemIdNeedActived['_id']).prop('checked', true);
                }

                // Call function to add tag selected to current page selected
                $scope.onClick({pageId:$scope.currentPage._id, tagId:item._id});

                $event.stopPropagation();
            }

            /**
             * When user click in check box then set active for tag
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @param Object  item   Tag content
             * @param Event   $event Event click
             *
             */
            $scope.SelectedCheckbox = function (item, $event){
                // When user click in check box then set active for tag
                $scope.selectedItem(item, $event);
            }

            /**
             * Toggle all parrent node of node activated
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @param  {$event} $event
             *
             * @return {Void}
             */
            $scope.toggleSelectMenu = function($event) {
                console.log($scope.itemSelected, '$scope.itemSelected');
                if ($scope.itemSelected != null) {
                    $scope.setValueDefaultForTag();
                    $scope.expandAllChildTagWithTagIds($scope.itemSelected);
                }

                // Toggle show Tag
                $("#select-level-modal-" + $scope.index).collapse('toggle');
                if(!$("#select-level-modal-" + $scope.index).hasClass('opened')){
                    $("#select-level-modal-" + $scope.index).addClass('opened');
                    $scope.itemsTmp = angular.copy($scope.items);
                }else{
                    $("#select-level-modal-" + $scope.index).removeClass('opened');
                    $scope.itemsTmp = [];
                }

                // Set value null for input search
                $scope.searchName = '';

                // Set array contain all parrent id of current item selected is null
                parentTagIds = [];

                $scope.setValueDefaultForTag();

                $scope.toggleAllChildTag();
            }

            /**
             * Set value default for tag content
             *
             * @author Thanh Tuan <tuan@httsolution.com
             *
             * @return Void
             */
            $scope.setValueDefaultForTag = function () {
                $timeout(function(){
                    // Remove all class active when user click in show toggle
                    $('.show-sub-select').removeClass('active');

                    // Close all child tag in first level
                    $('.parrent-select').addClass('off');

                    // Format all button to toggle child is ti-plus
                    $('.toggle-child-tag').removeClass('ti-minus').addClass('ti-plus');
                })
            }

            /**
             * toggle expanded all child tag
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @return {Void}
             */
            $scope.toggleAllChildTag = function () {
                // If current page hasn't tag
                $scope.tags = $scope.currentPage.tags;
                if($scope.currentPage.data){
                    $scope.tags = $scope.currentPage['data'].tags;
                }
                // If current page hasn't tag
                if (angular.isDefined($scope.tags) || $scope.tags != []) {
                    $timeout(function(){
                        // Each tag of page
                        angular.forEach($scope.tags, function(value, key) {
                            // Call function expand all parent
                            // Checked for checkbox of tag activated
                            $('.tag-content-' + value).prop('checked', true);
                            // Set active
                            $('.show-sub-select-' + value).addClass('active');

                            var tag = _.find($scope.allTags, function(obj) {return obj._id == value});

                            // Expanded all child tag
                            $scope.expandAllChildTagWithTagIds(tag.parentIds);
                        });
                    }) 
                }
            }

            /**
             * Expand all child node with parentTagIds
             *
             * @author Thanh Tuan <tuan@httsolution.com>
             *
             * @return {Void}
             */
            $scope.expandAllChildTagWithTagIds = function(parentTagIds) {
                $timeout(function(){
                    // Earch parentTagIds
                    for (var key in parentTagIds) {
                        // Find li parent and find first tag i and add class
                        $('.show-sub-select-' + parentTagIds[key]).find("i:first").addClass('ti-minus');
                        // // Toggle current ul
                        $('.parrent-select-' + parentTagIds[key]).removeClass("off");
                    }
                })
            }

        }

    }
}])
