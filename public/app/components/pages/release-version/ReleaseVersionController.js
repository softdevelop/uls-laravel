var pageApp = angular.module('pageApp');
pageApp.controller('ReleaseVersionController', ['$scope', '$modal', 'ngTableParams', '$timeout', '$filter', 'ReleaseVersionService', function ($scope, $modal, ngTableParams, $timeout, $filter, ReleaseVersionService){
    
    $scope.versions = ReleaseVersionService.setReleaseVersion(angular.copy(window.versions));

    $scope.tableParams = new ngTableParams({
        page: 1,
        count: 100,
        sorting: {
            title: 'asc'
        },
        filter: {
               // title:''
            }

    }, {
        total: $scope.versions.length,
        getData: function ($defer, params) {
            /* Filter and sort data */
            var filteredData = params.filter() ? $filter('filter')($scope.versions, params.filter()) : $scope.versions;
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
            params.total(filteredData.length);
            if (params.total() <= params.count()) {
                params.page(1);
            } else {
                if (params.total() % params.count() == 0  && params.total() / params.count() < params.page() && params.page() != 1) {
                    params.page(params.page()-1);
                }
            };

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
           /* $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));*/
        }
    });

    /**
     * set height table release table
     *
     * @author Cong Hoan <hoan@httsolution.com>
     *
     * @return Void
    */
    $(window).resize(function (){
        $scope.setDIVHeight();
    });

    $scope.setDIVHeight = function() {
        var Height_Version_History =  $('.box-with-title-body.release-table');

        var offset = Height_Version_History.offset();

        var offsetTop = offset.top;

        var winHeight = $(window).height();

        var divHeight = winHeight - offsetTop - 21;

        Height_Version_History.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
    }
    // end 

    $scope.showGroup = function($event) {
        var hBox = $('.group-btn-ac').outerHeight();
        var w = $(window).outerWidth();
        var h = $(window).outerHeight();
        var point = $event.pageY;
        var check = h - point;

        if (check < 300) {
            $('.wrap-ac-group').each(function( index ) {
                $( this ).addClass('show-top');
            });
        };

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
                top: $event.pageY - 70 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }
        $(document).on('click', function closeMenu (e){
            $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
            if($('.wrap-ac-group').has(e.target).length === 0){

                  $('.wrap-ac-group').removeClass('ac-up');
                  $('.wrap-ac-group').removeClass('show-top');

              } else {
                  $(document).one('click', closeMenu);
              }
        });
        angular.element('.table-responsive').addClass('fix-height');
    }

    // Lists version to show in select
    $scope.versionShowInSelect = window.versionShowInSelect;

    /**
     * Show version in select production domain
     * @return {Text} [description]
     */
    $scope.showVersionsProduction = function() {
        var selected = $filter('filter')($scope.versionShowInSelect, {value: $scope.versionProduction.version});
        return ($scope.versionProduction.version && selected.length) ? selected[0].text : 'Not set';
    };

    /**
     * Show version in select demo domain
     * @return {Text} [description]
     */
    $scope.showVersionsDemo = function() {
        var selected = $filter('filter')($scope.versionShowInSelect, {value: $scope.versionDemo.version});
        return ($scope.versionDemo.version && selected.length) ? selected[0].text : 'Not set';
    };

    $scope.changeVersion = function(newVer, oldVer, type) {
        if(newVer == oldVer) return;
        $scope.data = {};
        $scope.data.newVersion = newVer;
        $scope.data.oldVersion = oldVer;
        $scope.data.type = type;
        ReleaseVersionService.changeVersion($scope.data).then(function (data){
            window.versions = data.currentVersion;
            if($scope.isPastVersion) {                
                $scope.versions = ReleaseVersionService.setReleaseVersion(data.pastVersion);
            } else {
                $scope.versions = ReleaseVersionService.setReleaseVersion(angular.copy(window.versions));
            }
            $scope.tableParams.reload();
        });
    };

    $scope.getModalCreateRelease = function(id){
        var template = '/site-configuration/release-manager/create?v=' + new Date().getTime();
        if(typeof id != 'undefined'){
            template = '/site-configuration/release-manager/'+ id + '/edit?v=' + new Date().getTime();
        }
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + template,
            controller: 'ModalReleaseVersionCtrl',
            size: null,
            resolve: {
            }
            
        });

        modalInstance.result.then(function (data) {
            if (angular.isDefined(data.versionShowInSelect)) {
                $timeout(function() {
                    $scope.versionShowInSelect = data.versionShowInSelect;
                });
            }
            $scope.data = ReleaseVersionService.getReleaseVersion();
            $scope.tableParams.reload();
        }, function () {

           });
    };

    $scope.removeReleaseRevision = function(id){
        ReleaseVersionService.deleteReleaseVersion(id).then(function (){
            $scope.data = ReleaseVersionService.getReleaseVersion();
            $scope.tableParams.reload();
        });
    };

    $scope.getPastVersion = function() {
        $scope.isPastVersion = true;
        ReleaseVersionService.getPastVersion().then(function (){
            $scope.versions = ReleaseVersionService.getReleaseVersion();
            console.log($scope.versions,'$scope.data')
            $scope.tableParams.reload();
        });
    }

    $scope.hidePastVersion = function() {
        $scope.isPastVersion = false;
        $scope.versions = ReleaseVersionService.setReleaseVersion(angular.copy(window.versions));
        $scope.tableParams.reload();
    }

}]);

pageApp.controller('ModalReleaseVersionCtrl', ['$scope', '$modalInstance', 'ReleaseVersionService', function ($scope, $modalInstance, ReleaseVersionService) {

    $scope.requireVersion = true;

    $scope.requireDescription = true;

    $scope.submit = function (validate) {

        $scope.submitted  = true;

        if(validate){
            return;
        }

        if ($scope.release.version) {
            $scope.requireVersion = false;
        }

        if ($scope.requireVersion) {
            return;
        }

        if ($scope.requireDescription) {
            return;
        }

        ReleaseVersionService.createReleaseVersionProvider($scope.release).then(function (data){
            if(data.status == 0){
                $scope.errors = data.error;
            }
            else{
                $modalInstance.close(data);
            }
        })
    };

    $scope.$watch('release.version', function(newValue, oldValue) {
        if (angular.isDefined(newValue)) {
            $scope.requireVersion = false;
        } else {
            $scope.requireVersion = true;
        }
    });

    $scope.$watch('release.description', function(newValue, oldValue) {
        if (angular.isDefined(newValue) && newValue.length != 0) {
            $scope.requireDescription = false;
        } else {
            $scope.requireDescription = true;
        }
    });

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
}]);