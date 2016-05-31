
<label ng-show="checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && field.type=='select'"
       ng-repeat="optionId in pageOld.data.fields['_'+key+'_'+field.variable] track by $index">
    <span ng-if="dataOptionMap[optionId]">@{{dataOptionMap[optionId].name}}<span ng-if="!$last">,</span></span>
</label> 
<label ng-show="!checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && field.type=='select'">
    <lable>@{{dataOptionMap[pageOld.data.fields['_'+key+'_'+field.variable]].name}}</lable>
</label>