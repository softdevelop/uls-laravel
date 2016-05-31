var manageTermApp = angular.module('appManageTerm', ['ui.bootstrap', 'ngResource', 'ngTable']);
manageTermApp.factory('ManageTermResource',['$resource', function ($resource){
    return $resource('/api/manage-term/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}])
.service('ManageTermService', ['ManageTermResource', '$q', function (ManageTermResource, $q) {
    var that = this;
    var items = [];
    var fileAll = {};
	this.createProvider = function(data){
        console.log('data',data);
        if(typeof data['_id'] != 'undefined') {
            return that.editProvider(data);
        }
		var defer = $q.defer(); 
        var temp  = new ManageTermResource(data);
        temp.$save({}, function success(result) {
            if (result.$resolved == true){
                window.location = window.baseUrl + '/manage-term/' + data['termId'];
            }
        },
        function error(reponse) {
        	defer.resolve(reponse.data);
        });
        return defer.promise;  
	};

    this.editProvider = function(data){
        var defer = $q.defer(); 
        var temp  = new ManageTermResource(data);
        temp.$update({id: data['_id']}, function success(result) {
            window.location = window.baseUrl + '/manage-term/' + data['termId'];
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.deleteItem = function (termId, id) {
        var defer = $q.defer(); 
        var temp  = new ManageTermResource();
        temp.$delete({id: id, termId: termId}, function success(data) {
            if (data.$resolved == true){
                for (var key in items) {
                    if (items[key]._id == id){
                        items.splice(key, 1);
                        break;
                    }
                }
            }
            
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.setItems = function(data) {
        items = data;
        return items;
    }
    
    this.getItems = function()
    {
        return items;
    }

    this.getFileManagerTerm = function()
    {
        var defer = $q.defer();
        
        ManageTermResource.query({method:'file-manager-term'}, function(data) {

            for(var key in data){

                fileAll[data[key].id] = data[key];
            }
            defer.resolve(data);
        });
        return defer.promise;        
    }

    this.getFileALl = function()
    {
        return fileAll;
    }
    this.checkFile = function(type)
    {
        var images = ['png','gif','jpg', 'jpeg'];
        if(typeof type !== 'undefined'){

            if(images.indexOf(type.split('/')[1]) != -1 ){

                 return 'image';

            }else{
                
                switch(type.split('/')[1]){
                    case 'zip':
                        return 'zip';
                        break;
                    case 'pdf':
                        return 'pdf';
                        break;
                    case 'msword':
                        return 'msword';
                        break;
                    default:
                        return 'other';
                        break;
                }
            }
 
        }
       
    };
}]);
