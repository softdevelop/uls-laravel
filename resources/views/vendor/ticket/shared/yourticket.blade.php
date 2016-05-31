<div class="wrap-your-ticket">
    <i  class="fa fa-ticket"></i>
    <div class="your-ticket">
        <div class="sidebar-block equal-padding">
            <input type="text" ng-model="searchQuery.title" class="form-control ng-pristine ng-untouched ng-valid" placeholder={{trans('tickets/sidebar.right.search')}}>
            <div class="head-your-ticket">
                <h4 class="title title-your-ticket">{{trans('tickets/sidebar.right.your_task')}}</h4>
            </div>
            <div class="content-your-ticket">
                <ul class="scroll-y-t style-ul"> 
                    <li data-ng-repeat="item in tickets | filter:searchQuery" class="list-unstyled sidebar-block fixsiderbar">
                        <div class="media">
                            <span class="media-left">
                                <img ng-src="@{{users_map[item['user_id']].avatar}}" class="img-circle" width="30"/>
                                &nbsp
                                 <span class="your-awatar text-capitalize">
                                    @{{users_map[item['user_id']].first_name + ' ' + users_map[item['user_id']].last_name}}
                                </span>
                            </span>
                        </div>

                        <div class="title-your-ticket">
                            <h5 class="h5-tittle"><a class="text-capitalize tittleA" ng-href="@{{baseUrl}}/support/show/@{{item.id}}">@{{item['title']}}</a></h5>
                        </div>
                        <div class="p-l-10">
                            <span class="s-w-ans" ng-if="item.status == 'closed'">
                                <i class="fa fa-circle"></i> 
                                <span> @{{states[item.status]}}</span>
                            </span>

                            <span class="s-w-ans" ng-if="item.status=='new'">
                                <i  class="fa fa-exchange"></i> 
                                <span> @{{states[item.status]}}</span>
                            </span>

                            <span class="s-w-ans" ng-if="item.status=='open'">
                                <i  class="fa fa-refresh"></i>
                                <span> @{{states[item.status]}}</span>
                            </span>

                            <span class="s-w-ans" ng-if="item.status=='assigned'">
                                <i  class="fa fa-refresh"></i>
                                <span> @{{states[item.status]}}</span>
                            </span>

                            <span class="s-w-ans" ng-if="item.status=='reviewed'">
                                <i  class="fa fa-refresh"></i>
                                <span> @{{states[item.status]}}</span>
                            </span>

                            <span class="s-w-ans" ng-if="item.status=='approved'">
                                <i  class="fa fa-refresh"></i>
                                <span> @{{states[item.status]}}</span>
                            </span>
                            
                            <timer ng-if="item.timer && item.status=='closed'" start-time="item.timer" end-time="item.timer" >
                                <small class="pull-right text-muted">@{{ddays}} @{{ddays <= 1 ? 'day, ' : 'days, '}}@{{hhours}}:@{{mminutes}}:@{{sseconds}} ago</small>
                                <div class="clearfix"></div>
                            </timer>

                            <timer ng-if="item.timer && item.status!='closed'" start-time="item.timer">
                                <small class="pull-right text-muted">@{{ddays}} @{{ddays <= 1 ? 'day, ' : 'days, '}}@{{hhours}}:@{{mminutes}}:@{{sseconds}} ago</small>
                                <div class="clearfix"></div>
                            </timer>
                            
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>