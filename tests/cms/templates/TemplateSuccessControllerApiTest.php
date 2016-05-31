<?php 
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel;
use Way\Tests\Factory;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateFolderModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateContentManagerModel;
use Rowboat\TemplateContentManager\Models\Mongo\ContentTemplateModelMongo;
class TemplateSuccessControllerApiTest extends TestCase {


	protected $folderId = '0';

	protected $templateId = null;
	/**
	 * test succsess action create new folder 
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testSuccessActionCreateNewFolder()
	{
		$stringRandom = 'ABCDEFGHIJK';
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		if(empty($templateParrent)) {

			$templateParrent = TemplateFolderModelMongo::create(['name' => 'Templates', 'parent_id' => '0']);
		}
		$shuffled = str_shuffle($stringRandom);
		$data = [
			'name' => 'Test Create New Folder Random ' . $shuffled,
			'parent_id' => $templateParrent->_id
		];
		$this->folderId = $templateParrent->_id;
		$userLoginTest = UserModel::find(6);
		// login and call method api create folder
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/create-folder', $data);

		$request->seeJson(['status' => 1]);
	}
	/**
	 * test succsess action add new template
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testSuccessActionAddNewTemplate()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => 'Test Create Template',
			'folder_id' => $templateParrent->_id,
			'thumbnail' => null,
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post create new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/upload-new-template', $data);

		$request->seeJson(['status' => 1]);
	}
	/**
	 * test succsess action propose new template 
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testSuccessActionProposeNewTemplate()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		//initialization data
		$data = [
			'name' => 'Test Propose New Template',
			'folder_id' => $templateParrent->_id,
			'due_date' => '2016-04-18T17:00:00.000Z',
			'description' => 'description template',
			'files_id' => [421,422],

		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post propose new template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager', $data);
		// $request->dump();
		$request->seeJson(['status' => 1]);
	}
	/**
	 * test succsess action request translation template
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testSuccessActionRequestTranslation()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('name', 'Test Create Template')->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => '56d62993d64791746a8b456c',
			'name' => 'Test Propose New Template',
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '<div>aaa a aa a</div>',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'files_id' => [423, 424],
			'folderName' => 'Templates',
			'folder_id' => $templateParrent->_id,
			'languages' => ['Chinese'=> 'zh'],
			'status' => 'waiting-approve',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/request-translation', $data);

		$request->seeJson(['status' => 1]);
	}
	/**
	 * test succsess action request region template
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testSuccessActionRequestRegion()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('name', 'Test Create Template')->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => '56fc22c80454aa431131742c',
			'base_id' => '56fc22c80454aa431131742b',
			'name' => 'AMPC',
			'folder_id' => $templateParrent->_id,
			'ancestor_ids' => [$templateParrent->_id, "0"],
			'copyTemplate' => $contentTemplate->_id,
			'description' => '<div>aaa xx xx</div>',
			'due_date' => '2016-03-31T17:00:00.000Z',
			'files_id' => [425, 426],
			'folderName' => 'Templates',
			'languages' => ['Chinese'=> 'zh'],
			'status' => 'waiting-approve',
			'language' => 'en',
			'region' => null,
			'regions' => ['Andorra'=> 'aa'],
			'upload_new_template' => true,
			'thumbnail' => null,
			'modal' => 'request_region',
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/request-region', $data);

		$request->seeJson(['status' => 1]);
	}
	/**
	 * test succsess action update template
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testSuccessActionUpdateTemplate()
	{
		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('name', 'Test Create Template')->first();

		$contentTemplate = ContentTemplateModelMongo::where('base_id', $template->_id)->first();
		//initialization data
		$data = [
			'_id' => '56fc22c80454aa431131742c',
			'base_id' => $template->_id,
			'content' => 'test 1111 1111 11111111',
			'_id' => $contentTemplate->_id,
			'language'=> 'en',
		    'region'=> null,
		    'status'=> $contentTemplate->status,
		    'thumbnail'=> null,
		    'updated_at'=> '2016-03-30 19:15:41',
		    'upload_new_template'=> true,
		    'name'=> $template->name,
		    'folderName'=> 'Templates',
		    'folder_id'=> $templateParrent->_id,
		    'blocks'=> [],
		    'extends' => [],
		];

		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->put('api/template-content-manager/' . $contentTemplate->_id, $data);

		$request->seeJson(['status' => 1]);
	}
	/**
	 * test success action edit name folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * 
	 * @return [type] [description]
	 */
	public function testSuccessActionEditNameFolder()
	{
		$templateFolderParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		$templateFolderChilren = TemplateFolderModelMongo::where('parent_id', $templateFolderParrent->_id)->first();
		$shuffled = str_shuffle('ABCDEFGHIJK');
		$data = [
			'_id' => $templateFolderChilren->_id,
			'name' => 'test edit name ' . $shuffled
		];
		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->post('api/template-content-manager/edit-name-folder', $data);

		$request->seeJson(['status' => true]);
	}
	/**
	 * test success action delete folder
	 *
	 * @author Minh than <than@httsolution.com>
	 * 
	 * @return [type] [description]
	 */
	public function testSuccessActionDeleteFolder()
	{
		$templateFolderParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();
		$templateFolderChilren = TemplateFolderModelMongo::where('parent_id', $templateFolderParrent->_id)->first();
		$userLoginTest = UserModel::find(6);
		// login and call test method api post request translation template
		$request = $this->actingAs($userLoginTest)->delete('api/template-content-manager/' . $templateFolderChilren->_id);

		$request->seeJson(['status' => 1]);	
	}
}