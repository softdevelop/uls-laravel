var partnerApp = angular.module ('ChannelPartnersApp', ['ui.bootstrap','ngSanitize' ,'ngResource','ngTable']);

partnerApp.factory ('ChannelPartnersResource', ['$resource',function($resource) {
	return $resource ('/api/channel-partners/:method/:id', {method: '@method', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'},
        delete: {method: 'delete'}
	});
}]);


partnerApp.service ('ChannelPartnersService', ['ChannelPartnersResource','$q', function (ChannelPartnersResource, $q) {
	var that = this;
    this.createPartner = function (data) {

        if(typeof data['id'] != 'undefined') {
            return that.editPartner(data);
        }
		var defer = $q.defer ();
		var temp = new ChannelPartnersResource (data);
		temp.$save({},function success (data) {
			defer.resolve (data);
            if(data.status != 0) {
                partners.push(data.partner);
            }
	    }, function error (reponse) {
			defer.resolve (reponse);
		});
		return defer.promise;
	};

	this.editPartner = function (data) {

		var defer = $q.defer ();
		var temp = new ChannelPartnersResource (data);
		temp.$update ({id:data['id']}, function success (data){
			if(data.status){
                for(var key in partners) {
                    if(partners[key]['id'] == data['partner']['id']){
                         partners[key] = data['partner'];
                         break;
                    }
                }
            }
            defer.resolve(data);
		},
		function error (respone){
			defer.resolve(respone.data);
		});
		return defer.promise;
	};

	this.deletePartner = function (id) {
		var defer = $q.defer();
		var temp = new ChannelPartnersResource (id);
		temp.$delete ({id:id}, function success (data){
			if(data.status == 1) {
                for (var key in partners) {
                    if(partners[key]['id'] == id) {
                        partners.splice(key,1);
                        break;
                    }
                }
            }
            defer.resolve (data);
		},
		function error (respone){
			defer.resolve (respone.data);
		});
		return defer.promise;
	};

    this.setPartners = function (data){
        partners = data;
        return partners;
    }

    this.getPartners = function () {
        return partners;
    }

}]);