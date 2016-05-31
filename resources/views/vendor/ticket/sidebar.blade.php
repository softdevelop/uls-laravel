<?php
    use Rowboat\Ticket\Services\MenuService;
?>
<div data-type="dropdown" class="sidebar left sidebar-size-2 sidebar-offset-1 sidebar-skin-white sidebar-visible-desktop sider-ticket" id="ticket-menu">
    <div data-scrollable>
        <div class="sidebar-block equal-padding text-center">
            <a ng-href="/support/new" class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Create New Ticket</a>
        </div>
        @if(Auth::user()->hasRole('super_admin') || Auth::user()->hasPerm(MenuService::listPemissions()))
            <ul class="sidebar-menu sm-icons-block sm-icons-right">
                 <li ng-class="{active: groupName=='All Open'}">
                    <a href="/support/state/all_open"><i class="fa fa-inbox"></i><span>All Open</span> <span class="badge">@{{numberOfTickets[5]}}</span></a>
                </li>
                <li ng-class="{active: groupName=='New'}">
                    <a href="/support/state/new"><i class="fa fa-inbox"></i><span>New</span> <span class="badge">@{{numberOfTickets[0]}}</span></a>
                </li>
                 <li ng-class="{active: groupName=='Assigned'}">
                    <a href="/support/state/assigned"><i class="fa fa-inbox"></i><span>Assigned</span> <span class="badge">@{{numberOfTickets[1]}}</span></a>
                </li>
                <li ng-class="{active: groupName=='Updated'}">
                    <a href="/support/state/updated"><i class="fa fa-send"></i><span>Responded</span><span class="badge">@{{numberOfTickets[2]}}</span></a>
                </li>
                <li ng-class="{active: groupName=='Watching'}">
                    <a href="/support/state/following"><i class="fa fa-clipboard"></i><span>Following</span> <span class="badge">@{{numberOfTickets[3]}}<span></a>
                </li>
                <li ng-class="{active: groupName=='Closed'}">
                    <a href="/support/state/closed"><i class="fa fa-warning"></i><span>Closed</span> <span class="badge">@{{numberOfTickets[4]}}</span></a>
                </li>
            </ul>
        @else
            <ul class="sidebar-menu sm-icons-block sm-icons-right">
                <li ng-class="{active: groupName=='New'}">
                    <a href="/support/state/all_open"><i class="fa fa-inbox"></i><span>All Open</span> <span class="badge">@{{numberOfTickets[4]}}</span></a>
                </li>
                <li ng-class="{active: groupName=='New'}">
                    <a href="/support/state/new"><i class="fa fa-inbox"></i><span>New</span> <span class="badge">@{{numberOfTickets[0]}}</span></a>
                </li>
                 <li ng-class="{active: groupName=='Assigned'}">
                    <a href="/support/state/assigned"><i class="fa fa-inbox"></i><span>Assigned</span> <span class="badge">@{{numberOfTickets[1]}}</span></a>
                </li>
                <li ng-class="{active: groupName=='Updated'}">
                    <a href="/support/state/updated"><i class="fa fa-send"></i><span>Updated</span><span class="badge">@{{numberOfTickets[2]}}</span></a>
                </li>
               
                <li ng-class="{active: groupName=='Closed'}">
                    <a href="/support/state/closed"><i class="fa fa-warning"></i><span>Closed</span> <span class="badge">@{{numberOfTickets[3]}}</span></a>
                </li>
            </ul>
        @endif
    </div>
</div>