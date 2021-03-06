@extends('app')
@section('title')
	{{ trans('User/user-index.breadcrum') }}
@stop
@section('content')
<div ng-controller="UserController" ng-init="hashData={{json_encode($hashData)}}">
	<div class="top-content">
	    <label class="c-m">{{ trans('User/user-index.breadcrum') }}
	    	<a href="javascript:void(0)" ng-click="showHelp(['5714bf5c0454aa4b65395634','5714bf8a0454aa1a09799776','5714bf3f0454aa4b6b45de55'])">
	    		<i title="Help Information" class="fa fa-info-circle help-infor-icon"></i>
	    	</a>
	    </label>
	    <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalCreateUser()" class="btn btn-primary pull-right fix-btn-top-content">
            <i class="fa fa-plus"></i> &nbsp {{ trans('User/user-index.add_user') }}
        </a>
	</div>
	<div class="content user-content hidden">
	    <div class="alert alert-danger" ng-show="error_message">
	         <button type="button" class="close" data-dismiss="alert">×</button>
	        @{{error_message}}
	    </div>
	    <div class="alert alert-success" ng-show="success_message">
	         <button type="button" class="close" data-dismiss="alert">×</button>
	        @{{success_message}}
	    </div>
	    <div class="title-table">
	        <div class="table-responsive set-height"> 
	            <table class="table table-striped fix-height-tb center-td" ng-table="tableParams" show-filter="isSearch">
	                <a class="fixed-search" href="javascript:void(0)" ng-click="btnSearch()" >
	                    <i class="fa fa-search"></i>
	                </a>         
	                <tbody>
	                    <tr ng-repeat="item in $data">
	                        <td class="text-left" sortable="'name'" data-title="'{{ trans('User/user-index.name') }}'" filter="{ 'name': 'text' }">
	                            <a ng-show="item.status != 'no'" ng-href="@{{  baseUrl +'/user/profile/'+item.id }}">
	                                <img ng-if="item.avatar" ng-src="@{{item.avatar}}" width="40" class="img-circle" />
	                                &nbsp@{{item.name}}
	                            </a>
	                            <a ng-show="item.status == 'no'">
	                                <img ng-if="item.avatar" ng-src="@{{item.avatar}}" width="40" class="img-circle" />
	                                &nbsp@{{item.name}}
	                            </a>
	                            
	                        </td>
	                        <td class="text-left" sortable="'email'" data-title="'{{ trans('User/user-index.email') }}'" filter="{ 'email': 'text' }">
	                            <a ng-show="item.deleted_at == null"  ng-href="@{{  baseUrl +'/user/profile/'+item.id }}">@{{item.email}} </a>
	                            <a ng-show="item.deleted_at != null">@{{item.email}} </a>
	                        </td>
	                        <td class="text-center" sortable="'created_at'" data-title="'{{ trans('User/user-index.date_created') }}'">@{{item.created_at | clientDate:'MM-dd-yyyy HH:mm:ss'}}</td>
	                        <td class="text-center" data-title="'{{ trans('User/user-index.status') }}'" filter="{'status':'status'}">
	                            <span title="Active User" ng-show="item.status == 'yes'" class="label label-success pointer">{{ trans('User/user-index.active') }}</span>
	                            <span ng-click="changeStatus(item, $index)" ng-show="item.status == 'no'" class="label label-danger pointer">{{ trans('User/user-index.reactivate') }}</span>
	                        </td>
	                        <td class="text-center" sortable="'last_login'" data-title="'{{ trans('User/user-index.last_login') }}'">@{{ item.last_login | clientDate:'MM-dd-yyyy HH:mm:ss'}}</td>
	                        <td class="show-action text-left" data-title="'{{ trans('User/user-index.action') }}'">
	                            <div class="wrap-ac-group">
	                                <i class="fa fa-ellipsis-v"></i>
	                                <a ng-disabled="item.status == 'no'" href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn">
	                                    
	                                </a>
	                                  <ul class="group-btn-ac">
	                                    <li>
	                                        <a class="text-show-action" ng-href="/admin/user/show-permissions/@{{item.id}}">
	                                            <i class="fa fa-key"></i> {{ trans('User/user-index.update_permissions') }}
	                                        </a>
	                                    </li>
	                                    <li>
	                                      <a class="text-show-action" href="javascript:void(0)" ng-click="resetPassword(item.email)">
	                                        <i class="fa fa-unlock-alt"></i> {{ trans('User/user-index.reset_password') }}
	                                      </a>
	                                    </li> 
	                                    <li>
	                                      <a class="text-show-action" ng-href="/become-user/@{{item.email}}">
	                                        <i class="fa fa-user-secret"></i>{{ trans('User/user-index.become_user') }}
	                                      </a>
	                                    </li>
	                                    <li>
	                                     <a  class="text-show-action" ng-click="getModalCreateUser(item.id)">
	                                        <i class="fa fa-pencil"></i> {{ trans('User/user-index.edit_user_detail') }}
	                                      </a>
	                                    </li>
	                                    <li>
	                                      <a  class="text-show-action" ng-click="delete(item.id)">
	                                        <i class="fa fa-trash-o"></i>{{ trans('User/user-index.deactivate_user') }}
	                                    </a>
	                                    </li>
	                                  </ul>
	                            </div>
	                        </td> 
	                    </tr>    
	                </tbody>
	            </table>

	            <script type="text/ng-template" id="ng-table/filters/status.html">
	                <div class="checkbox checkbox-success">
	                    <input id="filter-checkbox" ng-change="changeFilter()" type="checkbox" ng-model="params.filter()[name]" name="filter-status" ng-true-value="'yes'" ng-false-value="'no'"/>
	                    <label for="filter-checkbox" ></label>
	                </div>
	            </script>
	        </div>
	    </div>
	</div>
</div>


@stop
@section('script')
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/user/userController.js?v='.getVersionScript()) !!}
		{!! Html::script('app/components/user/userService.js?v='.getVersionScript()) !!}
		{!! Html::script('app/components/user/help-editor/HelpEditorDirective.js?v='.getVersionScript()) !!}
	@else
		<script src="{{ elixir('app/pages/user.js') }}"></script>
	@endif
@stop
