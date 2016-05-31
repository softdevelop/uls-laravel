@extends('ticket::ticket.layout.ticket')
    @section('title')
        Detail Ticket
    @stop
@section('content')
    <!-- Right sibar -->
    @include('ticket::ticket.shared.yourticket')
    <!-- End Right sibar -->

<!-- Begin content -->
<!-- <a href="" id="sidebar-ticket" class="visible-xs"><i class="fa  fa-building-o"></i></a> -->

<ul class="breadcrumb br-ticket" ng-init="getTicket({{$id}});getAmountOfEachTypeTicket()">
    <li>
        <a href="/support/state/@{{linkGroupName}}">@{{groupName}}</a>
    </li>
    <li class="active">
        <a>@{{ticket.title}}</a>
    </li>
</ul>

<div class="top-detail-ticket">
    <label for="" class="label-st st-n bg-new-status-ticket" ng-if="ticket.status == 'new'" >NEW</label>
    <label for="" class="label-st st-o bg-open-status-ticket" ng-if="ticket.status!='answered' && (ticket.status=='open' || ticket.status=='assigned')" >OPEN</label>
    <label for="" class="label-st st-a" style="background-color:#649bd7" ng-if="ticket.status == 'answered'" >ANSWERED</label>
    <label for="" class="label-st st-c bg-close-status-ticket" ng-if="ticket.status == 'closed'" >CLOSE</label>
    <label for="" class="label-st st-o bg-ready-for-review-status-ticket" ng-if="ticket.status == 'reviewed'" >READY FOR REVIEW</label>
    <label for="" class="label-st st-o bg-approved-status-ticket" ng-if="ticket.status == 'approved'" >APPROVED</label>

    <label for="" class="label-st st-clock">
        <i class="fa fa-clock-o"></i>
        <timer ng-if="ticket.status!='closed' && ticket.status!='approved'" start-time="ticket['unixTime']"><span>@{{ddays}} @{{ddays > 1 ? 'days': 'day'}},</span>@{{hhours}}:@{{mminutes}}:@{{sseconds}}</timer>
        <span ng-if="ticket.time_consuming && (ticket.status=='closed' || ticket.status=='approved')">@{{ticket['unixTime']}}</span>
        <timer ng-if="ticket.time_consuming=='' && (ticket.status=='closed' || ticket.status=='approved')"  start-time="ticket['unixTime']" end-time="ticket['unixTime']"><span>@{{ddays}} @{{ddays > 1 ? 'days': 'day'}},</span>@{{hhours}}:@{{mminutes}}:@{{sseconds}}</timer>
    </label>
    
    <label for="" class="pull-right lab-day"><i class="fa fa-clock-o"></i> <span>@{{ convetUnixTime(ticket['date_create_ticket']) | date:'hh:mm a' }}</span></label>
    <label for="" class="pull-right lab-day"><i class="fa fa-calendar"></i> <span>@{{ convetUnixTime(ticket['date_create_ticket']) | date:'MMM dd, yyyy'}}</span></label>

    <label for="" class="pull-right lab-day1"><i class="fa fa-clock-o"></i></label>
</div>


