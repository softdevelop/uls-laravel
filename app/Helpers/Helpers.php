<?php namespace App\Helpers;
 
use Illuminate\Support\Str;
use Rowboat\Ticket\Models\TypeModel;
 
class Helper 
{
 
    public static function listMenuIwanTo() {

		$listType = TypeModel::where('position_show', 1)->get();

		return $listType;
    }
 
}
 
?>