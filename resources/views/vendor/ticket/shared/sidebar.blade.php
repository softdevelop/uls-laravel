<?php
    use Rowboat\Ticket\Services\MenuService;
?>

<div class="sider-ticket" id="ticket-menu">
    <div class="sidebar-head">
        <div class="sidebar-block text-center">
            <a class="btn btn-primary btn-squared btn-block"  ng-href="{{URL::to('support/new')}}">
            <i class="fa fa-pencil"></i> {{trans('tickets/sidebar.left.create_new_task')}}
            </a>
        </div>
    </div>
        <ul class="sidebar-menu sm-icons-block sm-icons-right">
            <li ng-class="{active: groupName=='All Open'}">
                <a href="{{URL::to('support/state/all_open')}}">
                    <span>{{trans('tickets/sidebar.left.all_open')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[0]}}</span>
                </a>
            </li>

            <li ng-class="{active: groupName=='Assigned To Me'}">
                <a href="{{URL::to('support/state/assigned-to-me')}}">
                    <span>{{trans('tickets/sidebar.left.assigned_to_me')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[7]}}</span>
                </a>
            </li>

            <li ng-class="{active: groupName=='Opened By Me'}">
                <a href="{{URL::to('support/state/opened-by-me')}}">
                    <span>{{trans('tickets/sidebar.left.opened_by_me')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[8]}}</span>
                </a>
            </li>

            <li ng-class="{active: groupName=='Following'}">
                <a href="{{URL::to('support/state/following')}}">
                    <span>{{trans('tickets/sidebar.left.following')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[6]}}</span>
                </a>
            </li>
            <li ng-class="{active: groupName=='New'}">
                <a href="{{URL::to('support/state/new')}}">
                    <span>{{trans('tickets/sidebar.left.new')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[1]}}</span>
                </a>
            </li>
            <li ng-class="{active: groupName=='Assigned'}">
                <a href="{{URL::to('support/state/assigned')}}">
                    <span>{{trans('tickets/sidebar.left.assigned')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[2]}}</span>
                </a>
            </li>

            <li ng-class="{active: groupName=='Ready For Review'}">
                <a href="{{URL::to('support/state/reviewed')}}">
                    <span>{{trans('tickets/sidebar.left.ready_for_review')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[3]}}</span>
                </a>
            </li>

            <li ng-class="{active: groupName=='Approved'}">
                <a href="{{URL::to('support/state/approved')}}">
                    <span>{{trans('tickets/sidebar.left.approved')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[4]}}</span>
                </a>
            </li>

            <li ng-class="{active: groupName=='Deployed'}">
                <a href="{{URL::to('support/state/deployed')}}">
                    <span>{{trans('tickets/sidebar.left.deploy')}}</span>
                    <span class="badge pull-right">@{{numberOfTickets[5]}}</span>
                </a>
            </li>
        </ul>   
</div>