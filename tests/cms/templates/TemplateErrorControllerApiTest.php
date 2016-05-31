<?php 
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel;
use Way\Tests\Factory;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateFolderModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateContentManagerModel;
use Rowboat\TemplateContentManager\Models\Mongo\ContentTemplateModelMongo;
class TemplateErrorControllerApiTest extends TestCase {

	/**
	 * test error action create new folder  not exits folder parrent
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionCreateNewFolderNotLogin()
	{

		$data = [
			'name' => 'asfsafs',
			'parent_id' => '0'
		];
		// login and call method api create folder
		$request = $this->post('api/template-content-manager/create-folder', $data);
		$request->see('Redirecting to http://localhost/auth/login');
	}
	/**
	 * test error action create new folder  not exits folder parrent
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionCreateNewFolderEmptyName()
	{

		$data = [
			'name' => '',
			'parent_id' => '0'
		];
		$userLoginTest = UserModel::find(6);
		// login and call method api create folder
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/create-folder', $data);

		$request->seeJson(['status' => 0]);
	}

	/**
	 * test error action create new folder  not exits folder parrent
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionCreateNewFolderNotExitsFolderParrent()
	{

		$data = [
			'name' => 'Templasafsaftes',
			'parent_id' => 'safsafsafsa'
		];
		$userLoginTest = UserModel::find(6);
		// login and call method api create folder
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/create-folder', $data);

		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action create new folder exits name
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionCreateNewFolderExitsFolderName()
	{

		$data = [
			'name' => 'Templates',
			'parent_id' => '0'
		];
		$userLoginTest = UserModel::find(6);
		// login and call method api create folder
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/create-folder', $data);

		$request->seeJson(['status' => 0]);
	}

	/**
	 * test error action add new template empty name
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	*/
	public function testErrorActionAddNewTemplateEmptyName()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => '',
			'folder_id' => $templateParrent->_id,
			'thumbnail' => null,
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post create new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/upload-new-template', $data);
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action add new template empty folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	*/
	public function testErrorActionAddNewTemplateEmptyFolder()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => 'test create template empty folder',
			'folder_id' => null,
			'thumbnail' => null,
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post create new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/upload-new-template', $data);
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action propose new template  empty name
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionProposeNewTemplateEmptyName()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => '',
			'folder_id' => $templateParrent->_id,
			'due_date' => '2016-04-18T17:00:00.000Z',
			'description' => 'description template',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		// $request->dump();
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action propose new template  max 255 length
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionProposeNewTemplateMaxLengthName()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => 'xxx xxx xxxx  xxx xxxxxxx xxxxx x xxxx xxxxxx xxxxx xxxx xxx xxxx xxxx xxxx xxxx xxxxx  xxxx xxxx xxxx xxxx xxxxx
			xxx xxx xxxx  xxx xxxxxxx xxxxx x xxxx xxxxxx xxxxx xxxx xxx xxxx xxxx xxxx xxxx xxxxx  xxxx xxxx xxxx xxxx xxxxx xxx x xx
			xxx xxx xxxx  xxx xxxxxxx xxxxx x xxxx xxxxxx xxxxx xxxx xxx xxxx xxxx xxxx xxxx xxxxx  xxxx xxxx xxxx xxxx xxxxx xxxx',
			'folder_id' => $templateParrent->_id,
			'due_date' => '2016-04-18T17:00:00.000Z',
			'description' => 'description template',

		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		// $request->dump();
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action propose new template empty folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionProposeNewTemplateEmptyDueDate()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => 'test empty dua date',
			'folder_id' => $templateParrent->_id,
			'due_date' => '',
			'description' => 'description template',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		// $request->dump();
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action propose new template empty folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionProposeNewTemplateDueDateNotFomatDate()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => 'test dua date not fomat date',
			'folder_id' => $templateParrent->_id,
			'due_date' => 'fgsdf safsa',
			'description' => 'description template',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		// $request->dump();
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action propose new template empty folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionProposeNewTemplateEmptyDescription()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => 'test empty description',
			'folder_id' => $templateParrent->_id,
			'due_date' => '2016-04-18T17:00:00.000Z',
			'description' => '',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		// $request->dump();
		$request->seeJson(['status' => 0]);
	}

	/**
	 * test error action request translation template empty name
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestTranslationEmptyName()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => '',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '<div>aaa a aa a</div>',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => ['Chinese'=> 'zh'],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action request translation template empty dua date
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestTranslationEmptyDuaDate()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => 'xx xx xxx',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '<div>aaa a aa a</div>',
			'due_date' => '',
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => ['Chinese'=> 'zh'],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action request translation template empty description
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestTranslationEmptyDescription()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => 'xx xx xxx',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => ['Chinese'=> 'zh'],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action request translation template empty language
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestTranslationEmptyLanguages()
	{

		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => 'xx xx xxx',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => [],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		$request->seeJson(['status' => 0]);		

	}
	/**
	 * test error action request region template empty region
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestRegionEmptyRegion()
	{

		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => 'xx xx xxx',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => ['Chinese'=> 'zh'],
			'regions' => [],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/request-region', $data);
		$request->seeJson(['status' => 0]);	
	}
	/**
	 * test error action request region template empty language
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestRegionEmptyName()
	{

		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => '',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => ['Chinese'=> 'zh'],
			'regions' => ['Andorra'=> 'aa'],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/request-region', $data);
		$request->seeJson(['status' => 0]);	
	}
	/**
	 * test error action request region template empty dua date
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestRegionEmptyDuaDate()
	{

		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => 'xx xxx xx',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '',
			'due_date' => '',
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => ['Chinese'=> 'zh'],
			'regions' => ['Andorra'=> 'aa'],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/request-region', $data);
		$request->seeJson(['status' => 0]);	
	}
	/**
	 * test error action request region template empty folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionRequestRegionEmptyFolder()
	{

		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => $template->_id,
			'name' => 'xx xxx xx',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'folderName' => 'Templates',
			'folder_id' => null,
			'languages' => ['Chinese'=> 'zh'],
			'regions' => ['Andorra'=> 'aa'],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/request-region', $data);
		$request->seeJson(['status' => 0]);	
	}
	/**
	 * test error action update template not has permission edit template
	 *
	 * @author Minh than <than@httsolution.com>
	 * 
	 * @return [type] [description]
	 */
	public function testErrorACtionEditTemplateNotHasPermission()
	{
		$userLoginTest = UserModel::find(10);

		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();

		$data = [
			'base_id' => $template->_id,
			'content' => 'test 1111 1111 11111111',
			'_id' => $contentTemplate->_id,
			'language'=> 'en',
		    'region'=> null,
		    'status'=> $contentTemplate->status,
		    'thumbnail'=> null,
		    'name'=> '',
		    'folderName'=> 'Templates',
		    'folder_id'=> $templateParrent->_id,
		    'blocks'=> [],
		    'extends' => [],
		];
		$request = $this->actingAs($userLoginTest)->put('api/template-content-manager/' . $contentTemplate->_id, $data);

		$request->seeJson(['status' => 0]);
	}

	/**
	 * test error action update template empty name
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionUpdateTemplateEmptyName()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();

		//initialization data
		$data = [
			'base_id' => $template->_id,
			'content' => 'test 1111 1111 11111111',
			'_id' => $contentTemplate->_id,
			'language'=> 'en',
		    'region'=> null,
		    'status'=> $contentTemplate->status,
		    'thumbnail'=> null,
		    'name'=> '',
		    'folderName'=> 'Templates',
		    'folder_id'=> $templateParrent->_id,
		    'blocks'=> [],
		    'extends' => [],
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->put('api/template-content-manager/' . $contentTemplate->_id, $data);

		$request->seeJson(['status' => 0]);		
	}
	/**
	 * test error action update template empty folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionUpdateTemplateEmptyFolder()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();

		//initialization data
		$data = [
			'base_id' => $template->_id,
			'content' => 'test 1111 1111 11111111',
			'_id' => $contentTemplate->_id,
			'language'=> 'en',
		    'region'=> null,
		    'status'=> $contentTemplate->status,
		    'thumbnail'=> null,
		    'name'=> 'aa aaa aaa',
		    'folderName'=> 'Templates',
		    'folder_id'=> null,
		    'blocks'=> [],
		    'extends' => [],
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->put('api/template-content-manager/' . $contentTemplate->_id, $data);

		$request->seeJson(['status' => 0]);		
	}

	/**
	 * test error action update template empty folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testErrorActionUpdateTemplateEmptyContent()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();

		//initialization data
		$data = [
			'base_id' => $template->_id,
			'content' => '',
			'_id' => $contentTemplate->_id,
			'language'=> 'en',
		    'region'=> null,
		    'status'=> $contentTemplate->status,
		    'thumbnail'=> null,
		    'name'=> 'aa aaa aaa',
		    'folderName'=> 'Templates',
		    'folder_id'=> $templateParrent->_id,
		    'blocks'=> [],
		    'extends' => [],
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->put('api/template-content-manager/' . $contentTemplate->_id, $data);

		$request->seeJson(['status' => 0]);		
	}
	/**
	 * test error action delete content template not has permission cms delete content
	 *
	 * @author Minh than <than@httsolution.com>
	 * 
	 * @return [type] [description]
	 */
	public function testErrorActionDeleteContentTemplateNotHasPermission()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();

		$userLoginTest = UserModel::find(10);

		$request = $this->actingAs($userLoginTest)->get('api/template-content-manager/delete-file/' . $contentTemplate->_id);
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action delete content template is language and region default
	 *
	 * @author Minh than <than@httsolution.com>
	 * 
	 * @return [type] [description]
	 */
	public function testErrorActionDeleteContentTemplateHasLanguageAndRegionDefault()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();

		$userLoginTest = UserModel::find(6);

		$request = $this->actingAs($userLoginTest)->get('api/template-content-manager/delete-file/' . $contentTemplate->_id);
		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action edit name folder empty name
	 *
	 * @author Minh than <than@httsolution.com>
	 * 
	 * @return [type] [description]
	 */
	public function testErrorActionEditNameFolderEmptyName()
	{
		$templateFolderParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		$templateFolderChilren = TemplateFolderModelMongo::where('parent_id', $templateFolderParrent->_id)->first();
		$data = [
			'_id' => $templateFolderChilren->_id,
			'name' => ''
		];
		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/edit-name-folder', $data);

		$request->seeJson(['status' => 0]);
	}
	/**
	 * test error action delete folder not has permission cms delete content
	 *
	 * @author Minh than <than@httsolution.com>
	 * 
	 * @return [type] [description]
	 */
	public function testErrorActionDeleteFolderNotHasPermission()
	{
		$templateFolderParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		$templateFolderChilren = TemplateFolderModelMongo::where('parent_id', $templateFolderParrent->_id)->first();
		$userLoginTest = UserModel::find(10);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->delete('api/template-content-manager/' . $templateFolderChilren->_id);

		$request->seeJson(['status' => 0]);	

	}

	public function testErrorActionDeleteFolderNotExits()
	{
		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->delete('api/template-content-manager/353453454');

		$request->seeJson(['status' => 0]);
	}

}