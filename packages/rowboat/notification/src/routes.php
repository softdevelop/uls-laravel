<?php
Route::group(['prefix' => 'api'], function(){
	Route::controller('notification', 'Rowboat\Notification\Http\Controllers\Api\NotificationController');
});