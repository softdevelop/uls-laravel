var templateManagerApp = angular.module('TemplateManagerApp');

templateManagerApp.factory('TemplateManagerResource', ['$resource',function($resource) {
	return $resource('/api/template-manager/:method/:action/:id', {method: '@method', action: '@action', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'},
        deleteImage: {method: 'delete'}
	});
}]);

templateManagerApp.service('TemplateManagerService', ['TemplateManagerResource','$q', function (TemplateManagerResource, $q) {
	var that = this;
	this.createTemplate = function(data) {
		if(typeof data['_id'] != 'undefined') {
			return that.editTemplate(data);
		}

    	var defer = $q.defer();
    	var temp = new TemplateManagerResource(data);
    	 temp.$save({},function success(data) {
                // if(data.status != 0) {
                // 	templates.push(data.template);
                // }
                defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse);
            });
		return defer.promise;
	};

	this.editTemplate = function(data) {
		var defer = $q.defer();
		var temp = new TemplateManagerResource(data);
		temp.$update({id:data['_id']},function success(data) {
			// if(data.status){
			// 	for(var key in templates) {
   //                  if(templates[key]['_id'] == data['template']['_id']){
   //                       templates[key] = data['template'];
   //                       break;
   //                  }
   //          	}
			// }			
			defer.resolve(data);
		},
		function error (respone) {
			defer.resolve(respone.data);
		});
		return defer.promise;
	};

	this.deleteTemplate = function(id) {
		var defer = $q.defer();
		$temp = new TemplateManagerResource();
		$temp.$delete({id:id},function success(data) {
			if(data.status){
                for(var key in templates) {
                    if(templates[key]['_id'] == id) {
                        templates.splice(key,1);
                        break;
                    }
                }
        	}
			defer.resolve(data);
		},
		function error (respone) {
			defer.resolve(respone.data);
		});
		return defer.promise;
	};

	// this.deleteThumbnailPosition = function (templateId, fileName) {
	// 	var defer = $q.defer();
	// 	$temp = new TemplateManagerResource();
	// 	$temp.$deleteImage({action: 'delete-image-position',id:templateId,name:fileName},function success(data) {
	// 		if(data.status) {
	// 			for(var key in templates) {
	// 				if(templates[key]['_id'] == templateId) {
	// 					templates[key].sections = data.sections;
	// 				}
	// 			}
	// 		}
	// 		defer.resolve(data);
	// 	},
	// 	function error (respone) {
	// 		defer.resolve(respone.data);
	// 	});
	// 	return defer.promise;
	// };

	this.deleteThumbnail = function (templateId) {
		var defer = $q.defer();
		$temp = new TemplateManagerResource();
		$temp.$deleteImage({action: 'delete-image',id:templateId},function success(data) {
			if(data.status) {
				for(var key in templates) {
					if(templates[key]['_id'] == templateId) {
						templates[key].thumbnail = '';
					}
				}
			}
			defer.resolve(data);
		},
		function error (respone) {
			defer.resolve(respone.data);
		});
		return defer.promise;
	};

	this.setTemplates = function(data) {
		templates = data;
		return templates;
	};

	this.getTemplates = function() {

		return templates;
	};
}]);