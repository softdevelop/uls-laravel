<?php

namespace App\Console\Commands\Page;

use Illuminate\Console\Command;
use Rowboat\TemplateContentManager\Models\Mongo\BuildContentModelMongo;
use Rowboat\BlocksManagement\Models\Mongo\BlocksContentModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\ContentManagement\Models\Mongo\CmsDataModelMongo;

class RemoveFieldsInvaldInContentPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:update_data_content_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Content Build Field.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start...');
        //get all page
        $allPage = ContentModelMongo::all();

        //passing each item from list page
        foreach ($allPage as $keyPage => $page) {
            $allDataContentPage = CmsDataModelMongo::where('content_id', $page['_id'])->get();
            foreach ($allDataContentPage as $keyContent => $contentPage) {
                if (isset($contentPage['data']) && !empty($contentPage['data']) && isset($contentPage['data']['fields']) && !empty($contentPage['data']['fields'])) {
                    $fieldValueOfPage = $contentPage['data']['fields'];
                    // if ($page['page_id'] == '56c265b5d64791716b8b4567') {
                    // 
                    $arrayValueField = self::getListFieldWithTemplateIdAndCustomFields($page['template_id']);

                    self::removeFieldInvalidInPage($fieldValueOfPage, $arrayValueField);

                    // $page_id = $page['page_id'];

                    //set value fields for page after remove fields is invalid
                    $contentPage['data.fields'] = $fieldValueOfPage;
                    $contentPage->timestamps = false;
                    //save content page agian
                    $contentPage->save();
                }
            }
        }
        $this->info('Success!');

    }

    /**
     * [getListFieldWithTemplateIdAndCustomFields description]
     * get fields of current template and template extend belong to current template
     * and fiekds of inject belong to current template
     * and contruct array value with format [id template or block + variable of field]
     *
     * @author [Nguyen Kim Bang] <[bang@httsolution.com]>
     * @param  [type] $_templateId      [description]
     * @return [type] array             [description]
     */
    public function getListFieldWithTemplateIdAndCustomFields($_templateId)
    {
        $arrayValueField = [];

        $query = BuildContentModelMongo::where('template_id', $_templateId)->first();
        //check exist template and content of template and that content is empty?
        if (!empty($query) && isset($query['content']) && !empty($query['content'])) {

            $allTemplate = [];
            //check exist template extend blong to current template?
            if (isset($query['content']['extends']) && !empty($query['content']['extends'])) {
                $allTemplate = $query['content']['extends'];
            }

            //check exist field belong to current template?
            if (isset($query['content']['fields']) && !empty($query['content']['fields'])) {
                $allTemplate[$_templateId] = $query['content'];
            }

            foreach ($allTemplate as $_keyTemplate => $content) {
                //check exist field of current template
                if (isset($content['fields']) && !empty($content['fields'])) {

                    self::contructArrayValueField($content['fields'], $_keyTemplate, $arrayValueField);
                }

                //check exist field inject of current template
                if (isset($content['injects']) && !empty($content['injects'])) {

                    self::getFieldInjectBelongtoTempaplate($content['injects'], $arrayValueField);
                }
            }
        }

        return $arrayValueField;
    }

    /**
     * [getFieldInjectBelongtoTempaplate description]
     * get list field in inject
     *
     * @author [Nguyen Kim Bang] <[bang@httsolution.com]>
     * @param  [type] $allInjectTeplate [list inject (block) inset in template]
     * @param  [type] &$arrayValueField [fill list value with format (id template or block + variable of field)]
     * @return [type]                   [description]
     */
    public function getFieldInjectBelongtoTempaplate($allInjectTeplate, &$arrayValueField) {

        //passing each block from list block of current template
        foreach ($allInjectTeplate as $_keyFieldExtend => $value) {

            //check exist field of current block?
            if (isset($allInjectTeplate[$_keyFieldExtend]['fields']) && !empty($allInjectTeplate[$_keyFieldExtend]['fields'])) {

                self::contructArrayValueField($allInjectTeplate[$_keyFieldExtend]['fields'], $_keyFieldExtend, $arrayValueField);
            }
        }
    }

    /**
     * [contructArrayValueField description]
     * make array with format ([id template or block + variable of field]) and default value is true
     * it use check content data of page
     *
     * @author [Nguyen Kim Bang] <[bang@httsolution.com]>
     * @param  [type] $fields           [description]
     * @param  [type] $arrayValueField  [description]
     * @param  [type] $_id              [id of template or block]
     * @return [type]                   [description]
     */
    public function contructArrayValueField($fields, $_id, &$arrayValueField) {
        //passing ech field from list field
        foreach ($fields as $keyField => $field) {

            $key = '_'.$_id.'_'.$field['variable'];

            //check current field is multiple?
            if (!$field['multiple']) {

                $arrayValueField[$key] = true;
            } else if(isset($field['option_id']) && !empty($field['option_id'])) {//check exist option_id (block id) and not empty of current field

                //get all field of current block with option id of field
                $listFieldsOfBlock = self::getFieldOfBlock($field['option_id']);

                //if exist list field of block, call back contructArrayValueField function
                if ($listFieldsOfBlock) {

                    self::contructArrayValueField($listFieldsOfBlock, $field['option_id'], $arrayValueField[$key]);
                }
            }
        }
    }

    /**
     * [getFieldOfBlock description]
     * get list field of block with block id
     *
     * @author [Nguyen Kim Bang] <[bang@httsolution.com]>
     * @param  [type] $_idBlock        [description]
     * @return [type] array            [exist field in block]
     * @return [type] boolean          [exist field in block]
     */
    public function getFieldOfBlock($_idBlock) {
        $query = BlocksContentModelMongo::where('base_id', $_idBlock)->first();
        
        //check exist field of block
        if (!empty($query) && isset($query['fields']) && !empty($query['fields'])) {

            return $query['fields'];
        }

        return false;
    }

    /**
     * [removeFieldInvalidInPage description]
     * remove fields is invalid in page, which not exist list field of template
     *
     * @author [Nguyen Kim Bang] <[bang@httsolution.com]>
     * @param  [type] $_pageId   [description]
     * @param  [type] $_variable [_variable with formart (id tempate or block + variable)]
     * @param  [type] $_childVariable [_childVariable with formart (id block + variable) apply for fields is multiple]
     * @return [type]            [description]
     */
    public function removeFieldInvalidInPage(&$_fieldValueOfPage, $_arrayValueField) {
        foreach ($_fieldValueOfPage as $key => $value) {

            //check exist field in list field of template (current template, template extends, injects)
            //if not exits, unset it from content of page
            if (!isset($_arrayValueField[$key])) {

                unset($_fieldValueOfPage[$key]);
            } elseif (is_array($_fieldValueOfPage[$key])) {//check current field value is array?

                //if true, passing each item and call back removeFieldInvalidInPage function
                //remove a few field (field of block) (not exist list field template) of multiple fields.
                foreach ($_fieldValueOfPage[$key] as $key1 => $value1) {

                    //check exit field in content page and it is an array?
                    if (isset($_fieldValueOfPage[$key][$key1]) && !empty($_fieldValueOfPage[$key][$key1]) && is_array($_fieldValueOfPage[$key][$key1])) {

                        self::removeFieldInvalidInPage($_fieldValueOfPage[$key][$key1], $_arrayValueField[$key]);
                    }
                }
            }
        }
    }
}
