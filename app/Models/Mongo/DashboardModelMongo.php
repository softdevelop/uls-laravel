<?php namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DashboardModelMongo extends Eloquent
{
    //set collection is traffic
    protected $collection = 'dashboard';
    //connection mongodb
    protected $connection = 'mongodb';

    protected $fillable = ['user_id', 'height', 'sort_order', 'file_name'];
    /**
     * `
     * @param  [int] $curentSort [ sort curent of file name]
     * @param  [int] $newSort    [sort new of file name]
     * @param  [boolean ] $collapse   []
     * @return [void] 
     */
    public static function editSortElement($data)
    {
        $status = 0;
        // get user login
        foreach ($data as $key => $value) {
            $dashBoard = self::find($value['_id']);
            $dashBoard->update(['sort_order'=>intval($key)]);
            $status = 1;
        }
    	return $status;
    }

    /**
     * [save New Dashboard with new user]
     * @param  [array] $user 
     * @return [void]
     */
    public static function saveNewDashboard($user)
    {
        //set date with all file name
        $status =1;
        $data = [
            [
                'user_id' => $user->id,
                'sort_order' => 0,
                'height' => 'auto',
                'file_name' => 'page-overview'
            ],
            [
                'user_id' => $user->id,
                'sort_order' => 1,
                'height' => 'auto',
                'file_name' => 'traffic-overview'
            ],
            [
                'user_id' => $user->id,
                'sort_order' => 2,
                'height' => 'auto',
                'file_name' => 'ticket-overview'
            ],
            [
                'user_id' => $user->id,
                'sort_order' => 3,
                'height' => 'auto',
                'file_name' => 'task-overview'
            ]
        ];
        // create new dashboard with file name
        foreach ($data as $value) {
            $dashboard = self::create($value);
            if(empty($dashboard)){
                $status = 0;
            }
        }
        return $status;
    }

    public function changeCollapse($data)
    {
        $dashboardUser = self::where('user_id', \Auth::user()->id)->where('sort_order', $data['sort_order'])->first();
        $dashboardUser->height = $data['height'];
        $dashboardUser->save();

        return $dashboardUser;
    }
}
