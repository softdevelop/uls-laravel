partnerApp.controller ('ChannelPartnersController', ['$scope', '$modal','$filter','ngTableParams','ChannelPartnersService', function ($scope, $modal,$filter,ngTableParams,ChannelPartnersService) {
	ChannelPartnersService.setPartners (angular.copy(window.partners));
	$scope.partners = ChannelPartnersService.getPartners();
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
        total: $scope.partners.length,
        getData: function ($defer, params) {
        	var filteredData = params.filter() ? $filter('filter')($scope.partners, params.filter()) : $scope.partners;
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
            params.total(filteredData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            
        }
    })

	$scope.getModalChannelPartners = function (id) {
		var teamplate = window.baseUrl+'/channel-partners/create';
		if(typeof id != 'undefined'){
			teamplate = window.baseUrl+'/channel-partners/'+ id + '/edit' + '?' + new Date().getTime();
		}
		var modalInstance = $modal.open ({
		    animation: $scope.animationsEnabled,
		    templateUrl: teamplate,
		    controller: 'ModalChannelPartnersCtrl', 	
		    size: null,
		    resolve: {
		    	countries : function() {
		    		return $scope.countries;
		    	}
		    }
		    
		});

		modalInstance.result.then (function (data) {
			if(data.status != 0) {
				$scope.partners = ChannelPartnersService.getPartners();
				$scope.tableParams.reload();
			}
		}, function () {

		   });
	};

	$scope.deletePartner = function (id) {
		if(!confirm('Do you want delete?')) {
			return;
		} else {
			ChannelPartnersService.deletePartner(id).then (function (data) {
				if(data.status == 1) {
					$scope.partners = ChannelPartnersService.getPartners();
					$scope.tableParams.reload();
				}
			})
		}				
	}

}]);

partnerApp.controller ('ModalChannelPartnersCtrl', ['$scope', '$modalInstance','$timeout','$http','countries','ChannelPartnersService',function ($scope, $modalInstance,$timeout, $http,countries,ChannelPartnersService) {
	$scope.countries = countries;
	$scope.partner = {};
	$scope.formatPhoneNumber = function() {
		$('#telephone').mask('(999) 999-9999? x99999',{ autoclear: false});
	}

	$scope.validatePhone = function(number){
        $scope.formData.telephone.$invalid = false;
        if(typeof number != 'undefined') {
            number = number.replace(/[^0-9]/g,'');
            if(number.length < 10) {
                $scope.formData.telephone.$invalid = true;
                $scope.formData.$invalid = true;
            }
        }
    }

	$scope.createPartner = function () {
		var number = ($scope.partner.telephone).replace(/[^0-9]/g,'');
		if (typeof $scope.partner.telephone != "undefined" && number.length < 10) {
			$scope.formData.$invalid = true;			
			return;
		} else {
			if(typeof $scope.partner.suite == 'undefined' ||  $scope.partner.suite == '') {
				$scope.partner.suite = 'null';
			}
			$scope.partner.alias_name = $scope.partner.name.replace(/\s+/g,'_').toLowerCase();
			$scope.partner.email = $scope.partner.email.toLowerCase();
			ChannelPartnersService.createPartner ($scope.partner).then (function (data) {
				if(data.status != 0) {
					$modalInstance.close (data);		
				} else {
  						$scope.errors = data.errors;
				}
			});
		}
	};

	$scope.cancel = function () {
		$modalInstance.dismiss ('cancel');
	};
}]);
