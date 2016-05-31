
var defaultModules = 
[
'ui.bootstrap',
'ngResource',
'xeditable',
'ngTable',
'ngImgCrop',
'angularFileUpload',
'user',
'role',
'permission',
'multiSelect'
];

if(typeof modules != 'undefined'){
	defaultModules = defaultModules.concat(modules);
}
var myApp = angular.module('users-rowboat', defaultModules);
(function($){
 var w = $(window).outerWidth();
 // console.log(w,'width');
 
 function size(){
  // var h = window.screen.availHeight;
  var w = $(window).outerWidth();
  // console.log(w,'width');
  var h = window.innerHeight;
  
  $('#box-role, #box-permission').css({
   height: h/2 - 113 + 'px',
  });
  $('#box-assignee').css({
   height: h - 120 + 'px',
  });
  
 };
 $(document).ready(size);
 $(window).resize(size);
 $(window).load(function(){
  $('.toggle-role').on('click', function() {
   $(this).closest('.toggle-role-p').siblings().find('.w-item-role-per').css( "display", "none" );
   $(this).closest('.toggle-role-p').find('.w-item-role-per').toggle('slow');
   $(this).find('.fa').toggleClass('fa-pluss');
   // }
  });
 });
 
})(jQuery)
