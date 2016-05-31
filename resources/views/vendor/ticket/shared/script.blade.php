<div class="butterbar-container hidden"><span id="butterbar">An unexpected error has occurred. Please try again later.</span></div>

<!-- Scripts -->
     <script>
    var config = {
        theme: "admin",
        skins: {
            "default": {
                "primary-color": "#3498db"
            }
        }
    };
    window.userId = {!! Auth::user()->id !!};
    window.hashData = {!! json_encode(getHashData()) !!};
    window.usersMap = {!! json_encode(getUsersMap()) !!};
    window.pusherConfig = {!! json_encode(getPusherConfig()) !!}
    </script>


    {!! Html::script('js/vendor-core.min.js')!!}
    {!! Html::script('js/vendor-forms.min.js')!!}
    {!! Html::script('js/vendor-media.min.js')!!}
    {!! Html::script('js/module-essentials.min.js')!!}
    {!! Html::script('js/module-layout.min.js')!!}
    {!! Html::script('js/module-sidebar.js')!!}
    {!! Html::script('js/module-media.min.js')!!}
    
    {!! Html::script('js/bootstrap-datepicker.js')!!}
    {!! Html::script('js/bootstrap-datepicker.init.js')!!}
    

    {!! Html::script('js/bootstrap-switch.js')!!}
    {!! Html::script('js/bootstrap-switch.init.js')!!}

    {!! Html::script('bower_components/angular/angular.js')!!}
    {!! Html::script('bower_components/angular-resource/angular-resource.js')!!}

    {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap.js')!!}
    {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap-tpls.js')!!}
    {!! Html::script('bower_components/angular-cookies/angular-cookies.js')!!}
    {!! Html::script('bower_components/angular-xeditable/dist/js/xeditable.js') !!}
    {!! Html::script('bower_components/cryptojslib/rollups/aes.js')!!}
    {!! Html::script('bower_components/cryptojslib/rollups/pbkdf2.js')!!}
    {!! Html::script('bower_components/ngImgCrop/source/js/init.js')!!}
    {!! Html::script('bower_components/ngImgCrop/source/js/ng-img-crop.js')!!}
    {!! Html::script('bower_components/ngImgCrop/compile/minified/ng-img-crop.js')!!}

    {!! Html::script('bower_components/momentjs/min/moment.min.js')!!}
    {!! Html::script('bower_components/momentjs/min/locales.min.js')!!}
    {!! Html::script('bower_components/humanize-duration/humanize-duration.js')!!}      
    {!! Html::script('bower_components/angular-timer/dist/angular-timer.js')!!}  

     <!-- Create the modal dynamically via Handlebars -->
    {!! Html::script('bower_components/momentjs/min/moment.min.js')!!}
    {!! Html::script('bower_components/momentjs/min/locales.min.js')!!}
    {!! Html::script('bower_components/humanize-duration/humanize-duration.js')!!}      
    {!! Html::script('bower_components/angular-timer/dist/angular-timer.js')!!}

    {!! Html::script('bower_components/angular-sanitize/angular-sanitize.js')!!} 

    {!! Html::script('bower_components/ng-table/dist/ng-table.js') !!}

    {!! Html::script('js/fuelux-checkbox.init.js')!!}
    
    <script>
    baseUrl = '{{Url::to("/")}}';
    // var modules = ['ngCookies'];
    </script>
   
    @if(!isProduction())
    {!! Html::script('app/lib/angular-file-upload-shim.min.js')!!}
    {!! Html::script('app/lib/angular-file-upload.min.js')!!}
    {!! Html::script('app/config.js')!!}
    {!! Html::script('app/app.js')!!} 
    {!! Html::script('app/baseController.js')!!}
    @endif
    @yield('scripts-modules')