<!-- begin info ticket -->
<div class="info-user-ticket fix-height-box">
    <input type="hidden" ng-model="userId" ng-init="userId={{Auth::user()->id}}" />
    <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 ava-u form-group">
        <div style="height:500px" class="box-u-ava text-center">
            <label>Originator</label>
            <img ng-src="@{{users_map[ticket['user_id']].avatar}}" alt="ava">
            <h4>@{{users_map[ticket['user_id']].name}}  @{{users_map[ticket['user_id']].deleted_at != null ? '(Deactivated)' : ''}}</h4>
            {{-- <p class="text-red">Accounting</p> --}}
        </div>
    </div> -->

    <div class="col-lg-3 ava-u">
        <div class="box-u-ava">
            <label>Originator</label>
            <img ng-src="@{{users_map[ticket['user_id']].avatar}}" alt="ava">
            <span class="p-l-10">ng-src="@{{users_map[ticket['user_id']].avatar}}"</span>
        </div>     
    </div>


    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 info-u form-group">
        <div class="box-u-info">
            <div class="info-branch">
                <p><strong>Ticket ID: </strong> <span>&nbsp;#@{{ticket.id}}</span></p>
                <p><strong>Ticket Type: </strong><span>@{{types[ticket.type_id]}}</span></p>
                <p class="align-p">@{{users_map[ticket['user_id']].work_address}}</p>
            </div>
            <div class="info-add">
          {{--       <p class="space-none" data-ng-if="users_map[ticket['user_id']].email"><strong>Email: </strong> <a href="mailto:@{{users_map[ticket['user_id']].email}}" target="_top">@{{users_map[ticket['user_id']].email}}</a><br/></p> --}}
                <p class="space-none" data-ng-if="users_map[ticket['user_id']].work_phone"><strong>Main: </strong>@{{users_map[ticket['user_id']].work_phone}}</p>
                <p class="space-none" data-ng-if="users_map[ticket['user_id']].direct_phone"><strong>Direct: </strong>@{{users_map[ticket['user_id']].direct_phone}}</p>
                <p class="space-none" data-ng-if="users_map[ticket['user_id']].work_mobile"><strong>Cell: </strong>@{{users_map[ticket['user_id']].work_mobile}}</p>
                <p data-ng-if="users_map[ticket['user_id']].fax" class="office"><strong>Fax: </strong>@{{users_map[ticket['user_id']].fax}}</p> 
            </div>
        </div>
    </div>

    <!--begin asign-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 option-u form-group">
        <div class="box-u-option" ng-hide="(!ticketAdmin && !ticket.assign_id && userId==ticket.user_id) || ticket.status == 'closed'">
            <div class="form-group fix-label">
                <label class="assign-fix" ng-show="ticket.assign_id != null">Assignee</label>
                <label class="pull-left" ng-hide="isSysAdmin && ticket.status!='approved' && ticket.assign_id ==null" style="width:100%">Assign To:</label>
                
                <label for="" class="pull-right">
                    <a href="javascript:void(0)" ng-if="((ticketAdmin && ticket.status != 'approved') || (userId==ticket.assign_id && ticket.status == 'assigned') || (isSysAdmin && ticket.status=='approved')) && checkAssign && ticket.status!='closed'"
                        ng-click="checkUserAssign(ticketAdmin,ticket.assign_id)" class="btn btn-primary btn-xs" style="margin-top:23px;"><i class="fa fa-undo"></i>Re-assign
                    </a>
                </label>
                {{-- <div class="clearfix"></div> --}}
                <div class="user-ass pull-left" ng-show="ticket.assign_id">
                    <img ng-if="ticket.assign_id" ng-src="@{{users_map[ticket.assign_id].avatar}} " alt="">
                    <span ng-show="ticket.assign_id">@{{users_map[ticket.assign_id].name}} @{{users_map[ticket.assign_id].deleted_at != null ? '(Deactivated)' : ''}}</span>
                </div>
                <div class="clearfix"></div>
                <search ng-if="((ticketAdmin && ticket.status != 'approved') || (userId==ticket.assign_id && ticket.status == 'assigned') || (isSysAdmin && ticket.status=='approved')) && !checkAssign && ticket.status!='closed'" items="usersOfTicket" type="false" ng-model="assignId" user-id="userId" component="share" on-change="assignPeople(assignId,ticket.assign_id,ticket.user_id)" placeholder="Select User"></search>
            </div>

            <div class="form-group">
                <strong ng-if="((isSysAdmin && ticket.status=='approved') || ticketAdmin) && ticket.status!='closed'" class="pull-left">Currently following: </strong>
                
                <label ng-if="((isSysAdmin && ticket.status=='approved') || ticketAdmin) && ticket.status!='closed' && invites.length == 0" class="pull-left"> <i>No Followers</i></label>
                {{-- <div class="clearfix"></div> --}}
                
                <label ng-if="((isSysAdmin && ticket.status=='approved') || ticketAdmin)  && ticket.status!='closed' && !hideSelect" for="" class="pull-right"><a href="javascript:void(0)" class="btn btn-primary btn-xs" ng-click="checkDisplayInvite(ticketAdmin)"><i class="fa fa-undo"></i> Add Followers</a></label>
                {{-- <div class="clearfix"></div> --}}
                <label ng-if="((isSysAdmin && ticket.status=='approved') || ticketAdmin) && ticket.status!='closed' && hideSelect" for="" class="pull-right"><a href="javascript:void(0)" class="btn btn-primary btn-xs" ng-click="hideSelectInvite()"><i class="fa fa-undo"></i> Add Followers</a></label>
                
                <div class="clearfix"></div>

                <search ng-if="((isSysAdmin && ticket.status=='approved') || ticketAdmin) && diplayListUserInvite && ticket.status!='closed' && hideSelect" items="usersOfTicketInvite" type="false" ng-model="inviteId" component="share" on-change="addInviteUsers(inviteId)" data-placeholder="Select User" style="margin-bottom:10px;">
                </search>

                <div class="wrap-user-ass" ng-show="(ticketAdmin || ( isSysAdmin && ticket.status=='approved' )) && invites.length != 0" >
                    <div class="user-ass" ng-repeat="invite in invites">
                        <a href="" ng-click="unFollowing(ticket['id'],invite,false)" class="a-times">
                            <i class="fa fa-times"></i>
                        </a>
                        <img ng-src="@{{users_map[invite].avatar}}" alt="">
                        <span>@{{users_map[invite].name}} @{{users_map[invite].deleted_at != null ? '(Deactivated)' : ''}}</span>
                    </div>
                    
                </div>
                <div class="act-follow">
                    <button class="btn btn-default btn-xs" ng-click="addFollowing(ticket['id'])" ng-if="!following && ((isSysAdmin && ticket.status=='approved') || ticketAdmin) && ticket.status!='closed'">
                        <i class="fa fa-rss"></i> Follow<span>&nbsp &nbsp</span>
                        <span ng-if="countFollowing && !following && ((isSysAdmin && ticket.status=='approved') || ticketAdmin) && ticket.status!='closed'" class="badge badge-primary">@{{countFollowing}}</span>
                    </button>
                    
                    <label class="btn following" ng-if="following && (userDisplayFollowing || (userId!=ticket.assign_id && userId!=ticket.user_id))"><i class="fa fa-check"> </i> Following</label>
                    
                    <label class="btn following count-following" ng-if="countFollowing && following"><i class="fa fa-rss"></i><span>&nbsp@{{countFollowing}}</span></label>
                    
                    <button class="btn btn-default btn-xs"  ng-click="unFollowing(ticket['id'],userId,true)" ng-if="following && ticket.status!='closed'"><i class="fa fa-rss-square"></i> Un Follow</button>
                </div>
            </div>
        </div><!--end asign-->
    </div>
    <div class="clearfix"></div>
