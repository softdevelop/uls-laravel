var moduleMTA = angular.module('recommended-laser-formular');

moduleMTA.controller('RecommendedLaserFormulaController', ['$scope', function ($scope) {
	var recommendedLaserFormulaCtrl = this;

	recommendedLaserFormulaCtrl.caculatorGlobalLaser = function(minMPRC, maxMPRC, data) {
		var P2GMinC = 0;
		var P2GMaxC = 0;
		var MLCC = false;
		var DLSC = false;

		var globalCaculator = {};

		// if (P2GMinC > 0 && minMPRC < P2GMinC) {
			P2GMinC = minMPRC;
		// }

		// if (maxMPRC > P2GMaxC) {
			P2GMaxC = maxMPRC;
		// }

		//Global Calculation: Material Type C02 Multiple Laser Configuration TRUE or FALSE
		var sub = P2GMaxC - P2GMinC;
		if (sub > 60) {
			MLCC = true;
		}

		if (sub > 75) {
			DLSC = true;
		}

		globalCaculator = {
			'P2GMinC' : P2GMinC,
			'P2GMaxC' : P2GMaxC,
			'MLCC' : MLCC,
			'DLSC' : DLSC,
		}
	}
	
}])