
<!-- Cut-->
<div class="form-group">
    <label class="label-form" for="name">{{trans('cms_database/create-category.cut_label')}}:</label>
    <div class="checkbox checkbox-success checkbox-inline">
        <input  type="checkbox" id="checkbox-cut" name="cut" ng-model="material.cut"/>
        <label for="checkbox-cut">
        </label>
    </div>
    <div class="pull-left">
        <small class="help-inline" ng-show="submitted && formData.cut.$error.required">{{trans('cms_database/create-category.cut_required')}}</small>
    </div>
    <div class="clearfix"></div>
</div>

<!-- CanBeRastered-->
<div class="form-group">
    <label class="label-form" for="name">CanBeRastered:</label>
    <div class="checkbox checkbox-success checkbox-inline">
        <input  type="checkbox" id="checkbox-can-be-rastered" name="can_be_rastered" ng-checked="material.can_be_rastered" ng-model="material.can_be_rastered"/>
        <label for="checkbox-can-be-rastered"></label>
    </div>
    <div class="clearfix"></div>
</div> 

<!-- Fixed Thickness-->
<div class="form-group">
    <label class="label-form" for="name">Fixed Thickness:</label>
    <div class="checkbox checkbox-success checkbox-inline">
        <input  type="checkbox" id="checkbox-fixed-thickness" name="fixed_thickness" ng-checked="material.fixed_thickness" ng-model="material.fixed_thickness"/>
        <label for="checkbox-fixed-thickness"></label>
    </div>
    <div class="clearfix"></div>
</div>
<!-- Engrave mark recommended power-->
<div class="form-group">
    <label class="label-form" for="name">{{trans('cms_database/create-category.engrave_mark_recommended_power_label')}}:<span class="text-require"> *</span></label>
    <div class="wrap-form">
        <input type="number" class="form-control name" name="engrave_mark_recommended_power" ng-model="material.engrave_mark_recommended_power" ng-required = "true">
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && formData.engrave_mark_recommended_power.$error.required">{{trans('cms_database/create-category.engrave_mark_recommended_power_required')}}</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- Min thickness-->
<div class="form-group">
    <label class="label-form" for="name">{{trans('cms_database/create-category.min_thickness_label')}}:<span class="text-require"> *</span></label>
    <div class="wrap-form">
        <input type="number" step="0.001" class="form-control name" name="min_thickness" ng-model="material.min_thickness" ng-required = "true">
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && formData.min_thickness.$error.required">{{trans('cms_database/create-category.min_thickness_required')}}</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- Power at min thickness-->
<div class="form-group">
    <label class="label-form" for="name">{{trans('cms_database/create-category.power_at_min_thickness_label')}}:<span class="text-require"> *</span></label>
    <div class="wrap-form">
        <input type="number" class="form-control name" name="power_at_min_thickness" ng-model="material.power_at_min_thickness" ng-required = "true">
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && formData.power_at_min_thickness.$error.required">{{trans('cms_database/create-category.power_at_min_thickness_required')}}</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- Max thickness-->
<div class="form-group">
    <label class="label-form" for="name">{{trans('cms_database/create-category.max_thickness_label')}}:<span class="text-require"> *</span></label>
    <div class="wrap-form">
        <input type="number" step="0.001" class="form-control name" name="max_thickness" ng-model="material.max_thickness" ng-required = "true">
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && formData.max_thickness.$error.required">{{trans('cms_database/create-category.max_thickness_required')}}</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- Power at max thickness-->
<div class="form-group">
    <label class="label-form" for="name">{{trans('cms_database/create-category.power_at_max_thickness_label')}}:<span class="text-require"> *</span></label>
    <div class="wrap-form">
        <input type="number" class="form-control name" name="power_at_max_thickness" ng-model="material.power_at_max_thickness" ng-required = "true">
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && formData.power_at_max_thickness.$error.required">{{trans('cms_database/create-category.power_at_max_thickness_required')}}</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- CanBeRastered-->
<div class="form-group">
    <label class="label-form" for="name">Laser type:</label>
    <div class="checkbox checkbox-success checkbox-inline">
         <select  name="laser_type" ng-model="material.laser_type"  ng-required = "true" >
              <option value="">---Please select---</option>
              <option value="CO2">CO2</option>
              <option value="Fiber">Fiber</option>
        </select><br>
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && formData.laser_type.$error.required">Power at max thickness is a required field.</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>            

