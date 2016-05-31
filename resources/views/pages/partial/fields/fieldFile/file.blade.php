
<label ng-show="checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && field.type=='file'"
       ng-repeat="fileId in pageOld.data.fields['_'+key+'_'+field.variable] track by $index">
    <span ng-if="listFileMapTranslate[fileId]">@{{listFileMapTranslate[fileId]}}<span ng-if="!$last">,</span></span>
</label> 
<label ng-show="!checkIsArray(pageOld.data.fields['_'+key+'_'+field.variable]) && field.type=='file'">
    <lable>@{{listFileMapTranslate[pageOld.data.fields['_'+key+'_'+field.variable]]}}</lable>
</label>