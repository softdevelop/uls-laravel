<div class="wrap-box-title" ng-show="loadDataDatabase">
    <label class="label-form">
        @{{databaseItem.table}} &nbsp
        <input type="hidden" ng-model="page.databases[index]['table_id']" ng-init="page.databases[index]['table_id'] = databaseItem.table_id"></input>
        <input type="hidden" ng-model="page.databases[index]['varialble']" ng-init="page.databases[index]['variable'] = databaseItem.variable"></input>
    </label>

    <div class="padding-none col-lg-12 p-b-15">
        <label class="label-form">
            @{{databaseItem.field | formatText}} &nbsp
        </label>

        <select ng-options="key as value for (key, value) in databaseItem.listView" ng-model="page.databases[index]['view_id']" name="view_@{{databaseItem.field}}_@{{index}}" ng-required="true" ng-change = "changeView(page.databases[index]['view_id'], databaseItem.table, index)">
            <option value="">Choose View</option>
        </select>
        <small class="help-inline" ng-show="submitted && formData.view_@{{databaseItem.field}}_@{{index}}.$error.required"><span>@{{databaseItem.field | formatText}}</span> is a required field</small>

        <div ng-repeat="(keyr, record) in databaseItem.listQueryData[page.databases[index]['view_id']]" ng-if="databaseItem.listQueryData[page.databases[index]['view_id']].length">
            <label class="label-form">
                @{{record.display_field | formatText}}
            </label>
            <select ng-options="key as value for (key, value) in record.allValueRecord" ng-model="page.databases[index]['query_value'][keyr]" name="query_@{{record.display_field}}_@{{keyr}}_@{{index}}" ng-required="true" ng-change = "validateCurrentForm(formData.$invalid, 'databases')">
                <option value="">Choose query...</option>
            </select>
            <small class="help-inline" ng-show="submitted && formData.query_@{{record.display_field}}_@{{keyr}}_@{{index}}.$error.required"><span>@{{record.display_field | formatText}}</span> is a required field</small>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
