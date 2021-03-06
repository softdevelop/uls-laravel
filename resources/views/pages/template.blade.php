
<div class="wrap-content-management">
	<div class="top-content">
	    <label class="c-m page-manager">{{trans('cms_page/page-index.cms_page_manager')}}</label>

	    <a data-toggle="modal" ng-click="getModalCreatePage()" class="hidden-xs btn btn-primary pull-right fix-btn-top-content">
	        <i class="fa fa-plus"></i> {{trans('cms_page/page-index.propose_new_page')}}
	    </a>

	    @if (\Auth::user()->can('cms_delete_content'))
	    	<a href="javascript:void(0)" ng-if="isShowBtnDelete" ng-click="deletePage()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content" ng-disabled="dsbBtnDelete">
				<i class="fa fa-times"></i> {{trans('cms_page/page-index.delete_page')}}
			</a>
		@endif

	    <a href="javascript:void(0)" ng-if="isShowBtnEditNameFolder" ng-click="editNameFolder()" class="btn btn-primary hidden-xs pull-right fix-btn-top-content">
			<i class="fa fa-pencil"></i> {{trans('cms_page/page-index.edit_folder_name')}}
		</a>
	</div>

	<div class="visible-xs group-action-mobile">
		<div class="btn-show-group" data-toggle="modal" ng-click="getModalCreatePage()" href="javascript:void(0)">
			<i class="fa fa-plus"></i>
		</div>

		<!-- <div class="wrap-btn-create-circle collapse" id="group-btn">

			<div class="btn-create-circle" ng-if="isShowBtnDelete">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="deletePage()" ng-disabled="dsbBtnDelete">
					<i class="fa fa-times"></i>
				</a>
			</div>

			<div class="btn-create-circle" ng-if="isShowBtnEditNameFolder">
				<a data-toggle="modal" href="javascript:void(0)"  ng-click="editNameFolder()">
					<i class="fa fa-pencil"></i>
				</a>
			</div>

			<div class="btn-create-circle">
				<a data-toggle="modal" ng-click="getModalCreatePage()" href="javascript:void(0)">
					<i class="fa fa-plus"></i>
				</a>
			</div>

		</div> -->
	</div>

	<!-- <div class="visible-xs group-action-mobile">
		<div class="btn-show-group" data-toggle="collapse" data-target="#group-btn" aria-expanded="false">
			<i class="fa fa-plus"></i>
		</div>

		<div class="wrap-btn-create-circle collapse" id="group-btn">

			<div class="btn-create-circle" ng-if="isShowBtnDelete">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="deletePage()" ng-disabled="dsbBtnDelete">
					<i class="fa fa-times"></i>
				</a>
			</div>

			<div class="btn-create-circle" ng-if="isShowBtnEditNameFolder">
				<a data-toggle="modal" href="javascript:void(0)"  ng-click="editNameFolder()">
					<i class="fa fa-pencil"></i>
				</a>
			</div>

			<div class="btn-create-circle">
				<a data-toggle="modal" ng-click="getModalCreatePage()" href="javascript:void(0)">
					<i class="fa fa-plus"></i>
				</a>
			</div>

		</div>
	</div> -->

	<div class="content margin-top-0">
		<div id="resize-left">
			<div data-toggle="tree" id="tree"></div>
		</div>

		<div id="resize-right" class="fix-td-tb">
			<div class="resize-right_box-wrap-top-table">
				<a href=""> <i class="fa fa-folder"></i> </a> @{{titleItemSelected}}
				<a class='btn btn-sm btn-default pull-right' ng-click="hideOrShowAllNestedContent()">
					<i class="fa fa-eye" ng-if="isShowNested"></i>
					<i class="fa fa-eye-slash" ng-if="!isShowNested"></i>
					<span ng-show="!isShowNested">{{trans('cms_page/page-index.hide_all_nested_content')}}</span>
					<span ng-show="isShowNested">{{trans('cms_page/page-index.show_all_nested_content')}}</span>
					{{--@{{contentHideOrShowAllNestedContent}}--}}
				</a>
				<div class="clearfix"></div>
			</div>
			<div class="table-responsive table-animate page-management">
				<a class="fixed-search" ng-click="btnSearch()">
                    <i class="fa fa-search"></i>
                </a>
			   	<table class="table set-padding table-page" ng-init="size()" show-filter="isSearch" ng-table="tableParams">
			   		<tbody class="tbody-animate">

			   			<tr class="parent-active page-@{{page._id}}" ng-repeat-start="page in $data" ng-class="{highlight:page.timeout}">
				            <td class="text-center" data-title="''" >
				                <a class="c-000" href="javascript:void(0)" ng-if="page.openChild" ng-click="page.openChild = false"><i class="fa fa-minus"></i></a>
	                    		<a class="c-000" href="javascript:void(0)" ng-if="!page.openChild" ng-click="page.openChild = true" data-toggle="collapse" data-target="#sub-tr" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i></a>
				            </td>

				            <td class="text-center" data-title="'Page Name'" filter="{ 'title': 'text' }" sortable="'title'">
				                @{{page.title}}
				            </td>

				            <td class="text-center parent-td3" data-title="'Parent'"  sortable="'parent_title'">
				                @{{page.parent_title}}
				            </td>

				            <td class="text-center" data-title="'Status'" sortable="'status'" filter="{ 'type': 'status' }">
								<div class="vertical-box" ng-class="{'exist-live-status':page.status == 'live'}">
				            	 	<span class="fa fa-circle yellow-status" tooltip="Not Started" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-if="page.status == 'Not Started'"></span>
								    <span class="fa fa-circle purple-status" tooltip="In Process" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-if="page.status == 'In Process'"></span>
								    <span class="fa fa-circle ready-for-review-status" tooltip="Ready for Review" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-if="page.status == 'reviewed'"></span>
								    <span class="fa fa-circle dark-blue-status" tooltip="Approved" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-if="page.status == 'Approved'"></span>
								    <!-- <span class="fa fa-circle red-status" tooltip="Overdue" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-if="page.status == 'Overdue'"></span> -->
								    <span class="fa fa-circle greens-status" tooltip="Live" tooltip-trigger tooltip-animation="true" tooltip-placement="top"  ng-if="page.status == 'live'"></span>
								</div>

								<div class="wrap-progress-circle">
				            		<div class="c100 p@{{page.percentComplete}} small" ng-if="page.status != 'live'">
					                    <span>@{{page.percentComplete || "0" }}%</span>
					                    <div class="slice">
					                        <div class="bar"></div>
					                        <div class="fill"></div>
					                    </div>
					                </div>
				            	</div>

				            </td>
							
							<!-- <td class="text-center wrap-progress-circle" data-title="'% Complete'">
				            	
				            </td> -->


				            <td class="text-center" data-title="'Languages'" sortable="'language'">
				                @{{page.language}}
				            </td>

				            <td class="text-center" data-title="'Regions'" sortable="'region'">

				            	<span ng-if="page.region == 0">{{trans('cms_page/page-index.n_a')}}</span>
				            	<span ng-if="page.region != 0">@{{page.region}}</span>
				            </td>

				            <td class="text-center" data-title="'Due Date'" sortable="'due_date'">
				                <span ng-if="page.status != 'Approved'&&page.status != 'live'&&page.due_date">@{{page.due_date | myDate}}</span>
				                <span ng-if="page.status == 'Approved'||page.status == 'live'||!page.due_date">n/a</span>
				            </td>
				            <td class="text-center" data-title="'Last Update'" sortable="'updated_at'">
				                @{{page.updated_at| clientDate}}
				            </td>

				            <td class="show-action text-left" data-title="'Action'">

	                            <div class="wrap-ac-group">
	                                <i class="fa fa-ellipsis-v"></i>
	                                <a href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn"></a>
									<ul class="group-btn-ac fix-missing-li">
										<a ng-if="page.checkLiveOrApproved"  ng-show="page.isTranlatetion" ng-click="getModalRequestTranslation(page._id)" href="javascript:void(0)" class="text-show-action" > 
											<li> {{trans('cms_page/page-index.request_translation')}} </li>
										</a>
										<li class="action-tag-content">
											<tag-content-directive items="tagsContent" class="wrap-tag-content" text="Tag Content Type" title="Apply labels to this page" placeholder="Filter labels" ng-model="idTagContent" current-page="page" all-tags="allTags" index="$index" on-click="addTagsForPage(pageId, tagId)"></tag-content-directive>
										</li>
										<a ng-click="movePage(page)" href="javascript:void(0)" class="text-show-action" > 
											<li> {{trans('cms_page/page-index.move_page')}} </li>
										</a>
										<a ng-click="historyPage(page._id)" class="text-show-action" > 
											<li> {{trans('cms_page/page-index.history')}} </li>
										</a>
									</ul>
	                            </div>
	                        </td>
				        </tr>

				        <tr class="child-active" ng-show="page.openChild" ng-repeat-end="" ng-repeat="content in page.contents">
				        	<td colspan="9" class="padding-none">
				        		<div class="show-animate">
					        		<table class="full-width">
                                        <tr class="child-active">
                                            <td class="text-center child-td1" data-title="''" ></td>

                                            <td class="text-center" data-title="'Page Name'" filter="{ 'title': 'text' }" sortable="'title'">
                                                <!-- <a ng-if="content.status == 'live'" href="/pages/show-over-view/@{{content._id}}"><i class="fa fa-eye"></i></a> -->
                                            </td>

                                            <td class="text-center child-td3" data-title="'Parent'">
                                                
                                            </td>

                                            <td class="text-center child-td4" data-title="'Status'">
                                                <div class="vertical-box" ng-if="content.status == 'Not Started'" tooltip="Not Started" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-class="{'exist-live-status':content.status == 'live'}">
                                                    <span class="fa fa-circle yellow-status" ></span>
                                                </div>

                                                <div class="vertical-box" ng-if="content.status == 'In Process'" tooltip="In Process" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-class="{'exist-live-status':content.status == 'live'}">
                                                    <span class="fa fa-circle purple-status"></span>
                                                </div>
                                                <div class="vertical-box" ng-if="content.status == 'reviewed'" tooltip="Ready for Review" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-class="{'exist-live-status':content.status == 'live'}">
                                                    <span class="fa fa-circle ready-for-review-status"></span>
                                                </div>

                                                <div class="vertical-box" ng-if="content.status == 'Approved'" tooltip="Approved" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-class="{'exist-live-status':content.status == 'live'}">
                                                    <span class="fa fa-circle dark-blue-status"></span>
                                                </div>

                                                <!-- <div class="vertical-box" ng-if="content.status == 'Overdue'" tooltip="Overdue" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-class="{'exist-live-status':content.status == 'live'}">
                                                    <span class="fa fa-circle red-status" ></span>
                                                </div> -->

                                                <div class="vertical-box" ng-if="content.status == 'live'"tooltip="Live" tooltip-trigger tooltip-animation="true" tooltip-placement="top" ng-class="{'exist-live-status':content.status == 'live'}">
                                                    <span class="fa fa-circle greens-status"></span>
                                                </div>

                                                <div class="wrap-progress-circle">
                                                    <div class="c100 p@{{content.percentComplete}} small" ng-if="content.status != 'live'">
                                                        <span>@{{content.percentComplete || "0" }}%</span>
                                                        <div class="slice">
                                                            <div class="bar"></div>
                                                            <div class="fill"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </td>
                                           <!--  <td class="text-center wrap-progress-circle" data-title="'% Complete'">

                                                <div class="c100 p@{{content.percentComplete}} small" ng-if="content.status != 'live'"ng-if="content.status != 'live'">
                                                    <span>@{{content.percentComplete}}%</span>
                                                    <div class="slice">
                                                        <div class="bar"></div>
                                                        <div class="fill"></div>
                                                    </div>
                                                </div>
                                            </td> -->

                                            <td class="text-center child-td5" data-title="'Languages'">
                                                <span>@{{content.language}}</span>
                                            </td>

                                            <td class="text-center child-td6" data-title="'Region'">
                                                <span ng-if="content.region != null">@{{content.region}}</span>
                                                <span ng-if="content.region == null">{{trans('cms_page/page-index.default')}}</span>
                                            </td>

                                            <td class="text-center child-td7" data-title="'Due Date'">
                                                <span ng-if="content.status != 'Approved'&&content.status != 'live'&&content.due_date!='n/a'">@{{content.due_date | myDate}}</span>
                                                <span ng-if="content.status == 'Approved'||content.status == 'live'||content.due_date  =='n/a'">{{trans('cms_page/page-index.n_a')}}</span>
                                            </td>

                                            <td class="text-center child-td8" data-title="'Last Update'">
                                                <!-- <span ng-if="content.status != 'Approved'&&content.status != 'Overdue'&&content.status != 'live'&&content.due_date!='n/a'">@{{content.due_date | myDate}}</span> -->
                                                <!-- <span ng-if="content.status == 'Approved'||content.status == 'live'||content.status == 'Overdue'||content.due_date  =='n/a'">n/a</span> -->
                                                @{{content.updated_at| clientDate}}
                                            </td>

                                            <td class="show-action text-left child-td9" data-title="'Action'">
                                                <div class="wrap-ac-group">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <a href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn"></a>
                                                    <ul class="group-btn-ac">
                                                        <a ng-if="content.status != 'live' && content.status != 'Not Started'" class="text-show-action" href="{{linkViewDraft()}}/@{{content.language}}-@{{content.region == null ? 'us' : content.region}}@{{content.url_build}}/@{{content._id}}" @if(isProduction() || isDev()) target="_blank" @else target="_self" @endif>
                                                            <li> {{trans('cms_page/page-index.view_draft')}}</li>
                                                        </a>
                                                        <a ng-if="content.status == 'live'" class="text-show-action" href="{{linkViewDraft()}}/@{{content.language}}-@{{content.region == null ? 'us' : content.region}}@{{content.url_build}}" target="_blank"> 
                                                            <li> {{trans('cms_page/page-index.view_live')}}</li>
                                                        </a>
                                                        <a ng-if="content.status == 'live'&& content.version!=0" class="text-show-action" href="{{linkViewDraft()}}/@{{content.language}}-@{{content.region == null ? 'us' : content.region}}@{{content.url_build}}/@{{content._id}}" target="_self">
                                                            <li> {{trans('cms_page/page-index.view_revision')}}</li>
                                                        </a>
                                                        @if(\Auth::user()->can('edit_page') )
                                                            <a ng-if="content.status != 'live'" class="text-show-action" ng-href="@{{baseUrl}}/cms/pages/edit-page/@{{content._id}}" target="_self"> 
                                                                <li> {{trans('cms_page/page-index.edit_page')}}</li>
                                                            </a>
                                                            <a ng-if="content.status == 'live'" class="text-show-action" ng-href="@{{baseUrl}}/cms/pages/page-build/@{{content._id}}" target="_self"> 
                                                                <li>{{trans('cms_page/page-index.page_build')}}</li>
                                                            </a>
                                                        @endif
                                                        <a ng-click="getModalRequestRevision(content._id)" ng-if="content.status == 'live'" class="text-show-action"> 
                                                            <li> {{trans('cms_page/page-index.request_revision')}}</li>
                                                        </a>
                                                        <a ng-click="getModalRequestRegion(content._id)" class="text-show-action"> 
                                                            <li> {{trans('cms_page/page-index.request_region_variation')}}</li>
                                                        </a>
                                                        <a ng-if="content.ticket_id"  href="{{URL::to('support/show')}}/@{{content.ticket_id}}" target="_self" class="text-show-action" >
                                                            <li> {{trans('cms_page/page-index.view_task')}}</li>
                                                        </a>
                                                        @if (\Auth::user()->can('cms_delete_content'))                                                        
                                                            <a ng-if="!((content.language == 'en' &&  content.region == null && !content.copyID) || (content.language == 'en' &&  content.region == null && content.copyID && content.status == 'live'))"
                                                               ng-click="deleteContent(content._id, page)" class="text-show-action" target="_self"> 
                                                                <li> {{trans('cms_page/page-index.delete_content')}}</li>
                                                            </a>
                                                        @endif
                                                        <a ng-click="historyPage(content._id)" class="text-show-action" > 
                                                            <li> {{trans('cms_page/page-index.history')}} </li>
                                                        </a>
                                                        @if (\Auth::user()->can('manage_redirects'))
                                                            <a href="@{{baseUrl}}/cms/pages/redirect/@{{content._id}}" target="_self" class="text-show-action" > 
                                                                <li> {{trans('cms_page/page-index.redirect')}} </li>
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

	<div class="clearfix"></div>

