<?php  namespace App\Models;
use Rowboat\Users\Models\RoleModel as Role;
use Rowboat\Users\Models\UserGroupModel;
class RoleModel extends Role
{
	/**
     * Check name permission exits
     * @param  string $perName permission's name
     * @return bool status
     */
    public function checkName($roleName)
    {
        $status = 0;
        $count = $this->where('name',$roleName)
                                  ->where('id','!=',$this->id)
                                  ->count();
        if($count == 0) {
            $status = 1;
        }

        return $status;
    }
}
