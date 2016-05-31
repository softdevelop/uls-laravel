<!DOCTYPE Html>
<Html lang="en" data-ng-app="uls">
{{-- <head> --}}
    @include('shared.head')
{{-- </head> --}}
<body id="pagehome">
    <div class="wrapper hidden" id="on-off-menu">
        <div id="navibar">
            <a href="" class="btn-user-info visible-xs">
                <i class="ti-view-grid"></i>
            </a>
            <div class="col-lg-12 navibar-uls">
                @include('shared.navbar')
            </div>
        </div>
        <div id="sidebar">
            <div class="side-bar" >
                @include('shared.sidebar')
            </div>
        </div>
        <div id="content-uls" class="content-uls">
            <div class="tpl-tiket" data-ng-controller="TicketController">
                <div class="content-ticket ticket-bg">
                    @include('ticket::ticket.shared.sidebar')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('shared.script')
</body>
</Html>

