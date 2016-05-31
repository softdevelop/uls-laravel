@extends('app_test_case')
@section('content')


@stop

@section('script')

	<script type="text/javascript">
        window.contentView = {!! json_encode($contentView) !!}
    </script>

    {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}
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
        {!! Html::script('app/components/blocks/BlockDirective.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/database/DatabaseManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/database/DatabaseManagerController.js?v='.getVersionScript())!!}
        
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/tag-content-directive/tagContentDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/pages/CreatePageDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/CmsService.js?v='.getVersionScript())!!}

        {!! Html::script('app/tests/spec/cms/pages/TestProposeNewPage.js?v='.getVersionScript())!!}

@stop
