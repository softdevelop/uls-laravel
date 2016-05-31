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
            selectedItems: '=selectedItems',
            allTags: '=',
            onClick: '&',
            itemSelected: '='
        },
        replace: true,
        templateUrl: baseUrl + '/app/shared/tag-content-directive/view/view.html?v=7',
        link: function($scope, element, attrs, ngModel) {
            var tagsDefault = $scope.items;             // Set tag default to contain value of tag tree
            $scope.placeholder = 'Search Tag...';       // Placeholder for input search
            if (typeof $scope.index == 'undefined') {   // check index undefined
                $scope.index = 0;
            }

            $timeout(function() {
                $(document).on('click', function closeMenu(e) { // Event click document Then close modal tag content
                    if ($('#select-level-modal-' + $scope.index).hasClass('in') && !$(".js-filterable-field").is(":focus")) {
                        $("#select-level-modal-" + $scope.index).collapse('hide');
                        $("#select-level-modal-" + $scope.index).removeClass('opened');
                        $('.show-sub-tag-select i').removeClass('ti-minus').addClass('ti-plus');
                    }
                });

                // Toggle off all child ul of tag li and add class ti-plus for all tag i
                $("#select-level-tag li:has(ul)").children("ul").addClass('off'); // hide the li UL
                $("#select-level-tag li a i").addClass('ti-plus');

                /**
                 * Show sub item of item select
                 * @author Thanh Tuan <tuan@httsolution.com>
                 * @param  {Event}  event  Envent click
                 * @param  {String} id     Id of tag
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
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param  {String}  newVal  Value search new
             * @param  {String}  oldVal  Value search old
             * @return {Void}
             */
            $scope.$watch('searchName', function(newVal, oldVal) {                
                var tagValidWithSearch = [];                       // Set null for array tag contain valid tag search                
                var firstLevelOfTagSearched = [];                  // Set null for first level of tag seached               
                if (angular.isDefined(newVal) && newVal != '') {   // Then user input value for search                    
                    var check = ".*" + newVal + ".*";              // Declare pattern to check valid name
                    var pattern = new RegExp(check, 'gi');

                    // Check each tag, if tag same with tag search then push tag to array tagValidWithSearch
                    for (var key in allTags) {
                        if(allTags[key].name.match(pattern)) {
                            tagValidWithSearch.push(allTags[key]);
                        }
                    }

                    // Get first level tags of tags searched
                    firstLevelOfTagSearched = $scope.getFirstLevelOfTagSearched(tagValidWithSearch);                    
                    $scope.itemsTmp = {};           // Set new value tag to scope to show in tag content modal
                    $scope.itemsTmp = _.uniq(firstLevelOfTagSearched);                    
                    $scope.setValueDefaultForTag(); // Set value default for tag

                    // Expanded all child tag of tag valid with search
                    angular.forEach(tagValidWithSearch, function(value, key) {
                        $scope.expandAllChildTagWithTagIds(value['ancestor_ids']);
                    })

                    angular.forEach($scope.tags, function(value, key) {
                        $timeout(function() {
                            $('.tag-content-' + value).prop('checked', true);      // Checked tag activated
                            $('.show-sub-tag-select-' + value).addClass('active'); // Set active
                        })
                    });

                } else if(newVal == '') { // If value search is null
                    $scope.itemsTmp = tagsDefault; 
                    // Format tag
                    $scope.setValueDefaultForTag();
                    $scope.toggleTags();
                }
            });

            /**
             * Get tags in first level of tags searched
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param  {Array} tagValidWithSearch Array tags
             * @return {Array}                    Array tags
             */
            $scope.getFirstLevelOfTagSearched = function (tagValidWithSearch) {
                var firstLevelOfTagSearched = [];   // Contain first level of tags valid with tags search
                angular.forEach(tagValidWithSearch, function(value, key) {
                    if (value['parent_id'] == 0) {  // If tag seached is first level
                        firstLevelOfTagSearched.push(_.find(tagsDefault, function(obj) { return obj._id == value['_id'] }));
                    } else {
                        firstLevelOfTagSearched.push(_.find(tagsDefault, function(obj) {
                            return obj._id == value['ancestor_ids'][value['ancestor_ids'].length - 2] ;
                        }));
                    }
                }); 
                return firstLevelOfTagSearched;
            }

            /**
             * Select and active tag
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param  {array} item   Tags
             * @param  {event} $event Event click
             * @return {void}
             */
            $scope.selectedItem = function(item, $event) {
                ngModel.$setViewValue(item._id);   // Set value selected for ng-model
                itemIdNeedActived = item;          // Item user selected is active it
                // If current selected has class active then remove class active
                if ($('.show-sub-tag-select-' + itemIdNeedActived['_id']).hasClass('active')) {
                    $('.show-sub-tag-select-' + itemIdNeedActived['_id']).removeClass('active');
                    // Checked for checkbox of tag activated
                    $('.tag-content-' + itemIdNeedActived['_id']).prop('checked', false);
                } else { // Add class active if it not active
                    $('.show-sub-tag-select-' + itemIdNeedActived['_id']).addClass('active');
                    // Checked for checkbox of tag activated
                    $('.tag-content-' + itemIdNeedActived['_id']).prop('checked', true);
                }

                // Call function to add tag selected to current page selected
                $scope.onClick({pageId:$scope.currentPage._id, tagId:item._id});

                $event.stopPropagation();
            }

            /**
             * When user click in check box then set active for tag
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param Object  item   Tag content
             * @param Event   $event Event click
             */
            $scope.SelectedCheckbox = function (item, $event){
                $scope.selectedItem(item, $event); // When user click in check box then set active for tag
            }

            /**
             * Toggle all parrent node of node activated
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param  {$event} $event
             * @return {Void}
             */
            $scope.toggleSelectMenu = function($event) {
                $scope.setValueDefaultForTag(); // Call function set value default for tag
                // Add tag when upload new asset
                if (angular.isDefined($scope.selectedItems) && $scope.selectedItems.length > 0) {
                    $scope.activeTagAngParentWithTagIds($scope.selectedItems);
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

                $scope.searchName = ''; // Set value null for input search
                $scope.toggleTags();
            }

            /**
             * Set value default for tag content
             * @author Thanh Tuan <tuan@httsolution.com
             * @return Void
             */
            $scope.setValueDefaultForTag = function () {
                $timeout(function(){
                    // Remove all class active when user click in show toggle
                    $('.show-sub-tag-select').removeClass('active');
                    // Close all child tag in first level
                    $('.parrent-select').addClass('off');
                    // Format all button to toggle child is ti-plus
                    $('.toggle-child-tag').removeClass('ti-minus').addClass('ti-plus');
                })
            }

            /**
             * Toggle expanded all child tag
             * @author Thanh Tuan <tuan@httsolution.com>
             * @return {Void}
             */
            $scope.toggleTags = function () {
                $timeout(function() {
                    var tagsOfCurrentPage = [];
                    if (angular.isDefined($scope.currentPage.data)) {
                        tagsOfCurrentPage = $scope.currentPage.data.tags;
                    } else {
                        tagsOfCurrentPage = $scope.currentPage.tags;
                    }
                    // Each tag id
                    angular.forEach(tagsOfCurrentPage, function(value, key) {
                        // Checked for checkbox of tag activated
                        $('.tag-content-' + value).prop('checked', true);
                        // Set active
                        $('.show-sub-tag-select-' + value).addClass('active');
                        // Find tag
                        var tag = _.find($scope.allTags, function(obj) {return obj._id == value});
                        // Expanded all child tag
                        $scope.expandAllChildTagWithTagIds(tag['ancestor_ids']);
                    })
                })
            }

            /**
             * [activeTagAngParentWithTagIds description]
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param  {Array} tagIds Array tag ids
             * @return {Void}        
             */
            $scope.activeTagAngParentWithTagIds = function (tagIds) {
                $timeout(function() {
                    // Each tag id
                    angular.forEach(tagIds, function(value, key) {
                        // Checked for checkbox of tag activated
                        $('.tag-content-' + value).prop('checked', true);
                        // Set active
                        $('.show-sub-tag-select-' + value).addClass('active');
                        var tag = _.find($scope.allTags, function(obj) {return obj._id == value});
                        // Expanded all child tag
                        $scope.expandAllChildTagWithTagIds(tag['ancestor_ids']);
                    })
                })
            }

            /**
             * Expand all child node with parentTagIds
             * @author Thanh Tuan <tuan@httsolution.com>
             * @return {Void}
             */
            $scope.expandAllChildTagWithTagIds = function(ancestorIds) {
                $timeout(function(){
                    // Earch ancestorIds
                    for (var key in ancestorIds) {
                        // Find li parent and find first tag i and add class
                        $('.show-sub-tag-select-' + ancestorIds[key]).find("i:first").addClass('ti-minus');
                        // Toggle current ul
                        $('.parrent-select-' + ancestorIds[key]).removeClass("off");
                    }
                })
            }
        }

    }
}])
