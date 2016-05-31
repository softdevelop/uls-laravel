<table class="table table-striped center-td" ng-table="tableParams" show-filter="isSearch">
    <tbody id="responsive-table-body">
        <tr class="pointer" >
            <td data-title="'Ticket ID'" class=" w-104">
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}">
                    @{{ticket.parentTicket.id}}
                </a>
            </td>
            <td data-title="'Ticket Type'" class=" position-select">
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    @{{types[ticket.parentTicket.type_id]['name']}}
                </a>
            </td>
            <td data-title="'Subject'" class="w100">
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    @{{ticket.parentTicket.title}}
                </a>
            </td>
            <td data-title="'Status'" class="position-select w100" >
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    @{{states[ticket.parentTicket.status]}}
                </a>
            </td>
            <td data-title="'Priority'" class="w100">
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    @{{ticket.parentTicket.priority}}
                </a>
            </td>
            <td data-title="'Assignee'" class="w100">
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    @{{users_map[ticket.parentTicket.assign_id].name != null ? users_map[ticket.parentTicket.assign_id].name : 'Unassigned'}} @{{users_map[ticket.parentTicket.assign_id].deleted_at != null ? '(Deactivated)' : ''}}
                </a>
            </td>
            <td data-title="'Date Started'" class="w130" >
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    @{{ticket.parentTicket.created_at | myDateTime}}
                </a>
            </td>
            <td data-title="'Due Date'" class=" w130" >
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    <span ng-if="!hideDueDate">
                        @{{ticket.parentTicket.due_date | myDateTime}}
                    </span>
                </a>
            </td>
            <td data-title="'Percent Complete'" class=" w-110" >
                <a class="a-wrap-table" href="@{{baseUrl}}/support/show/@{{ticket.parentTicket.id}}"> 
                    <span class="progress progress-normal full-left">
                    <span class="progress-bar progress-bar-primary" style="width:@{{ticket.parentTicket.percent_complete}}%">@{{ticket.parentTicket.percent_complete}}%</span>
                </span>
            </td>
        </tr>
    </tbody>
</table>