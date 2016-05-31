
    {!! Html::script('js/rowboat/vendor-core.min.js')!!}
    {!! Html::script('bower_components/angular/angular.js')!!}
    {!! Html::script('bower_components/angular-resource/angular-resource.js')!!}
    {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap.js')!!}
    {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap-tpls.js')!!}
    {!! Html::script('bower_components/ng-table/dist/ng-table.js') !!}
    
    {!! Html::script('app/lib/angular-file-upload-shim.min.js')!!}
    {!! Html::script('app/lib/angular-file-upload.min.js')!!}
    {!! Html::script('app-data-option/config.js')!!}
    {!! Html::script('app-data-option/app.js')!!}  
    
    <script>
        baseUrl = '{{Url::to("/")}}';
    </script>
