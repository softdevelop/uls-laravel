
<div class="modal-header">
    @if ($marketSegment->id == '')
        <h4 class="modal-title">{{ trans('configuration/market-segments/create.create_marketsegment') }}</h4>
    @else
        <h4 class="modal-title">{{ trans('configuration/market-segments/create.edit_marketsegment') }}</h4>
    @endif
</div>
<div class="modal-body" >
    <form action="" method="POST" role="form" name="createMarketSegment_form" ng-init="marketSegment={{$marketSegment}}" novalidate>
        <!-- Input Name Market Segment-->
        <div class="form-group" ng-class="{true: 'error'}[submitted && (createMarketSegment_form.name.$invalid || nameExists)]">
            <label class="hightlight-lb" for="">{{ trans('configuration/market-segments/create.name') }}:<span class="text-require"> *</span></label>
            <input type="text" class="form-control" name="name" placeholder="Name"
                   ng-model="marketSegment.name"
                   ng-minlength=3
                   ng-maxlength=50
                   ng-required="true" />
            <div class="pull-left">
                <small class="help-inline">@{{nameExists}}</small>
                <small class="help-inline" ng-show="submitted && createMarketSegment_form.name.$error.required">{{ trans('configuration/market-segments/create.name_required') }}.</small>
                <small class="help-inline" ng-show="submitted && createMarketSegment_form.name.$error.minlength">{{ trans('configuration/market-segments/create.name_minlength') }}</small>
                <small class="help-inline" ng-show="submitted && createMarketSegment_form.name.$error.maxlength">{{ trans('configuration/market-segments/create.name_maxlength') }}</small>
            </div>
        </div>

        <div class="clearfix"></div>

        <!-- Input Active-->
        <div class="form-group" ng-class="{true: 'error'}[submitted && createMarketSegment_form.active.$invalid]">
            <div class="radio radio-danger">
                <input type="radio" ng-model="marketSegment.active" value="1" name="active" ng-required="true" />
                <label for="radio3">{{ trans('configuration/market-segments/create.active') }}</label>
            </div>
            <div class="radio radio-danger">
                <input type="radio" ng-model="marketSegment.active" value="0" name="active" ng-required="true" />
                <label for="radio3">{{ trans('configuration/market-segments/create.inactive') }}</label>
            </div>
        </div>
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && createMarketSegment_form.active.$error.required">{{ trans('configuration/market-segments/create.active_inactive_required') }}.</small>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
<div class="modal-footer">
        <button class="btn btn-primary" ng-click="submit(createMarketSegment_form.$invalid)">
        <i class="fa fa-plus"></i>
        <span>
            @if(!empty($marketSegment->id))
                {{ trans('configuration/market-segments/create.edit') }}
            @else
                {{ trans('configuration/market-segments/create.add') }}
            @endif
        </span>
    </button>
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{ trans('configuration/market-segments/create.cancel') }}</button>
</div>
