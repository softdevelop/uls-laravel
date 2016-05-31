var historyApp = angular.module('historyApp');
historyApp.controller('HistoryController', ['$scope', '$modal', '$filter', 'ngTableParams', '$http', '$window', '$timeout', '$filter', '$cookieStore','$controller', 
    function ($scope, $modal, $filter, ngTableParams, $http, $window, $timeout, $filter, $cookieStore,$controller){
        $controller('BaseController', { $scope: $scope });
        $scope.callbackLoadUserFinish = function(){
    
        };
        $scope.isSearch = false;
        $scope.items = angular.copy(window.histories);
        $scope.tableParams = new ngTableParams({
        page: 1,
        count: 50,
        sorting: {
            'id': 'desc'
        },
        }, {
            total: $scope.items.length,
            getData: function($defer, params) {
                var orderedData = params.sorting() ? $filter('orderBy')($scope.items, params.orderBy()) : $scope.items;
                orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
                params.total(orderedData.length);
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
        });

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
                    top: $event.pageY - 50 + 'px',
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
}])