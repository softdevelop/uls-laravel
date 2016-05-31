
<div class="pull-left logo">
    <a href="/" target="_self" >
        <img src="/images/uls_logo.png" alt="Universal Laser Systems">
    </a>

    <!-- <a href="#sidebar-menu-toggle" class="btn-on-off hidden-xs" id="sidebar-menu-toggle">
        <span id="switch"></span>
    </a>

    <a href="#sidebar-menu-toggle" class="btn-on-off visible-xs" id="sidebar-menu-toggle-mobile">
        <span id="switch"></span>
    </a> -->

<!--     <div class="wrap-toogle-menu btn-on-off hidden-xs" id="sidebar-menu-toggle">
        <div class="nav-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
    </div> -->

    <div class="wrap-toogle-menu btn-on-off visible-xs" id="sidebar-menu-toggle-mobile">
        <div class="nav-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
    </div>

</div>
<div class="pull-right info-user">
  <ul class="nav navbar-nav">
  <!-- notification -->
    <li>
        @if(\Session::has('old_user'))
        {{-- User Become{{\Session::get('old_user')}} --}}
            @if(\Session::get('old_user') == 'stop')
                <a class="s-being-u" target="_self" href="{{URL::to('auth/logout')}}"><i class="fa fa-hand-stop-o"></i> Stop Being User</a>
            @else
                <a class="s-being-u" href="/become-user/{{Session::get('old_user')}}"><i class="fa fa-hand-stop-o"></i> Stop Being User</a>
            @endif
        @endif
    </li>
    <li class="dropdown notifications updates" id="notification-top"  data-ng-controller="NotificationController">
        @include('shared.notification')
    </li>
    <!-- the en notification -->

    <!-- messages -->
  {{--   <li class="dropdown notifications">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">
            <i class="ti-email"></i>
            <span class="badge badge-danger">2</span>
        </a>
        <ul class="dropdown-menu" role="notification">
            <li class="dropdown-header">Notification</li>
            <li class="media">
                <a href="" class="wrap-media">
                    <div class="up-top"></div>
                    <div class="media-body">
                        <img src="images/user/awatar.png" alt="" class="img-circle" width="40" height="40">
                        <span class="status">
                            <span>Matt Shearon</span> comment on your last video
                        </span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="media">
                <a href="" class="wrap-media">
                    <div class="up-top"></div>
                    <div class="media-body">
                        <img src="images/user/awatar.png" alt="" class="img-circle" width="40" height="40">
                        <span class="status">
                            <span>Matt Shearon</span> comment on your last video
                        </span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
        </ul>
    </li> --}}
    <!-- the end messages -->

    <!-- user -->
    <li class="dropdown user">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="wrap-img-onl">
                @if(Auth::user()->avatar)
                    <img ng-src="{{URL::to('avatars/'.Auth::user()->avatar)}}" alt="" class="img-circle" width="40" height="40" />
                @else
                    <img ng-src="{{URL::to('/50x50_avatar_default.png')}}" alt="" class="img-circle" width="40" height="40" />
                @endif
            </span>
            <span class="name-user hidden-xs">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
            <span class="caret" ></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li><a target="_self" href="{{URL::to('user/profile/'.Auth::user()->id)}}"><i class="fa fa-user pull-right"></i> Profile</a>
            </li>
            <li>
                <a target="_self" href="{{URL::to('auth/logout')}}"><i class="fa fa-sign-out pull-right"></i> Logout</a>
            </li>
        </ul>
    </li>
    <!-- // END user -->

  </ul>
</div>