</div>
<script type="text/ng-template" id="ng-table/filters/status.html">
    <select class="form-control" ng-model="params.filter()['status']">  
    	<option value="">{{trans('cms_page/page-index.all_status')}}</option>          
        <option class="yellow-status" value="Not Started">{{trans('cms_page/page-index.not_started')}}</option>
        <option class="purple-status" value="In Process">{{trans('cms_page/page-index.in_process')}}</option>
         <option class="ready-for-review-status" value="reviewed">{{trans('cms_page/page-index.ready_for_review')}}</option>
        <option class="dark-blue-status" value="Approved">{{trans('cms_page/page-index.approved')}}</option>
        <!-- <option class="red-status" value="Overdue">Overdue</option> -->
        <option class="greens-status" value="live">{{trans('cms_page/page-index.live')}}</option>
    </select>
</script>

<script type="text/javascript">
	window.pages ={!! json_encode($pages) !!};
	window.labels = {!! json_encode($labels) !!};
	window.tagsContent = {!! json_encode($tagsContent) !!};
	window.allTags = {!! json_encode($allTags) !!};
	window.currentPage = 'pages';
</script>
<!-- hide model loading -->
<script type="text/javascript">
    'use strict';
    (function($) {
        $('#page-loading').css('display','none');
    })(jQuery);
</script>
