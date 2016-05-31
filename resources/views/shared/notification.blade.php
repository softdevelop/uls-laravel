
<a href="" class="dropdown-toggle" data-toggle="dropdown" data-ng-click="getNotifications()">
    <i class="ti-bell absolute"></i>
    <span class="badge badge-primary">@{{amount}}</span>
</a>
<ul class="dropdown-menu" role="notification">
    <li class="dropdown-header">Notification</li>
    <div class="scroll-noti1">
        <li class="media" ng-repeat="notification in notifications | limitTo:limitTo track by $index" ng-class="{'active1': $index+1 <= hightlight}">
            <div class="wrap-link">
                <a ng-href="@{{baseUrl}}/@{{notification.href}}" class="wrap-media" target="_self">
                    <div class="up-top"></div>
                    <div class="media-body">
                        <img ng-src="@{{users_map[notification.sender_id].avatar}}" ng-if="notification.sender_id != -1" alt="" class="img-circle" width="40" height="40">
                        <img ng-src="@{{baseUrl}}/160x160_avatar_default.png?t=1" ng-if="notification.sender_id == -1" alt="" class="img-circle" width="40" height="40">
                        <span class="status">
                            <span ng-if="notification.sender_id != -1">
                                @{{users_map[notification.sender_id].name}}@{{users_map[notification.sender_id].deleted_at != null ? ' (Deactivated)' : ''}}.
                            </span>

                            <span ng-if="notification.sender_id == -1">
                                System.
                            </span>
                            <span>@{{notification.message}}</span>
                        </span> 
                    </div>
                    <div class="pull-right m-r-20">
                        <!-- <small class="text-muted">@{{notification.created_at}}</small> -->
                        <small class="text-muted">@{{notification.created_at | clientDate:'MM-dd-yyyy HH:mm:ss' | elapsedtime}}</small>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </li>
    </div>
    {{-- <div class="text-center wrap-box-show-all"><a class="show-all-noti" href="/notification">Show All</a></div> --}}
</ul>