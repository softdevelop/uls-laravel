
<div class="modal-header">
    <button aria-label="Close" data-dismiss="modal" class="close" type="button">
        <span ng-click="cancel()">×</span>
    </button>
    <h4 class="modal-title">{{trans('dashboard/dashboard.taskOverview.action.add.title')}}</h4>
</div>

<div class="modal-body" ng-init="types={{json_encode($types)}}">
    <div class="form-group col-xs-offset-1 col-sm-offset-3 col-ms-offset-3 col-lg-offset-3 col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="input-group">
            <span class="input-group-addon">{{trans('dashboard/dashboard.taskOverview.action.add.type')}}:</span>
            <select ng-options="item as item.name for item in types" ng-model="selected">
                <option value="" disabled="true">{{trans('dashboard/dashboard.taskOverview.action.add.select_type')}}</option>
            </select>
        </div>
        <div ng-show="errorType"><span class="help-inline">{{trans('dashboard/dashboard.taskOverview.action.add.type_invalid')}}</span></div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="clearfix"></div>

<div class="modal-footer">
    <div class="form-group center-block">
        <button class="btn btn-default" aria-label="Close" ng-click="cancel()"><i class="fa fa-times"></i> {{trans('dashboard/dashboard.taskOverview.action.add.cancel')}}</button>
        <button class="btn btn-primary" ng-click="selectTypeShow(selected)" id="btnAddType"><i class="fa fa-check"></i> {{trans('dashboard/dashboard.taskOverview.action.add.save')}}</button>  
    </div>
</div>