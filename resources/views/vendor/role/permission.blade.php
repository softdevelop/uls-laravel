<div class="modal-header">
	<button type="button" class="close"  ng-click="cancel()" aria-hidden="true">×</button>
	<h4 class="modal-title">{{ trans('Role/role-permission.role') }}</h4>
</div>
<!-- // Modal heading END -->

<!-- Modal body -->
<div class="modal-body" ng-init="rolePermissions={{json_encode($rolePermissions)}}">
	<div class="w-w-item"> 
		<div class="w-item"> 
			<span class="item">{{$role->name}}</span> 
		</div> 
		<div class="item-ch" ng-repeat="(key, value) in rolePermissions"> 
			<span>-</span> <span>@{{value.name}}</span> 
		</div> 
	</div>
</div>
<!-- // Modal body END -->

<!-- Modal footer -->
<div class="modal-footer">
	<a href="javascript:void(0)" ng-click="cancel()" class="btn btn-default" data-dismiss="modal">{{ trans('Role/role-permission.close') }}</a> 
</div>
