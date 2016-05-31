
<div class="modal-header">
    <h4>Guide Me</h4>
</div>
<div class="modal-body" style="height: 600px" ng-init="initTree(); databaseTree={{json_encode($databaseTree)}}; dataPage={{json_encode($dataPage)}} ">
    <div ng-show="currentStep == 0">
        <h4>Your progress will be saved as you go through the tool. We recommed that you enter your email address now so that all saved progress can be send to your once you exit the tool</h4>
        <label>Email *</label>
        <input type="text" class="form-control" ng-model="dataInput.email"></input>
        <small>@{{messageError}}</small>
    </div>
    <div class="content margin-top-0" ng-show="currentStep == 1">
        @include('database.partial.guide-configurator-step1')
    </div>

    <div class="content margin-top-0" ng-show="currentStep == 2">
        @include('database.partial.guide-configurator-step2')
    </div>

    <div class="content margin-top-0" ng-show="currentStep == 3">
        @include('database.partial.guide-configurator-step3')        
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" ng-click="changeStep()">
        <i class="fa fa-arrow-right"></i> Go To Step @{{currentStep + 1}}
    </button>

    <!-- <button class="btn btn-primary" ng-click="report()" ng-show="reportData">
        <i class="fa fa-arrow-right"></i> Report
    </button> -->
</div>