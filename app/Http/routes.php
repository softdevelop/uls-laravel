<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Authentication routes...
Route::controller('tests', 'Test\TestController');
Route::controller('tests-cms-page', 'Test\Cms\Pages\TestPageController');
Route::controller('tests-cms-block', 'Test\Cms\Blocks\TestBlockController');

Route::get('test', 'TestController@index');
Route::post('test/tags', 'TestController@getTags');

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('become-user/{email}', 'Auth\AuthController@autoLogin');
// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('password/create-password/{token}', 'Auth\PasswordController@getCreatePassword');

Route::get('dashboard/select-type-to-show-dashboard','DashboardController@selectTypeToShowDashboard');

Route::get('/', 'DashboardController@index');
Route::get('generate-update-template', 'DashboardController@generateUpdateTemplate');
Route::get('demo-rockmongo', 'DashboardController@getDemoRockmongo');
Route::get('generate-build-template', 'DashboardController@getGenerateBuild');
Route::get('generate-build-block', 'DashboardController@getGenerateContentBlockBuild');
Route::get('update-template-built', 'DashboardController@getUpdateTemplateBuilt');
Route::get('test-s3', 'DashboardController@getTestS3');
Route::get('get-table-name', 'DashboardController@getTablename');
Route::get('home', 'HomeController@index');

Route::get('home/upload-file', 'HomeController@uploadFile');

Route::resource('users','UserController');

Route::get('demo/{url}', 'PagesController@demoPages');

Route::get('demo/{partBeforeUrl}/{url}', 'PagesController@demoChildPages');

Route::get('pages-sync/page-traffic', 'PagesSyncController@trafficPage');
Route::get('pages-sync/seo-page-traffic', 'PagesSyncController@getTraffic');

// Route::get('/get-page/{language}/{region}','Api\PagesController@getListPage');

/*User route*/
Route::group(['prefix' => 'admin'], function(){
	Route::group(['prefix' => 'user'], function(){
		Route::get('roles/permissions/{id}','RoleController@permissions');
		Route::resource('roles','RoleController');

		Route::resource('permissions','PermissionController');
		Route::group(['prefix' => 'api'], function(){
			Route::resource('roles','Api\RoleController');
			Route::post('roles/update-permission/{id}','Api\RoleController@updatePermission');
			Route::post('roles/check-name','Api\RoleController@checkName');

			Route::post('permissions/check-name','Api\PermissionController@checkName');
			Route::post('permissions/add-user-permission','Api\PermissionController@addUserPermission');
			Route::post('permissions/add-group-permission','Api\PermissionController@addGroupPermission');
			Route::post('permissions/delete-user-permission/{id}','Api\PermissionController@deleteUserPermission');
			Route::post('permissions/delete-group-permission/{id}','Api\PermissionController@deleteGroupPermission');
			Route::resource('permissions','Api\PermissionController');
		});
	});

	Route::get('user/show-permissions/{id}','UserController@permissions');
	Route::resource('user','UserController');

	Route::resource('terms/{termId}/template-manager','TermTemplateManagerController');

	Route::controller('terms','TermController');


});


/**
 * Route for products
 */
Route::group(['prefix' => 'products'], function(){
	Route::controller('configurator', 'ConfiguratorController');
	 // Route::controller('', 'ProductsController');

});
Route::controller('products', 'ProductsController');
// Route::get('user/profile/{id}','UserController@profile');
// Route::post('api/user/profile/check-email','Api\UserController@checkEmailProfile');

Route::controller('seo/pages', 'PagesSyncController');

Route::get('find-representatives', 'FindRepByAddressController@getFindRepresentatives');
Route::get('find-by-address', 'FindRepByAddressController@postFindByAddress');
Route::post('find-by-address', 'FindRepByAddressController@postFindByAddress');
// Route::controller('find-representatives', 'FindRepByAddressController');

