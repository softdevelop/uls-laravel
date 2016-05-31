<div class="navbar navbar-default navbar-fixed-top" data-role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="#sidebar-menu" data-toggle="sidebar-menu" data-effect="st-effect-3" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>
                    
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
  {{--                   <a href="{{ Url::to('/') }}" class="navbar-brand logo">
                        <img src="images/logo.png" alt="Logo">
                    </a> --}}
                </div>
                <div class="navbar-collapse collapse" id="collapse">
                   
                    <ul class="nav navbar-nav navbar-right">
                        <!-- notifications -->
                        <li class="dropdown notifications updates hidden" id="notification-top"  data-ng-controller="NotificationController">
                            @include('ticket::ticket.shared.notification')
                        </li>
                        <!-- // END notifications -->
                       
                      
                        <!-- user -->
                        <li class="dropdown user">

                              @if(Auth::check())

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                
                                    <img src="{{Auth::user()->getAvatarUrl()}}" alt="" class="img-circle" /> 
                                    {{Auth::user()->first_name}} {{Auth::user()->last_name}}<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" data-role="menu">
                                    <li><a href="{{Url::to('user/profile/'.Auth::user()->id)}}"><i class="fa fa-user"></i>Profile</a></li>
                                    <!-- <li><a href="#"><i class="fa fa-wrench"></i>Settings</a></li> -->
                                    <li><a href="{{Url::to('auth/logout')}}"><i class="fa fa-sign-out"></i>Logout</a></li>
                                </ul>
                             @endif

                        </li>
                        <!-- // END user -->
                        
                        <!-- // END country flags -->
                    </ul>
                </div>
            </div>
        </div>