<?php namespace App\Models;
use Rowboat\Users\Models\PermissionModel as Permission;
use Rowboat\Users\Models\UserGroupModel;
class PermissionModel extends Permission
{
    /**
     * Check name permission exits
     * @param  string $perName permission's name
     * @return bool status
     */
    public function checkName($perName)
    {
        $status = 1;
        $check = $this->where('name',$perName)
                                  ->where('id','!=',$this->id)->count();
        if($check > 0) {
            $status = 0;
        }
        return $status;
    }
}
