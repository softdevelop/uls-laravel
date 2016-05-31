@extends('ticket::ticket.layout.ticket')
    @section('title')
        {{trans('tickets/detail.web_title')}}
    @stop
@section('content')

    @include('ticket::ticket.shared.yourticket')

    <ul class="breadcrumb br-ticket wrap-breadcrumb" ng-init="getTicket({{$id}});getAmountOfEachTypeTicket();">
        <li class="breadcrumb-level">
            <a href="/support/state/@{{linkGroupName}}">@{{groupName}}</a>
        </li>
        <li class="breadcrumb-level">
            <span title="@{{ticket.title}}">
                @{{ticket.title}}
            </span>
        </li>
    </ul>
    <div class="wrap-box-content">
        <div class="top-detail-ticket hidden-xs">
            <div class="col-lg-3 col-md-3 col-xs-3">
                <p class="space-id-ticket">{{trans('tickets/detail.ticket_id')}}: <strong>&nbsp;#@{{ticket.id}}</strong></p>
                <p ng-show="ticket.base_id" class="space-id-ticket-parent">{{trans('tickets/detail.parent_ticket_id')}}: <strong>&nbsp;<a class="child-link" href="/support/show/@{{ticket.base_id}}" target="_self" >#@{{ticket.base_id}}</a></strong></p>
            </div>
            <div class="col-lg-5 col-md-5 col-xs-5">
                <span class="text-grey">{{trans('tickets/detail.ticket_type')}}:</span>
                <strong>@{{types[ticket.type_id]['name']}}</strong>
                <p ng-if="ticket.type == 'page'" class="ellipsis-width-auto">
                    <a tooltip="@{{ticket.url}}" tooltip-trigger="" tooltip-animation="true" tooltip-placement="top" href="{{linkViewDraft()}}@{{ticket.url}}" target="_bank">@{{ticket.url}}</a>
                </p>

                <p ng-if="ticket.type != 'page'" class="ellipsis-width-auto">
                    <a tooltip="@{{ticket.url}}" tooltip-trigger="" tooltip-animation="true" tooltip-placement="top" href="@{{ticket.url}}" target="_bank">@{{ticket.url}}</a>
                </p>
                
                <p class="title-ticket">@{{ticket.title}}</p>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4">
                <div class="pull-right left-768" ng-show="lastUpdated">
                    <p class="text-grey">{{trans('tickets/detail.last_updated')}}:</p>

                    <timer ng-if="ticket.status!='closed'" start-time="lastUpdated">
                        @{{ddays > 0 ? ddays + (ddays == 1 ? ' day, ' : ' days, ' ) +  hhours + (hhours > 1 ? ' hours ago' : ' hour ago'): '' }}
                        @{{ddays == 0 &&  hhours > 0 ? hhours + (hhours == 1 ? ' hour, ' : ' hours, ' ) +  mminutes + (mminutes > 1 ? ' minutes ago' : ' minute ago'): '' }}
                        @{{ddays == 0 && hhours == 0 ? mminutes + (mminutes == 1 ? ' minute, ' : ' minutes, ' ) +  sseconds + (sseconds > 1 ? ' seconds ago' : ' second ago'): '' }}
                    </timer>

                    <timer ng-if="ticket.status=='closed'" start-time="lastUpdated" end-time="lastUpdated">
                        @{{ddays > 0 ? ddays + (ddays == 1 ? ' day, ' : ' days, ' ) +  hhours + (hhours > 1 ? ' hours ago' : ' hour ago'): '' }}
                        @{{ddays == 0 &&  hhours > 0 ? hhours + (hhours == 1 ? ' hour, ' : ' hours, ' ) +  mminutes + (mminutes > 1 ? ' minutes ago' : ' minute ago'): '' }}
                        @{{ddays == 0 && hhours == 0 ? mminutes + (mminutes == 1 ? ' minute, ' : ' minutes, ' ) +  sseconds + (sseconds > 1 ? ' seconds ago' : ' second ago'): '' }}
                    </timer>
                </div>
            </div>

            <label for="" class="label-st st-n bg-new-status-ticket" ng-if="ticket.status == 'new'" >NEW</label>
            <label for="" class="label-st st-o bg-open-status-ticket" ng-if="ticket.status!='answered' && (ticket.status=='open' || ticket.status=='assigned')" >OPEN
            </label>
            <label for="" class="label-st st-a bg-answered-status-ticket" ng-if="ticket.status == 'answered'" >ANSWERED</label>
            <label for="" class="label-st st-c bg-close-status-ticket" ng-if="ticket.status == 'closed'" >CLOSED</label>
            <label for="" class="label-st st-o bg-ready-for-review-status-ticket" ng-if="ticket.status == 'reviewed'" >READY FOR REVIEW</label>
            <label for="" class="label-st st-o bg-approved-status-ticket" ng-if="ticket.status == 'approved'" >APPROVED</label>

            <div class="clearfix"></div>
        </div>

        <div class="top-detail-ticket visible-xs">
            <div class="col-lg-12 col-md-12 col-xs-12 l-h-30">
                <p>{{trans('tickets/detail.ticket_id')}}: <strong>&nbsp;#@{{ticket.id}}</strong></p>
                <span class="text-grey">{{trans('tickets/detail.ticket_type')}}:</span> <strong>@{{types[ticket.type_id]['name']}}</strong>
                <br />

                <span class="text-grey">{{trans('tickets/detail.status')}}:</span>

                <span for="" class="padding-stt st-n  bg-new-status-ticket" ng-if="ticket.status == 'new'" >NEW</span>
                <span for="" class="padding-stt st-o bg-open-status-ticket" ng-if="ticket.status!='answered' && (ticket.status=='open' || ticket.status=='assigned')" >OPEN</span>
                <span for="" class="padding-stt st-a bg-answered-status-ticket" ng-if="ticket.status == 'answered'" >ANSWERED</span>
                <span for="" class="padding-stt st-c bg-close-status-ticket" ng-if="ticket.status == 'closed'" >CLOSE</span>
                <span for="" class="padding-stt st-o bg-ready-for-review-status-ticket" ng-if="ticket.status == 'reviewed'" >READY FOR REVIEW</span>
                <span for="" class="padding-stt st-o bg-approved-status-ticket" ng-if="ticket.status == 'approved'" >APPROVED</span>

                <br />

                <span class="text-grey">{{trans('tickets/detail.originator')}}:</span> <strong class="p-l-10">@{{users_map[ticket['user_id']].name}}  @{{users_map[ticket['user_id']].deleted_at != null ? '(Deactivated)' : ''}}</strong>
                <br />

                <span class="text-grey">{{trans('tickets/detail.assigned_to')}}:</span> <strong ng-show="ticket.assign_id">@{{users_map[ticket.assign_id].name}} @{{users_map[ticket.assign_id].deleted_at != null ? '(Deactivated)' : ''}}</strong>

            </div>
            <div class="clearfix"></div>
        </div>

        <!-- begin info ticket -->
        <div class="info-user-ticket fix-height-box hidden-xs">
            <input type="hidden" ng-model="userId" ng-init="userId={{Auth::user()->id}}" />

            <!-- Originator -->
            <div class="col-lg-3 ava-u">
                <div class="box-u-ava">
                    <label>{{trans('tickets/detail.originator')}}:</label>
                    <div class="mini-show">
                        <img ng-src="@{{users_map[ticket['user_id']].avatar}}" alt="ava" />
                        <span class="p-l-10">@{{users_map[ticket['user_id']].name}}  @{{users_map[ticket['user_id']].deleted_at != null ? '(Deactivated)' : ''}}</span>
                    </div>
                </div>
            </div>
            <!-- End Originator -->

            <!-- Assign ticket -->
            <div class="col-lg-3 ava-u">
                <div class="box-u-ava allways-visible">
                    <label ng-if="!ticket.assign_id" class="pull-left"> <i>{{trans('tickets/detail.unassigned')}}</i></label>
                    <label class="lb-1" ng-if="ticket.assign_id">{{trans('tickets/detail.assigned_to')}}:</label>
                        <span class="lb-2 text-center" ng-if="((ticketAdmin && ticket.status != 'approved') || (userId==ticket.assign_id && ticket.status == 'assigned') || (isSysAdmin && ticket.status == 'approved' && !isCms)) && checkAssign && ticket.status!='closed'">
                                <select-menu text="@{{ticket.assign_id ? 'Re-assign': 'Assignee'}}" placeholder="Search User" title={{trans('tickets/detail.assign_directive')}}
                                           items="usersOfTicket" 
                                           ng-model="assignId" 
                                           user-id="ticket.assign_id" 
                                           on-click="assignPeople(assignId,ticket.assign_id,ticket.user_id)" 
                                           type="assign" icon="@{{ticket.assign_id ? 'fa-undo': 'fa-gear'}}">
                                </select-menu>

                        </span>

                    <div class="mini-show" ng-if="ticket.assign_id">

                        <img class="img-mini" ng-src="@{{users_map[ticket.assign_id].avatar}} " alt="ava" />
                        <!-- Action un-assign ticket -->
                        <a href="" ng-if="ticket.status != 'closed'" ng-click="unAssign(ticket.id)" class="a-times c-000" id="btnUnAssign" title={{trans('tickets/detail.button.un_assign')}}>
                            <i class="fa fa-times"></i>
                        </a>

                        <span class="p-l-10">
                            @{{users_map[ticket.assign_id].name}} @{{users_map[ticket.assign_id].deleted_at != null ? '(Deactivated)' : ''}}
                        </span>
                    </div>
                    <div class="clearfix"></div>


                </div>
            </div>
            <!-- End Assign ticket -->

            <!-- Invite list -->
            <div class="col-lg-3 ava-u" ng-if="(isSysAdmin || ticketAdmin || following) && ticket.status != 'closed'">

                <div class="box-u-ava btn-assignee allways-visible" ng-class="{'none-btn-assignee':!(!following && ((isSysAdmin && ticket.status=='approved') || ticketAdmin) && userId!=ticket.user_id && userId!=ticket.assign_id && ticket.status!='closed')}">

                    <label class="lb-1">{{trans('tickets/detail.follower')}}:</label>

                    <label ng-if="((isSysAdmin && ticket.status=='approved') || ticketAdmin) && ticket.status!='closed' && invites.length == 0" class="pull-left"> <i>{{trans('tickets/detail.no_followers')}}</i></label>

                    <button title="Click to follow me" ng-disabled="followMe" class="btn btn-default btn-xs pull-right" ng-click="addFollowing(ticket['id'])" ng-if="!following && ((isSysAdmin && ticket.status=='approved') || ticketAdmin) && userId!=ticket.user_id && userId!=ticket.assign_id && ticket.status!='closed'">
                        <i class="fa fa-rss-square"></i> {{trans('tickets/detail.button.follow')}}
                        <span ng-if="countFollowing && !following && ((isSysAdmin && ticket.status=='approved') || ticketAdmin) && ticket.status!='closed'" class="badge badge-primary">@{{countFollowing}}</span>
                    </button>

                    <label class="following count-following" ng-if="countFollowing && following"><i class="fa fa-rss"></i><span>&nbsp@{{countFollowing}}</span></label>

                    <button title="Click to unfollow" class="btn btn-default btn-xs pull-right unfollow-btn" ng-disabled="unFollowMe" ng-click="unFollowing(ticket['id'],userId,true)" ng-if="following && ticket.status!='closed'"><i class="fa fa-rss-square"></i> {{trans('tickets/detail.button.following')}}</button>

                    <span class="lb-2 text-center" ng-if="((isSysAdmin && ticket.status=='approved') || ticketAdmin)  && ticket.status!='closed'">

                        <select-menu text="Add" items="usersOfTicketInvite" ng-model="inviteId" placeholder="Search User" title={{trans('tickets/detail.invite_directive')}} on-click="addInviteUsers(inviteId)" type="invite" icon="fa-plus"></select-menu>

                    </span>
                    <div class="wrap-user-ass" ng-class="{'none-btn-assignee':!(!following && ((isSysAdmin && ticket.status=='approved') || ticketAdmin) && userId!=ticket.user_id && userId!=ticket.assign_id && ticket.status!='closed')}"
                        ng-show="(ticketAdmin || ( isSysAdmin && ticket.status=='approved' )) && invites.length != 0" >
                        <span class="user-ass" ng-repeat="invite in invites track by $index">
                            <a href="" ng-click="removeInvite(ticket['id'],invite,false)" ng-show="ticket.status!='closed'" class="a-times c-000" title={{trans('tickets/detail.button.unFollow')}}>
                                <i class="fa fa-times"></i>
                            </a>
                            <img ng-src="@{{users_map[invite].avatar}}" alt="" title="@{{users_map[invite].name}}" />
                        </span>
                    </div>
                </div>
            </div>
            <!-- End Invite list -->
            <!-- Priority, Due Date, Complete -->
            <div class="col-lg-3 ava-u">
                <div class="box-u-ava box-priority">
                    <p class="m-b-5"><span class="text-grey">{{trans('tickets/detail.priority')}}: </span><strong>@{{listPriorities[ticket.priority]}}</strong></p>
                    <p class="m-b-5" ng-if="ticket.status != 'closed' && !hideDueDate">
                        <span class="text-grey" ng-if="isTime">{{trans('tickets/detail.due_in')}}: </span>
                        <span class="text-grey" ng-if="!isTime">{{trans('tickets/detail.due_date')}}: </span>
                        <timer id="due_date" end-time="ticket.due_date" finish-callback="finishCountDown()" ng-if="!overdue && isTime">
                            @{{ddays > 0 ? ddays + (ddays == 1 ? ' day ' : ' days ' ) +  hhours + (hhours > 1 ? ' hours' : ' hour'): '' }}
                            @{{ddays == 0 &&  hhours > 0 ? hhours + (hhours == 1 ? ' hour ' : ' hours ' ) +  mminutes + (mminutes > 1 ? ' minutes' : ' minute'): '' }}
                            @{{ddays == 0 && hhours == 0 ? mminutes + (mminutes == 1 ? ' minute, ' : ' minutes ' ) +  sseconds + (sseconds > 1 ? ' seconds' : ' second'): '' }}
                        </timer>

                        <span ng-if="!isTime">&nbsp;@{{ticket.due_date | myDateL}}</span>
                        <span ng-if="isTime && overdue">{{trans('tickets/detail.overdue')}}</span>

                        <a ng-if="!isTime" class="c-icon-hl" href="javascript:void(0)" ng-click="updateShowDueDateUser('time')"><i class="fa fa-clock-o"></i></a>

                        <a class="c-icon-hl" ng-if="isTime" href="javascript:void(0)" ng-click="updateShowDueDateUser('date')"><i class="fa fa-calendar"></i></a>

                    </p>
                    <div class="text-complete text-grey pull-left">{{trans('tickets/detail.complete')}}:</div>
                    <span class="progress progress-normal col-lg-6 col-md-6 col-xs-6 padding-none">
                        <span class="progress-bar progress-bar-primary" ng-style="{'width':ticket.percent_complete + '%'}">@{{ticket.percent_complete}}%</span>
                    </span>
                </div>
            </div>
            <!-- End Priority, Due Date, Complete -->

            <div class="clearfix"></div>
        </div>
        <!-- end info ticket -->
        <!-- Start action button ticket -->
        <div class="col-lg-12 col-md-12 col-xs-12 desc-file-ticket box-action text-center b-b-ccc" ng-show="isShowAction">
            <div>
                <button class="btn btn-default m-7-5" 
                    ng-click="returnSearchResult()"
                    ng-if="filterDataParam !=  null && filterDataParam !=  ''">
                    <i class="fa fa-search"></i>
                    {{trans('tickets/detail.button.return_search_result')}}
                </button>

                <button data-toggle="collapse" data-target="#collapseExample-child-ticket" aria-expanded="false" aria-controls="collapseExample" class="btn btn-default m-7-5"
                        ng-if="((ticketAdmin && ticket.status != 'approved') || (userId==ticket.assign_id && ticket.status == 'assigned') || (isSysAdmin && ticket.status == 'approved' && !isCms)) && checkAssign && ticket.status!='closed'"
                        ng-click="getChildRedactor()">
                   <i class="fa fa-tags"></i> {{trans('tickets/detail.button.spawn_child_ticket')}}
                </button>
                <button data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" class="btn btn-default m-7-5"
                    ng-click="hiddentAction('response')"
                    ng-if="ticket.status != 'closed' && (userId==ticket.assign_id || (ticketAdmin && !userInternal) || ( ticketAdmin && userInternal && (ticket.status!='approved' || ticket.status=='reviewed'|| ticket.status=='assigned' || ticket.status=='approved') ) || (isSysAdmin && ticket.status=='approved') || userId==ticket.user_id ) ">
                <a class="c-333" href=""><i class="fa fa-mail-reply"></i> {{trans('tickets/detail.button.respond')}}</a>
                </button>

                <button class="btn btn-default m-7-5" ng-if="userId==ticket.assign_id && ticket.status == 'assigned'" id="reviewed" ng-click="readyForReviewed({{$id}})">
                    <a class="c-333" href=""><i class="fa fa-retweet"></i> {{trans('tickets/detail.button.request_review')}}</a>
                </button>

                <button class="btn btn-default m-7-5" ng-if="userId==ticket.assign_id && ticket.status == 'assigned' && isCms" ng-click="editDraft({{$id}})">
                    <a class="c-333" href=""><i class="ti-pencil"></i> {{trans('tickets/detail.button.edit_draft')}}</a>
                </button>

                <button class="btn btn-default m-7-5" ng-if="userId==ticket.assign_id && ticket.status == 'assigned' && isCms" ng-click="viewDraft({{$id}})">
                    <a class="c-333" href=""><i class="fa fa-eye"></i> {{trans('tickets/detail.button.view_draft')}}</a>
                </button>

                <button class="btn btn-default m-7-5" ng-if="ticketAdmin && ticket.status == 'reviewed' && isCms" ng-click="viewDraft({{$id}})">
                   <a class="c-333" href=""> <i class="fa fa-undo"></i> {{trans('tickets/detail.button.review_page')}}</a>
                </button>

                <!-- if ticket is childs -->
                <span ng-if="(ticket.base_id == null && ticket.childTickets.length == 0) || (ticket.base_id != null)">
                    <button class="btn btn-default m-7-5"
                            ng-if="userId==ticket.assign_id && ticket.status == 'assigned'"
                            ng-click="getModalUpdatePercent(ticket.id,ticket.percent_complete)">
                        <a class="c-333" href=""><i class="fa fa-refresh"></i> {{trans('tickets/detail.button.update_percent_complete')}}</a>
                    </button>                    
                </span>

                <button class="btn btn-default m-7-5"
                        ng-if="!hideDueDate && userId==ticket.assign_id && ticket.status == 'assigned'"
                        ng-click="getModalRequestExtention(ticket.id,ticket.due_date,0)">
                    <a class="c-333" href=""><i class="fa fa-expand"></i> {{trans('tickets/detail.button.request_extension')}}</a>
                </button>

                <button class="btn btn-default m-7-5"
                        ng-if="!hideDueDate && userId==ticket.user_id && ticket.status != 'closed'"
                        ng-click="getModalRequestExtention(ticket.id,ticket.due_date ,1)">
                    <a class="c-333" href=""><i class="fa fa-expand"></i> {{trans('tickets/detail.button.update_due_date')}}</a>
                </button>

                <button class="btn btn-default m-7-5" ng-if="ticketAdmin && ticket.status == 'reviewed'" id="approved" ng-click="approved({{$id}})">
                    <span><a class="c-333" href=""><i class="fa fa-check"></i> {{trans('tickets/detail.button.approve')}}</a></span>
                </button>

                <button class="btn btn-default m-7-5" ng-if="ticketAdmin && ticket.status == 'reviewed'" id="deny" ng-click="deny({{$id}})">
                    <a class="c-333" href=""><i class="fa fa-close"></i> {{trans('tickets/detail.button.deny')}} </a>
                </button>

                <button class="btn btn-default m-7-5" ng-if="(ticketAdmin || userId==ticket.user_id) && ticket.request_extension != null && ticket.status != 'closed'" id="btnApproveExtension" ng-click="approveExtension({{$id}})">
                    <a class="c-333" href=""><i class="fa fa-clock-o"></i> {{trans('tickets/detail.button.approve_extension')}} </a>
                </button>

                <!-- if ticket is parent and is not childs -->
                <span ng-if="ticket.base_id == null">
                    <button class="btn btn-default m-7-5" ng-if="isSysAdmin && ticket.status == 'approved'" id="deploy" ng-click="deploy({{$id}})">
                        <span ng-if="!isCms"><a class="c-333" href=""><i class="fa fa-exchange "></i> {{trans('tickets/detail.button.deploy')}}</a></span>
                        <span ng-if="isCms"><a class="c-333" href=""><i class="fa fa-share-alt"></i> {{trans('tickets/detail.button.publish')}}</a></span>
                    </button>
                </span>
            </div>


            <div class="clearfix"></div>
        </div>
        <!-- End action button ticket -->

    </div>

    <div class="clearfix"></div>

    <!-- Box response (action comment ticket) -->
    <div class="wrap-box-content collapse ui-create" id="collapseExample">
        <h4 class="title-respond">{{trans('tickets/detail.respond')}}</h4>
        <div class="p-20">

            <div class="col-xs-12 col-md-12 col-lg-12 ticket-body padding-none m-b-20">

                <!-- box to comment -->
                <div>
                    <div ng-show="ticket.status != 'closed'">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-none">
                            <textarea id="content" class="form-control" placeholder="Comment" ng-model="comment.content"></textarea>
                            <span class="control-label span-error" ng-show="submitted && !validate">{{trans('tickets/detail.validate.comment_required')}}</span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div ng-show="ticket.status != 'closed'" class="form-group drop-file">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-none">
                            <file-upload ng-model="filesUpload"></file-upload>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- response -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button id="respond" ng-disabled="!filesUpload.finished" class="btn btn-green pull-right"
                                ng-if="typeShow == 'response' && ticket.status != 'closed' && (userId==ticket.assign_id || (ticketAdmin && !userInternal) || ( ticketAdmin && userInternal && (ticket.status!='approved' || ticket.status=='reviewed'|| ticket.status=='assigned' || ticket.status=='approved') ) || (isSysAdmin && ticket.status=='approved') || userId==ticket.user_id ) "
                                ng-click="response({{$id}})">
                                <i class="fa fa-check"></i>
                                {{trans('tickets/detail.button.submit')}}
                        </button>
                        <!-- cancel -->
                        <button data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" ng-click="showAction()" class="btn btn-default pull-right m-r-10"><i class="fa fa-times"></i> {{trans('tickets/detail.button.cancel')}}
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- End Box response (action comment ticket) -->

    <div class="clearfix"></div>

    <!-- create child ticket -->
    <div class="wrap-box-content collapse m-t-15" id="collapseExample-child-ticket">

        <div class="col-xs-12 col-md-12 col-lg-12 ticket-body padding-none m-b-20">

            <!-- box to comment -->
            <div class="wrap-create-child-ticket">
                <h3>{{trans('tickets/detail.child')}} :  <a href="#" editable-text="ticketChild.title"  e-name="ticketChild.title"onaftersave="updateTitleChild()">@{{ticketChild.title}} </a>
                </h3>
                <div class="info-user-ticket fix-height-box hidden-xs">

                    <div class="col-lg-4 ava-u">
                        <div class="box-u-ava">
                            <label>{{trans('tickets/detail.originator')}}:</label>
                            <div class="mini-show">
                                <img ng-src="@{{users_map[userId].avatar}}" alt="ava" />
                                <span class="p-l-10">@{{users_map[userId].name}}  @{{users_map[userId].deleted_at != null ? '(Deactivated)' : ''}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 ava-u">
                        <div class="box-u-ava allways-visible">
                              <label ng-if="!ticket.assign_id" class="pull-left"> <i>{{trans('tickets/detail.unassigned')}}</i></label>
                                <label class="lb-1" ng-if="ticket.assign_id">{{trans('tickets/detail.assigned_to')}}:<span class="text-require"> *</span></label>
                                    <span class="lb-2 text-center" ng-if="((ticketAdmin && ticket.status != 'approved') || (userId==ticket.assign_id && ticket.status == 'assigned') || (isSysAdmin && ticket.status == 'approved' && !isCms)) && checkAssign && ticket.status!='closed'">

                                        <select-menu text="@{{ticket.assign_id ? 'Re-assign': 'Assignee'}}" items="usersOfTicket" ng-model="assignIdChild" user-id="ticketChild.assign_id" placeholder="Search User" title={{trans('tickets/detail.assign_directive')}} on-click="assignPeopleChild(assignIdChild,ticketChild.assign_id,ticket.user_id)" type="assign_child" icon="@{{ticketChild.assign_id ? 'fa-undo': 'fa-gear'}}"></select-menu>

                                    </span>

                            <div class="mini-show" ng-if="ticketChild.assign_id">
                                <img class="img-mini" ng-src="@{{users_map[ticketChild.assign_id].avatar}} " alt="ava" />
                                <span class="p-l-10">
                                    @{{users_map[ticketChild.assign_id].name}} @{{users_map[ticketChild.assign_id].deleted_at != null ? '(Deactivated)' : ''}}
                                </span>
                            </div>
                            <span class="control-label span-error" ng-show="submittedChild && !ticketChild.assign_id">{{trans('tickets/detail.validate.assignee_required')}}</span>
                            <div class="clearfix"></div>


                        </div>
                    </div>

                    <div ng-if="!hideDueDate" class="col-lg-4 ava-u">
                        <div class="box-u-ava p-40-10-0 allways-visible">
                            <label class="lb-1"><strong>{{trans('tickets/detail.due_date')}}</strong></label>
                            <input  type="text" class="form-control" name="due_date"
                                        datepicker-popup="MM-dd-yyyy"
                                        placeholder="mm-dd-yyyy"
                                        ng-model="ticketChild.due_date"
                                        placeholder="mm-dd-yyyy"
                                        is-open="datePicker.opened"
                                        ng-click="open($event)"
                                        ng-change="changeDateTimeChildTicket()"
                                        ng-required="true" min-date="minDate"/>

                            <div ng-if="errorDateTime" class="help-inline">{{trans('tickets/detail.validate.date_time_invalid')}}</div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>

                <div class="m-t-15">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-none">
                        <textarea id="content-child" class="form-control" placeholder="Description"></textarea>
                        <span class="control-label span-error" ng-show="submittedChild && !validateChild">{{trans('tickets/detail.validate.description_required')}}</span>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div ng-show="ticket.status != 'closed'" class="form-group drop-file">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-none">
                         <file-upload ng-model="filesUploadChild" placeholder="Drop files upload or click here to browse for file" control="focusinControl"></file-upload>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-green pull-right" ng-click="newChildTicket(ticketChild)" ng-disabled="!filesUploadChild.finished" >
                            <i class="fa fa-check"></i>
                            {{trans('tickets/detail.button.submit')}}
                    </button>
                    <!-- cancel -->
                    <button data-toggle="collapse" data-target="#collapseExample-child-ticket" aria-expanded="false" aria-controls="collapseExample" ng-click="showAction1(); focusinControl.deleteAllFileUploaded()" class="btn btn-default pull-right m-r-10"><i class="fa fa-times"></i> {{trans('tickets/detail.button.cancel')}}
                    </button>
                </div>

                <div class="clearfix"></div>

            </div>
            <div class="clearfix"></div>

            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
    </div>
    <!-- end create child ticket -->

    <!-- show infomation of parent ticket -->
    <div class="wrap-children-ticket" ng-show="ticket.parentTicket">
        <h3>{{trans('tickets/detail.parent_ticket')}}</h3>
        <div class="table-responsive wrap-box-content">
            @include('ticket::ticket.partial.parent-detail')
        </div>
    </div>
    <!-- End show infomation of parent ticket -->

    <!-- show infomation of child ticke-->
    <div class="wrap-children-ticket" ng-show="ticket.childTickets.length">
        <h3>{{trans('tickets/detail.child_tickets')}}</h3>
        <div class="table-responsive wrap-box-content">
            <table class="table table-striped center-td table-for-child-ticket-details" ng-table="tableParams" show-filter="isSearch">
                <thead>
                    <tr>
                        <th colspan="9" class="padding-none">
                            <div>
                                <table class="table center-td margin-none min-width-1110">
                                    <tr>
                                        <td class="w70"></td>
                                        <td class="text-hightlight-head-table w104">{{trans('tickets/detail.table.ticket_id')}}</td>
                                        <td class="text-hightlight-head-table min-width-100">{{trans('tickets/detail.table.ticket_type')}}</td>
                                        <td class="text-hightlight-head-table w100">{{trans('tickets/detail.table.description')}}</td>
                                        <td class="text-hightlight-head-table w100">{{trans('tickets/detail.table.status')}}</td>
                                        <td class="text-hightlight-head-table w100">{{trans('tickets/detail.table.priority')}}</td>
                                        <td class="text-hightlight-head-table w100">{{trans('tickets/detail.table.assignee')}}</td>
                                        <td class="text-hightlight-head-table w130">{{trans('tickets/detail.table.date_started')}}</td>
                                        <td class="text-hightlight-head-table w130">{{trans('tickets/detail.table.due_date')}}</td>
                                        <td class="text-hightlight-head-table w130">{{trans('tickets/detail.table.percent_complete')}}</td>
                                    </tr>
                                </table>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody id="responsive-table-body" class="table-child-ticket-details">
                    <tr class="pointer">
                        @include('ticket::ticket.partial.child-detail')
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End show infomation of child ticket or parent ticket -->

    <!-- Show comments in ticket -->
    <div class="m-t-10 wrap-box-content">
         <comments users-map="users_map" ticket="ticket" files="fileAll" items="items_s" number-limit="numberLimit" total-comments="totalComments" limit-step="limitStep" hide-load-more="hideLoadMore" open-picture="viewModel(id)"></comments>
        <div class="clearfix"></div>
    </div>
    <!-- End Show comments in ticket -->

    <div class="clearfix"></div>

@stop
@section('script')
    <script type="text/javascript">
        var modules = ['timer', 'ngSanitize','xeditable'];
        window.types = {!!json_encode($listType)!!}
        window.listPriorities = {!!json_encode($listPriorities)!!}
        window.ticket = {!!json_encode($ticket->getDetail())!!};
        window.isAdmin = {!!json_encode($isAdmin)!!};
        window.isSysAdmin = {!!json_encode($isSysAdmin)!!};
        window.ticket_content_map = {!!json_encode(getTicket_Content_Map())!!}
        window.linkViewDraft = {!!json_encode(linkViewDraft())!!}

        window.hideDueDate = {!!json_encode($hideDueDate)!!}
        window.filterDataParam = {!!json_encode($filterDataParam)!!}

    </script>
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/ticket/ticketController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/ticket/ticketControllerDetail.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/ticket/ticketService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/comments/commentsDirective.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/assign/choosePeopleDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/invite/inviteDirective.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/file/fileController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file/fileDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/user/userService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/search/searchDirective.js?v='.getVersionScript())!!}
         {!! Html::script('app/shared/select-menu/selectMenuDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/scenario-request/scenarioRequestDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/viewticket.js') }}"></script>
    @endif
@stop
