angular.module('term')
.controller('TermController', ['$scope', '$modal', function($scope, $modal) {

    $scope.showModal = function (name, label, ngModel, parentModel)
    { 
    	if(angular.isUndefined($scope[parentModel])) {
    		$scope[parentModel] = {};
    	}
    	if(angular.isUndefined($scope[parentModel][ngModel])) {

    		$scope[parentModel][ngModel] = [];
    	}
    	console.log('ticket', $scope.ticket);
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl+'/app/shared/term/view-modal.html?v=' + new Date().getTime(),
            controller: 'ModalTerm',
            resolve: {
                content: function () {
                    return window[name];
                },
                label: function() {

                	return label;
                }
            }
        });
        modalInstance.result.then(function (data) {

            $scope[parentModel][ngModel].push(data);

        }, function () {

        });    
    }

}])
.controller('ModalTerm', ['$scope', '$modalInstance','content', 'label', 
	function ($scope, $modalInstance, content, label) {

	$scope.content = content;
	$scope.label = label;
	$scope.submitted = false;

	$scope.submit = function(validate) {

		$scope.submitted = true;

	    if(validate) {
	      return; 
	    }

		$modalInstance.close($scope.currentField);
	}
    $scope.cancel = function() {

      $modalInstance.dismiss('cancel');
    };
}])