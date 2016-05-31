@extends('app')
@section('title')
    {{trans('cms_asset/crop-image.tile')}}
@stop
@section('content')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.12/css/jquery.Jcrop.min.css" />
<div ng-controller="CropImageAssetController" class="content-crop-asset hidden" ng-init="setDIVHeight()">
    <div class="top-content">
        <label class="c-m">{{trans('cms_asset/crop-image.breadcrumb')}}
        </label>
    </div>
    <div class="top-edit-crop">
        <div class="wrap-conent-edit-crop">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="input-group">

                    <span class="input-group-addon control-label hightlight-lb">{{trans('cms_asset/crop-image.size_label')}}</span>
                        {!!
                            Form::select(
                                'size',
                                $assetFileSize,
                                null,
                                array(
                                    'class'=>'form-control',
                                    'name'=>'size',
                                    'ng-model'=>'size'
                                )
                            )
                        !!}
                </div>
            </div>

             <a ng-click="crop()" class="btn btn-primary btn-crop" href="">
                <i class="fa fa-check"></i> {{trans('cms_asset/crop-image.submit_btn')}}
            </a>
            <div class="clearfix"></div>

        </div>

    </div>
    <div class="content content-crop-images">
        <div rowboat-jcrop="obj.src" ng-model="imageCroped" config="obj.config" ratio="ratio" size="size" ng-show="!isFinishedCrop">

        </div>
    </div>
</div>
@stop
@section('scripts-modules')
    <script type="text/javascript">
        var modules = ['rowboatJcrop'];
    </script>
@stop

@section('script')
    <script type="text/javascript">
        window.assetFile = {!! json_encode($assetFile) !!};
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.12/js/jquery.Jcrop.min.js"></script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/crop-image/cropImageAssetController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/rowboat-jcrop/rowboatJcropDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/crop.js') }}"></script>
    @endif

@stop

<script type="text/ng-template" id="imageCropPreview.html">
    <div class="modal-header">
        <button ng-click="cancel()" class="close ng-scope" type="button"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Result</h4>
        </div>
    <div class="modal-body text-center wrap-review-cr">
        <div class="review-cr">
            <img src="@{{imageSrc}}" alt="">
        </div>

    </div>

    <div class="modal-footer">
        <a class="btn btn-primary" type="button" ng-click="ok()"><i class="fa fa-check"></i> Save</a>
    </div>
</script>
