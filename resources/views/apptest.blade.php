<!DOCTYPE html>
<html lang="en" data-ng-app="app">

@include('shared.head')

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
            <div class="home-uls">
                @yield('content')
            </div>
        </div>
    </div>
    @include('shared.script')
    <script>
        $('.wrapper').removeClass('hidden');
    </script>
</body>
</html>
