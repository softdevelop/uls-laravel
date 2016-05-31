
<div ng-if="field.form">
    <div ng-if="!field.multiple">
        <label class="label-form" >
            <span>@{{field.name}}<span ng-if="field.required !== 'false' && field.required" class="text-require"> *</span></span>
        </label>
        <div class="wrap-form"> 
            <form-builder content="field.form"> </form-builder>
        </div>
    </div>

    <div class="wrap-box-title" ng-if="field.multiple">
        <label class="label-form">
            
            <a data-toggle="collapse" id="action-@{{field.variable}}"  data-target="#parentBlock_@{{field.variable}}" class="capitalize accordion-toggle have-bg-grey collapsed">
                <span class="f16">@{{field.name}} &nbsp</span>
            </a>
        </label>

        <a id="addFieldType_@{{$index}}" class="pointer btn btn-xs btn-upload pull-right" ng-click="addNewField(field, 'inject')"  ng-if="field.max_field > 1 || !field.max_field">
            <i class="fa fa-plus-square"></i>  Add
        </a>
        <div id="parentBlock_@{{field.variable}}" class="collapse">
            <div>
                <div class="panel-group" role="tablist" aria-multiselectable="true" ng-repeat="(key, field_el) in multiFieldFollowVariable[field.variable]" class="sectionsid">

                    <div class="panel panel-default have-border">
                        <div class="panel-heading have-bg fix-height" role="tab">
                            <h4 class="panel-title relative">
                                <span class="position-close" ng-click="removeCurrentField(field, field_el.key_field, 'inject')" ng-show="field_el.key_field != 0 || field.min_field == 0">
                                    <i class="ti-close"></i>
                                </span>
                                <a data-toggle="collapse"  data-target="#blockid_@{{field.variable}}_@{{field_el.key_field}}" class="capitalize accordion-toggle collapsed">
                                
                                    @{{field.name}} &nbsp
                                </a>
                                
                            </h4>
                        </div>

                        <div id="blockid_@{{field.variable}}_@{{field_el.key_field}}" class="collapse bg-fff blockid_@{{field.variable}}_@{{field_el.key_field}}" role="tabpanel">
                            <div class="panel-body">
                                <form-builder content="field.form"> </form-builder>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
</div>
<div ng-if="!field.form">
    <div ng-if="listOutTypeMap[field.type] != 'select' && listOutTypeMap[field.type] != 'textarea'">
        @include('cms-content.partial.input-template')
    </div>
    <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'select'">
        @include('cms-content.partial.select-template')
    </div>
    <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'textarea'">
        @include('cms-content.partial.text-area-template')
    </div>
    <div class="clearfix"></div>
</div>
