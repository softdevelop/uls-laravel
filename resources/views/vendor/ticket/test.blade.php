@extends('app')
@section('content')
<div class="page-section"  data-ng-controller="FileController">
	<div class="row">
    dsfdsfdsf
    @{{fileId}}
		<div class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">

    		<file-manager ng-model="fileIds"></file-manager>
    	</div>
    </div>
</div>
@stop
@section('scripts')
    {!! Html::script('app/lib/angular-file-upload-shim.min.js')!!}
    {!! Html::script('app/lib/angular-file-upload.min.js')!!}
    {!! Html::script('app/app.js')!!}
    {!! Html::script('app/components/file/fileController.js')!!}
    {!! Html::script('app/components/file/fileService.js')!!}
    {!! Html::script('app/shared/file/fileDirective.js')!!}
@stop