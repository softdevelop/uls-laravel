
@extends('app')
@section('title')
	{{trans('configuration/release-version/release-version-index.release_version')}}
@stop
@section('content')

<div data-ng-controller="ReleaseVersionController" ng-init="setDIVHeight(); versionProduction={{$versionProduction}}; versionDemo={{$versionDemo}}">
    <div class="top-content">
        <label class="c-m"> {{trans('configuration/release-version/release-version-index.site_configuration')}} : {{trans('configuration/release-version/release-version-index.release_version_manager')}}</label>
        <a data-toggle="modal" ng-click="getModalCreateRelease()" class="hidden-xs btn btn-primary pull-right fix-btn-top-content">
	        <i class="fa fa-plus"></i> {{trans('configuration/release-version/release-version-index.add_new_release_version')}}
	    </a>
    </div>

    <div class="content">
	
        <div class="box-with-title">
            <div class="box-with-title-top">
                <p class="title">{{trans('configuration/release-version/release-version-index.active_release_version')}}</p>
            </div>
            <div class="box-with-title-body">
				<div>
					<span>{{getUrlProductionVersion()}}</span>
	                <span>
	                	<a href="#" id="version-production" editable-select="versionProduction.version" e-ng-options="s.value as s.text for s in versionShowInSelect" onbeforesave="changeVersion($data, versionProduction.version, 'active_production')">
	                		@{{ showVersionsProduction() }}
						</a>
					</span>
				</div>

				<div>
					<span>{{getUrlDemoVersion()}}</span>
					<span>
		                <a href="#" id="version-demo" editable-select="versionDemo.version" e-ng-options="s.value as s.text for s in versionShowInSelect" onbeforesave="changeVersion($data, versionDemo.version, 'active_demo')">
	                		@{{ showVersionsDemo() }}
						</a>
					</span>
				</div>
                
            </div>
        </div>

        <div class="box-with-title version-history">
            <div class="box-with-title-top h51">
                <label class="title m-t-5">{{trans('configuration/release-version/release-version-index.version_history')}}</label>
                <a href="" ng-if="!isPastVersion" ng-click="getPastVersion()" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-eye"></i> {{trans('configuration/release-version/release-version-index.show_past_version')}}
                </a>

                <a href="" ng-if="isPastVersion" ng-click="hidePastVersion()" class="btn btn-default btn-sm pull-right">
                	<i class="fa fa-eye"></i> {{trans('configuration/release-version/release-version-index.show_current_version')}}
                </a>

            </div>

            <div class="box-with-title-body release-table">

				<div class="table-responsive">
					<table class="table center-td table-bordered" ng-table="tableParams" show-filter="isSearch">
					<!-- <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a> -->
						<tbody>
							<tr ng-repeat="item in $data">

								<td data-title="'Release Version'" sortable="'version'">@{{item.version}}</td>
								<td data-title="'Status'" sortable="'status'" >
									<div class="vertical-box">
							            <span class="fa fa-circle yellow-status" ng-show ="item.status !='live'" tooltip="Not Started" tooltip-trigger tooltip-animation="true" tooltip-placement="top"></span>
							            <span class="fa fa-circle greens-status" ng-show ="item.status =='live'" tooltip="Live" tooltip-trigger tooltip-animation="true" tooltip-placement="top"></span>
							        </div>
								</td>
								<td data-title="'Not Started'" sortable="'countNotStarted'">@{{item.countNotStarted}}</td>
								<td data-title="'In Process'" sortable="'countInProcess'" >@{{item.countInProcess}}</td>
								<td data-title="'Ready For Review'" sortable="'countReadyForReview'">@{{item.countReadyForReview}}</td>
								<td data-title="'Approved'" sortable="'countApproved'">@{{item.countApproved}}</td>
								<td data-title="'Live'" sortable="'countLive'" >@{{item.countLive}}</td>
								<td data-title="'Languages'" sortable="'countLanguage'" >@{{item.countLanguage}}</td>
								<td data-title="'Regions'" sortable="'countRegion'" >@{{item.countRegion ==0?'n/a':item.countRegion}}</td>
								<td data-title="'Description'" sortable="'description'" >@{{item.description}}</td>
								<td class="show-action text-center" data-title="'Action'">
	                            <div class="wrap-ac-group">
	                                <i class="fa fa-ellipsis-v"></i>
	                                <a href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn"></a>
									<ul class="group-btn-ac">
										<a href="" class="text-show-action" ng-click="getModalCreateRelease(item._id)" >
											<li> {{trans('configuration/release-version/release-version-index.edit_release_version')}}</li>
										</a>
										<a href="" ng-show ="item.active_production =='new' &&item.active_demo =='new'" ng-click="removeReleaseRevision(item._id)" class="text-show-action" >
											<li> {{trans('configuration/release-version/release-version-index.delete_release_version')}}</li >
										</a>
									</ul>
	                            </div>
	                        </td>
							</tr>

						</tbody>
					</table>	
				</div>
	                
	                
	        </div>

            
        </div>
 	
    </div>  
</div>


@stop
@section('script')	
	<script>
		window.versions = {!!json_encode($versions)!!}
		window.versionShowInSelect = {!!json_encode($versionShowInSelect)!!}
	</script>
		{!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
		{!! Html::script('bower_components/ng-file-upload/ng-file-upload.min.js')!!}
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/pages/release-version/ReleaseVersionService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/pages/release-version/ReleaseVersionController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/versions.js') }}"></script>
	@endif
	
@stop


