<?php namespace Rowboat\Campaign\Services;
class TimeService{

	public static function setTimeZoneCurrentUser($timeZoneUser, $timeZoneCreate){

		$time = strtotime($timeZoneCreate) - intval($timeZoneUser*60);

		return date('Y-m-d', $time);
	}
}