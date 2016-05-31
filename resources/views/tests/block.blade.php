@extends('app')
@section('content')


@stop

@section('script')
    <script type="text/javascript">
        window.contentTemplate = {!! json_encode($content) !!};
        window.contentCreateFolder = {!!json_encode($contentCreateFolder)!!};
        window.contentRequestBlock = {!!json_encode($contentRequestBlock)!!}
    </script>
    {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}

    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}

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
    {!! Html::script('app/tests/spec/TestBlock.js?v='.getVersionScript())!!}

@stop
