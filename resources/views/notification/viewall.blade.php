@extends('app')
@section('content')
<div class="wrap-branch">
	<div class="top-content">
		<label class="c-m">Notifications</label>
	</div>
	<div class="content" ng-controller="NotificationController">
		<div class="col-lg-12 full-notification" ng-init="getNotifications()">
			<ul class="fdropdown-menu" role="notification">
		        <li class="fmedia" ng-repeat="notification in notifications track by $index" ng-class="{'f-active': $index+1 <= hightlight}">
		            <a class="wrap-media1" ng-href="@{{baseUrl}}/@{{notification.href}}">
		                <div class="m-t-10 media-body1 col-lg-9 col-md-9 col-sm-9 col-xs-9">
		                    <img ng-src="@{{users_map[notification.sender_id].avatar}}" alt="" class="img-circle" width="40" height="40">
		                    <span class="status1">
		                        <span class="fname">
		                           @{{users_map[notification.sender_id].first_name + ' ' + users_map[notification.sender_id].last_name }}
		                        </span>
		                        <span class="c-0d0d0d">@{{notification.message}}</span>
		                    </span> 
		                </div>
		                <div class="pull-right m-t-18 text-right col-lg-3 col-md-3 col-sm-3 col-xs-3 ">
		                    <small class="ftext-muted">@{{notification.created_at | elapsedtime}}</small>
		                </div>
		            </a>
		        </li>
			</ul>
		</div>
	</div>
</div>
@stop