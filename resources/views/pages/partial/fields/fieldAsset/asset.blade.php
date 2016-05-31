
<label ng-show="checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && (field.type=='asset' || field.type=='img_object')"
       ng-repeat="itemId in pageOld.data.fields['_'+key+'_'+field.variable] track by $index">
    <span ng-if="listsAsset[itemId]">@{{listsAsset[itemId]}}<span ng-if="!$last">,</span></span>
</label> 

<label ng-show="!checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && (field.type=='asset' || field.type=='img_object')">
    <lable>@{{listsAsset[pageOld.data.fields['_'+key+'_'+field.variable]]}}</lable>
</label>