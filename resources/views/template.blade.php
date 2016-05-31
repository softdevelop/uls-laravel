<!DOCTYPE HTML>
<html lang="en" class="template-pages" data-ng-app="uls">
@include('shared.headtpl')
<style>
   .want-to-learn:hover {
    color: #b00000!important;
}
.view-gallery:hover {
    color: #b00000!important;
}
</style>
<body >
	@include('shared.header')
	<div id="page-wrap">
		<div class="redactor-editor redactor-in redactor-relative space-template">
			@yield('content')
		</div>
	</div>
		
	@include('shared.footer')
	@include('shared.script-tpl')
	
</body>
</html>