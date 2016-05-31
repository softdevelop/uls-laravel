
<label class="label-form">
    <span>@{{fieldNested.name}}<span ng-if="fieldNested.required !== 'false' && fieldNested.required" class="text-require"> *</span></span>
</label>
<div class="wrap-form">

    <form-builder  content="fieldNested.form"  field-name="nested_block[currentTabId][field.variable][field_el.key_field][keyNested]['data'][fieldNested.variable]"> </form-builder>
</div>

<div class="clearfix"></div>
