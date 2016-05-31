@extends('app')
@section('title')
	{{trans('cms_template/template-index.title')}}
@stop
@section('content')
<a id="click-asset" href="{{URL::to('cms/asset-manager')}}" class="hide"></a>
<a id="click-page" href="{{URL::to('cms/pages')}}" class="hide"></a>
<a id="click-template" href="{{URL::to('cms/template-content-manager')}}" class="hide"></a>
<a id="click-block" href="{{URL::to('cms/block-manager')}}" class="hide"></a>
<a id="click-database" href="{{URL::to('cms/database-manager')}}" class="hide"></a>
<a id="click-manager-block" href="{{URL::to('cms/manager-block')}}" class="hide"></a>
<div ng-view></div>
@stop
@section('script')
	<script type="text/javascript">
        'use strict';
        (function($) {
            $('#page-loading').css('display','block');
            $('#resize-right .table-responsive').css('opacity','0');
            $('#resize-right .table-responsive').css('opacity','1');
        })(jQuery);
    </script>
	<script>
		window.idOfTemplateSelected = {!! json_encode($idOfItemSelected) !!};
	</script>
	{!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}
	{!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
	@if(!isProduction() && !isDev())

		{!! Html::script('app/components/pages/PageService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/pages/PageController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/pages/CreatePageController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/pages/CreatePageService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/assetmanagers/AssetManagerController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/assetmanagers/RequestAssetService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/assetmanagers/RequestAssetController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/assetmanagers/UploadNewAssetDirective.js?v='.getVersionScript())!!}

        {!! Html::script('/app/components/assetmanagers/RequestNewAssetDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/template-content-manager/templateContentManagerController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/template-content-manager/templateContentManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/template-content-manager/RequestNewTemplateDirective.js?v='.getVersionScript())!!}
		{{-- {!! Html::script('app/shared/cms-config-field/ConfigFieldController.js?v='.getVersionScript())!!} --}}
		{!! Html::script('app/shared/cms/cms-config/CmsConfigController.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/blocks/BlockManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/blocks/BlockManagerController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/blocks/RequestBlockController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/blocks/RequestBlockService.js?v='.getVersionScript())!!}

		{!! Html::script('app/components/blocks/partial/EditBlockController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/blocks/RequestNewBlockDirective.js?v='.getVersionScript())!!}

		{!! Html::script('app/components/database/DatabaseManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/database/DatabaseManagerController.js?v='.getVersionScript())!!}
		
		{!! Html::script('app/components/blocks/BlockDirective.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/tag-content-directive/tagContentDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/pages/CreatePageDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/CmsService.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/page.js') }}"></script>

	@endif
	 {!! Html::script('app/route.js?v='.getVersionScript())!!}
@stop
