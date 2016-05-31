var termModule = angular.module('term');

termModule.controller('TermController', ['$scope', '$modal', 'TermService', function ($scope, $modal, TermService) {

    $scope.terms = angular.copy(TermService.setTerms(window.terms));

    $scope.getModalCreateNewTerm = function() {

        var modalInstance = $modal.open({
            templateUrl: '/admin/terms/create',
            controller: 'ModalCreateTerm',
            resolve: {}
        });
        modalInstance.result.then(function(data) {

        }, function() {});
    };

    /**
     * Delete Term
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id Id term
     *
     * @return {Void}
     */
    $scope.deleteTerm = function(id){
        if (!confirm('All changes will be lost if this is changed. Do you want to proceed?')) return;
        TermService.remove(id).then(function (){
            $scope.terms = TermService.getTerms();
        });
    };

}])
.controller('ModalCreateTerm', ['$scope', '$modalInstance', 'TermService',function($scope, $modalInstance, TermService) {

    $scope.createNewTerm = function(validate)
    {
        $scope.submitted = true;
        if (validate) {
            return;
        }
        angular.element("#bt-submit").attr("disabled", "true");
        TermService.create($scope.term).then(function(data) {
            if (data.status == 0) {
                angular.element("#bt-submit").removeAttr("disabled");
                $scope.error = '';
                for (var key in data.error) {
                    $scope.error = data.error[key][0];
                }
            } else {

                window.location = "/admin/terms/edit/" + data.term._id;
            }

        });
    };
    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    };

}]);
