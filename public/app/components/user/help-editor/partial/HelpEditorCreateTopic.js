var helpEditorApp = angular.module('HelpEditorApp');
helpEditorApp.controller('ModelCreateTopic', ['$scope', '$modalInstance', 'parentId', 'listItemHelpEditor', '$timeout', 'HelpEditorService',
	function ($scope, $modalInstance, parentId, listItemHelpEditor, $timeout, HelpEditorService) {
	console.log()
	$scope.topic = {};

	$scope.loadData = function() {
		$scope.submitted = false;
		$scope.listItemHelpEditor = angular.copy(listItemHelpEditor);		
		$('#page-type-topic').select2({
			'placeholder': 'Choose page tyle',
		});
		$timeout(function(){
			$scope.topic.parent_id = parentId;
			$('#page-type-topic').select2().val(parentId).change();			
		})
	}

	$scope.addNewTopic = function(validate) {
		$scope.submitted = false;
		delete $scope.errors;

		if (validate) {
			$scope.submitted = true;
			return true;
		}

		$scope.topic.description = '';

		HelpEditorService.createNewTopic($scope.topic).then(function(result){
			if (!result.status && result.errors) {
				$scope.errors = result.errors;
			} else {
				$modalInstance.close(result)
			}
        });
	}

	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	}
}])