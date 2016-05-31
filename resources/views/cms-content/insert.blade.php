<style>
	body .select2-container.select2-container--default.select2-container--open{
	z-index: 9999999;
	}
</style>
<div class="modal-header">
	<h4 class="modal-title">
	Modal Insert {{$msg}}
</div>
<form name="formDataModal" ng-init="type={{json_encode($msg)}}; contents = {{json_encode($data)}};assetMap = {{json_encode($assetMap)}};template={{json_encode($template)}}; notShowFieldBlock={{json_encode($notShowFieldBlock)}}" id="form-edit-field" novalidate>
	<div class="modal-body">
		<div ng-show="!existField">
			@if($msg == 'Asset')
				<select-level-asset items="contents" type="type" index="100" text="Choose {{$msg}}" text-filter="Filter folder" ng-model="item.curValue"></select-level-asset>
			@else
				<select-level items="contents" type="type" index="100" text="Choose {{$msg}}" text-filter="Filter folder" ng-model="item.curValue"></select-level>
			@endif
		</div>
		<div ng-if="existField">
			@include('cms-content.editFields')
		</div>
	</div>
	<div style="padding: 5px 20px">
	    @if($msg == "Asset")
		<div class="checkbox checkbox-info" ng-show ="assetMap[item.curValue]">
			<input id="checkbox-insert-object" type="checkbox" ng-model="ischecked" >
			<label for="checkbox-insert-object">Insert Object</label>
		</div>
		@endif
		<div ng-repeat="(key, value) in assetMap[item.curValue]" ng-if="assetMap[item.curValue] != 'image' &&!ischecked">
			<div class="radio radio-default">
				<input type="radio" id="thumbNail_@{{value}}" name="thumbNail" ng-model="item.thumbNail" ng-value="value">
				<label style="padding-left: 10px;" for="thumbNail_@{{value}}">@{{value}}</label>
			</div>
		</div>
	</div>
	<div class="form-group control-label col-lg-12 help-inline" ng-show="requireId">{{$msg}} is required field</div>

	<div class="form-group control-label col-lg-12 help-inline" ng-repeat="(key, value) in listErrorListFile" >@{{value}}</div>

	<div class="clearfix"></div>
	<div class="modal-footer">
		<button class="btn btn-default" ng-click="cancel()"> <i class="fa fa-times"></i> Cancel</button>
		<button class="btn btn-primary" ng-if="!existField" ng-click="submit(type)"><i class="fa fa-plus"></i> Insert</button>
		<button class="btn btn-primary" ng-click="saveContentBlock(formDataModal.$invalid)" ng-if="existField"><i class="fa fa-check"></i> Save</button>
	</div>
</form>