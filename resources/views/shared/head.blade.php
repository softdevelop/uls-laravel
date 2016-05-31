<head>
	@if(Request::is('cms/*'))
		<base href="/">
	@endif
	<meta charset="utf-8">
	<title>
		@yield('title') | UNIVERSAL
	</title>
	<meta name="description" content="">
	<!-- <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> -->
	<meta name="viewport" content="width=device-width">
	<link rel="icon" href="{{URL::to('favicon.ico')}}" type="image/x-icon" />

	{!!Html::style('bower_components/fontawesome/css/font-awesome.min.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/ui-iconpicker/dist/styles/ui-iconpicker.min.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/fancytree/dist/skin-lion/ui.fancytree.min.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/magnific-popup/dist/magnific-popup.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/bootstrap/dist/css/bootstrap.min.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/ng-table/dist/ng-table.min.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/angular-xeditable/dist/css/xeditable.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/angular-wizard/dist/angular-wizard.css?v='.getVersionCss())!!}

	{!!Html::style('bower_components/angular-toggle-switch/angular-toggle-switch-bootstrap.css?v='.getVersionCss())!!}
	{!!Html::style('bower_components/angular-toggle-switch/angular-toggle-switch.css?v='.getVersionCss())!!}


	{!!Html::style('app/lib/redactor1023/redactor/redactor.css?v='.getVersionCss())!!}

	<!-- Link bootstrap switch -->
	{!!Html::style('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css?v='.getVersionCss())!!}

	<!-- Link spectrum color picker -->
	{!!Html::style('bower_components/spectrum/spectrum.css?v='.getVersionCss())!!}

	<!-- Link  multiselect -->
	{!!Html::style('assets/forms_elements_multiselect/css/multi-select.css?v='.getVersionCss())!!}

	<!-- Link select 2 -->
	{!!Html::style('bower_components/select2/dist/css/select2.min.css?v='.getVersionCss())!!}

	{!! Html::style('app/lib/codemirror/lib/codemirror.css')!!}
	{!! Html::style('app/lib/codemirror/addon/display/fullscreen.css')!!}
	{!! Html::style('app/lib/codemirror/theme/night.css')!!}

	{!! Html::style('app/lib/codemirror/addon/fold/foldgutter.css')!!}
	{!! Html::style('app/lib/codemirror/addon/dialog/dialog.css')!!}
	{!! Html::style('app/lib/codemirror/theme/monokai.css')!!}

	

	@if(isTesting())
	  {!!Html::style('bower_components/jasmine-core/lib/jasmine-core/jasmine.css')!!}
	@endif

	{{-- {!! Html::style('app/lib/codemirror/theme/night.css')!!} --}}

	@if(!isProduction() && !isDev())
		{!! Html::style('assets/css/all.css?v='.getVersionCss())!!}
	@else
		<link rel="stylesheet" href="{{ elixir('assets/css/all.css') }}">
	@endif
	{!! Html::style('css/fix-css.css?v='.getVersionCss())!!}

</head>
