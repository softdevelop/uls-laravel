
    <a  class="dropdown-toggle" data-toggle="dropdown" data-ng-click="getNotifications()">
        <i class="fa fa-bell-o"></i>
        <span class="badge badge-primary">@{{amount}}</span>
    </a>
    <ul class="dropdown-menu" data-role="notification" >
        <li class="dropdown-header">Notifications</li>
        <div data-scrollable class="over-noti">
            <li class="media pointer" ng-repeat="notification in notifications">
                    <div class="media-body">
                        <a>
                            <img class="media-object thumb" ng-src="@{{users_map[notification.sender_id].avatar}}" alt="people"> @{{users_map[notification.sender_id].first_name + ' ' + users_map[notification.sender_id].last_name }}.
                        </a>
                        <a class="content-noti" ng-href="@{{notification.href}}">
                             @{{notification.message}}

                            <small class="text-muted">@{{notification.created_at | elapsedtime}}</small>
                        </a>
                       
                    </div>
              
            </li>
        </div>
    </ul>
