// var roleModule = angular.module('role');
// // The Users directive show list users
// roleModule.directive('roles', ['$modal', 'ngTableParams', '$filter', "RoleService",
//     function($modal, ngTableParams, $filter, RoleService) {
//         return {
//             restrict: 'EA',
//             // replace: true,
//             scope: {
//                 items: '='
//             },
//             templateUrl: baseUrl + '/app/components/role/views/index.html',
//             link: function($scope, element, attr) {

//                 $scope.items_s = RoleService.setData(angular.copy($scope.items));
//                 $scope.tableParams = new ngTableParams({
//                     page: 1, // show first page
//                     count: 10, // count per page
//                     sorting: {
//                         'name': 'asc' // initial sorting
//                     }
//                 }, {
//                     total: $scope.items_s.length, // length of data
//                     getData: function($defer, params) {
//                         var orderedData = params.sorting() ? $filter('orderBy')($scope.items_s, params.orderBy()) : $scope.items_s;
//                         orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
//                         params.total(orderedData.length);
//                         $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
//                     }
//                 });


//                 $scope.delete = function(id) {
//                     if (!confirm('Do you want delete this role')) return;
//                     RoleService.remove(id).then(function(data) {
//                         $scope.tableParams.reload();
//                     });
//                 }
//                 $scope.getModalCreateRole = function(id) {
//                     var templateUrl = 'admin/user/roles/create';
//                     if (typeof id != 'undefined') {
//                         templateUrl = 'admin/user/roles/' + id + '/edit' + '?' + new Date().getTime();
//                     }
//                     var modalInstance = $modal.open({
//                         templateUrl: templateUrl,
//                         controller: 'ModalCreateRole',
//                         size: undefined,
//                         resolve: {}
//                     });
//                     modalInstance.result.then(function(selectedItem) {
//                         $scope.selected = selectedItem;
//                         $scope.tableParams.reload();
//                     }, function() {});
//                 };
//                 $scope.showGroup = function($event){
//                     var w = $(window).outerWidth();
//                     $($event.target).parent().toggleClass("ac-up");
//                      $('.group-btn-ac').css({
//                         top: $event.pageY  + 'px',
//                         right: w - $event.pageX - 30 + 'px',
//                     });
//                     $(document).on('click', function closeMenu (e){
//                         $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
//                         if($('.wrap-ac-group').has(e.target).length === 0){
//                             $('.wrap-ac-group').removeClass('ac-up');
//                         } else {
//                             $(document).one('click', closeMenu);
//                         }
//                     });
//                     angular.element('.table-responsive').addClass('fix-height');
//                 };
//             }
            
//         }
//     }
// ]).controller('ModalCreateRole', ['$scope', '$timeout', '$modalInstance', 'RoleService',function($scope, $timeout, $modalInstance, RoleService) {
//         $timeout(function() {
//             angular.element("#permission-select").select2();
            
//             if (typeof $scope.role != 'undefined') angular.element("#permission-select").select2('val', $scope.role.permissions);
//         }, 100)

//         $scope.createRole = function() {
//             angular.element("#bt-submit").attr("disabled", "true");
            
//             $scope.role.name = angular.lowercase($scope.role.name).trim().replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,"_").replace(/\s+/g,"_");
           
//             RoleService.create($scope.role).then(function(data) {
//                 if (data.status == 0) {
//                     angular.element("#bt-submit").removeAttr("disabled");
//                     $scope.error = '';
//                     for (var key in data.error) {
//                         $scope.error = data.error[key][0];
//                     }
//                 } else {
//                     $modalInstance.close(data.item);
//                 }
                
//                 // $modalInstance.close($scope.selected.item);
//             });
//         };
//         $scope.cancel = function() {
//             $modalInstance.dismiss('cancel');
//         };
//     }
// ]);