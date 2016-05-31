var templateManagerApp = angular.module('TermTemplateManagerApp');
templateManagerApp.controller ('TermTemplateManagerController', ['$scope','$filter','ngTableParams','TermTemplateManagerService', function ($scope,$filter,ngTableParams,TermTemplateManagerService) {
		angular.element('.st-container').removeClass('hidden');

		$scope.baseUrl = window.baseUrl;
		TermTemplateManagerService.setTemplates(window.templates);
		$scope.templates = TermTemplateManagerService.getTemplates();

		$scope.templateType = window.templateType;

		$scope.termId = window.termId;

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
	        getData: function($defer, params) {
                var orderedData = params.sorting() ? $filter('orderBy')($scope.templates, params.orderBy()) : $scope.templates;
                orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
                params.total(orderedData.length);
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
	    });
		
		$scope.deleteTemplate = function(id) {
			if (!confirm('Do you want delete this template?')) {
				return;
			} else {
				TermTemplateManagerService.deleteTemplate(id).then(function (data) {
					if(data.status){
						$scope.templates = TermTemplateManagerService.getTemplates();
						$scope.tableParams.reload();
					}					
				});
			}			
		};

		// $scope.viewImage = function(imgPath) {
		// 	var teamplate = '/template-manager/view-image/' + imgPath;
		// 	var modalInstance = $modal.open ({
		// 	    animation: $scope.animationsEnabled,
		// 	    templateUrl: teamplate,
		// 	    controller: 'ModalViewImage',
		// 	    size: null,
		// 	    resolve: {
		// 	    }
			    
		// 	});
		// }
}]); 

templateManagerApp.controller('ModalTermTemplateCtrl', ['$scope','$timeout','$http','Upload','TermTemplateManagerService',function ($scope,$timeout, $http,Upload,TermTemplateManagerService) {
	
	editAreaLoader.init({
		id: "html"	// id of the textarea to transform	
		,start_highlight: true	
		,font_size: "8"
		,font_family: "verdana, monospace"
		,allow_resize: "y"
		,allow_toggle: false
		,language: "en"
		,syntax: "html"	
		,toolbar: "search, |, undo, redo, |, select_font, |, syntax_selection"
		,syntax_selection_allow: "html"
		,min_height: 400
			
	});
		
	$scope.template = angular.copy(window.template);

	$scope.userFillable = window.userFillable;

	$scope.term = window.term;


  	$scope.insertViewField =function (field){

  	 	field = '{{' + field + '}}';
  	 	editAreaLoader.insertTags("html", field, "")
	 //    var start = $('#html').prop('selectionStart');
		// var end = $('#html').prop('selectionEnd');
		// var text = $('#html').val();
		// var before = text.substring(0, start);
		// var after  = text.substring(end, text.length);
		// $('#html').val(before + field + after);
		// $('#html')[0].selectionStart = $('#html')[0].selectionEnd = start + field.length;
		// $('#html').focus();
		// return true;
  		
  	}
	$scope.submitTermTemplate = function (validate) {

		// angular.element("#btnAdd").attr("disabled", "true");
		
		$scope.template.html = editAreaLoader.getValue("html");

		// $scope.template.html = $('#html').redactor('code.get');
		$scope.submitted  = true;
		if(validate) {
			angular.element("#btnAdd").removeAttr("disabled");
			return;
		} else {
        	$scope.template.termId = window.termId;
			TermTemplateManagerService.createTemplate($scope.template).then(function (data) {
				console.log(data,'ddddd');
				if (data.status == 0) {
					angular.element("#btnAdd").removeAttr("disabled");
					$scope.errors = 'The type has been exist a template';
					return;
            	} else if (data.status == 1){
	            	if( typeof $scope.template.images_add != 'undefined' && $scope.template.images_add.length > 0) {
	            		for (var i = 0; i < $scope.template.images_add.length; i++) {
							var file = $scope.template.images_add[i];
							Upload.upload({
								url: window.baseUrl + '/api/term-template-manager/upload',
								fields: {
									id_template: data.template._id
								},
								file: file
							}).progress(function (evt) {

							}).success(function (data, status, headers, config) {
								window.location.href=window.baseUrl + '/admin/terms/'+ window.termId +'/template-manager';
							});
						}
					} else {
						window.location.href=window.baseUrl + '/admin/terms/'+ window.termId +'/template-manager';
					}
            	}
			});
		}
	};

	$scope.deleteThumbnail = function(templateId) {
		if (!confirm('Do you want delete this image?')) return;
		$scope.template.thumbnail = "";
	};

	$scope.deleteImageAdd = function(index) {
		if (!confirm('Do you want delete this image?')) return;
		$scope.template.images_add.splice(index,1);
	}

// 	$scope.cancel = function () {
// 		window.location.href=window.baseUrl + '/template-manager';
// 	};
}]);

// templateManagerApp.controller('ModalViewImage', ['$scope', '$modalInstance',function ($scope, $modalInstance) {
// 	$scope.cancel = function () {
// 	    $modalInstance.dismiss('cancel');
// 	};
// }]);