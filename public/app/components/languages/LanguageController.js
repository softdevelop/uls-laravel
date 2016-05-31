languageApp.controller('LanguageControler', ['$scope', '$modal', '$filter', 'ngTableParams', 'LanguageService', function ($scope, $modal, $filter, ngTableParams, LanguageService) {
	$scope.isSearch = false;
	$scope.data = LanguageService.setLanguages(angular.copy(window.languages));

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
        total: $scope.data.length,
        getData: function ($defer, params) {
        	var orderedData = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
        	orderedData = params.sorting() ? $filter('orderBy')(orderedData, params.orderBy()) : orderedData;
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    })

	$scope.getModalLanguage = function(id){
		var teamplate = '/site-configuration/languages/create';
		if(typeof id != 'undefined'){
			teamplate = '/site-configuration/languages/'+ id + '/edit' + '?' + new Date().getTime();
		}
		var modalInstance = $modal.open({
		    animation: $scope.animationsEnabled,
		    templateUrl: window.baseUrl + teamplate,
		    controller: 'ModalLanguageCtrl',
		    size: null,
		    resolve: {
		    }
		    
		});

		modalInstance.result.then(function (data) {
			$scope.data = LanguageService.getLanguages();
			$scope.tableParams.reload();
			
		}, function () {

		   });
	};

	$scope.removeLanguage = function(id){
		LanguageService.deleteLanguage(id).then(function (){
			$scope.data = LanguageService.getLanguages();
			$scope.tableParams.reload();
		});
	};

}]);
languageApp.controller('ModalLanguageCtrl', ['$scope', '$modalInstance', 'LanguageService', function ($scope, $modalInstance, LanguageService) {
	$scope.codeExists == '';
	$scope.nameExists == '';

	$scope.submit = function (validate) {
		$scope.submitted  = true;
  		if(validate){
			return;
  		}
  		$scope.language.alias_name = $scope.language.name.replace(/\s+/g,'_').toLowerCase();
  		$scope.language.code = $scope.language.code.toLowerCase();
		LanguageService.createLanguageProvider($scope.language).then(function (data){
			$scope.nameExists = '';
			$scope.codeExists = '';
			if(data.status == 0){
				$scope.errors = data.error;
			}
			else{
				$modalInstance.close(data);
			}
		})
	};

	$scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	};
}]);

(function() {
    'use strict';

    app.directive('rowboatLength', ['$compile', function($compile) {
        return {
            restrict: 'A',

            require: 'ngModel',

            scope: {
                rowboatLength: '@',
                model: '=ngModel'
            },

            link: function($scope, $element, $attrs, ngModel) {
                $scope.$watch('model', function() {
                	var content = '';
                	var value = $element.val();

                	if(!$element.hasClass('ng-dirty') && (!value|| value == null)) return;

                    var isValid = (value.length == $scope.rowboatLength);

					if (isValid) {
						$element.parent().find('span').remove();
						$element.parent().removeClass('error');
					} else {
						if ($element.parent().find('span').length == 0) {
							$element.parent().addClass('error');
							var content = '<span class="control-label">Length is '+$scope.rowboatLength+'</span>';
							$element.parent().append(content);
						}
					}
					ngModel.$setValidity($attrs.ngModel, isValid);
                    
				});
				$element.on('blur', function() {
                    var content = '';
                	var value = $element.val();

                    if ($element.parent().find('span').length == 0 || !value) {
	                	$element.parent().find('span').remove();
						$element.parent().removeClass('error');

	                	if (!value) {
	                		$element.parent().addClass('error');
	                		var content = '<span class="control-label">This field is require</span>';
							$element.parent().append(content);
		                	ngModel.$setValidity($attrs.ngModel, false);
	                	}
	                }
				});
			}
        }
    }]);
})();