</div> <!-- end info ticket -->

<scenario-request ng-if="ticket.typeTicket.alias=='scenario_request'" item="ticket.scenarioRequest"></scenario-request>
<div class="desc-file-ticket">
    <div class="desc-ticket">
        <h3>@{{ticket.title}}</h3> 

        <p> <a href="@{{ticket['url']}}" target="_blank">@{{ticket['url']}}</a></p>
        <p>Due Date: @{{ticket['due_date'] | myDate}}</p> 
            {{-- @{{ticket['notes']}} --}}
        {{-- @{{ticket['notes']}}huy --}}
        <div id="note-task" class="redactor-editor redactor-placeholder" ng-bind-html="ticket.notes | to_trusted">
 
        </div>
        {{-- <p ng-bind-html="ticket['notes']"></p>     --}}
    </div>

    <div class="file-ticket" ng-if="ticket['files_id'].length">
        <div ng-repeat="file in ticket['files_id']" class="file-item">
            <a ng-show="checkFile(fileAll[file]['type']) == 'image'" href="javascript:void(0)" ng-click="viewModel(file)" class="icon-f">
                <i class="fa fa-picture-o"></i>
                {{-- <span>@{{fileAll[file]['file_name'] | limitTo: 5}}@{{fileAll[file]['file_name'].length > 5 ? '...' : '.'}} @{{fileAll[file]['file_name'].split('.').pop()}}</span> --}}
                <span ng-show="fileAll[file]['file_name'].length  <= 5">@{{fileAll[file]['file_name'] }}</span>
                <span ng-show="fileAll[file]['file_name'].length  > 5">@{{fileAll[file]['file_name'] | limitTo: 5}}@{{fileAll[file]['file_name'].length > 5 ? '...' : '.'}} @{{fileAll[file]['file_name'].split('.').pop()}}</span>
                {{-- <span>@{{ fileAll[file]['size'] | bytes }}</span> --}}
               
            </a>
            <a ng-show="checkFile(fileAll[file]['type']) != 'image'" ng-href="@{{ baseUrl }}/support/file/download/@{{file}}" class="icon-f">
                <i class="fa fa-file-o"></i>
                {{-- <span>@{{fileAll[file]['file_name'] | limitTo: 5}}@{{fileAll[file]['file_name'].length > 5 ? '...' : '.'}} @{{fileAll[file]['file_name'].split('.').pop()}}</span> --}}
                <span ng-show="fileAll[file]['file_name'].length  <= 5">@{{fileAll[file]['file_name'] }}</span>
                <span ng-show="fileAll[file]['file_name'].length  > 5">@{{fileAll[file]['file_name'] | limitTo: 5}}@{{fileAll[file]['file_name'].length > 5 ? '...' : '.'}} @{{fileAll[file]['file_name'].split('.').pop()}}</span>
                {{-- <span>@{{ fileAll[file]['size'] | bytes }}</span> --}}
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="col-md-12 col-lg-12 ticket-body">

    <comments users-map="users_map" files="fileAll" items="items_s" number-limit="numberLimit" total-comments="totalComments" limit-step="limitStep" hide-load-more="hideLoadMore" open-picture="viewModel(id)"></comments>

    <!-- box to comment -->
    <div class="ui-create">
        <div ng-show="ticket.status != 'closed'" class="form-group">
            <div>
                <textarea id="content" class="form-control" placeholder="Comment" ng-model="comment.content"></textarea>
                <span class="control-label span-error" ng-show="submitted && !validate">Comment is a required field</span>
            </div>
        </div>
        <div ng-show="ticket.status != 'closed'" class="form-group drop-file">
            <div>
                <file-upload ng-model="filesUpload"></file-upload>
                {{-- <textarea class="form-control" placeholder="Drop files upload or click here to browse for file"></textarea> --}}
            </div>
        </div>
        <div class="btn-option text-right">
           {{--  <button ng-if="isSysAdmin && ticket['status'] == 'closed'" class="btn btn-primary" ng-click="reopen({{$id}})">
                Re-Open
            </button> --}}
            <button id="internal" ng-disabled="!filesUpload.finished" ng-if="( ( isSysAdmin && (ticket.status == 'approved' || userInternal)) || ticketAdmin || userInternal) && ticket.status != 'closed'" class="btn btn-primary" ng-click="addComment({{$id}})">
                Internal
            </button>
        
            <button id="respond" ng-disabled="!filesUpload.finished" class="btn btn-green" ng-if="ticket.status != 'closed' && (userId==ticket.assign_id || (ticketAdmin && !userInternal) || ( ticketAdmin && userInternal && (ticket.status!='approved' || ticket.status=='reviewed'|| ticket.status=='assigned' || ticket.status=='approved') ) || (isSysAdmin && ticket.status=='approved') || userId==ticket.user_id ) " ng-click="response({{$id}})">

                Respond
            </button>

            <button class="item-content btn btn-primary button-o" ng-if="userId==ticket.assign_id && ticket.status == 'assigned' && types[ticket.type_id] == 'Create New Page'" ng-click="editDraft({{$id}})">
                Edit Draft 
            </button>

            <button class="item-content btn btn-primary button-o" ng-if="((userId==ticket.assign_id && ticket.status == 'assigned') || (ticketAdmin && ticket.status == 'reviewed')) && types[ticket.type_id] == 'Create New Page'" ng-click="viewDraft({{$id}})">
                View Draft 
            </button>

            <button class="item-content btn btn-primary button-o" ng-if="userId==ticket.assign_id && ticket.status == 'assigned'" id="reviewed" ng-click="readyForReviewed({{$id}})">
                Request Review
            </button>
            <button class="item-content btn btn-primary button-o" ng-if="ticketAdmin && ticket.status == 'reviewed'" id="approved" ng-click="approved({{$id}})">
                Approve
            </button>
            <button class="item-content btn btn-primary button-o" ng-if="ticketAdmin && ticket.status == 'reviewed'" id="deny" ng-click="deny({{$id}})">
                Deny
            </button>
            <button class="item-content btn btn-primary button-o" ng-if="isSysAdmin && ticket.status == 'approved'" id="deploy" ng-click="deploy({{$id}})">
                Deploy
            </button>
            {{-- <button class="item-content btn btn-primary button-o" ng-if="(userId==ticket['user_id'] || ticketAdmin) && ticket['status'] != 'closed'" ng-click="close({{$id}})"> 
                Close
            </button>--}}
        </div>
    </div>
<div class="clearfix"></div>

</div>

@stop
@section('script')
    <script type="text/javascript">
    var modules = ['timer', 'ngSanitize','xeditable'];
    window.types = {!!json_encode($listType)!!}
    window.ticket = {!!json_encode($ticket->getDetail())!!};
    window.isAdmin = {!!json_encode($isAdmin)!!};
    window.isSysAdmin = {!!json_encode($isSysAdmin)!!};
    window.ticket_content_map = {!!json_encode(getTicket_Content_Map())!!}
</script>
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
        {!! Html::script('app/components/scenario-request/scenarioRequestDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/viewticket.js') }}"></script>
    @endif
@stop