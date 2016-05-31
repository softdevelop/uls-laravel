<div ng-if="field.form" ng-init="currentTabId = currentChosseTemplate">
    <div ng-if="!field.multiple">
        <label class="label-form" >
            <span>@{{field.name}}:<small class="text-require" ng-show="field.required != 'false' && field.required"> *</small></span>
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

        <a id="addFieldType_@{{$index}}" class="pointer btn btn-xs btn-upload pull-right" ng-click="addNewField(field, currentChosseTemplate)"  ng-if="(field.max_field > 1 || !field.max_field) && !isDisable">
            <i class="fa fa-plus-square"></i>  {{trans('cms_page/page-edit-draft.add')}}
        </a>
        
        <div id="parentBlock_@{{field.variable}}" class="collapse">
            <div ui-sortable="sortableOptionsFields" ng-model="multiFieldFollowVariable['_' + currentChosseTemplate + '_' + field.variable]" variable-field="variable-@{{field.variable}}" data-tab-key="@{{'_' + currentChosseTemplate + '_' + field.variable}}" tab-field="tab-@{{currentChosseTemplate}}">
                <div class="panel-group" role="tablist" aria-multiselectable="true" ng-repeat="(key, field_el) in multiFieldFollowVariable['_' + currentChosseTemplate + '_' + field.variable]" ng-if="field.multiple && field_el.id == field.variable + '___'+  field_el.key_field" class="sectionsid">
                    
                    <div class="panel panel-default have-border">
                        <div class="panel-heading have-bg fix-height" role="tab">
                            <h4 class="panel-title relative">
                                <span class="position-close" ng-click="removeCurrentField(field, field_el.key_field, currentChosseTemplate)" ng-show="(!$first || field.min_field == 0) && !isDisable">
                                    <i class="ti-close"></i>
                                </span>
                                
                                <a ng-if="!$last && !field.key_sort  && !isDisable" href="javascript:void(0)" ng-click="moveDown($event)" class="position-move c-828282 movedownlink"  tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                    <i class="fa fa-arrow-down"></i>
                                </a>

                                <a  ng-if="!$first && !field.key_sort  && !isDisable" href="javascript:void(0)" ng-click="moveUp($event)" class="position-move c-828282 up moveuplink" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                    <i class="fa fa-arrow-up"></i>
                                </a>

                                <span ng-if="!field.key_sort  && !isDisable" class="my-handle-field c-828282" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                    <i class="fa fa-arrows"></i>
                                </span>
                                <a data-toggle="collapse"  data-target=".blockid_@{{field.variable}}_@{{field_el.key_field}}" class="capitalize accordion-toggle collapsed">
                                
                                    @{{field.name}} &nbsp
                                </a>
                                
                            </h4>
                        </div>

                        <div id="blockid_@{{field.variable}}_@{{field_el.key_field}}" class="collapse bg-fff blockid_@{{field.variable}}_@{{field_el.key_field}}" role="tabpanel">
                            <div class="panel-body">
                                <form-builder content="field.form"> </form-builder>

                                <label class="label-form" ng-if="!isDisable">
                                    <span class="bulleted-text">{{trans('cms_page/page-nested.sub_content_blocks')}}</span> &nbsp
                                    <a class="pointer btn btn-xs btn-upload" ng-click="addSubContentBlock(field.option_id, currentChosseTemplate, page.content_id, page.language, page.region, field_el.key_field, field.variable)"  ng-if="field.max_field > 1 || !field.max_field">
                                        <i class="fa fa-plus-square"></i>  {{trans('cms_page/page-nested.add')}}
                                    </a>
                                </label>
                               
                            </div>

                        </div>
                    </div>

                    <div class="panel-body wrap-nested collapse blockid_@{{field.variable}}_@{{field_el.key_field}}">
                        <div class="fix-scroll" ui-sortable="sortableOptionsNesteds" ng-model="nested_block[currentChosseTemplate][field.variable][field_el.key_field]" tab-nested="tab-@{{currentChosseTemplate}}" variable="variable-@{{field.variable}}" id="nesteds-@{{field_el.key_field}}">
                            <div ng-if="nestedContent._id" ng-repeat="(keyNested, nestedContent) in nested_block[currentChosseTemplate][field.variable][field_el.key_field]" class="panel-group" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default have-border">
                                    <div class="panel-heading have-bg fix-height" role="tab" id="headingOne">
                                        <h4 class="panel-title relative">
                                            <span class="position-close" ng-click="removeNestedContent(nestedContent._id, currentChosseTemplate, field_el.key_field, field.variable, keyNested)"  ng-if="nestedContent._id  && !isDisable">
                                                <i class="ti-close"></i>
                                            </span>

                                            <a href="jvascript:void()" ng-if="$last == false  && !isDisable" ng-click="moveDownNestedBlock($event)" class="position-move"  data-tab-id="@{{currentChosseTemplate}}" data-variable="@{{field.variable}}" data-index-parent="@{{field_el.key_field}}" data-nested-id="@{{nestedContent._id}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                                <i class="fa fa-arrow-down"></i>
                                            </a>
                                            <!-- ng-click="changePositionOfBlock(nestedContent._id, 'down', currentChosseTemplate, field_el.key_field, field.variable, keyNested)" -->

                                            <a href="jvascript:void()" ng-if="$first == false  && !isDisable" ng-click="moveUpNestedBlock($event)" class="position-move up" data-tab-id="@{{currentChosseTemplate}}" data-variable="@{{field.variable}}" data-index-parent="@{{field_el.key_field}}" data-nested-id="@{{nestedContent._id}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                                <i class="fa fa-arrow-up"></i>
                                            </a>

                                            <span ng-if="!isDisable" class="my-handle" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                                <i class="fa fa-arrows"></i>
                                            </span>
                                            
                                            <a data-toggle="collapse" data-target="#sub-blockid_@{{nestedContent._id}}" class="capitalize accordion-toggle collapsed">
                                            
                                                &nbsp@{{nestedContent.name}} &nbsp
                                            </a>
                                            <div class="clearfix"></div>
                                        </h4>
                                    </div>

                                    <div id="sub-blockid_@{{nestedContent._id}}" class="collapse bg-fff" role="tabpanel">
                                        <div class="panel-body" ng-repeat="(keyChildNested, fieldNested) in listBlockMapData[nestedContent.sub_block_id].fields">
                                            <div ng-if="fieldNested.form" ng-init="currentTabId = currentChosseTemplate">
                                                @include('pages.partial.fields.form-buider')
                                            </div>
                                            <div ng-if="!fieldNested.form" ng-init="currentTabId = currentChosseTemplate">
                                                <div ng-if="listOutTypeMap[fieldNested.type] != 'select' && listOutTypeMap[fieldNested.type] != 'textarea'">
                                                    @include('pages.partial.fields.input-template-nested')
                                                </div>
                                                <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[fieldNested.type] == 'select'">
                                                    @include('pages.partial.fields.select-template-nested')
                                                </div>
                                                <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[fieldNested.type] == 'textarea'">
                                                    @include('pages.partial.fields.text-area-template-nested')
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                          </div>
                                          <div class='quote-nothing' ng-if="listBlockMapData[nestedContent.sub_block_id].fields.length == 0">{{trans('cms_page/page-nested.no_field')}}</div>
                                    </div>
                                </div>
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
<div ng-if="!field.form" ng-init="currentTabId = currentChosseTemplate; type='page'">
    <div ng-if="listOutTypeMap[field.type] != 'select' && listOutTypeMap[field.type] != 'textarea'">
        @include('pages.partial.fields.input-template')
    </div>
    <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'select'">
        @include('pages.partial.fields.select-template')
    </div>
    <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'textarea'">
        @include('pages.partial.fields.text-area-template')
    </div>
    <div class="clearfix"></div>
</div>
