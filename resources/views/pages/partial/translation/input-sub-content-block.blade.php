
<div ng-if="nested_block[key][field.variable][field_el.key_field]" ng-repeat="(keyNested, nestedContent) in nested_block[key][field.variable][field_el.key_field]">
    <div class="panel panel-default have-border">
        <div class="panel-heading have-bg fix-height bg-4a4a4a" role="tab" id="headingOne">
            <h4 class="panel-title relative c-fff">
                <a data-toggle="collapse" data-target="#sub-blockid_@{{nestedContent._id}}" class="capitalize accordion-toggle">
                    &nbsp@{{nestedContent.name}} &nbsp
                </a>
            </h4>
        </div>
        <div id="sub-blockid_@{{nestedContent._id}}" class="p-20 collapse in bg-fff" role="tabpanel">
            <div ng-repeat="(keyData, itemData) in dataNestedOlds[key][field.variable][field_el.key_field][keyNested]['data']">
                <p ng-if="checkIsArray(itemData)">
                    @{{keyData | fomatField}}: 
                    <label ng-repeat="(key, value) in itemData track by $index">
                        <span ng-if="dataOptionMap[value]">@{{dataOptionMap[value].name}}<span ng-if="!$last">,</span></span>
                        <span ng-if="listFileMapTranslate[value]">@{{listFileMapTranslate[value]}}<span ng-if="!$last">,</span></span>
                    </label> 
                </p>
                <p ng-if="!checkIsArray(itemData)">
                    <span ng-if="listsAsset[itemData]">@{{keyData | fomatField}}: @{{listsAsset[itemData]}}</span>
                    <span ng-if="dataOptionMap[itemData]"> @{{keyData | fomatField}}: @{{dataOptionMap[itemData].name}}</span>
                    <span ng-if="listFileMapTranslate[itemData]">@{{keyData | fomatField}}: @{{listFileMapTranslate[itemData]}}</span>
                    <span ng-if="listMapContentIdWithUrl[itemData]">@{{keyData | fomatField}}: @{{listMapContentIdWithUrl[itemData]}} </span>
                    <span ng-if="!listFileMapTranslate[itemData] && !listMapContentIdWithUrl[itemData] && !dataOptionMap[itemData] && !listsAsset[itemData]"> @{{keyData | fomatField}}: @{{itemData}} </span>
                </p>               
            </div>
            <span ng-if="!dataNestedOlds[key][field.variable][field_el.key_field][keyNested]['data'] || dataNestedOlds[key][field.variable][field_el.key_field][keyNested]['data'].length == 0">
                {{trans('cms_page/page-nested.no_field')}}
            </span>
            <div ng-repeat="(keyChildNested, fieldNested) in listBlockMapData[nestedContent.sub_block_id].fields" class="form-group">

                <div ng-if="fieldNested.form" ng-init="currentTabId = key">
                    @include('pages.partial.fields.form-buider')
                </div>
                <div ng-if="!fieldNested.form"  ng-init="currentTabId = key">
                    <div ng-if="listOutTypeMap[fieldNested.type] != 'select' && listOutTypeMap[fieldNested.type] != 'textarea'">
                        @include('pages.partial.fields.input-template-nested')
                    </div>
                    <div id="field_@{{fieldNested._id.$id}}" ng-if="listOutTypeMap[fieldNested.type] == 'select'">
                        @include('pages.partial.fields.select-template-nested')
                    </div>
                    <div id="field_@{{fieldNested._id.$id}}" ng-if="listOutTypeMap[fieldNested.type] == 'textarea'">
                        @include('pages.partial.fields.text-area-template-nested')
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
