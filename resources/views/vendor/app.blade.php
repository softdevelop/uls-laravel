<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Rowboat</title>
	
	<link href="{{ asset('/css/rowboat/all.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/theme-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/module-sidebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/module-essentials.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/vendor.min.css') }}" rel="stylesheet">
	
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
</head>
<body>
    <!-- Wrapper required for sidebar transitions -->
    <div class="st-container">
        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="#sidebar-menu" data-toggle="sidebar-menu" data-effect="st-effect-3" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.html" class="navbar-brand hidden-xs navbar-brand-primary">LOGO</a>
                </div>
                <div class="navbar-collapse collapse" id="collapse">
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ url('/auth/login') }}">Login</a></li>
                            <li><a href="{{ url('/auth/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- content push wrapper -->
        <div class="st-pusher">
            <!-- Sidebar component with st-effect-3 (set on the toggle button within the navbar) -->
            <div class="sidebar left sidebar-size-2 sidebar-offset-0 sidebar-skin-blue sidebar-visible-desktop" id="sidebar-menu" data-type="collapse">
                <div class="split-vertical">
                    <div class="sidebar-block tabbable tabs-icons">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#sidebar-tabs-menu" data-toggle="tab"><i class="fa fa-bars"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="split-vertical-body">
                        <div class="split-vertical-cell">
                            <div class="tab-content">
                                <div class="tab-pane active" id="sidebar-tabs-menu">
                                    <div data-scrollable>
                                        <ul class="sidebar-menu sm-icons-right sm-icons-block">
                                            <li class="active"><a href="/"><i class="fa fa-home"></i> <span>Home</span></a>
                                            </li>
                                            @if(\Auth::check())
                                                @if(\Auth::user()->hasRole('super_admin') || \Auth::user()->hasPerm('user_admin')){
                                                <li><a href="/admin/user"><i class="fa fa-user"></i> <span>User</span></a>
                                                </li>
                                                @endif
                                                @if(\Auth::user()->hasRole('super_admin')){
                                                <li><a href="/admin/user/roles"><i class="fa fa-puzzle-piece"></i> <span>Roles</span></a>
                                                </li>
                                                <li><a href="/admin/user/permissions"><i class="fa fa-magic"></i> <span>Permissions</span></a>
                                                </li>
                                                @endif
                                            @endif
                                            
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- // END .tab-content -->
                        </div>
                        <!-- // END .split-vertical-cell -->
                    </div>
                    <!-- // END .split-vertical-body -->
                </div>
            </div>
            <!-- this is the wrapper for the content -->
            <div class="st-content" id="content">
                <!-- extra div for emulating position:fixed of the menu -->
                <div class="st-content-inner">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                <!-- /st-content-inner -->
            </div>
            <!-- /st-content -->
        </div>
        <!-- /st-pusher -->
        <!-- Footer -->
      <!--   <footer class="footer">
            <strong>Rowboat</strong> Copyright 2015
        </footer> -->
        <!-- // Footer -->
    </div>
    <!-- /st-container -->

    <!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>


    {!! Html::script('js/module-sidebar.min.js')!!}
    {!! Html::script('js/vendor-core.min.js')!!}
    {!! Html::script('js/module-layout.min.js')!!}
    {!! Html::script('js/module-essentials.min.js')!!}
    {!! Html::script('js/module-media.min.js')!!}
    {!! Html::script('js/vendor-media.min.js')!!}

    
</body>
</html>