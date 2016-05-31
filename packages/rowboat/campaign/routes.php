<?php

Route::post('api/campaign/search-report-campaign', 'Rowboat\Campaign\Http\Controllers\Api\CampaignController@searchReportCampaign');
Route::post('api/campaign/search-report-ads', 'Rowboat\Campaign\Http\Controllers\Api\CampaignController@searchReportAds');
Route::post('api/campaign/search-report-group', 'Rowboat\Campaign\Http\Controllers\Api\CampaignController@searchReportGroup');

Route::resource('campaign', 'Rowboat\Campaign\Http\Controllers\CampaignController');

Route::resource('campaign/report-group', 'Rowboat\Campaign\Http\Controllers\CampaignController@reportGroup');
Route::resource('campaign/report-ads', 'Rowboat\Campaign\Http\Controllers\CampaignController@reportAds');

Route::get('delete-cache-campaign', 'Rowboat\Campaign\Http\Controllers\CampaignController@deleteCacheCampaign');
