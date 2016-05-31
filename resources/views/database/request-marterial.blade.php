<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">
        <span ng-if="material.id && material.modal == 'request_translation'">Request Translation</span>
        <span ng-if="material.id && material.modal == 'request_region'">Request Region</span>
    </h4>
</div>

<div class="modal-body" id="loaded">
    <div ng-if="error">@{{error}}</div>
    <form role="form" name="formData" novalidate ng-init ="material = {{json_encode($material)}}">
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">Name:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div ng-if="material.id">
                    <span>@{{material.name}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input folders-->
        <div class="form-group" ng-class="[submitted && formData.folder_id.$invalid]">
            <label class="label-form" for="name">Category:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div>
                    <span>@{{material.folderName}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- Inmaterialput Languages-->
        @if($material->id && $material->modal == 'request_translation')
            <div class="form-group">
                <label class="label-form" for="requestDate">Requested Languages:<span class="text-require"> *</span></label>
                <div class="clearfix"></div>
                <multi-select-block items = "{{json_encode($languagesUnselected)}}" required-item="requiredLanguage" items-assigned = "languages_selected"></multi-select-block>
                <div class="clearfix"></div>
                <small class="help-inline m-l-15 ng-invalid" ng-show="submitted && requiredLanguage">Requested Language is required field.</small>
            </div>
        @endif

        <!-- Input Regions-->
        @if($material->id && $material->modal == 'request_region')
            <div class="form-group">
                <label class="label-form" for="requestDate">Requested Regions:<span class="text-require"> *</span></label>
                <div class="clearfix"></div>
                <multi-select-block items = "{{json_encode($regionsUnselected)}}" required-item="requiredRegion" items-assigned = "regions_selected"></multi-select-block>
                <div class="clearfix"></div>
                <small class="help-inline m-l-15 ng-invalid" ng-show="submitted && requiredRegion">Requested Region is required field.</small>
            </div>
        @endif
    </form>

</div>

<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()" ><i class="fa fa-times"></i> Cancel</button>

    <button class="btn btn-primary" id="btnSubmit" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> Submit Request</button>
</div>

<script>
    window.material = {!!json_encode($material)!!};
</script>
