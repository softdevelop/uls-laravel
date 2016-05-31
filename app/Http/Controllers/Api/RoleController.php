<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\RoleModel;
use Illuminate\Http\JsonResponse;

use Rowboat\Users\Http\Controllers\Api\RoleController as RowboatRoleController;

class RoleController extends RowboatRoleController
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
		$roleModel = new RoleModel();
		$role = $roleModel -> find($data['id']);
		if(empty($role)) {
			return new JsonResponse(['status' => -1]);
		}
		$status = $role -> checkName($data['roleName']);
		
		return new JsonResponse(['status' => $status]);
	}
}
