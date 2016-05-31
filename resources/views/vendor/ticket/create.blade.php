@extends('ticket::ticket.layout.ticket')
    @section('title')
        Create Task
    @stop
@section('content')
<form method="POST" class="css-form" accept-charset="UTF-8" name="formData">
    <div class="info-user-ticket fix-height wrap-box-content" data-ng-init="currentUserId={{Auth::user()->id}}; initCreateTicket()">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 ava-u">
            <div class="box-name-user box-u-ava">
                <div class="box-name-user_img">
                    <img ng-src="@{{users_map[currentUserId].avatar}}" alt="alt">
                </div>
                <div class="box-name-user_text">
                    <span class="user-name"><strong>@{{users_map[currentUserId].name}}</strong></span>
                    <span class="user-name"><strong>@{{users_map[currentUserId].position}}</strong></span>
                    {{-- <span class="error">Accounting</span> --}}
                </div>

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 info-u">
            <div class="box-u-info">
                <div class="info-add">
                   {{--  <p class="space-none" data-ng-if="users_map[currentUserId].email"><a href="mailto:@{{users_map[currentUserId].email}}">@{{users_map[currentUserId].email}}</a><br/></p> --}}
                    <p class="space-none" data-ng-if="users_map[currentUserId].work_phone"><strong>Main:</strong><a href="tel:@{{users_map[currentUserId].work_phone}}"> @{{users_map[currentUserId].work_phone}}</a></p>
                    <p class="space-none" data-ng-if="users_map[currentUserId].direct_phone"><strong>Direct:</strong><a href="tel:@{{users_map[currentUserId].direct_phone}}"> @{{users_map[currentUserId].direct_phone}}</a></p>
                    <p class="space-none" data-ng-if="users_map[currentUserId].work_mobile"><strong>Cell:</strong><a href="tel:@{{users_map[currentUserId].work_mobile}}"> @{{users_map[currentUserId].work_mobile}}</a></p>
                    <p data-ng-if="users_map[currentUserId].fax" class="office"><strong>Fax:</strong><a href="tel:@{{users_map[currentUserId].fax}}"> @{{users_map[currentUserId].fax}}</a></p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 option-u">

            <div class="box-u-option">
                <div ng-class="{'has-error-select': submitted && formData.type.$invalid}" class="form-group fix-select">
                    <select ng-options="key as value for (key,value) in {{json_encode($listType)}}" ng-init="ticket.type='{{$type}}'" ng-model="ticket.type" name="type" class="form-control select2" ng-change = "checkLicensing()" ng-required ="true">
                        <option value="">Select Ticket Type</option>
                    </select>
                    <span class="control-label span-error" ng-show="submitted && formData.type.$error.required">Type is a required field</span>
                </div>
                <!-- @{{ticket.priority}} -->
                <div ng-class="{'has-error-select': submitted && formData.priority.$invalid}" class="form-group fix-select">
                    {!!
                         Form::select('priority', $listPrioritys,
                         null,
                         array('class'=>'form-control','ng-required'=>'true', 'ng-init'=>'ticket.priority="medium"','data-ng-model'=>'ticket.priority')
                         )
                    !!}
                    <span class="control-label span-error" ng-show="submitted && formData.priority.$error.required">Priority is a required field</span>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="ui-create wrap-box-content">
        <div class="form-group  col-lg-12">
            <label><strong>Title<span class="text-require"> *</span></strong></label>
            <div ng-class="{'has-error': submitted && formData.title.$invalid}">
                <input  ng-required="true"  type="text"  class="form-control" id="url" ng-model="ticket.title" name="title"  placeholder="Enter title">
                <span class="control-label span-error" ng-show="submitted && formData.title.$error.required">Title is a required field</span>
            </div>
        </div>
        <div ng-if="ticket.type != 'platform_issues_requests'" class="form-group  col-lg-12">
            <label><strong>URL</strong></label>
            <div ng-class="{'has-error': submitted && formData.url.$invalid}">
                <input type="url"  class="form-control" id="password_title" ng-model="ticket.url" name="url"  placeholder="Enter url">
                <span class="control-label span-error" ng-show="submitted && formData.url.$error.url">URL must http://example.com</span>

            </div>
        </div>
        <div class="form-group  col-lg-12" ng-if="ticket.type != 'platform_issues_requests'">
            <label><strong>Due Date<span class="text-require"> *</span></strong></label>
            
            <div ng-class="{'has-error': submitted && formData.due_date.$invalid}">
                <input  type="text" class="form-control" name="due_date"
                        datepicker-popup="MM-dd-yyyy"
                        ng-model="ticket.due_date"
                        is-open="opened['create']"
                        ng-click="open($event,'create')"
                        ng-required="true" min-date="minDate"/>

                <span class="control-label span-error" ng-show="submitted && formData.due_date.$error.required">Due date is a required field</span>
            </div>
        </div>
        <div data-ng-include="templateCreateTicket"></div>
        <div class="col-lg-12">
            <label><strong>Description<span class="text-require"> *</span></strong></label>
            <div ng-class="{'has-error': submitted && formData.notes.$invalid }">
                <textarea id="content"  class="form-control" placeholder="Description" name="notes" rows="3" ng-model="ticket.description" name="content">
                </textarea>
            </div>
            <span class="control-label span-error" ng-show="submitted && !isRequiredRedactor">Description is a required field</span>
        </div>
        <div class="clearfix"></div>
        <div class="form-group drop-file  col-lg-12">
            <div>
                <file-upload ng-model="filesUpload" placeholder="Drop files upload or click here to browse for file"></file-upload>
            </div>
        </div>
        <div class="btn-option text-right  col-lg-12">
            <button type="submit" class="btn btn-primary pull-right bt-submit" ng-disabled="!filesUpload.finished" ng-click="create(formData.$invalid)"><i class="fa fa-check"></i> Submit</button>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>
@stop
@section('script')
<script type="text/javascript">
        var modules = ['xeditable'];
        window.ticketType = '{{$type}}';
        window.decisions = {!! json_encode($decisions) !!};
</script>
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}

@if(!isProduction() && !isDev())
    {!! Html::script('app/components/ticket/ticketCreateController.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/ticket/ticketService.js?v='.getVersionScript())!!}
    {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
    {!! Html::script('app/components/user/userService.js?v='.getVersionScript())!!}
    {{-- {!! Html::script('app/shared/redactor/redactorDirective.js?v='.getVersionScript())!!}    --}}
@else
    <script src="{{ elixir('app/pages/createticket.js') }}"></script>
@endif
<!-- Create the modal dynamically via Handlebars -->

@stop
