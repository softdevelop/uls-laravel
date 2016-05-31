@extends('app')
@section('title')
	{{ trans('configuration/tag-content/index.tag_content_management') }}
@endsection
@section('content')
	<div class="wrap-branch" data-ng-controller="TagContentController as tagcontent">
		<div class="top-content">
		    <label class="c-m">{{ trans('configuration/tag-content/index.tag_content_management') }}
		    </label>
		    <a data-toggle="modal" ng-click="tagcontent.getModalTagContent('0', 'create')" class="btn btn-primary fix-btn-top-content pull-right">
	       		<i class="fa fa-plus"></i> {{ trans('configuration/tag-content/index.tag_content') }}
	        </a>
		</div>
		<div class="content tag-content">
			<ul class="style-ul ul-parent">
				<li class="">
				    <div class="table-responsive table-animate">
				        <table class="table center-td table-tag-content" ng-table="tagcontent.tableParams">
				            <tbody class="tbody-animate">
					            <tr class="show-sub-select-" ng-repeat-start="tagContent in $data" ng-class="{highlight:tagContent.timeout}">
						            <td class="text-center parent-plus-or-minus" data-title="''" >
	                                	<a class="btn-toggle-@{{tagContent._id}}" href="javascript:void(0)" ng-if="tagContent.children.length > 0" data-toggle="collapse" data-target="#show-sub-select-@{{tagContent._id}}" >
	                                		<i class="fa fa-plus" ng-click="tagcontent.showSubSelect($event, tagContent._id)"></i>
	                                	</a>
	                                </td>
					                <td  data-title="'Name'" sortable="'name'" class="parent-name">
						                @{{tagContent.name}}
						            </td>
						            <td data-title="'Color'" class="parent-color">
						                <span style="color:@{{tagContent.color}}" class="fa fa-circle"></span>
						            </td>
						            <td class="show-action" data-title="'Action'" class="parent-action">

						            	<div class="wrap-ac-group">
			                                <i class="fa fa-ellipsis-v"></i>
			                                <a href="javascript:void(0)" ng-click="tagcontent.showGroup($event)" class="ac-group btn"></a>
											<ul class="group-btn-ac fix-missing-li">
												<li>
													<a ng-click="tagcontent.getModalTagContent(tagContent, 'create')" class="text-show-action">
						                                <i class="fa fa-plus"></i> {{ trans('configuration/tag-content/index.add') }}
						                            </a>
												</li>
												<li>
													<a ng-click="tagcontent.getModalTagContent(tagContent, 'edit')" class="text-show-action">
						                                <i class="ti-pencil"></i> {{ trans('configuration/tag-content/index.edit') }}
						                            </a>
												</li>
												<li>
													<a ng-click="tagcontent.deleteTagContent(tagContent)" class="text-show-action">
						                                <i class="fa fa-times"></i> {{ trans('configuration/tag-content/index.delete') }}
						                            </a>
												</li>
											</ul>
			                            </div>
									</td>
					            </tr>

					            <tr class="style-ul collapse" id="show-sub-select-@{{tagContent._id}}" ng-repeat-end>
					            	<td class="show-gradation padding-none" colspan="4">
					            		<div class="show-animate">
						            		<ul class="style-ul">
								                <li id="li-select-tag-@{{value._id}}" ng-repeat="(index, value) in tagContent.children" ng-include="'subSelect-@{{index}}'">
								                    <script type="text/ng-template" id="subSelect-@{{index}}">
								                        <table class="full-width">
								                            <tr class="child-active child-tag">
								                                <td class="text-center child-plus-or-minus" data-title="''" >
								                                	<a class="btn-toggle-@{{value._id}}" href="javascript:void(0)" ng-if="value.children.length > 0" data-toggle="collapse" data-target="#show-sub-select-@{{value._id}}" >
								                                		<i class="fa fa-plus" ng-click="tagcontent.showSubSelect($event, value._id)"></i>
								                                	</a>
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
								                                            <li ng-if="value.parent_id == tagContent._id">
								                                                <a ng-click="tagcontent.getModalTagContent(value, 'create')" class="text-show-action">
								                                                    <i class="fa fa-plus"></i> {{ trans('configuration/tag-content/index.add') }}
								                                                </a>
								                                            </li>
								                                            <li>
								                                                <a ng-click="tagcontent.getModalTagContent(value, 'edit')" class="text-show-action">
								                                                    <i class="ti-pencil"></i> {{ trans('configuration/tag-content/index.edit') }}
								                                                </a>
								                                            </li>
								                                            <li>
								                                                <a ng-click="tagcontent.deleteTagContent(value)" class="text-show-action">
								                                                	<i class="fa fa-times"></i> {{ trans('configuration/tag-content/index.delete') }}
								                                                </a>
								                                            </li>
								                                        </ul>
								                                    </div>
								                                </td>
								                            </tr>
								                        </table>
								                        <ul class="style-ul collapse show-inset" id="show-sub-select-@{{value._id}}">
								                            <li ng-repeat="(index, value) in value.children" ng-include="'subSelect-@{{index}}'"></li>
								                        </ul>
								                    </script>
								                    
								                </li>
								            </ul>
							            </div>
					            	</td>
					            </tr>
				            </tbody>
				        </table>
				    </div>
				</li>
			</ul>
		</div>
	</div>
@stop

@section('script')
	<script>
		window.tagsContent = {!! json_encode($tagsContent) !!};
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/tag-content/TagContentService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/tag-content/TagContentController.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/tagContent.js') }}"></script>
	@endif

@stop

