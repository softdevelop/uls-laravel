
<div class="modal-header">
  <button aria-label="Close" data-dismiss="modal" class="close" type="button">
   <span ng-click="cancel()">×</span>
  </button>
  <h4 class="modal-title">{{trans('tickets/index.update_progress')}}</h4>
</div>

<div class="modal-body">

<div class="form-group col-xs-offset-1 col-sm-offset-3 col-ms-offset-3 col-lg-offset-3 col-xs-12 col-sm-6 col-md-6 col-lg-6">
  <div class="input-group">
    <span class="input-group-addon">{{trans('tickets/index.percent_complete')}}:</span>
    <input type="number" ng-model="ticket.percent_complete" min="0" max="100" class="form-control">
    <span class="input-group-addon">%</span>
  </div>
  <div ng-show="errorPercent"><span class="has-error">{{trans('tickets/index.percent_invalid')}}</span></div>
</div>
<div class="clearfix"></div>

</div>
<div class="clearfix"></div>
<div class="modal-footer">
  <div class="form-group center-block">
 <button class="btn btn-default" aria-label="Close" ng-click="cancel()"><i class="fa fa-times"></i> {{trans('tickets/index.action.cancel')}}</button>
 <button class="btn btn-primary" ng-click="updatePercentComplete(ticket.id)" id="btnUpdatePercent"><i class="fa fa-check"></i> {{trans('tickets/index.action.save')}}</button>  
  </div>
</div>