
<!DOCTYPE Html>

<html id="login" lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rowboat</title>
        <base href="{!!URL::to('/')!!}">
        {!! Html::script('js/vendor-forms.min.js')!!}
        {!! Html::style('css/vendor.min.css') !!}
        {!! Html::style('css/theme-bundle.min.css')!!}
        {!! Html::style('css/module-layout.min.css')!!}
        {!! Html::style('assets/css/all.css')!!}

        <!-- Fonts -->
        {!! Html::style('css/fonts/glyphicons_filetypes.css')!!}
        {!! Html::style('css/fonts/font-awesome.css')!!}
        <!-- Html5 shim and Respond.js for IE8 support of Html5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/Html5shiv/3.7.2/Html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            var baseUrl = '{!!URL::to('/')!!}';
        </script>
    </head>

    <body id="login_body" class="wrap-auth">
        <div class="content-auth">      
        @yield('content')
        </div> 
        <a href="#" title="Explore Mortgage Branch Opportunities Across the Country" id="outbound">
            Mortgage Branch Opportunities
        </a>
        {!! Html::script('js/vendor-core.min.js')!!}
        {!! Html::script('js/vendor-forms.min.js')!!}
        {!! Html::script('js/module-layout.min.js')!!}
        <!-- UItoTop plugin -->
        {!! Html::script('js/jquery.ui.totop.min.js')!!}
        <!-- Template JS -->
        {!! Html::script('js/template.js')!!}
        {!! Html::script('js/fuelux-checkbox.init.js')!!}

    </body>

</html>