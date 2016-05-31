<td class="show-gradation padding-none">
	<div class="show-animate">
		<ul class="style-ul">
            <li id="li-select-tag-@{{value.id}}" ng-repeat="(index, value) in ticket.childTickets" ng-include="'subSelect-@{{index}}'">
                <script type="text/ng-template" id="subSelect-@{{index}}">
                    <a class="a-wrap-table" href="/support/show/@{{value.id}}">
                        <!-- table for child ticket details -->
                        <table class="table center-td margin-none min-width-1100">
                            <tr class="child-active child-tag">
                                <td class="text-center child-plus-or-minus w70 border-bottom padding-none" data-title="''" >
                                    <a class="btn-toggle-@{{value.id}} c-000" href="javascript:void(0)" ng-if="value.children.length > 0" data-toggle="collapse" data-target="#show-sub-select-@{{value.id}}" >
                                        <i class="fa fa-plus p-15-20" ng-click="showSubSelect($event, value.id)"></i>
                                    </a>
                                </td>
                                <td data-title="'Ticket ID'" class="w-104 border-bottom">@{{value.id}}</td>

                                <td data-title="'Ticket Type'" class="min-width-150 border-bottom">@{{types[value.type_id]['name']}}</td>

                                <td data-title="'Subject'" class="w100 border-bottom">@{{value.title}}</td>

                                <td data-title="'Status'" class="w100 border-bottom" >@{{states[value.status]}}</td>

                                <td data-title="'Priority'" class='w100 border-bottom' >@{{value.priority}}</td>

                                <td data-title="'Assignee'" class="w100 border-bottom">@{{users_map[value.assign_id].name != null ? users_map[value.assign_id].name : 'Unassigned'}} @{{users_map[value.assign_id].deleted_at != null ? '(Deactivated)' : ''}}</td>

                                <td data-title="'Date Started'" class="w130 border-bottom" >@{{value.created_at | myDateTime}}</td>

                                <td data-title="'Due Date'" class="w130 border-bottom" >
                                    <span ng-if="!hideDueDate">
                                        @{{value.due_date | myDateTime}}        
                                    </span>
                                </td>

                                <td data-title="'Percent Complete'" class="w130 border-bottom" >
                                    <span class="progress progress-normal full-left">
                                    <span class="progress-bar progress-bar-primary" style="width:@{{value.percent_complete}}%">@{{value.percent_complete}}%</span>

                                   <!--  <div class="wrap-progress-circle">
                                        <div class="c100 p@{{value.percent_complete}} small" >
                                            <span>@{{value.percent_complete || "0" }}%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div> -->

                                </td>
                            </tr>
                        </table>
                        <!-- table for child ticket details -->
                    </a>
                    
                    <ul class="style-ul collapse show-inset" id="show-sub-select-@{{value.id}}">
                        <li ng-repeat="(index, value) in value.children" ng-include="'subSelect-@{{index}}'"></li>
                    </ul>
                </script>            
            </li>
        </ul>
    </div>
</td>