<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\PermissionModel;
use Rowboat\Users\Http\Controllers\Api\PermissionController as RowboatPermissionController;

class PermissionController extends RowboatPermissionController
{

	/**
	 * check name permission exist
	 * @param  Request $request 
	 * @return JsonResponse
	 */
	public function checkName(Request $request)
	{
		$data = $request->all();
		if(empty($data['id'])) {
			return new JsonResponse(['status' => -1]);
		}
		$permissionModel = new PermissionModel();
		$permission = $permissionModel -> find($data['id']);
		if(empty($permission)) {
			return new JsonResponse(['status' => -1]);
		}
		$status = $permission -> checkName($data['permName']);
		
		return new JsonResponse(['status' => $status]);
	}
}
