configFormDatabaseApp.controller('ConfigFormDatabaseManagerController', ['$scope', '$modal', 'ngTableParams','$timeout','ConfigformDatabaseService', '$filter', 
    function ($scope, $modal, ngTableParams, $timeout, ConfigformDatabaseService, $filter){
        $scope.table = angular.copy(window.table); // Set first value

        var nameTable = $scope.table.name;

        // Call function to general form for table
        $scope.generalForm = function(tableName) {
            if (angular.isDefined($scope.table.fields) && $scope.table.fields.length == 0) {
                var msg = 'Do you want to general form?'; // Message
                if (window.confirm(msg)) { // If user confirm to general form    
                    // Call function general form of page
                    ConfigformDatabaseService.generalForm(tableName).then(function (data){
                        $scope.table = data.table;
                        console.log($scope.table, '$scope.table');
                    });
                }
            }
        }

        $scope[nameTable] = {};
        $scope.submit = function (tableName, validate) {
            $scope.submitted = false;

            if (validate) {
                $scope.submitted = true;
                return;
            }
            console.log($scope[tableName], 'dsa')
        }
}])
.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode){
        return $sce.trustAsHtml(htmlCode); // render code to show html
    }
}])
.filter('formatText', function() {
    return function(input) {
        var text = input.replace(/_/gi, " ");
        return text[0].toUpperCase() + text.slice(1);;
    }
})


