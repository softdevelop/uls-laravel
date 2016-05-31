var tagContentApp = angular.module('tagContentApp');

tagContentApp.controller('TagContentController', ['$modal', 'ngTableParams', '$timeout', '$filter', 'TagContentService', function ($modal, ngTableParams, $timeout, $filter, TagContentService){
    that = this;

    // Show search button
    this.isSearch = false;

    // Set value for tagsContent
    this.tagsContent = TagContentService.setTagContent(angular.copy(window.tagsContent));

    if (angular.isDefined(this.tagsContent)) {
        // Ng table
        this.tableParams = new ngTableParams({

            page: 1,
            count: 10,
            sorting: {
                name: 'asc'
            }

        }, {
            total: that.tagsContent.length,
            getData: function ($defer, params) {
                var orderedData = params.filter() ? $filter('filter')(that.tagsContent, params.filter()) : that.tagsContent;
                orderedData = params.sorting() ? $filter('orderBy')(orderedData, params.orderBy()) : orderedData;
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
        })  
    }

    this.getModalTagContent = function(tag, type) {

        var parentId = '0';

        if (tag != '0' && type == 'create') {
            parentId = tag._id;
        }

        if (type == 'edit') {
            var template = '/site-configuration/tag-content/'+ tag._id + '/edit' + '?' + new Date().getTime();
        } else {
            template = '/site-configuration/tag-content/create' + '?parentId=' + parentId + '&dateTime=' + new Date().getTime();
        }

        var modalInstance = $modal.open({
            animation: this.animationsEnabled,
            templateUrl: window.baseUrl + template,
            controller: 'ModalCreateTagContentCtrl',
            size: null,
            resolve: {
                parentId: function(){
                    return parentId;
                },
                type: function(){
                    return type;
                }
            }

        });

        modalInstance.result.then(function (data) {
            that.tagsContent = TagContentService.getTagContent();
            that.tableParams.reload();
            if (tag != '0') {
                $timeout(function(){
                    $('#show-sub-select-' + tag._id).addClass('in');
                    $('.btn-toggle-' + tag._id).find('i:first').removeClass('fa-plus').addClass('fa-minus');
                    angular.forEach(tag['ancestor_ids'], function(value, key) {
                        $('#show-sub-select-' + value).addClass('in');
                        $('.btn-toggle-' + value).find('i:first').removeClass('fa-plus').addClass('fa-minus');
                    })  
                })
            }
            
        }, function () {

           });
    };

    this.deleteTagContent = function(tag) {
        TagContentService.deleteTag(tag._id).then(function (data){
            that.tagsContent = TagContentService.getTagContent();
            that.tableParams.reload();
            if (tag != '0') {
                $('#show-sub-select-' + tag._id).addClass('in');
                $('.btn-toggle-' + tag._id).find('i:first').removeClass('fa-plus').addClass('fa-minus');
                angular.forEach(tag['ancestor_ids'], function(value, key) {
                    $('#show-sub-select-' + value).addClass('in');
                    $('.btn-toggle-' + value).find('i:first').removeClass('fa-plus').addClass('fa-minus');
                }) 
            }
        });
    }

    this.showGroup = function($event) {
        var w = $(window).outerWidth();

        $('.wrap-ac-group').each(function( index ) {
            $( this ).removeClass('ac-up');
        });

        $($event.target).parent().toggleClass("ac-up");


        if($('.group-btn-ac').hasClass('fix-missing-li')){
            $('.group-btn-ac').css({
                top: $event.pageY - 65 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }
        else{
            $('.group-btn-ac').css({
                top: $event.pageY - 140 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }
        $(document).on('click', function closeMenu (e){
            $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
            if($('.wrap-ac-group').has(e.target).length === 0){

                  $('.wrap-ac-group').removeClass('ac-up');

              } else {
                  $(document).one('click', closeMenu);
              }
        });
        angular.element('.table-responsive').addClass('fix-height');
    }

    this.showSubSelect = function (event, tagId) {
        event.preventDefault();
        $(event.currentTarget).addClass('fa-plus');
        $(event.currentTarget).toggleClass('fa-minus');

        // Change background color
        var colorOfParent = $(event.currentTarget).closest('tr').css('backgroundColor');
        $(event.currentTarget).closest('li').find('ul').find('tr').css('backgroundColor', colorOfParent.slice(0,-1) + ', 0.1)');
    }

}])
.controller('ModalCreateTagContentCtrl', ['$scope', '$modalInstance', 'TagContentService', 'parentId', 'type', function ($scope, $modalInstance, TagContentService, parentId, type) {

	$scope.submit = function (validate) {

        $scope.submitted = true;
        if (validate) {
            return;
        }

        $scope.tagContent.parent_id = parentId;

        TagContentService.createTagContent($scope.tagContent, type).then(function (data){
            $scope.nameExists = '';
            if(data.status == 0){
                $scope.nameExists = data.error;
            }
            else{
                $modalInstance.close(data);
            }
        });
	};

	$scope.cancel = function () {
        $modalInstance.dismiss('cancel');
	};
}])
