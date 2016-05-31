
<!--  dont use -->

@extends('app')
@section('title')
    {{ trans('configuration/tag-content/new-tag.tag_content_management') }}
@endsection
@section('content')
    <div class="wrap-branch" data-ng-controller="TagContentController as tagcontent">
        <div class="top-content">
            <label class="c-m">{{ trans('configuration/tag-content/new-tag.tag_content_management') }}
            </label>

            <a data-toggle="modal" ng-click="tagcontent.getModalTagContent('0', 'create', 'showColor')" class="btn btn-primary fix-btn-top-content pull-right">
                <i class="fa fa-plus"></i> {{ trans('configuration/tag-content/new-tag.tag_content') }}
            </a>
        </div>
        <div class="content tag-content">
            <ul class="style-ul">
                <li class="second" ng-repeat="(index, value) in tagcontent.tagsContent" ng-include="'subSelect-@{{index}}'">
                    <script type="text/ng-template" id="subSelect-@{{index}}">
                        <table class="full-width">
                            <tr class="child-active child-tag">
                                <td class="text-center child-plus-or-minus" data-title="''" >
                                    <a class="c-000" href="javascript:void(0)" ng-if="value.openChild && value.children.length > 0" ng-click="value.openChild = false" data-toggle="collapse" data-target="#show-sub-select-@{{value._id}}" ><i class="fa fa-minus"></i></a>

                                    <a class="c-000" href="javascript:void(0)" ng-if="!value.openChild && value.children.length > 0" ng-click="value.openChild = true" data-toggle="collapse" data-target="#show-sub-select-@{{value._id}}" ><i class="fa fa-plus"></i></a>
                                </td>
                                <td class="child-name">
                                    <span>@{{value.name}}</span>
                                </td>

                                <td class="child-color">
                                    <span ng-if="value.parent_id == '0'" style="color:@{{value.color}}" class="fa fa-circle"></span>
                                </td>
                                <td class="show-action child-action">
                                    <div class="wrap-ac-group">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <a href="javascript:void(0)" ng-click="tagcontent.showGroup($event)" class="ac-group btn"></a>
                                        <ul class="group-btn-ac fix-missing-li">
                                            <li>
                                                <a ng-click="tagcontent.getModalTagContent(value._id, 'edit')" class="text-show-action">
                                                    <i class="ti-pencil"></i> {{ trans('configuration/tag-content/new-tag.edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a ng-click="tagcontent.getModalTagContent(value._id, 'create')" class="text-show-action">
                                                    <i class="fa fa-plus"></i> {{ trans('configuration/tag-content/new-tag.add') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a ng-click="tagcontent.deleteTagContent(value._id)" class="text-show-action">
                                                <i class="fa fa-times"></i> {{ trans('configuration/tag-content/new-tag.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <ul class="style-ul collapse" id="show-sub-select-@{{value._id}}">
                            <li class="second" ng-repeat="(index, value) in value.children" ng-include="'subSelect-@{{index}}'"></li>
                        </ul>
                    </script>
                    
                </li>
            </ul>
            
        </div>
    </div>
@stop

@section('script')
    <script>
        window.allTags = {!! json_encode($allTags) !!};
        window.tagsContent = {!! json_encode($tagsContent) !!};
    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/tag-content/TagContentService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/tag-content/TagContentController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/tag-content/TagContent.js') }}"></script>
    @endif

@stop

