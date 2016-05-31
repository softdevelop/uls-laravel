<div class="navbar navbar-default navbar-fixed-top" data-role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="#sidebar-menu" data-toggle="sidebar-menu" data-effect="st-effect-3" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only">{{ trans('configuration/data-option/shared/navbar.toggle_navigation') }}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                 
                </div>
                <div class="navbar-collapse collapse" id="collapse">
                   
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown user">

                              @if(Auth::check())

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                
                                    <img src="{{Auth::user()->getAvatarUrl()}}" alt="" class="img-circle" /> 
                                    {{Auth::user()->first_name}} {{Auth::user()->last_name}}<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" data-role="menu">
                                    <li><a href="{{Url::to('user/profile/'.Auth::user()->id)}}"><i class="fa fa-user"></i>{{ trans('configuration/data-option/shared/navbar.profile') }}</a></li>
                                 
                                    <li><a href="{{Url::to('auth/logout')}}"><i class="fa fa-sign-out"></i>{{ trans('configuration/data-option/shared/navbar.logout') }}</a></li>
                                </ul>
                             @endif

                        </li>
                        <!-- // END user -->
                        
                        <!-- // END country flags -->
                    </ul>
                </div>
            </div>
        </div>