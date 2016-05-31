@extends('app')
@section('title')
    Test Field Type
@stop
@section('content')

<div class="roles-wrap wrap-branch" data-ng-controller="filedTypeController">
    <div class="tab-menu-field wrap-term">
        <a  href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i> Terms</a>
        <a href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
        <a class="active" href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a>
    </div>
    <div class="tab-content">
        {!! $fileType !!}

    </div>
</div>
@stop
@section('script')
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/field-type/filedTypeController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/field-type/filedTypeService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/test-field-type.js') }}"></script>
    @endif
@stop
