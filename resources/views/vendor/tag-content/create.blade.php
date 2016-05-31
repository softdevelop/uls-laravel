
<div class="modal-header">
    <h4 class="modal-title">
        @if($tagContent->_id == '')
            {{ trans('configuration/tag-content/create.create_tag_content') }}
        @else
            {{ trans('configuration/tag-content/create.edit_tag_content') }} {{$tagContent->name}}
        @endif
</div>
<div class="modal-body">
<div class="alert alert-danger" ng-show="errors">
    <span ng-repeat="error in errors">@{{error[0]}}<br></span>
</div>
<form role="form" name="createTagContent" ng-init="tagContent={{$tagContent}}" novalidate>

        <!-- Input Name-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && createTagContent.name.$invalid]">
            <label for="">{{ trans('configuration/tag-content/create.name') }}:<span class="text-require"> *</span></label>
            <input type="text" class="form-control" name="name" placeholder="Name"
                   ng-model="tagContent.name"
                   ng-required="true" />
            <div class="clearfix"></div>
            <div class="show-error pull-left">
                <small class="help-inline" ng-show="submitted && createTagContent.name.$error.required">{{ trans('configuration/tag-content/create.name_required') }}.</small>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Show color when edit tag and tag is first level -->
        @if($parentId == '0')
            <!-- Input Color-->
            <div class="form-group" ng-class="{true: 'has-error'}[submitted && createTagContent.color.$invalid]">
                <label for="">{{ trans('configuration/tag-content/create.color') }}:<span class="text-require"> *</span></label>
                <input type="text" color-picker class="form-control" name="color"
                       ng-model="tagContent.color"
                       ng-required="true" />
                <div class="show-error pull-left">
                    <small class="help-inline" ng-show="submitted && createTagContent.color.$error.required">{{ trans('configuration/tag-content/create.color_required') }}.</small>
                </div>
            </div>
        @endif

        <div class="clearfix"></div>

   </form>
</div>
<div class="modal-footer">
        <button class="btn btn-default" ng-click="cancel()"> <i class="fa fa-times"></i> {{ trans('configuration/tag-content/create.cancel') }}</button>
        <button class="btn btn-primary" ng-click="submit(createTagContent.$invalid)">
        <i class="fa fa-plus"></i>
        <span>
            @if(!empty($tagContent->_id))
                {{ trans('configuration/tag-content/create.edit') }}
            @else
                {{ trans('configuration/tag-content/create.create') }}
            @endif
        </span>
    </button>

</div>
