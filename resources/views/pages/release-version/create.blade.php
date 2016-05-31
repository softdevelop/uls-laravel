
<div class="modal-header">
    <h4 class="modal-title">
        @if($release->id == '')
            {{trans('configuration/release-version/release-version-create.add_release_version')}}
        @else
            {{trans('configuration/release-version/release-version-create.edit_release_version')}}
        @endif
</div>
<div class="modal-body">
<div class="alert alert-danger" ng-show="errors">
    <span ng-repeat="error in errors">@{{error[0]}}<br></span>
</div>
<form role="form" name="formRelease" ng-init="release={{$release}}; newVersion={{$newVersion}}; nextVersion={{$nextVersion}}" novalidate>
        @if($release->id == '')
        <!-- Input Language-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && requireVersion]">
            <label class="label-form" for="">{{trans('configuration/release-version/release-version-create.version')}}:<span class="text-require"> *</span></label>
            <select class="form-control" ng-model="release.version" ng-required="true">
                <option value="@{{newVersion | number:1}}">@{{newVersion | number:1}}</option>
                <option value="@{{nextVersion | number:1}}">@{{nextVersion | number:1}}</option>
            </select>
            <div class="clearfix"></div>
            <div class="show-error pull-left">
                <small class="help-inline" ng-show="submitted && requireVersion">{{trans('configuration/release-version/release-version-create.version_required')}}</small>
            </div>
        </div>

        <div class="clearfix"></div>
        @else
         <label class="label-form" for="">{{trans('configuration/release-version/release-version-create.version')}}<span class="text-require"> *</span></label>
         <p class="">@{{release.version}}</p>
        @endif

        <div class="form-group" ng-class="{true: 'has-error'}[submitted && requireDescription]">
            <label class="label-form" for="">{{trans('configuration/release-version/release-version-create.description')}}<span class="text-require"> *</span></label>
            <textarea class="form-control" rows="5" id="description" ng-model="release.description" ng-required="true"></textarea>
            <div class="clearfix"></div>
            <div class="show-error pull-left">
                <small class="help-inline" ng-show="submitted && requireDescription">{{trans('configuration/release-version/release-version-create.description_required')}}</small>
            </div>
        </div>
        <div class="clearfix"></div>

   </form>
</div>
<div class="modal-footer">
        <button class="btn btn-default" ng-click="cancel()"> <i class="fa fa-times"></i> {{trans('configuration/release-version/release-version-create.cancel')}}</button>
        <button class="btn btn-primary" ng-click="submit(formRelease.$invalid)">
        <i class="fa fa-plus"></i>
        <span>
            @if(!empty($release->id))
                {{trans('configuration/release-version/release-version-create.edit')}}
            @else
                {{trans('configuration/release-version/release-version-create.add')}}
            @endif
        </span>
    </button>

</div>
