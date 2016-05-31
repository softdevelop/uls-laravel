
<label ng-show="checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && field.type=='link'"
       ng-repeat="itemId in pageOld.data.fields['_'+key+'_'+field.variable] track by $index">
    <span ng-if="listMapContentIdWithUrl[itemId]">@{{listMapContentIdWithUrl[itemId]}}<span ng-if="!$last">,</span></span>
</label> 
<label ng-show="!checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && field.type=='link'">
    <lable>@{{listMapContentIdWithUrl[pageOld.data.fields['_'+key+'_'+field.variable]]}}</lable>
</label>