@extends('app')
@section('title') Document Management @stop
@section('content')
<div class="wrap-graphic" data-ng-controller="FileController" data-ng-init="folders={{json_encode($folders)}};">
  <div class="top-content">
      <label class="c-m page-manager">
        
        <ul class="breadcrumb top-content">
          <li><a href="javascript:void(0)" ng-click="reload()"> Document Management</a></li>

          <li class="pointer" ng-repeat="item in breadcumbItems"><a ng-click="activeFolder(item.key)"><span><i class="fa icon-folder-fill"></i></span> <span class="hidden-xs">@{{item.title}}</span></a></li>
          
        </ul>
      </label>
      <a ng-if="{{Auth::user()->can('document_manger')}}" href="javascript:void(0)" ng-click="addFolder()" class="hidden-xs btn btn-primary pull-right fix-btn-top-content">
        <i class="fa fa-plus"></i> Add Folder
      </a>

      <a ng-show="breadcumbItems.length >1" ng-if="{{Auth::user()->can('document_manger')}}" href="javascript:void(0)" ng-click="deleteFolder()" class="btn btn-primary pull-right fix-btn-top-content">
        <i class="fa fa-times-circle"></i> Delete Folder
      </a>

      <!-- <a href="#tree-file" title="Sidebar Folder" data-toggle="sidebar-menu" data-effect="st-effect-1" class="toggle visible-xs add-folder-click btn btn-primary pull-right hidden-xs ">Show Menu</a> -->

      <!-- <a href="#tree-file" title="Sidebar Folder" data-toggle="sidebar-menu" data-effect="st-effect-1" class="toggle visible-xs add-folder-click btn btn-primary pull-right btn-sm ">
        <i class="fa fa-align-left"></i>
      </a> -->

      
      
      <a  title="Delete Folder" ng-show="breadcumbItems.length >1" ng-if="{{Auth::user()->can('document_manger')}}" href="javascript:void(0)" ng-click="deleteFolder()" class="toggle  btn btn-primary pull-right visible-xs btn-sm">
        <i class="fa fa-times-circle"></i>
      </a>

      <!-- <a href="#tree-file" title="Sidebar Folder" data-toggle="sidebar-menu" data-effect="st-effect-1" class="toggle visible-xs add-folder-click btn btn-primary pull-right "><i class="fa fa-align-left"></i></a> -->
      
  </div>

  <a title="Add Folder" ng-if="{{Auth::user()->can('document_manger')}}" href="javascript:void(0)" ng-click="addFolder()" class="visible-xs add-fixed-mobile">
    <i class="fa fa-plus"></i>
  </a>
  <div class="content margin-top-0">

    <div class="sidebar left sidebar-offset-0 sidebar-size-2 sidebar-skin-white sidebar-visible-desktop" id="tree-file" data-type="collapse">
      <div class="split-vertical">
          <div class="split-vertical-body">
            <div class="split-vertical-cell">
                <div data-toggle="tree" id="tree" data-ng-init="initTree()">          
              </div>
            </div>
          </div>
      </div>
    </div>
    
    <div class="content-file-right">
        
        <div class="list-up-file">
          <files data-tree show-folder-id="activeFolder(id)" delete-file="deleteFile(id)" visible-folder="visibleFolder(id)" delete-folder="deleteFolder(id,position)" open-picture="viewModel(id)" is-admin="{{Auth::user()->can('document_manger')}}" is-document-rowboat ="{{Auth::user()->can('document_manger')}} " items='items'  list-name-user='listNameUser' model="getModalCreateFile()" ></files>
          <file-manager  data-add-file="addFile" ng-if="{{Auth::user()->can('document_manger')}}" store="graphic" folder-id='currentFolderId'></file-manager><br>
        </div>
    </div>

    <div id="sidebar-resizer" 
          resizer="vertical" 
          resizer-width="0"
          resizer-left="#tree-file" 
          resizer-right=".content-file-right"
          resizer-max="500">
          
    </div>

  </div>

</div>

@stop


@section('script')
  <script type="text/javascript">
      window.files = {!! json_encode($files) !!};
      window.listNameUser = {!! json_encode($listNameUser) !!};
      window.foldersParent = {!! json_encode($foldersParent) !!};
      window.maxUpload = {!! json_encode($maxUpload) !!};
  </script>
  {!! Html::script('js/vendor-tree.min.js')!!}
  @if(!isProduction() && !isDev())
    {!! Html::script('app/shared/resize/resizeDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/file/fileController.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/file-manager/fileManagerDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/file/fileDirective.js?v='.getVersionScript())!!}
    
  @else
      <script src="{{ elixir('app/pages/graphic.js') }}"></script>
  @endif

@stop
