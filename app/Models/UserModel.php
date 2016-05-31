<?php namespace App\Models;

use Rowboat\Users\Models\UserModel as User;
use Rowboat\Users\Services\CacheService;
use App\Services\TimeService;

class UserModel extends User
{
	/**
     * [store description]
     * store users
     * @return [type] [description]
     */
    public function store($data)
    {
        $user = $this->create($data);

        if(!empty($data['personal_information'])){

            $profile = new PersonalInformationModel($data['personal_information']);

            $user->personalInformation()->save($profile);

        }

        $user->status = 'yes';
        $user->created_at = date("Y-m-d H:i:s", TimeService::setTimeZoneCurrentUser( \Auth::user()->time_zone, $user->created_at));
        return $user;
    }

}