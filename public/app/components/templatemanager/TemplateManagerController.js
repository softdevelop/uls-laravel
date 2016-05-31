var templateManagerApp = angular.module('TemplateManagerApp');
templateManagerApp.controller ('TemplateManagerController', ['$scope', '$modal','$filter','ngTableParams','TemplateManagerService', function ($scope, $modal,$filter,ngTableParams,TemplateManagerService) {
		angular.element('.st-container').removeClass('hidden');
		$scope.baseUrl = window.baseUrl;
		TemplateManagerService.setTemplates(window.templates);
		$scope.templates = TemplateManagerService.getTemplates();

		$scope.tableParams = new ngTableParams({
	        page: 1,
	        count: 10,
	        sorting: {
	            name: 'asc'
	        },
	        filter: {
                name: ''
            }        
	    }, {
	        total: $scope.templates.length,
	        getData: function ($defer, params) {
	        	var filteredData = params.filter() ? $filter('filter')($scope.templates, params.filter()) : $scope.templates;
	            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
	            params.total(filteredData.length);
	            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
	            
	        }
	    });
		$scope.getModalTemplate = function (id) {
			var teamplate = '/template-manager/create';
			if(typeof id != 'undefined'){
				teamplate = '/template-manager/'+ id + '/edit' + '?' + new Date().getTime();
			}
			var modalInstance = $modal.open ({
			    animation: $scope.animationsEnabled,
			    templateUrl: teamplate,
			    controller: 'ModalTemplateCtrl',
			    size: null,
			    resolve: {
			    }
			    
			});

			modalInstance.result.then(function (template) {
				$scope.tableParams.reload();
			}, function () {

			   });
		};


		$scope.deleteTemplate = function(id) {
			if (!confirm('Do you want delete this template?')) {
				return;
			} else {
				TemplateManagerService.deleteTemplate(id).then(function (data) {
					if(data.status){
						$scope.templates = TemplateManagerService.getTemplates();
						$scope.tableParams.reload();
					}					
				});
			}			
		};

		$scope.viewImage = function(imgPath) {
			var teamplate = '/template-manager/view-image/' + imgPath;
			var modalInstance = $modal.open ({
			    animation: $scope.animationsEnabled,
			    templateUrl: teamplate,
			    controller: 'ModalViewImage',
			    size: null,
			    resolve: {
			    }
			    
			});
		}
}]); 

