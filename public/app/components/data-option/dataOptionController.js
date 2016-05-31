var dataOption = angular.module('dataOption');

dataOption.controller('DataOptionController', ['$scope', 'DataOptionService', '$modal', '$filter', 'ngTableParams', function($scope, DataOptionService, $modal, $filter, ngTableParams) {
    angular.element('.st-container').removeClass('hidden');
    $scope.options = DataOptionService.setDataOption(window.options);

    $scope.tableParams = new ngTableParams({
        page: 1,
        count: 10
    }, {
        total: $scope.options.length,
        getData: function($defer, params) {

            var orderedData = params.sorting() ? $filter('orderBy')($scope.options, params.orderBy()) : $scope.options;
            console.log('orderedData', orderedData);
            orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
            params.total(orderedData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });


    $scope.getModalCreate = function(group, $index) {
            var tmp = window.baseUrl + '/site-configuration/data-option/create';
            var modalInstance = $modal.open({
                templateUrl: tmp,
                controller: 'createDataOptionModalCtrl',
                size: undefined,
                windowClass: 'modal fade mod_branch_overview closecollapsibles',
                resolve: {
                    group: function() {
                        return group;
                    },
                    index: function() {
                        return $index;
                    }
                }
            });
            modalInstance.result.then(function(option) {

                $scope.options = DataOptionService.getDataOption();
                $scope.tableParams.reload();
            }, function() {});
        }
    /**
     * [delete description]
     * @param  {[type]} id    [description]
     * @param  {[type]} index [description]
     * @return {[type]}       [description]
     */
    $scope.delete = function(id, index) {
        var r = confirm("Do you want delete dropdown?");
        if (r == true) {
            DataOptionService.remove(id).then(function(data) {
                $scope.options = DataOptionService.getDataOption();
                $scope.tableParams.reload();
            });
        }

    }

}]).controller('createDataOptionModalCtrl', ['$scope', '$modalInstance', 'DataOptionService', 'group', 'index', function($scope, $modalInstance, DataOptionService, group, index) {
    if (typeof group != 'undefined') {
        $scope.index = index;
        $scope.dataOption = angular.copy(group);
        if (typeof $scope.dataOption != 'undefined') {
            if (typeof $scope.dataOption.table_name != 'undefined') {
                $scope.dataOption.checkTable = true;
                console.log($scope.dataOption.table_name);
                $scope.dataOption.dataTable = $scope.dataOption.table_name;
                $scope.dataOption.option = [];
            }
        }
        console.log($scope.dataOption);
        $scope.options = $scope.dataOption.option;
    }
    $scope.createOption = function(validate) {
        $scope.submitted = false;
        if (validate) {
            return;
        }

        $scope.options = [];
        for (var i = 0; i < $scope.dataOption.number_option; i++) {
            $scope.options.push(i)
        }
    }
    $scope.create = function(validate) {
        $scope.submitted = true;
        if (!$scope.dataOption) return;
        if ((validate && !$scope.dataOption.checkTable) || ($scope.dataOption.checkTable && !$scope.dataOption.dataTable)) {
            return;
        }
        DataOptionService.create($scope.dataOption).then(function(data) {
            if (data.status == 422) {
                $scope.error = 'Label exists !';
            } else {
                $modalInstance.close(data);
            }

        })
    }

    $scope.updating = false;
    $scope.update = function(validate) {
        angular.element('#page-loading').css('display', 'block');
        $scope.submitted = true;
        if (validate) return;
        if (typeof $scope.dataOption._id['$id'] != 'undefined') {
            $scope.dataOption._id = $scope.dataOption._id['$id'];
        }
        $scope.updating = true;
        DataOptionService.update($scope.dataOption).then(function(data) {
            $scope.updating = false;
            $modalInstance.close({
                data: data,
                index: $scope.index
            });

            angular.element('#page-loading').css('display', 'none');

        })
    }
    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }
}])