{{-- <div id="page-loading" style="display: none;" class="overlay-loading">
    <span class="loading-icon"><i class="fa fa-spinner fa-pulse fa-fw margin-bottom"></i></span>
</div> --}}

<div id="page-loading" class="overlay-loading none">
  <div class="spin-box"></div>
</div>
<div class="butterbar-container hidden"><span id="butterbar">An unexpected error has occurred. Please try again later.</span></div>
{!! Html::script('bower_components/jquery/dist/jquery.min.js')!!}
<script type="text/javascript">
  window.debug = {!! isDebug() !!};
</script>

<script>
  $(document).ready(function(){
    $('#tag-roles').click(function(){
        $('.session-roles').addClass('in');
        $('.session-user-admin').removeClass('in');
        $('.session-permissions').removeClass('in');
    });
    $('#tag-permission').click(function(){
        $('.session-permissions').addClass('in');
        $('.session-roles').removeClass('in');
        $('.session-user-admin').removeClass('in');
    });
  });
</script>

{!! Html::script('app/lib/socket.io-1.3.4.js') !!}

@yield('scripts-modules')
@if(!isProduction() && !isDev())
  {!! Html::script('scripts/main.js')!!}
  {!! Html::script('scripts/vendor.js?v=1')!!}
  {!! Html::script('scripts/modernizr.js')!!}
  {!! Html::script('bower_components/jquery-ui/jquery-ui.min.js')!!}
  {!! Html::script('bower_components/jquery.maskedinput/dist/jquery.maskedinput.min.js')!!}
  {!! Html::script('bower_components/fancytree/dist/jquery.fancytree-all.min.js')!!}
  {!! Html::script('bower_components/fancytree/dist/src/jquery.fancytree.dnd.js')!!}
  {!! Html::script('bower_components/fancytree/dist/src/jquery.fancytree.edit.js')!!}
  {!! Html::script('bower_components/underscore/underscore.js')!!}

  {!! Html::script('bower_components/angular/angular.js')!!}
  {!! Html::script('bower_components/angular-resource/angular-resource.js')!!}
  {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap.min.js')!!}
  {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js')!!}
  {!! Html::script('bower_components/ng-table/dist/ng-table.min.js')!!}
  {!! Html::script('bower_components/ngImgCrop/source/js/init.js')!!}
  {!! Html::script('bower_components/ngImgCrop/source/js/ng-img-crop.js')!!}
  {!! Html::script('bower_components/ngImgCrop/compile/minified/ng-img-crop.js')!!}
  {!! Html::script('bower_components/pusher/dist/pusher.min.js')!!}
  {!! Html::script('bower_components/angular-cookies/angular-cookies.js')!!}
  {!! Html::script('bower_components/angular-xeditable/dist/js/xeditable.js') !!}
  {!! Html::script('bower_components/angular-sanitize/angular-sanitize.js')!!}
  {!! Html::script('bower_components/moment/min/moment.min.js')!!}
  {!! Html::script('bower_components/moment/min/locales.min.js')!!}
  {!! Html::script('bower_components/humanize-duration/humanize-duration.js')!!}
  {!! Html::script('bower_components/angular-timer/dist/angular-timer.js')!!}

  {{-- {!! Html::script('bower_components/angular-ui-router/release/angular-ui-router.min.js')!!} --}}
  {!! Html::script('bower_components/angular-animate/angular-animate.js')!!}
  {!! Html::script('bower_components/angular-wizard/dist/angular-wizard.min.js')!!}


  {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}


  {!! Html::script('bower_components/magnific-popup/dist/jquery.magnific-popup.js')!!}
  {!! Html::script('bower_components/magnific-popup/dist/jquery.magnific-popup.min.js')!!}
  <!-- jquery highcharts -->
  {!!Html::script('bower_components/highcharts/highcharts.js')!!}
  {!!Html::script('bower_components/angular-route/angular-route.js')!!}
  {{-- {!! Html::script('bower_components/angular-ui-utils/modules/mask/mask.js')!!} --}}
  {!! Html::script('app/lib/tool-tip/tool-tip.js')!!}


  {!! Html::script('app/app.js') !!}
  {!! Html::script('app/config.js') !!}
  {!! Html::script('app/baseController.js')!!}

  {{-- {!! Html::script('app/route.js')!!} --}}
  {!! Html::script('app/components/user/userService.js')!!}
  {!! Html::script('app/components/assetmanagers/AssetManagerService.js')!!}
  {!! Html::script('app/shared/notification/notificationController.js')!!}
  {!! Html::script('app/shared/notification/notificationService.js')!!}
  {!! Html::script('app/shared/notification/notificationDirective.js')!!}
  {!! Html::script('app/shared/validate/rowboatValidateDirective.js')!!}
  {!! Html::script('app/shared/format-date/formatDate.js') !!}
  {!! Html::script('app/shared/translation/transFilter.js') !!}

  {!! Html::script('app/shared/filters/elapsedTime.js')!!}

  {!! Html::script('app/lib/redactor1023/redactor/redactor.js?v='.getVersionScript())!!}
  {!! Html::script('app/lib/redactor1023/redactor/table.js?v='.getVersionScript())!!}
  {!! Html::script('app/lib/redactor1023/redactor/source.js?v='.getVersionScript())!!}
  {!! Html::script('app/lib/redactor1023/redactor/insertlink.js?v='.getVersionScript())!!}
  {!! Html::script('app/lib/redactor1023/redactor/insertpage.js?v='.getVersionScript())!!}
  {!! Html::script('app/shared/ng-file-upload/ng-file-upload-all.js?v='.getVersionScript())!!}

  {!!Html::script('app/components/user/help-editor/HelpEditorDirective.js')!!}

@else
  <script src="{{ elixir('app/pages/library.js') }}"></script>
@endif
{!! Html::script('app/lib/codemirror/lib/codemirror.js')!!}
{!! Html::script('app/lib/codemirror/addon/search/searchcursor.js')!!}
{!! Html::script('app/lib/codemirror/addon/search/search.js')!!}
{!! Html::script('app/lib/codemirror/addon/dialog/dialog.js')!!}
{!! Html::script('app/lib/codemirror/addon/edit/matchbrackets.js')!!}
{!! Html::script('app/lib/codemirror/addon/edit/closebrackets.js')!!}
{!! Html::script('app/lib/codemirror/addon/comment/comment.js')!!}
{!! Html::script('app/lib/codemirror/addon/wrap/hardwrap.js')!!}
{!! Html::script('app/lib/codemirror/addon/display/placeholder.js')!!}
{!! Html::script('app/lib/codemirror/addon/fold/foldcode.js')!!}
{!! Html::script('app/lib/codemirror/addon/fold/brace-fold.js')!!}
{!! Html::script('app/lib/codemirror/mode/javascript/javascript.js')!!}
{!! Html::script('app/lib/codemirror/keymap/sublime.js')!!}


{{-- {!! Html::script('app/lib/codemirror/addon/display/fullscreen.js')!!} --}}
{!! Html::script('app/lib/codemirror/mode/htmlmixed/htmlmixed.js')!!}
{!! Html::script('app/lib/codemirror/mode/xml/xml.js')!!}
{!! Html::script('app/lib/codemirror/mode/clike/clike.js')!!}
{!! Html::script('app/lib/codemirror/mode/php/php.js')!!}


{{-- {!! Html::script('app/lib/redactor1023/redactor/redactor.js?v='.getVersionScript())!!} --}}
{{-- {!! Html::script('app/lib/redactor1023/redactor/table.js?v='.getVersionScript())!!} --}}
{{-- {!! Html::script('app/lib/redactor1023/redactor/insertblock.js?v='.getVersionScript())!!} --}}

{{-- {!! Html::script('app/lib/redactor1023/redactor/source.js?v='.getVersionScript())!!} --}}
{{-- {!! Html::script('app/lib/redactor1023/redactor/insertlink.js?v='.getVersionScript())!!} --}}
{{-- {!! Html::script('app/lib/redactor1023/redactor/insertpage.js?v='.getVersionScript())!!} --}}
{{-- {!! Html::script('app/lib/redactor1023/redactor/insertasset.js?v='.getVersionScript())!!} --}}
{{-- {!! Html::script('app/lib/redactor1023/redactor/parsercontent.js?v='.getVersionScript())!!} --}}


{!! Html::script('bower_components/notify.js/notify.js')!!}

{{-- {!! Html::script('bower_components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')!!} --}}
<!-- ui-iconpicker Script -->
{!! Html::script('bower_components/ui-iconpicker/dist/scripts/ui-iconpicker.min.js')!!}

<!-- Angular switch bootstrap -->
{!! Html::script('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js')!!}
{!! Html::script('bower_components/angular-toggle-switch/angular-toggle-switch.min.js')!!}


<!-- jquery spectrum color picker -->
{!!Html::script('bower_components/spectrum/spectrum.js')!!}

<!-- jquery  multiselect -->
{!!Html::script('assets/forms_elements_multiselect/js/jquery.multi-select.js')!!}
{!!Html::script('assets/forms_elements_multiselect/js/multiselect.init.js')!!}

<!-- jquery  select 2 -->
{!!Html::script('bower_components/select2/dist/js/select2.min.js')!!}

<!-- angular-sortable -->
{!!Html::script('bower_components/angular-ui-sortable/sortable.min.js')!!}


<script type="text/javascript">

  window.baseUrl = '{{URL::to("")}}';
  window.maxUpload   = {!!json_encode(uploadMaxFile())!!};
  window.userId = {!! Auth::user()->id !!};
  window.hashData = {!! json_encode(getHashData()) !!};
  window.usersMap = {!! json_encode(getUsersMap()) !!};
  window.testFuture = {!! json_encode(testFuture()) !!};
  window.isTime = {!! json_encode(checkIsTime(Auth::user()->id))!!}
  window.listsAsset = {!! json_encode(getFileImagesAsset())!!}
  window.translations = {!! json_encode(trans('js/js'))!!}

  window.dataOptionMap = {!! json_encode(getDataOptionsMap()) !!};

  window.socketURL = '{{env("SOCKET_URL", "http://localhost:8891")}}';
  window.urlFrontEnd = '{{ env("url_front_end", "http://demo.ulsinc.com") }}';

  window.isAdvancedEditingFeatures = {!! json_encode(Auth::user()->can('advanced_editing_features')) !!}

// $(document).ready(function() {
//     $('#rootwizard').bootstrapWizard();
// });

</script>

@if(isTesting())
  {!!Html::script('bower_components/jasmine-core/lib/jasmine-core/jasmine.js')!!}
  {!!Html::script('bower_components/jasmine-core/lib/jasmine-core/jasmine-html.js')!!}
  {!!Html::script('bower_components/jasmine-core/lib/jasmine-core/boot.js')!!}
  {!! Html::script('bower_components/angular-mocks/angular-mocks.js')!!}
   <script type="text/javascript">

        var angularMock = ['ngMock'];
    </script>

@endif
@yield('script')
{!! Html::script('app/shared/fomat-html/fomatHtml.js?v=' . getVersionScript() )!!}

<script>
  var RowboatPusher = {
            init: function(){
                this.socket = io(window.socketURL);
            },
            socket: null,
            subscribe: function(channel){
                return {
                    channel: channel,
                    bind: function(event, callback){
                        RowboatPusher.socket.on(this.channel+':'+event, callback)
                    }
                }
            }
        }
        RowboatPusher.init();
</script>

@if(isProduction() && isDev())
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>
@endif

