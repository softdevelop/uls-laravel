
<div class="modal-content" id="model-template-content" ng-init="selectedItem = {{json_encode($selectedItem)}}">
	<div ng-if="stepFirst">
		@include('vendor.tempalte-content-manager.partial.template-manager-step1')
	</div>
{{-- 	<div ng-if="stepSecond">
		@include('vendor.tempalte-content-manager.partial.template-manager-step2')

	</div>
	<div ng-if="stepThird">
		@include('vendor.tempalte-content-manager.partial.template-manager-step3')
	</div> --}}
</div>