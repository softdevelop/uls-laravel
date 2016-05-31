
<div ng-if="key1==index" ng-repeat="(index, value) in pageOld.data.fields['_'+key+'_'+field.variable] track by $index">

    <div ng-repeat="(keyData, itemData) in value" ng-if="variableMapNameFieldsMulti[keyData]">
        @include('pages.partial.translation.load-map-old-data')
    	
    </div>
   {{--}} <fieldset class="scheduler-border" ng-if="dataNestedOlds[key][field.variable][index]">
        <legend class="scheduler-border bulleted-text">{{trans('cms_page/page-nested.sub_content_blocks')}}</legend>
        <div class="control-group">
            <div ng-if="dataNestedOlds[key][field.variable][index]" ng-repeat="(keyData, itemData) in dataNestedOlds[key][field.variable][index]">
                <p class="name">@{{itemData['name']}} :</p>

                <div class="wrap-item-nested-data" ng-if="itemData.data" ng-repeat="(keyItemNested, valueItemNested) in itemData.data">

                    <p ng-if="listsAsset[valueItemNested]"> @{{keyItemNested | fomatField}}: @{{listsAsset[valueItemNested]}} </p>

                    <p ng-if="dataOptionMap[valueItemNested]"> @{{keyItemNested | fomatField}}: @{{dataOptionMap[valueItemNested].name}} </p>

                    <p ng-if="listFileMapTranslate[valueItemNested]"> @{{keyItemNested | fomatField}}: @{{listFileMapTranslate[valueItemNested]}}  </p>

                    <p ng-if="listMapContentIdWithUrl[valueItemNested]"> @{{keyItemNested | fomatField}}: @{{listMapContentIdWithUrl[valueItemNested]}}  </p>

                    <p ng-if="!listFileMapTranslate[valueItemNested] && !listMapContentIdWithUrl[valueItemNested] && !dataOptionMap[valueItemNested] && !listsAsset[valueItemNested]">
                        @{{keyItemNested | fomatField}}: @{{valueItemNested}} 
                    </p>

                </div>
                <span ng-if="itemData.data.length == 0">{{trans('cms_page/page-nested.no_field')}}</span>
            </div>
        </div>
    </fieldset>--}}
</div>
