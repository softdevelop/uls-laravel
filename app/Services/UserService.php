<?php namespace App\Services;

use App\Models\UserModel;

class UserService
{
    public function getInforUser($string, $id)
    {
        $user = UserModel::find($id)->toArray();
        // d($user);die;
        foreach ($user as $key => $value) {

            if(!is_array($value))
                $string = str_replace('{{' . 'user.' . $key .'}}', $value, $string);

        }
        
        return $string;
    }
}