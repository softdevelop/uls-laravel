$(document).ready(function(e){
	
	$(".btn-user-info").click(function(e) {
	  e.preventDefault();
	  $(".navibar-uls").toggleClass("show-u");
	});

	$(".s-open").click(function(e) {
	  e.preventDefault();
	  $(".search-form").toggleClass("s-search");
	});
	$("u-open").click(function(e) {
	  e.preventDefault();
	  $(".sub-user").toggleClass("s-search");
	});

	$("#sidebar-menu-toggle").click(function(e) {
	  e.preventDefault();
	  $("body").toggleClass("on-off");
	});
	$("#sidebar-menu-toggle-mobile").click(function(e) {
	  e.preventDefault();
	  $("body").toggleClass("on-off-mobile");
	});
	$('#sidebar').find('li').on('click', function(e){
		var href = $(this).find('a').attr('href');
		e.preventDefault(); 
		e.stopPropagation();
		$(this).toggleClass('open');
		$(this).siblings().removeClass('open');
		if(typeof href != 'undefined'){
			window.location.href = href;
		}
	});
	$('#myTabs a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})
	$("#sidebar-ticket").click(function(e) {
	  e.preventDefault();
	  $("body").toggleClass("push");
	});
	
	function activeParentSidebar(){
		var page = '';
		var pathName = window.location.pathname;

		if(pathName.indexOf('/admin/user') >= 0){
			page = '.user';
		}
		if(pathName.indexOf('/support/new') >= 0){
			page = '.support';
		}
		if(pathName.indexOf('/support/new') >= 0){
			page = '.site';
		}

		var childrenActive = $('li.hasmenu'+ page).children().find('li');
		if (childrenActive.hasClass('active')) {
			childrenActive.closest('li.hasmenu'+page).addClass('open');	
		}
	}
	activeParentSidebar();

	// $(".ti-user").on('click',function(e) {
	// 	$(this).parent().parent().parent().parent().find('.sub-menu').toggle();
	// });
	// $(".ti-settings").on('click',function(e) {
	// 	$(this).parent().parent().parent().parent().find('.sub-menu').toggle();
	// });
	
	
})