templateManagerApp.controller('ModalTemplateCtrl', ['$scope','$timeout','$http','TemplateManagerService','Upload',function ($scope,$timeout, $http,TemplateManagerService,Upload) {
	// $scope.hasImageThumbPosition =  = false;
	$scope.baseUrl = window.baseUrl;
	$scope.numberOptions = [];
	$scope.fieldNumber = [];

	$scope.addFieldTemplate = function() {
		$scope.fieldNumber.push($scope.fieldNumber.length);

		// var maxLength = $scope.fieldNumber.length;

		// /*create new an option*/
		// if ($scope.fieldNumber.indexOf(maxLength) != -1 || maxLength <= $scope.fieldNumber[maxLength-1]) {
		// 	$scope.fieldNumber.push($scope.fieldNumber[maxLength - 1] + 1);
		// } else {
		// 	$scope.fieldNumber.push(maxLength);
		// }

		// /*get last option*/
		// var maxLengthAfter = $scope.fieldNumber.length;
		// var currentF = "";
		// var price = "";
		// if($scope.template.fields) {
		// 	price = $scope.template.fields[$scope.fieldNumber[[maxLengthAfter-1]]];
		// 	currentField = $scope.template.fields[$scope.fieldNumber[maxLengthAfter-1]];
		// }

		// /*set default value for current value in input*/
		// ($scope.template.fields && currentField && currentField != null)?delete $scope.template.fields[$scope.fieldNumber[maxLengthAfter-1]].quantity:[];
		// ($scope.template.fields && price && price != null)?delete $scope.template.fields[$scope.fieldNumber[[maxLengthAfter-1]]].price:[];

	};

	$scope.deleteFieldTemplate = function(index) {
		var currentField = [];
		/*get current value of fields that not be removed*/
		if(typeof $scope.template.fields != 'undefined') {
			var listFields = $scope.template.fields;
			for (i in $scope.template.fields) {
				if(i!=index) {
					currentField.push(listFields[i])
				}
			}
			// delete $scope.template.fields;
			$scope.template.fields = currentField;
		}
		$scope.fieldNumber.splice($scope.fieldNumber.length-1, 1);
		/*remove field is chosen*/
		// $timeout(function() {
		// }, 10);

	};

	$scope.getTemplate = function(template){
		$scope.template = template;

		if(angular.isUndefined(template._id)) return;

		//formnat positions
		for(var key in $scope.template.sections) {
			$scope.numberOptions.push(key);
			if(angular.isUndefined($scope.template.sections)) {
				$scope.template.sections = [];
			}
			$scope.template.sections[key] = $scope.template.sections[key];
		}

		//formnat fields
		for(var key in $scope.template.fields) {
			$scope.fieldNumber.push(key);
			if(angular.isUndefined($scope.template.fields)) {
				$scope.template.fields = [];
			}
			$scope.template.fields[key] = $scope.template.fields[key];
		}
	}
	/*add field price for form*/
	$scope.addPositionTemplate = function() {
		$scope.numberOptions.push($scope.numberOptions.length);
		// var maxLength = $scope.numberOptions.length;

		// /*create new an option*/
		// if ($scope.numberOptions.indexOf(maxLength) != -1 || maxLength <= $scope.numberOptions[maxLength-1]) {
		// 	$scope.numberOptions.push($scope.numberOptions[maxLength - 1] + 1);
		// } else {
		// 	$scope.numberOptions.push(maxLength);
		// }

		// /*get last option*/
		// var maxLengthAfter = $scope.numberOptions.length;
		// var currentQuantity = "";
		// var price = "";
		// if($scope.template.sections) {
		// 	price = $scope.template.sections[$scope.numberOptions[[maxLengthAfter-1]]];
		// 	currentQuantity = $scope.template.sections[$scope.numberOptions[maxLengthAfter-1]];
		// }

		// /*set default value for current value in input*/
		// ($scope.template.sections && currentQuantity && currentQuantity != null)?delete $scope.template.sections[$scope.numberOptions[maxLengthAfter-1]].quantity:[];
		// ($scope.template.sections && price && price != null)?delete $scope.template.sections[$scope.numberOptions[[maxLengthAfter-1]]].price:[];
	};

	/**
	 * [deleteThumbPosition description]
	 * @param  {[type]} key [description]
	 * @return {[type]}     [description]
	 */
	$scope.deleteThumbPosition = function(key){
		if (!confirm('Do you want delete this image?')) return;
		delete $scope.template.sections[key].thumbnail;
		// if(typeof $scope.template._id == 'undefined') {
		// 	delete $scope.template.sections[key].file_name;
		// } else {
		// 	var fileName = $scope.template.sections[key].file_name;
		// 	var templateId = $scope.template._id;
		// 	TemplateManagerService.deleteThumbnailPosition(templateId, fileName).then(function (data) {
		// 		if (data.status) {
		// 			$scope.templates = TemplateManagerService.getTemplates();
		// 			for(i in $scope.templates) {
		// 				if($scope.templates[i]._id == $scope.template._id) {
		// 					$scope.template = $scope.templates[i];
		// 				}
		// 			}
		// 		} else {
		// 			$scope.errors = "Can't delete image";
		// 		}
		// 	});
		// }
	}

	/*remove field*/
	$scope.removePositionTemplate = function(index) {
		var currentPosition = [];
		/*get current value of fields that not be removed*/
		if(typeof $scope.template.sections != 'undefined') {
			var listPosition = $scope.template.sections;
			for (i in listPosition) {
			if(i!=index) {
				currentPosition.push(listPosition[i])
			}
		}
			delete $scope.template.sections[currentPosition.length];
			$scope.template.sections = currentPosition;
		}
		/*remove field is chosen*/
		$timeout(function() {
			$scope.numberOptions.splice($scope.numberOptions.length-1, 1);
		}, 10);

	};

	$scope.sections = [];
	 // upload on file select or drop
    $scope.upload = function (file, key) {
    	if(angular.isUndefined(file)) return;
        Upload.upload({
            url: window.baseUrl+ '/api/template-manager/upload/position',
            file: file
        }).then(function (resp) {

        	if(angular.isUndefined($scope.template.sections)) {
        		$scope.template.sections = [];
        	}
        	if(angular.isUndefined($scope.template.sections[key])) {
        		$scope.template.sections[key] = {};
        	}
        	$scope.template.sections[key].thumbnail = resp.data.thumbnail;
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
        });
    };

	$scope.submitTemplate = function (validate) {
		console.log(validate,'h');
		$scope.submitted  = true;
		if(validate) {
			return;
		} else {
			angular.element('#page-loading').css('display','block');
        	$scope.template.file = $scope.template.name.replace(/\s+/g,'_').toLowerCase();
			TemplateManagerService.createTemplate($scope.template).then(function (data) {
				if (data.status == 0) {
					$scope.errors = 'The template has been exist';
					angular.element('#page-loading').css('display','none');
					return;
            	} else if (data.status == 1){
	            	if( typeof $scope.template.images_add != 'undefined' && $scope.template.images_add.length > 0) {
	            		for (var i = 0; i < $scope.template.images_add.length; i++) {
							var file = $scope.template.images_add[i];
							Upload.upload({
								url: window.baseUrl + '/api/template-manager/upload',
								fields: {
									id_template: data.template._id,
									aliastitle_template : data.template.file,
									i : i
								},
								file: file
							}).progress(function (evt) {

							}).success(function (data, status, headers, config) {
								window.location.href=window.baseUrl + '/template-manager';
							});
						}
					} else {
						window.location.href=window.baseUrl + '/template-manager';
					}
            		// $modalInstance.close(data.template);
            	}
			});
		}
	};

	$scope.deleteThumbnail = function(templateId) {
		if (!confirm('Do you want delete this image?')) return;
		$scope.template.thumbnail = "";
		// TemplateManagerService.deleteThumbnail(templateId).then(function (data) {
		// 	if (data.status) {
		// 		$scope.templates = TemplateManagerService.getTemplates();
		// 		$scope.template.thumbnail = '';
		// 	} else {
		// 		$scope.error = "Can't delete image";
		// 	}
		// });
	};

	$scope.deleteImageAdd = function(index) {
		if (!confirm('Do you want delete this image?')) return;
		$scope.template.images_add.splice(index,1);
	}

	$scope.cancel = function () {
		window.location.href=window.baseUrl + '/template-manager';

	    // $scope.template = angular.copy(window.template);
	    
	    // /*Reset sections*/
	    // $scope.numberOptions = [];
	    // for(i in $scope.template.sections) {
	    // 	$scope.numberOptions.push(i);
	    // }

	    // /*Reset field*/
	    // $scope.fieldNumber = [];
	    // for(i in $scope.template.fields) {
	    // 	$scope.fieldNumber.push(i);
	    // }
	};
}]);

templateManagerApp.controller('ModalViewImage', ['$scope', '$modalInstance',function ($scope, $modalInstance) {
	$scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	};
}]);