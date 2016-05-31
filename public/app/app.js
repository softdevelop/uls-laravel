var defaultModules =
[
	'ui.bootstrap',
	'ngResource',
	'ngCookies',
	'ngFileUpload',
	'ngRoute',
	'toggle-switch',
	'ngImgCrop',
	'ngTable',
	'user',
	'role',
	'permission',
	'multiSelect',
	'ticket',
	'type',
	'dataOption',
	'nlcFilter',
	'file',
	'xeditable',
	'timer',
	'AppLanguage',
	'TemplateManagerApp',
	'RegionApp',
	'campaignApp',
	'campaignDetailApp',
	'MarketsegmentApp',
	'notification',
	'transApp',
	'assetManager',
	'BlockApp',
	'ChannelPartnersApp',
	'roleGroup1',
	'filedType',
	'filed',
	'term',
	'ui-iconpicker',
	'customFormatDate',
	'SeoAnalysisApp',
	'pageApp',
	'treeresizer',
	'CreatePageApp',
	'EditDraftApp',
	'fomatHtml',
	'colorpicker.module',
	'formBuilderDirectiveApp',
	'appManageTerm',
	'TermTemplateManagerApp',
	'mgo-angular-wizard',
	'configurator',
	'TemplateContentManager',
	'cmsContentFolderApp',
	'lowercaseCharater',
	'selectLevel',
	'configField',
	'cmsContentInsertApp',
	'confirmDirective',
	'CmsApp',
	'checkLimitAndChangeDateTimeDirectiveApp',
	'tagContentApp',
	'tagContentDirective',
	'cmsContentTagApp',
	'viewDraft',
	'modalSelectLevel',
	'databaseManager',
	'selectLevelDatabase',
	'modalSelectPage',
	'configFormDatabaseApp',
	'historyApp',
	'BlockNestedApp',
	'selectLevelAsset',
	'MaterialApp',
	'ui.sortable',
	'activityLog',
	'translation',
	'HelpEditorApp',
	'helpEditorDirective',
	'selectLevelHelp',
	'cache',
	'file',
	'treeresize',
	'guide',
	'PlatformsApp',
	'accessories'
];

if(typeof modules != 'undefined'){
	defaultModules = defaultModules.concat(modules);
}
var myApp = angular.module('uls', defaultModules);

angular.module('uls').run(['editableOptions',function(editableOptions) {
  	editableOptions.theme = 'bs3';
}]);
// var debug = false;
// if (angular.isDefined(window.debug)) {
// 	debug = true;
// }
angular.module('uls').config(['$logProvider', function($logProvider){
    $logProvider.debugEnabled(window.debug);
}]);

if(typeof angularMock != 'undefined'){
	defaultModules = defaultModules.concat(angularMock);
}

/**
 * go to help
 *
 * @author Quang <quang@httsolution.com>
 * 
 * @param  {string} id [id of help]
 */
var goTo = function(id) {
	window.location.href = '#_'+id;
	$('#fix-modal-top').scrollTop(0);
	if(!$('#'+id).hasClass('in')) {
		$('#'+id).prev().trigger('click');
	}
	// $('#'+id).removeAttr('style');
	// $('.sub-select-' + id).addClass('in');
}

myApp.config(['$httpProvider',function($httpProvider) {
    $httpProvider.interceptors.push(['$q',function($q) {
    	// console.log(this);
    	var deferred = $q.defer();
		  return {
		    'responseError': function(response) {
		    	var elementError = angular.element('.butterbar-container');
		      switch(response.status){
		      	case 401:
		      	console.log('dsfdsfdsfdsf');
		      	window.location.href = window.baseUrl;
		      	return;
		      	break;
		      	case 404:
		      		if(elementError.hasClass('hidden')){
		      			elementError.removeClass('hidden');
		      		}

		      	break;
		      	case 500:
		      		if(elementError.hasClass('hidden')){
		      			elementError.removeClass('hidden');
		      		}

		      	break;


		      }
	      	// jQuery.ajax({
	      	// 	url: '/log/add',
	      	// 	method: 'post',
	      	// 	data: {'response': response.data, 'status': response.status},
	      	// 	success: function(data){
	      	// 		// console.log(data);
	      	// 	}
	      	// })
	    //   $http.post('/log/error', response).
			  // success(function(data, status, headers, config) {
			    	// console.log(data);
			  // }).
			  // error(function(data, status, headers, config) {
			  	// console.log(data);
			  //   // called asynchronously if an error occurs
			  //   // or server returns response with an error status.
			  // });
	      return $q.reject(response);


	    }
	  };
	}]);
}]);


(function($){
 	function size(){
		var h = window.innerHeight;

		var winHeight = screen.height;


		$('.table-responsive.set-height, .table-responsive#tb-group-user').css({
			height: h - 170 + 'px',
		});

		$('.table-animate').css({
			height: h - 170 + 'px',
		});

		$('#search-page,.box-maps').css({
			height: h - 105 + 'px',
		});

		$('.box-list-rep').css({
			height: h - 100 + 'px',
		});

		$('#load-maps').css({
			height: h - 185 + 'px',
		});
 	};

 	$(document).ready(size);
 	$(window).resize(size);

	$(document).ready(function(){
   		$(".dropdown-menu table tr td button").removeAttr("style");
	});

	//tool html
	$(document).ready( function() {
		setTimeout(function(){
			var $head = $('#frame_html').contents().find("head");
			$head.append('<style type="text/css">.area_toolbar{background-color:#f1f1f1;}#editor{border:solid #ccc 1px}#result{border-top:solid #ccc 1px;border-bottom: solid #ccc 1px}.editarea_popup{box-shadow: 0px 4px 36px rgba(177, 177, 177, 0.75);border: solid 1px #CCCCCC;background-color: #FFFFFF;}.area_toolbar select{font-size:9pt;background-color:#fff}</style>');
		}, 1000);

	});


	$(window).load(function() {
	    $('.step3 .show-more').click(function(){
	        $('.step3 .wrap-more-product').toggleClass('show');
	    });
	});

	$(document).ready(function(){
		$('.nav-icon').click(function(){
			$(this).toggleClass('open');
			$('#pagehome').toggleClass('on-off');
		});

		// fix your ticket

	});



//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	next_fs = $(this).parent().next();

	//activate next step on progressbar using the index of next_fs
	// $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

	//show the next fieldset
	next_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();

	//de-activate current step on progressbar
	// $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

	//show the previous fieldset
	previous_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})

})(jQuery)
