<div ng-controller="BlockManagerController" ng-init="initTree()" class="wrap-content-management block-manager">
	<div class="top-content">
		<label class="c-m block-manager">CMS Manager Block
		</label>

		<a data-toggle="modal" href="javascript:void(0)" ng-click="createFolderBlock()" class="btn btn-primary pull-right fix-btn-top-content hidden-xs">
			<i class="fa fa-folder"></i> Create Directory
		</a>

		<a data-toggle="modal" href="javascript:void(0)" ng-model="files" ng-click="uploadNewBlock()" class="btn btn-primary pull-right fix-btn-top-content hidden-xs">
			<i class="fa fa-upload"></i> Create New Block
		</a>

		<a data-ng-controller="RequestBlockController" ng-click="getModalRequestNewBlock()" href="javascript:void(0)" class="btn btn-primary pull-right fix-btn-top-content hidden-xs">
			<i class="fa fa-mail-reply"></i> Request New Block
		</a>

		@if (\Auth::user()->can('cms_delete_content'))
			<button  ng-if="isShowBtnDelete" ng-click="deleteFolderAndBlock()" href="javascript:void(0)" class="btn btn-primary pull-right fix-btn-top-content hidden-xs" ng-disabled="dsbBtnDelete">
				<i class="fa fa-times"></i> Delete
			</button>
		@endif

		<a href="javascript:void(0)" ng-if="isShowBtnEditNameFolder" ng-click="editNameFolder()" class="btn btn-primary pull-right fix-btn-top-content hidden-xs">
			<i class="fa fa-pencil"></i> Edit Folder Name
		</a>
	</div>

	<div class="visible-xs group-action-mobile">
		<div class="btn-show-group" data-toggle="collapse" data-target="#group-btn" aria-expanded="false">
			<i class="fa fa-plus"></i>
		</div>
		<div class="wrap-btn-create-circle collapse" id="group-btn">
			<div class="btn-create-circle">
				<a data-ng-controller="RequestBlockController" ng-click="getModalRequestNewBlock()" href="javascript:void(0)" href=""><i class="fa fa-mail-reply"></i></a>
			</div>

			<div class="btn-create-circle">
				<a data-toggle="modal" href="javascript:void(0)" ng-model="files" ng-click="uploadNewBlock()" href="" target="_self"><i class="fa fa-upload"></i></a>
			</div>

			<div class="btn-create-circle">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="createFolderBlock()" href=""><i class="fa fa-folder"></i></a>
			</div>

			<div class="btn-create-circle" ng-if="isShowBtnEditNameFolder">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="editNameFolder()" href="">
					<i class="fa fa-pencil"></i>
				</a>
			</div>

		</div>
	</div>


	<div class="content margin-top-0">
		<div id="resize-left" >
			<div data-toggle="tree" id="tree"></div>
		</div>
		<div id="resize-right" class="fix-td-tb">
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
				<table class="table table-block" show-filter="isSearch"  ng-table="tableParams">
					<tbody class="tbody-animate">

						<tr class="parent-active" class="text-center" ng-repeat-start="block in $data">

							<td class="text-center parent-td1" data-title="''" >
				                <a class="c-000" href="javascript:void(0)" ng-if="block.expanded" ng-click="block.expanded = false"><i class="fa fa-minus"></i></a>
	                    		<a class="c-000" href="javascript:void(0)" ng-if="!block.expanded" ng-click="block.expanded = true" data-toggle="collapse" data-target="#sub-tr" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i></a>
				            </td>

							<td class="text-center" data-title="'Block Name'" filter="{ 'title': 'text' }" sortable="'title'">@{{block.data.name}}</td>
							{{-- <td></td> --}}
							<td class="text-center ellipsis" data-title="'Id'">
								<span title="@{{block.data._id}}">@{{block.data._id}}</span>
							</td>

							<td class="text-center parent-td4" data-title="'Status'">
								<div class="vertical-box" ng-class="{'greens-status': block.data.status =='live', 'yellow-status' : block.data.status !='live'}" data-toggle="tooltip" data-placement="top" title="Requested">
									<span class="fa fa-circle"></span>
								</div>
							</td>

							<td class="text-center" data-title="'Languages'">@{{block.data.language}}</td>

							<td class="text-center" data-title="'Regions'">@{{block.data.region}}</td>

							<td class="text-center" data-title="'Due Date'">

								<span ng-show="block.data.status != 'live'">@{{block.data.due_date | myDate}}</span>
								<span ng-show="block.data.status =='live'">n/a</span>
							</td>

							<td class="show-action text-left parent-td8" data-title="'Action'">
	                            <div class="wrap-ac-group">
	                                <i class="fa fa-ellipsis-v"></i>
	                                <a href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn"></a>
									<ul class="group-btn-ac fix-missing-li">
										<a data-ng-controller="RequestBlockController" ng-click="getModalRequestTranslation(block.data._id)" href="javascript:void(0)" class="text-show-action" > 
											<li> Request Translation</li>
										</a>
										<li class="action-tag-content">
											<tag-content-directive items="tagsContent" class="wrap-tag-content" text="Tag Content Type" title="Apply labels to this page" placeholder="Filter labels" ng-model="idTagContent" current-page="block" all-tags="allTags" index="$index+200" on-click="addTagsForPage(pageId, tagId)"></tag-content-directive>
										</li>
									</ul>
	                            </div>
	                        </td>
						</tr>

						<tr class="child-active"  ng-show="block.expanded" ng-repeat-end ng-repeat="subFile in block.data.subBlocks">

				        	<td colspan="8" class="padding-none">
				        		<div class="show-animate">
					        		<table class="full-width">
					        			<tr class="child-active">

					        				<td class="text-center child-td1" data-title="''" ></td>

								            <!-- <td class="text-center" data-title="'block Name'"></td> -->
								            <td class="text-center child-td2" data-title="'Parent'"></td>

								            <td class="text-center child-td3" data-title="'Status'">
								            	<div class="vertical-box" ng-class="{'greens-status': subFile.status =='live', 'yellow-status' : subFile.status =='draft'}" data-toggle="tooltip" data-placement="top" title="Requested">
								            		<span class="fa fa-circle"></span>
								            	</div>
								            </td>

								            <td class="text-center child-td4" data-title="'Languages'">
								                @{{subFile.language == null ? 'default' : subFile.language}}
								            </td>

								            <td class="text-center child-td5" data-title="'Region'">
								            	@{{subFile.region == null ? 'default' : subFile.region}}
								            </td>

								            <td class="text-center child-td6" data-title="'Due Date'">
								            	<span ng-show="subFile.status != 'live'">@{{subFile.due_date | myDate}}</span>
								            	<span ng-show="subFile.status == 'live'">n/a</span>
								            </td>

								            <td class="show-action text-left child-td7" data-title="'Action'">
					                            <div class="wrap-ac-group">
					                                <i class="fa fa-ellipsis-v"></i>
					                                <a href="javascript:void(0)" ng-click="showGroup($event,subFile)" class="ac-group btn"></a>
													<ul class="group-btn-ac">
														<a data-ng-controller="RequestBlockController" ng-click="getModalRequestRegion(subFile._id)" class="text-show-action" href="script:void(0)">
															<li> Request Region</li>
														</a>
														<a ng-if="subFile.status == 'live'" target="_self" class="text-show-action" href="/cms/block-manager/review-block/@{{subFile._id}}" >
															<li>
																Review Block
															</li>
														</a>
														@if(Auth::user()->can('edit_block'))
															<a class="text-show-action" href=" cms/block-manager/edit-block/@{{subFile._id}}" target="_self" >
																<li> Edit Block</li>
															</a>
														@endif
														@if (\Auth::user()->can('cms_delete_content'))
															<a ng-if="!(subFile.language == null &&  subFile.region == null)" ng-click="deleteFileBlock(subFile._id, block.data)" class="text-show-action" target="_self"> 
																<li> Delete file</li>
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
	</div>
</div>
<script type="text/javascript">
	window.folders = {!! json_encode($folders) !!};
	window.tagsContent = {!! json_encode($tagsContent) !!};
	window.allTags = {!! json_encode($allTags) !!};
	window.currentPage = 'managed_block';
</script>
<script type="text/javascript">
    'use strict';
    (function($) {
        $('#page-loading').css('display','none');
    })(jQuery);
</script>
