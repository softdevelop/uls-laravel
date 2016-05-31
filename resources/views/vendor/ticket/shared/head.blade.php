<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1.5, user-scalable=yes">

	<base href="{!!URL::to('/')!!}">
	<title>@yield('title') | UNVERSAL</title>
    {{-- <link rel="icon" type="image/png" href="favicon.ico"> --}}
    <!-- Fonts -->
    {!! Html::style('css/fonts/glyphicons_filetypes.css')!!}
    {!! Html::style('css/fonts/glyphicons_regular.css')!!}
    {!! Html::style('css/fonts/glyphicons_social.css')!!}
    {!! Html::style('css/fonts/font-awesome.css')!!}
	{!! Html::style('css/vendor.min.css') !!}
	{!! Html::style('css/theme-bundle.min.css')!!}
	
	{!! Html::style('css/module-essentials.min.css') !!}
    {!! Html::style('css/module-layout.min.css')!!}
    {!! Html::style('css/module-sidebar.min.css')!!}
    {!! Html::style('css/module-sidebar-skins.min.css')!!}
    {!! Html::style('css/module-navbar.min.css')!!}
    {!! Html::style('css/module-media.min.css')!!}
    {!! Html::style('css/module-timeline.min.css') !!}
    {!! Html::style('css/module-chat.min.css')!!}
    
    {!! Html::style('css/bootstrap-switch.css')!!}

    {!! Html::style('css/bootstrap-datepicker.css')!!}

   
    {!! Html::style('css/dropzone.css')!!}
    
    

    
    {!! Html::style('css/rowboat/all.css?v='.getVersionCss())!!}
    
	<!-- the end Fonts -->
     {!! Html::style('bower_components/angular-xeditable/dist/css/xeditable.css')!!}

     @yield('style')
	<!-- Html5 shim and Respond.js for IE8 support of Html5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/Html5shiv/3.7.2/Html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    <script type="text/javascript">
        var baseUrl = '{!!URL::to('/')!!}';
    </script>
    {!! Html::script('bower_components/pusher/dist/pusher.min.js')!!}