Route::group(['prefix' => 'api'], function()
{
	/*User route*/
	// Route::get('user/get-all-user-manager','Api\UserController@getAllUserManager');
	// Route::post('user/update-permission/{id}','Api\UserController@updatePermission');
	// Route::post('user/update-role/{id}','Api\UserController@updateRole');
	// Route::post('user/change-password/{id}','Api\UserController@changePassword');
	// Route::post('user/change-avatar/{id?}','Api\UserController@changeAvatar');
	// Route::post('user/email','Api\UserController@postEmail');
	// Route::post('user/update-show-due-date-user', 'Api\UserController@updateShowDueDateUser');
	// Route::delete('user/change-status/{id}','Api\UserController@changeStatus');
	// Route::resource('user','Api\UserController');

	Route::resource('pagination', 'Api\PaginationController');

	Route::resource('languages', 'Api\LanguagesController');

	Route::resource('regions', 'Api\RegionsController');

	Route::post('regions/check/','Api\RegionsController@checkRegion');

	Route::resource('market-segments', 'Api\MarketSegmentsController');

	Route::resource('channel-partners', 'Api\ChannelPartnersController');
	Route::post('channel-partners/check/','Api\ChannelPartnersController@checkPartner');

	Route::get('translation-queue/export','Api\TranslationQueueController@export');

	Route::resource('translation-queue', 'Api\TranslationQueueController');

	Route::post('translation-queue/file-upload', 'Api\TranslationQueueController@upload');

	Route::resource('campaign-manager', 'Api\CampaignManagerController');

	Route::post('template-manager/upload/position', 'Api\TemplateManagerController@uploadFileForPosition');
	Route::post('template-manager/upload', 'Api\TemplateManagerController@uploadFile');
    Route::delete('template-manager/delete-image/{templateId}', 'Api\TemplateManagerController@deleteThumbnail');
    // Route::delete('template-manager/delete-image-position/{templateId}/{fileName}', 'Api\TemplateManagerController@deleteThumbnailPosition');
	Route::resource('template-manager', 'Api\TemplateManagerController');

	Route::post('term-template-manager/upload', 'Api\TermTemplateManagerController@uploadFile');
	Route::resource('term-template-manager', 'Api\TermTemplateManagerController');

	Route::post('term/get-show-html-field/{id}','Api\TermController@showHtmlField');
	Route::post('term/update-html-field/{id}','Api\TermController@updateHtmlField');
	Route::post('term/add-wrapper/{id}/{_id}','Api\TermController@addWrapper');
	Route::post('term/update-term/{id}/{_id}','Api\TermController@updateTerm');
	Route::post('term/delete-group-html/{id}', 'Api\TermController@deleteGroupHtml');
	Route::post('term/change-field-is-modal', 'Api\TermController@changeFieldIsModal');
	Route::delete('term/delete-field-term/{id}/{_id}', 'Api\TermController@deleteFieldTerm');
	Route::resource('term', 'Api\TermController');

	Route::post('dashboard/change-collapse', 'Api\DashboardController@changeCollapse');
	Route::post('dashboard/set-session-filter-ticket-type', 'Api\DashboardController@setSessionFilterTicketType');
	Route::post('dashboard/select-type-show', 'Api\DashboardController@selectTypeShow');
	Route::post('dashboard/save-sort', 'Api\DashboardController@saveSort');
	Route::post('dashboard/remove-type-dashboard', 'Api\DashboardController@removeTypeDashboard');
	Route::resource('dashboard', 'Api\DashboardController');

	Route::get('seo/pages/show-seo-report/{id}', 'Api\PagesSyncController@showSeoReportPage');

	Route::get('seo/pages/sync', 'Api\PagesSyncController@synPageReport');

	Route::get('manage-term/file-manager-term', 'Api\ManageTermController@getFileManagerTerm');

	Route::resource('manage-term', 'Api\ManageTermController');

	//guided configuaration
	Route::resource('guide-configuaration', 'Api\GuidedConfiguratorController');
});

Route::group(['prefix' => 'site-configuration'], function(){

	Route::resource('languages', 'LanguagesController');

	Route::resource('regions', 'RegionsController');

	Route::resource('market-segments', 'MarketSegmentsController');
});

Route::resource('pagination', 'PaginationController');

Route::resource('campaign-manager', 'CampaignManagerController');

Route::resource('channel-partners', 'ChannelPartnersController');

Route::resource('translation-queue', 'TranslationQueueController');

Route::resource('contactus', 'ContactUsController');

Route::controller('file-redactor', 'FileController');

Route::controller('theme', 'ThemeController');

Route::get('template-manager/view-image/{path}', 'TemplateManagerController@viewImage');
Route::resource('template-manager', 'TemplateManagerController');

Route::resource('uls-page', 'MainPageController');

Route::resource('seo/overview', 'SeoAnalysisController');

Route::resource('seo', 'SeoController');

Route::get('manage-term/create/{termId}', 'ManageTermController@createNewItem');
Route::get('manage-term/edit/{termId}/{id}', 'ManageTermController@editItem');

Route::get('manage-term/create-modal/{lenght}', 'ManageTermController@createModal');

Route::get('manage-term/{termId}/content-type/{id}/show-detail', 'ManageTermController@showDetail');

Route::resource('manage-term', 'ManageTermController');
