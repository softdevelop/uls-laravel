<div ng-controller="TemplateContentManagerCtr" ng-init="initTree()" class="wrap-content-management asset-management template-manager">
	<div class="top-content">
		<label class="c-m">{{trans('cms_template/template-index.breadcrumb')}}
		</label>

		<a data-toggle="modal" href="javascript:void(0)" ng-click="createFolderTemplate()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
				<i class="fa fa-folder"></i> {{trans('cms_template/template-index.create_directory')}}
			</a>

			<a data-toggle="modal" href="javascript:void(0)" ng-model="files" ng-click="getModalCreateTemplateContentManager()"  class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
				<i class="fa fa-upload"></i> {{trans('cms_template/template-index.add_new_template')}}
			</a>

			<a ng-click="getModalRequestProposeNewTemplate()" href="javascript:void(0)" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
				<i class="fa fa-mail-reply"></i> {{trans('cms_template/template-index.propose_new_template')}}
			</a>

			@if (\Auth::user()->can('cms_delete_content'))
				<button ng-if="isShowBtnDelete" ng-click="deleteFolderAndTemplate()" href="javascript:void(0)" class="btn btn-primary hidden-xs pull-right fix-btn-top-content" ng-disabled="dsbBtnDelete">
					<i class="fa fa-times"></i> {{trans('cms_template/template-index.delete')}}
				</button>
			@endif

			<a href="javascript:void(0)" ng-if="isShowBtnEditNameFolder" ng-click="editNameFolder()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
				<i class="fa fa-pencil"></i> {{trans('cms_template/template-index.edit_name_folder')}}
			</a>
	</div>

	<div class="visible-xs group-action-mobile">
		<div class="btn-show-group" data-toggle="collapse" data-target="#group-btn" aria-expanded="false">
			<i class="fa fa-plus"></i>
		</div>
		<div class="wrap-btn-create-circle collapse" id="group-btn">
			<div class="btn-create-circle">
				<a ng-click="getModalRequestProposeNewTemplate()" href="javascript:void(0)" href=""><i class="fa fa-mail-reply"></i></a>
			</div>
			<div class="btn-create-circle">
				<a data-toggle="modal" href="javascript:void(0)" ng-model="files" ng-click="getModalCreateTemplateContentManager()" ngf-multiple="true" href=""><i class="fa fa-upload"></i></a>
			</div>

			<div class="btn-create-circle">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="createFolderTemplate()" href=""><i class="fa fa-folder"></i></a>
			</div>

			<div class="btn-create-circle" ng-if="isShowBtnEditNameFolder">
				<a data-toggle="modal" ng-click="editNameFolder()">
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
				<table class="table set-padding table-min-1000 table-template" ng-init="size()" show-filter="isSearch"  ng-table="tableParams">
					<tbody class="tbody-animate">
						<tr class="parent-active" ng-repeat-start="item in $data">
							<td class="parent-td1" data-title="''" >
				                <a class="c-000" href="javascript:void(0)" ng-if="item.expanded" ng-click="item.expanded = false"><i class="fa fa-minus"></i></a>
	                    		<a class="c-000" href="javascript:void(0)" ng-if="!item.expanded" ng-click="item.expanded = true" data-toggle="collapse" data-target="#sub-tr" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i></a>
				            </td>

							<td data-title="'{{trans('cms_template/template-index.name')}}'" filter="{ 'title': 'text' }" sortable="'title'">@{{item.data.name}}</td>
							<td></td>
							<td data-title="'{{trans('cms_template/template-index.status')}}'" filter="{ 'type': 'status' }" >
								<div class="vertical-box" ng-if="item.data.status != 'uptodate'" tooltip="Requested" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
									<span class="fa fa-circle orange-status"></span>
								</div>
									
								<div class="vertical-box" ng-if="item.data.status == 'uptodate'" tooltip="Live" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
									<span class="fa fa-circle greens-status"></span>
								</div>

							</td>
							<td data-title="'{{trans('cms_template/template-index.languages')}}'">@{{item.data.language}}</td>
							<td data-title="'{{trans('cms_template/template-index.regions')}}'">@{{item.data.region}}</td>
							<td data-title="'{{trans('cms_template/template-index.due_date')}}'">
								<span ng-show="item.data.status != 'uptodate'&& item.data.due_date!='n/a'">@{{item.data.due_date | myDate}}</span>
								<span ng-show="item.data.status =='uptodate'||item.data.due_date=='n/a'">{{trans('cms_template/template-index.n_a')}}</span>
							</td>
							<td data-title="'{{trans('cms_template/template-index.last_update')}}'" sortable="'data.due_date'">
							
				                @{{item.data.updated_at| clientDate}}
				            </td>
							<td class="show-action text-left parent-td9" data-title="'{{trans('cms_template/template-index.action')}}'">
	                            <div class="wrap-ac-group">
	                                <i class="fa fa-ellipsis-v"></i>
	                                <a href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn"></a>
									<ul class="group-btn-ac fix-missing-li">
										<a ng-click="getModalRequestTranslationTemplate(item.data._id, item.data.subFiles)" ng-show="item.data.isTranlatetion" href="javascript:void(0)" class="text-show-action" > 
											<li> {{trans('cms_template/template-index.request_translation')}}</li>
										</a>
										<li class="action-tag-content">
											<tag-content-directive items="tagsContent" class="wrap-tag-content" text="Tag Content Type" title="Apply labels to this page" placeholder="Filter labels" ng-model="idTagContent" current-page="item" all-tags="allTags" index="$index+200" on-click="addTagsForPage(item.data._id, tagId)"></tag-content-directive>
										</li>
									</ul>
	                            </div>
	                        </td>
						</tr>
						<tr class="child-active"  ng-show="item.expanded" ng-repeat-end ng-repeat="subFile in item.data.subFiles">

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
									            <div class="vertical-box" ng-if="subFile.status != 'uptodate'" tooltip="Requested" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
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
														@if (Auth::user()->can('template_editor'))
															<a class="text-show-action" ng-if="!subFile['$id']" id="editTemplate-@{{subFile._id}}" href="/cms/template-content-manager/update-template/@{{subFile._id}}" target="_self" >
																<li> {{trans('cms_template/template-index.edit_template')}}</li>
															</a>
															<a class="text-show-action" ng-if="subFile['$id']" id="editTemplate-@{{subFile._id}}" href="/cms/template-content-manager/update-template/@{{subFile._id}}" target="_self" >
																<li> {{trans('cms_template/template-index.edit_template')}}</li>
															</a>
														@endif
														<a ng-click="getModalRequestRegionTemplate(subFile._id, subFile)" class="text-show-action" href="script:void(0)">
															<li> {{trans('cms_template/template-index.request_region')}}</li>
														</a>
														<a ng-if="subFile.ticket_id"  href="{{URL::to('support/show')}}/@{{subFile.ticket_id}}" target="_self" class="text-show-action" >
															<li> {{trans('cms_template/template-index.view_task')}}</li>
														</a>
														@if (\Auth::user()->can('cms_delete_content'))
															<a ng-if="!(subFile.language == 'en' &&  subFile.region == null)" ng-click="deleteFileTemplate(subFile._id, item.data)" class="text-show-action" target="_self"> 
																<li> {{trans('cms_template/template-index.delete')}}</li>
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
	    <select class="form-control" ng-model="params.filter()['data']['status']"> 
	        <option value="">{{trans('cms_template/template-index.all_status')}}</option>           
	        <option class="yellow-status" value="waiting-approve">{{trans('cms_template/template-index.draft')}}</option>
	        <option class="greens-status" value="uptodate">{{trans('cms_template/template-index.live')}}</option>
	    </select>
	</script>
	<script type="text/javascript">
		window.folders = {!!json_encode($folders)!!}
		window.templates = {!!json_encode($results)!!};
		window.listFieldType = {!!json_encode($listFieldType)!!};
		window.listIdCheck = {!!json_encode(getTypeFollowIdTCM())!!};
		window.listMapType = {!!json_encode(getMapTypeTCM())!!};
		window.maxUpload = {!!json_encode($maxUpload)!!};
		window.listAttributeDataOption = {!!json_encode(getAttributeDataOption())!!};
		window.listFieldNameMap = {!!json_encode(getListFieldNameFollowIdTCM())!!};
		window.listMapTypeTextSpecial = {!! json_encode(getmapTypeTextSpecial())!!};
		window.tagsContent = {!! json_encode($tagsContent) !!};
		window.allTags = {!! json_encode($allTags) !!};
		window.currentPage = 'templates';
	</script>
	<script type="text/javascript">
	    'use strict';
	    (function($) {
	        $('#page-loading').css('display','none');
	    })(jQuery);
	</script>
