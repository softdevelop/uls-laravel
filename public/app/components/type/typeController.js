
var typeModule = angular.module('type');

typeModule.controller('TypeController', ['$scope', 'TypeService', '$modal','$filter','ngTableParams', function($scope, TypeService, $modal,$filter,ngTableParams) {
    angular.element('.wrapper').removeClass('hidden');
    $scope.getAllType = function(){
        TypeService.query().then(function(data){
             $scope.items = data;
             $scope.tableParams = new ngTableParams({
                page: 1,
                count: 50,
                sorting: {
                    'name': 'asc'
                }
                }, {
                total: $scope.items.length,
                getData: function($defer, params) {
                    var orderedData = params.sorting() ? $filter('orderBy')($scope.items, params.orderBy()) : $scope.items;
                    orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
                    params.total(orderedData.length);
                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                }

            })
         })
        .then(function(){

        })
    }
    $scope.delete = function(id){
        if (!confirm('System will remove all tickets of this type. Do you want delete it?')) return;
        TypeService.remove(id).then(function(data){
            $scope.tableParams.reload();
        })
    }
    $scope.getModalCreate = function(id){
        var templateUrl = '/support/type/create';
        if (typeof id != 'undefined') {
            templateUrl = '/support/type/' + id + '/edit' + '?' + new Date().getTime();
        }
        var modalInstance = $modal.open({
            templateUrl: templateUrl,
            controller: 'ModalCreate',
            size: undefined,
            resolve: {
                
            }
        });
         modalInstance.result.then(function(item) {
            $scope.items = TypeService.getTypes();
            $scope.tableParams.reload();
         }, function () {});
    }
}])
.controller('ModalCreate',['$scope','$modalInstance','$filter','TypeService',function($scope,$modalInstance, $filter,TypeService){
    $scope.ticketAdmin = {};
    $scope.ticketAssignee = {};

    $scope.setValue = function() {
        $scope.type = angular.copy(window.type);
    }

   $scope.transString = function() {
        if(angular.isDefined($scope.type.position_show)) {
            $scope.type.position_show = type.position_show.toString();
            $scope.type.position_show = $scope.type.position_show == '0' ? '' : $scope.type.position_show;
            console.log($scope.type.position_show,'$scope.type.position_show');
        }
   }
   function getPermissions(permission, update)
   {
    TypeService.getPermissions().then(function(data){
        $scope.ticketAdmin = $filter('orderBy')(data.ticketAdmin, '-name');
        $scope.ticketAssignee = $filter('orderBy')(data.ticketAssignee, '-name');
        console.log(permission);
         if(!angular.isUndefined(permission))
        {
            angular.forEach(permission, function(value, key){

                if(value.pivot.ticket_admin == 1)
                {
                    $scope.type.ticketAdmin = value.id;

                }else
                {
                    $scope.type.ticketAssignee = value.id;
                }
           });
           
        }
        if(! angular.isUndefined(update))
        {
             window.location.reload();
        }
        
     });
   }

    getPermissions();

    $scope.create = function(update){
        angular.element("#bt-submit").attr("disabled", "true");
        if(typeof $scope.type.id == 'undefined'){
            $scope.type.alias = angular.lowercase($scope.type.name).replace(/\s+/g,'_');
        }
        
        TypeService.create($scope.type).then(function(data){
            
            if(data.status == 0){
                angular.element("#bt-submit").removeAttr("disabled");
                $scope.errors = [];
                for(var key in data.error){
                    $scope.errors.push(data.error[key][0]);
                }
            }else{
                var permission = data.item.pemissions;
                delete $scope.errors;
                 getPermissions(permission, update);
                 $scope.type.id = data.item.id;
            }
        })
    }
    $scope.cancel = function(){
        $modalInstance.close();
    }

}])
