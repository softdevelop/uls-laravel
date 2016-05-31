<?php 
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel;
use Way\Tests\Factory;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateFolderModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateContentManagerModel;
use Rowboat\TemplateContentManager\Models\Mongo\ContentTemplateModelMongo;
use Rowboat\TemplateContentManager\Services\TemplateContentManagerService;
use Rowboat\TemplateContentManager\Services\parsingFileService;
class TemplateFunctionTest extends TestCase {



    public function testGetContentInject()
    {
        TemplateContentManagerService::getContentInject([], 'en', null);
    }
	/**
	 * test function get priority template conten
	 *
	 * @author Minh than <than@httsolution.com>
	 * @return [type] [description]
	 */
	public function testFunctionPriorityTemplateContent()
	{

		$templateParrent = TemplateFolderModelMongo::where('name', 'Templates')->where('parent_id', '0')->first();

		$template = TemplateContentManagerModel::where('folder_id', $templateParrent->_id)->first();
        // query get template current region and languge time new
        $contentTemplate = ContentTemplateModelMongo::where(function($query){ // get template with language and region

            $query->where('language', 'zh')
                  ->where('region', null);
        })
        ->orWhere(function($query) { // get template default

            $query->where('language', 'en')
                  ->where('region', null);
        })
        ->where('status', 'uptodate')
        ->where('base_id', $template->_id)
        ->orderBy('created_at', 'desc')
        ->first();

        $templateContentInFuntion = TemplateContentManagerService::priorityTemplateContent($template->_id, 'zh', null, false);
        // assert equals
        $this->assertEquals($contentTemplate, $templateContentInFuntion);
	}
}