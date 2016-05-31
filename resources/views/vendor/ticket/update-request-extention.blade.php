
<div class="modal-header">
    <button aria-label="Close" data-dismiss="modal" class="close" type="button">
        <span ng-click="cancel()">×</span>
    </button>

    <h4 class="modal-title" ng-show ="checkDueDate != 1">{{trans('tickets/index.request_extension')}}</h4>
    <h4 class="modal-title" ng-show ="checkDueDate==1">{{trans('tickets/index.update_due_date')}}</h4>
</div>

<div class="modal-body request-extension">

    <div class="col-lg-12 padding-none">
        <div class="input-group">
            <span class="input-group-addon">{{trans('tickets/index.due_date')}}:</span>
            <span class="input-table-cell"><input  type="text" class="form-control" name="due_date" 
                  datepicker-popup="MM-dd-yyyy"
                  ng-change="changeDateTime()" 
                  ng-model="myDate" 
                  is-open="opened"
                  ng-click="open($event)" 
                  ng-required="true" min-date="minDate"/></span>

            <span class="input-group-addon"><i class="fa fa-calendar"></i> <span>@{{myTime|date:'hh:mm a'}}</span></span>
            {{-- <span>@{{myTime|date:'hh:mm a'}}</span> --}}
            {{-- <timepicker class="pick-day" ng-readonly-input = 'true' ng-model="myTime" hour-step="1" ng-readonly="true" minute-step="1" show-meridian="true" ng-disabled="true"></timepicker>   --}}
            
        </div>
    </div>
    <div ng-if="errorDateTime"  class="has-error">{{trans('tickets/index.validate.date_invalid')}}</div>
    <div class="clearfix"></div>
</div>

<div class="clearfix"></div>

<div class="modal-footer">
    <div class="form-group center-block">
        <button class="btn btn-default" ng-click="cancel()" aria-label="Close"><i class="fa fa-times"></i> {{trans('tickets/index.action.cancel')}}</button>
        
        <button class="btn btn-primary" ng-click="updateDueDate(ticket.id)" id="btnRequestExtension"><i class="fa fa-check" ></i> {{trans('tickets/index.action.save')}}</button>
    </div>
</div>