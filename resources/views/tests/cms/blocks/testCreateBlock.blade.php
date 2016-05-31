@extends('app_test_case')
@section('content')


@stop

@section('script')

	<script type="text/javascript">
        window.contentView = {!! json_encode($contentView) !!}
    </script>

    {!! Html::script('app/components/blocks/BlockManagerService.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/blocks/BlockManagerController.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/blocks/RequestBlockController.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/blocks/RequestBlockService.js?v='.getVersionScript())!!}

    {!! Html::script('app/components/blocks/partial/InsertBlockLinkAssetController.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/blocks/partial/UploadNewBlockController.js?v='.getVersionScript())!!}

    {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/cms-content/cmsContentInsertService.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/blocks/RequestNewBlockDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/blocks/BlockDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}

    {{-- {!! Html::script('app/shared/cms-config-field/ConfigFieldController.js?v='.getVersionScript())!!} --}}
    {!! Html::script('app/shared/cms/cms-config/CmsConfigController.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}
    {!! Html::script('/app/components/pages/EditDraftService.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/select-level-database/selectLevelDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/select-level-asset/selectLevelDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/tests/spec/cms/blocks/TestCreateBlock.js?v='.getVersionScript())!!}

@stop
