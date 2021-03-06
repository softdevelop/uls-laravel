<div ng-controller="AssetManagerController" ng-init="initTree()" class="wrap-content-management">
	<div class="top-content">
		<label class="c-m">{{trans('cms_asset/asset-index.breadcrumb')}}</label>

		<a data-toggle="modal" href="javascript:void(0)" ng-click="createFolderAsset()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
			<i class="fa fa-folder"></i> {{trans('cms_asset/asset-index.create_directory')}}
		</a>

		<a data-toggle="modal" href="javascript:void(0)" ng-model="files" ng-click="uploadNewAssets()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
			<i class="fa fa-upload"></i> {{trans('cms_asset/asset-index.upload_new_asset')}}
		</a>

		<a data-ng-controller="RequestAssetController" ng-click="getModalRequestNewAsset()" href="javascript:void(0)" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
			<i class="fa fa-mail-reply"></i> {{trans('cms_asset/asset-index.request_new_asset')}}
		</a>

		@if (\Auth::user()->can('cms_delete_content'))
			<a ng-if="isShowBtnDelete" ng-click="deleteFolderAndAsset()" href="javascript:void(0)" class="btn btn-primary hidden-xs pull-right fix-btn-top-content" ng-disabled="dsbBtnDelete">
				<i class="fa fa-times"></i> {{trans('cms_asset/asset-index.delete')}}
			</a>
		@endif

		<a href="javascript:void(0)" ng-if="isShowBtnEditNameFolder" ng-click="editNameFolder()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
			<i class="fa fa-pencil"></i> {{trans('cms_asset/asset-index.edit_name_folder')}}
		</a>

		<a href="javascript:void(0)"  ng-show = "isShowBtnCreateNewAsset" ng-click="createNewAsset()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
			<i class="fa fa-pencil"></i> {{trans('cms_asset/asset-index.create_new_asset')}}
		</a>
	</div>

	<div class="visible-xs group-action-mobile">
		<div class="btn-show-group" data-toggle="collapse" data-target="#group-btn" aria-expanded="false">
			<i class="fa fa-plus"></i>
		</div>

		<div class="wrap-btn-create-circle collapse" id="group-btn">
			<div class="btn-create-circle">
				<a data-ng-controller="RequestAssetController" ng-click="getModalRequestNewAsset()" href="javascript:void(0)" href=""><i class="fa fa-mail-reply"></i></a>
			</div>
			<div class="btn-create-circle">
				<a data-toggle="modal" href="javascript:void(0)" ng-model="files" ng-click="uploadNewAssets()" href=""><i class="fa fa-upload"></i></a>
			</div>
			<div class="btn-create-circle">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="createFolderAsset()" href=""><i class="fa fa-folder"></i></a>
			</div>
			<div class="btn-create-circle" ng-if="isShowBtnEditNameFolder">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="editNameFolder()">
					<i class="fa fa-pencil"></i>
				</a>
			</div>

		</div>
	</div>


	<div class="content margin-top-0">
		<div id="resize-left" >
			<div data-toggle="tree" id="tree"></div>
		</div>

		<div id="resize-right" class="fix-td-tb" >
			<div class="resize-right_box-wrap-top-table">
				<a href=""> <i class="fa fa-folder"></i> </a> @{{titleItemSelected}}
				<a class='btn btn-sm btn-default pull-right' ng-click="hideOrShowAllNestedContent()">
					<i class="fa fa-eye" ng-if="isShowNested"></i>
					<i class="fa fa-eye-slash" ng-if="!isShowNested"></i>
					@{{contentHideOrShowAllNestedContent}}
				</a>
				<div class="clearfix"></div>
			</div>
			<div class="table-responsive table-animate">
				<a class="fixed-search" ng-click="btnSearch()">
                    <i class="fa fa-search"></i>
                </a>
				<table class="table set-padding table-asset-manager min-width-1100" ng-init="size()" show-filter="isSearch" ng-table="tableParams">
					<tbody class="tbody-animate">

						<tr class="parent-active" ng-repeat-start="asset in $data">

							<td class="parent-td1" data-title="''">
				                <a class="c-000" href="javascript:void(0)" ng-if="asset.expanded" ng-click="asset.expanded = false">
				                	<i class="fa fa-minus"></i>
				                </a>
	                    		<a class="c-000" href="javascript:void(0)" ng-if="!asset.expanded" ng-click="asset.expanded = true" data-toggle="collapse" data-target="#sub-tr" aria-expanded="false" aria-controls="collapseExample">
	                    			<i class="fa fa-plus"></i>
	                    		</a>
				            </td>

							<td class="parent-td2" data-title="'{{trans('cms_asset/asset-index.name')}}'" filter="{ 'title': 'text' }" sortable="'title'">@{{asset.data.name}}</td>

							<td class="ellipsis" data-title="'{{trans('cms_asset/asset-index.file_name')}}'">
								<span title="@{{asset.data.filename}}"> @{{asset.data.filename}}</span>
							</td>

							<td class="parent-td4" data-title="'{{trans('cms_asset/asset-index.status')}}'" sortable="'data.status'" filter="{ 'type': 'status' }">
								
								<div class="vertical-box" ng-if="asset.data.status != 'uptodate'" tooltip="{{trans('cms_asset/asset-index.requested')}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
									<span class="fa fa-circle orange-status"></span>	
								</div>

								<div class="vertical-box" ng-if="asset.data.status == 'uptodate'" tooltip="{{trans('cms_asset/asset-index.live')}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
									<span class="fa fa-circle greens-status"></span>
								</div>
								
							</td>

							<td class="parent-td5" data-title="'{{trans('cms_asset/asset-index.languages')}}'">@{{asset.data.language}}</td>
							<td class="parent-td6" data-title="'{{trans('cms_asset/asset-index.regions')}}'">@{{asset.data.region}}</td>
							<td class="parent-td7" data-title="'{{trans('cms_asset/asset-index.due_date')}}'">
								<span ng-show="asset.data.status != 'uptodate'&& asset.data.due_date!='n/a'">@{{asset.data.due_date | myDate}}</span>
								<span ng-show="asset.data.status =='uptodate'||asset.data.due_date=='n/a'">{{trans('cms_asset/asset-index.n_a')}}</span>
							</td>
							<td class="text-center parent-td8"  sortable="'data.updated_at'" data-title="'{{trans('cms_asset/asset-index.last_update')}}'">
				                @{{asset.data.updated_at| clientDate}}
				            </td>

							<td class="show-action text-left parent-td9" data-title="'{{trans('cms_asset/asset-index.action')}}'">
	                            <div class="wrap-ac-group">
	                                <i class="fa fa-ellipsis-v"></i>
	                                <a href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn"></a>
									<ul class="group-btn-ac fix-missing-li">
										<a data-ng-controller="RequestAssetController" ng-show="asset.data.isTranlatetion" ng-click="getModalRequestTranslationAsset(asset.data._id)" href="javascript:void(0)" class="text-show-action" >
											<li> {{trans('cms_asset/asset-index.request_translation')}}</li>
										</a>
										<li class="action-tag-content">
											<tag-content-directive items="tagsContent" class="wrap-tag-content" text="Tag Content Type" title="Apply labels to this page" placeholder="Filter labels" ng-model="idTagContent" current-page="asset" all-tags="allTags" index="$index+200" on-click="addTagsForPage(asset.data._id, tagId)"></tag-content-directive>
										</li>
									</ul>
	                            </div>
	                        </td>
						</tr>

						<tr class="child-active"  ng-show="asset.expanded" ng-repeat-end ng-repeat="subFile in asset.data.subFiles">

				        	<td colspan="9" class="padding-none">
				        		<div class="show-animate">
					        		<table class="full-width">
					        			<tr class="child-active">
					        				<td class="text-center child-td1" data-title="''" ></td>

								            <td class="text-center child-td2" data-title="'Page Name'" >
								            	{{-- <a ng-if="content.status == 'live'" href="/pages/show-over-view/@{{content._id}}"><i class="fa fa-eye"></i></a> --}}
								            </td>

								            <td class="text-center child-td3" data-title="'Parent'"></td>

								            <td class="text-center child-td4" data-title="'Status'">
								            	<div class="vertical-box"ng-if="subFile.status != 'uptodate'" tooltip="Requested" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
													<span class="fa fa-circle orange-status"></span>
												</div>

												<div class="vertical-box" ng-if="subFile.status == 'uptodate'" tooltip="Live" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
													<span class="fa fa-circle greens-status"></span>
												</div>

								            </td>

								            <td class="text-center child-td5" data-title="'Languages'">
								                @{{subFile.language == null ? 'default' : subFile.language}}
								            </td>

								            <td class="text-center child-td6" data-title="'Region'">
								            	@{{subFile.region == null ? 'default' : subFile.region}}
								            	{{-- <span ng-if="content.region != null">@{{content.region}}</span>
								            	<span ng-if="content.region == null">default</span> --}}
								            </td>

								            <td class="text-center child-td7" data-title="'Due Date'">
								            	<span ng-show="subFile.status != 'uptodate'&&subFile.due_date != 'n/a'">@{{subFile.due_date | myDate}}</span>
								            	<span ng-show="subFile.status == 'uptodate'||subFile.due_date == 'n/a'">n/a</span>
								            </td>

								            <td class="text-center child-td8" data-title="'Last Update'">

								                @{{subFile.updated_at| clientDate}}
								            </td>

								            <td class="show-action text-left child-td9" data-title="'Action'">
					                            <div class="wrap-ac-group">
					                                <i class="fa fa-ellipsis-v"></i>
					                                <a href="javascript:void(0)" ng-click="showGroup($event,subFile)" class="ac-group btn"></a>
													<ul class="group-btn-ac affix">
														<a ng-show="subFile.filename" ng-click="viewFile(subFile)" class="text-show-action" id="viewFile-@{{subFile._id}}" href="script:void(0)">
															<li> {{trans('cms_asset/asset-index.view_file')}}</li>
														</a>
														@if (\Auth::user()->can('eidt_file_asset'))
														<a data-ng-controller="RequestAssetController" ng-click="getModalEditFile(subFile._id)" class="text-show-action" href="script:void(0)" >
															<li> {{trans('cms_asset/asset-index.upload_new_version')}}</li>
														</a>
														@endif
														@if (\Auth::user()->can('eidt_file_asset'))
														<a ng-show="checkFileType(subFile)" data-ng-controller="RequestAssetController" ng-click="getModalUploadNewVersion(subFile._id)" class="text-show-action">
															<li> {{trans('cms_asset/asset-index.edit_file')}}</li>
														</a>
														@endif
														<a ng-show ="subFile.filename && subFile.type =='image'" class="text-show-action" target="_self" ng-href="{{getBaseUrl()}}/cms/asset-manager/crop-image/@{{subFile._id}}">
															<li> {{trans('cms_asset/asset-index.crop_image')}}</li>
														</a>

														<a ng-if="asset.status != 'uptodate'" data-ng-controller="RequestAssetController" ng-click="getModalRequestRegionAsset(subFile._id)" class="text-show-action" href="script:void(0)">
															<li> {{trans('cms_asset/asset-index.request_region')}}</li>
														</a>
														<a ng-if="subFile.ticket_id"  href="{{URL::to('support/show')}}/@{{subFile.ticket_id}}" target="_self" class="text-show-action" >
															<li> {{trans('cms_asset/asset-index.view_task')}}</li>
														</a>
														@if (\Auth::user()->can('cms_delete_content'))
															<a ng-if="!(subFile.language == 'en' && subFile.region == null)" ng-click="deleteFileAsset(subFile._id, asset.data)" class="text-show-action" target="_self">
																<li> {{trans('cms_asset/asset-index.delete')}}</li>
															</a>
														@endif
													</ul>
					                            </div>
					                        </td>
					        			</tr>
					        		</table>
					        	</div>
				        	</td>
			            </tr>
					</tbody>
				</table>
			</div>
		</div>

		<div id="sidebar-resizer" resizer="vertical" resizer-width="0" resizer-left="#resize-left" resizer-right="#resize-right" resizer-max="500" resizer-position-left="300">
  		</div>

  		<div class="clearfix"></div>

	</div>
</div>
<script type="text/ng-template" id="ng-table/filters/status.html">
    <select class="form-control pointer" ng-model="params.filter()['data']['status']">
        <option value="">{{trans('cms_asset/asset-index.all_status')}}</option>
        <option class="orange-status" value="waiting-approve">{{trans('cms_asset/asset-index.requested')}}</option>
        <option class="greens-status" value="uptodate">{{trans('cms_asset/asset-index.live')}}</option>
    </select>
</script>
<script type="text/javascript">
	window.folders = {!!json_encode($folders)!!}
	window.editAssetPermission = {!! json_encode(Auth::user()->can('eidt_file_asset')) !!}
	window.maxUpload = {!! json_encode($maxUpload) !!}
	window.labels = {!!json_encode($labels)!!};
	window.tagsContent = {!! json_encode($tagsContent) !!};
	window.allTags = {!! json_encode($allTags) !!};
	window.folderType = {!! json_encode($folderType) !!};
	window.currentPage = 'assets';
</script>
<script type="text/javascript">
    'use strict';
    (function($) {
        $('#page-loading').css('display','none');
    })(jQuery);
</script>
