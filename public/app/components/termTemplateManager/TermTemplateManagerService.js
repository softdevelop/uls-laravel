var termTemplateManagerApp = angular.module('TermTemplateManagerApp');

termTemplateManagerApp.factory('TermTemplateManagerResource', ['$resource',function($resource) {
	return $resource('/api/term-template-manager/:method/:action/:id', {method: '@method', action: '@action', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'},
        deleteImage: {method: 'delete'}
	});
}]);

termTemplateManagerApp.service('TermTemplateManagerService', ['TermTemplateManagerResource','$q', function (TermTemplateManagerResource, $q) {
	var that = this;
	this.createTemplate = function(data) {
		if(typeof data['_id'] != 'undefined')
		{
			return that.editTemplate(data);
		}

    	var defer = $q.defer();
    	var temp = new TermTemplateManagerResource(data);
    	 temp.$save({},function success(data) {
                defer.resolve(data);                
            },
            function error(reponse) {
               defer.resolve(reponse);
            });
		return defer.promise;
	};

	this.editTemplate = function(data)
	{
		var defer = $q.defer();
		var temp = new TermTemplateManagerResource(data);
		temp.$update({id:data['_id']},function success(data) {
			defer.resolve(data);
		},
		function error (respone) {
			defer.resolve(respone.data);
		});
		return defer.promise;
	};

	this.deleteTemplate = function(id)
	{
		var defer = $q.defer();
		$temp = new TermTemplateManagerResource();
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
	

	this.setTemplates = function(data) {
		templates = data;
		return templates;
	};

	this.getTemplates = function() {

		return templates;
	};
}]);