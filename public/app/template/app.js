
var defaultModules = 
[
	'ngResource',
	'viewDraft'
];

if(typeof modules != 'undefined'){
	defaultModules = defaultModules.concat(modules);
}
angular.module('uls', defaultModules);