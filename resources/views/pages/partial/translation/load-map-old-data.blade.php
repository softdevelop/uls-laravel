    <p ng-if="itemData && checkIsArray(itemData)">
        @{{variableMapNameFieldsMulti[keyData]}} {{trans('cms_page/page-edit-translation.old')}}: 
        
        <label ng-repeat="(key, value) in itemData track by $index">
            <span ng-if="dataOptionMap[value]">@{{dataOptionMap[value].name}}<span ng-if="!$last">,</span></span>
            <span ng-if="listFileMapTranslate[value]">@{{listFileMapTranslate[value]}}<span ng-if="!$last">,</span></span>
        </label> 
        
    </p>
    <p ng-if="itemData && !checkIsArray(itemData)">
    	<span ng-if="listsAsset[itemData]">@{{variableMapNameFieldsMulti[keyData]}} {{trans('cms_page/page-edit-translation.old')}}: @{{listsAsset[itemData]}}</span>
    	<span ng-if="dataOptionMap[itemData]">@{{variableMapNameFieldsMulti[keyData]}} {{trans('cms_page/page-edit-translation.old')}}: @{{dataOptionMap[itemData].name}} </span>
    	<span ng-if="listFileMapTranslate[itemData]">@{{variableMapNameFieldsMulti[keyData]}} {{trans('cms_page/page-edit-translation.old')}}: @{{listFileMapTranslate[itemData]}}</span>
    	<span ng-if="listMapContentIdWithUrl[itemData]">@{{variableMapNameFieldsMulti[keyData]}} {{trans('cms_page/page-edit-translation.old')}}: @{{listMapContentIdWithUrl[itemData]}} </span>
    	<span ng-if="!listFileMapTranslate[itemData] && !listMapContentIdWithUrl[itemData] && !dataOptionMap[itemData] && !listsAsset[itemData]">
    		@{{variableMapNameFieldsMulti[keyData]}} {{trans('cms_page/page-edit-translation.old')}}: @{{itemData}}
    	</span>
    </p>