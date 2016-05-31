<div class="form-group">
    <label class="label-form" for="name">Description:</label>
    <div class="wrap-form">
        <textarea class="form-control" rows="3" name="description" ng-model="material.description"></textarea>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
    <label class="label-form" for="name">Benefits:</label>
    <div class="wrap-form">
        <textarea class="form-control" rows="3" name="benefits" ng-model="material.benefits"></textarea>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
    <label class="label-form" for="name">Dependencies:</label>
    <div class="wrap-form">
        <input  type="text" name="dependencies" ng-model="material.dependencies"/>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
    <label class="label-form" for="name">Uuf:</label>
    <div class="wrap-form">
         <input  type="text" id="checkbox-cut" name="uuf" ng-model="material.uuf"/>
    </div>
    <div class="clearfix"></div>
</div>
<div class="wrap-box-title">

    <a class="pointer btn btn-xs btn-upload pull-right" ng-click="addPlatform()" >
        <i class="fa fa-plus-square"></i>  Add Platform
    </a>

    <div class="clearfix"></div>
    <br />
    <div>
        <div>
            <div class="panel-group" ng-repeat="(key, value) in multiPlatforms" class="sectionsid"  ng-init="platforms = {{json_encode($platforms)}}">
                
                <div class="panel panel-default have-border">
                    <div class="panel-heading have-bg fix-height">
                        <h4 class="panel-title relative">
                            <span class="position-close" ng-click="removePlatform(key)">
                                <i class="ti-close"></i>
                            </span>
                            <a data-toggle="collapse"  data-target=".platform_@{{key}}" class="capitalize accordion-toggle">
                                Platform &nbsp
                            </a>  
                        </h4>
                    </div>
                    <div class="bg-fff platform_@{{key}} collapse in" role="tabpanel">
                        <div class="panel-body">
                           <div class="wrap-form">
                                <select ng-options="key as value for (key, value) in platforms" name="platform_@{{key}}" class="form-control" ng-model="listPlatformAndStale['data'][key].platform_id" ng-required="true" ng-change ="changePlatform()">
                                    <option value="" ng-if="!listPlatformAndStale['data'][key].platform_id">Select Platform</option>
                                </select>
                                <div class="pull-left">

                                    <small class="help-inline" ng-show="submitted && formData.platform_@{{key}}.$error.required">Platform is a required field</small>
                                </div>
                                <select name="state_@{{key}}" class="form-control" ng-model="listPlatformAndStale['data'][key].state" ng-required="true">
                                    <option value="" ng-if="!listPlatformAndStale['data'][key].state">Select state</option>
                                    <option value="s" >Standard: Pre-selected for that platform</option>
                                    <option value="o" >Optional - User must select</option>
                                </select>
                                <div class="pull-left">

                                    <small class="help-inline" ng-show="submitted && formData.state_@{{key}}.$error.required">State is a required field</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <small class="help-inline" ng-show="submitted && choosePlatform">Platform is a required field.</small>
                <small class="help-inline" ng-show="submitted && !choosePlatform &&isExistPlatform ">The platform exists.</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="clearfix"></div>
<!-- Image -->
<div class="form-group">
    <label class="label-form" for="name">Image:</label>
    <file-upload-directive file-type="'image/*'" files="material.image" is-multi=false ng-model="filesUpload"></file-upload-directive>
    <div class="clearfix"></div>
</div>