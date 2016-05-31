var tagContentApp = angular.module('tagContentApp');

tagContentApp.controller('TagContentController', ['$modal' 'ngTableParams', '$timeout', '$filter', function ($modal, ngTableParams, $timeout, $filter){
    this.isSearch = false;
    this.tagsContent = TagContentService.setTagContent(angular.copy(window.tagsContent));

    $scope.tableParams = new ngTableParams({

        page: 1,
        count: 10,
        filter: {
            name: ''
        },
        sorting: {
            name: 'asc'
        }

    }, {
        total: this.tagsContent.length,
        getData: function ($defer, params) {
            var orderedData = params.filter() ? $filter('filter')($scope.data, params.filter()) : this.tagsContent;
            orderedData = params.sorting() ? $filter('orderBy')(orderedData, params.orderBy()) : orderedData;
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    })

}])
.controller('ModalCreateTagContentCtrl', ['$modalInstance', function ($modalInstance) {

	$scope.submit = function (validate) {

	};

	$scope.cancel = function () {

	};
}])
