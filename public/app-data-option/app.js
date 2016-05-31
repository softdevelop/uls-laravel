

var defaultModules = [
	'ui.bootstrap',
	'angularFileUpload',
	'ngResource',
	'ngTable',
	'dataOption'
];
if(typeof modules != 'undefined'){
	defaultModules = defaultModules.concat(modules);
}
var myApp = angular.module('rowboat', defaultModules);
