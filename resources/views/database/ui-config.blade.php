@extends('app')
@section('title')
    Guided Configurator
@stop
@section('content')
    <div ng-controller="GuideConfiguratorController" class="wrap-content-management">
    <div class="top-content">
        <label class="c-m">{{trans('cms_database/database-index.guided_configurator')}}</label>

        <a href="javascript:void(0)" ng-click="GuideMe()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content" ng-disabled="dsbBtnDelete">
            <i class="fa fa-plus"></i> Guide Me
        </a>
    </div>
    
    <div class="visible-xs group-action-mobile">
        <div class="btn-show-group" data-toggle="collapse" data-target="#group-btn" aria-expanded="false">
            <i class="fa fa-plus"></i>
        </div>

        <div class="wrap-btn-create-circle collapse" id="group-btn">

            <div class="btn-create-circle">
                <a data-toggle="modal" ng-click="getModalCreatePage()" href="javascript:void(0)">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>

</div>
@stop

<script type="text/javascript">
    window.listAnswer = {!! json_encode(listAnswer()) !!};
    window.listALP = {!! json_encode(listALP()) !!};
</script>
    
@section('script')
    {!! Html::script('app/shared/cms-content/CmsService.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/database/GuideConfiguratorService.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/database/GuideConfiguratorController.js?v='.getVersionScript())!!}
@stop