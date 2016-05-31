<div class="modal-header">
    <h4 class="modal-title">Modal Insert {{$msg}}
</div>
<form name="formDataModal" ng-init="type={{json_encode($msg)}}; contents = {{json_encode($data)}};template={{json_encode($template)}};" id="form-edit-field" novalidate>
	<div class="modal-body">
	    <div ng-if="!existField">
	    	<select-level-database items="contents" index="100" text="Choose {{$msg}}" text-filter="Filter folder" ng-model="item.curValue"></select-level-database>
	    </div>
	</div>
	<div class="clearfix"></div>
	<div class="modal-footer">
	    <button class="btn btn-default" ng-click="cancel()"> <i class="fa fa-times"></i> Cancel</button>
	    <button class="btn btn-primary" ng-click="submit(type, database)"><i class="fa fa-plus"></i> Insert</button>
	</div>
</form>
