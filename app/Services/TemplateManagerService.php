<?php namespace App\Services;

use App\Models\TemplateManagerModel;
use App\Models\Mongo\TemplateManagerModelMongo;
use App\Models\BlockModel;
use App\Models\ImageTemplate;

class TemplateManagerService
{

    /**
     * get list templates with title and alias title
     * @return array list object template
     */
    public function getListTemplate()
    {
        /* Get lists template with title and alias_title */
        $db = TemplateManagerModel::lists('title','alias_title');

        return $db;
    }

    /**
     * get lists template by id
     * @return [type] [description]
     */
    public function getListsTemplatebyId()
    {
        /* Get lists template by id */
        $templates = $this->lists('title', 'id');

        return $templates;
    }

    /**
     * check name template has been exist
     * @param data $db     data
     * @param string $alias_title alias title
     * @return  status
     */
    public function CheckUniqueName ($db, $alias_title)
    {
        /* Set status is 1 */
        $status = 1;

        /* Each template */
        foreach ($db as $key => $value) {
            /* If alias title = title of template */
            if($alias_title == $key){
                /* Set status is 0 (fail)*/
                $status = 0;
                break;
            }
        }

        return $status;
    }

    public function updateThumbnailTemplate($id,$thumbnail)
    {
        $template = TemplateManagerModelMongo::find($id);
        if($template->thumbnail != '') {
            $path = public_path('/uploads/templates/').$template['thumbnail'];
            \File::delete($path);
        }

        $template->update(['thumbnail' => $thumbnail]);
        return $template;
    }

    /**
     * upload image
     * @param  Request $request request
     * @return array           status, template, file
     */
    public function uploadFile($data)
    {
        /* Set status is 1 */
        $status = 1;

        /* Find template with id input */
        // $template = TemplateManagerModelMongo::find($data['id_template']);
        
        /* If file is exists */
        if ($data['file']->isValid()) {
            /* Path is contain file */
            $destinationPath = 'uploads/templates';
            /* Get file extension */
            $extendsion = $data['file']->getClientOriginalExtension();
            /* Set file name is encrypt of time with extendion */
            $fileName = md5(date('YmdHis')).'.'.$extendsion;
            /* Move file to path contain file */
            $data['file']->move($destinationPath, $fileName);
            $template = self::updateThumbnailTemplate($data['id_template'], $fileName);
            // $template->update(['thumbnail' => $fileName]);
        } else {
            $status = 0;
        }
        return ['status' => $status,'template' => $template,'file' => $fileName];
    }

    public function deleteThumbnail($templateId)
    {
        /* Set status is 0 */
        $status = 0;

        /* Find template with template id */
        $template = TemplateManagerModelMongo::find($templateId);

        if($template) {
            $path_image = public_path('/uploads/templates/').$template['thumbnail'];
            \File::delete($path_image);
            $template['thumbnail'] = "";
            $template->save();
            $status = 1;
        }

        return ['status'=>$status];
    }

    // public function deleteThumbnailPosition($templateId,$fileName)
    // {
    //     /* Set status is 0 */
    //     $status = false;

    //     /* Find template with template id */
    //     $template = TemplateManagerModelMongo::find($templateId);

    //     $data = $template->toArray();
    //     /*Delete image in path*/
    //     $path = public_path('/files/positions/').$fileName;
    //     if (file_exists($path)) {
    //         $status = \File::delete($path);
    //         $status = 1;
    //     }

    //     /*Delete in mongo*/
    //     if($status) {
    //         foreach ($data['sections'] as &$section) {                
    //             if(isset($section['file_name']) && $section['file_name'] == $fileName) {
    //                 unset($section['file_name']);
    //                 break;
    //             }
    //         }
    //         $template->update(['sections' => $data['sections']]);
    //     }

    //     return ['status' => $status, 'sections' => $data['sections']];
    // }

    public function deleteTemplate($template)
    {
        /* Set status is 0 */
        $status = 0;

        /* If template */
        if(!empty($template)) {
            /* Delete image in path contain */
            if($template['thumbnail'] !='') {
                $path = public_path('/uploads/templates/').$template['thumbnail'];
                \File::delete($path);
            }
            /*Delete image position*/
            foreach ($template['sections'] as $section) {
                if(isset($section['file_name'])) {
                    $path = public_path('/files/positions/').$section['file_name'];
                    \File::delete($path);                    
                }
            }
            
            /* Delete template*/
            $template->delete();
            $status = 1;
        }
        return $status;   
    }

    /**
     * get lists image of template with id template
     * @return array 
     */
    public static function getListsTemplateIdWithImageOfTemplate()
    {
        /* Lists template with template id and image */
        return TemplateManagerModelMongo::lists('thumbnail', '_id');
    }

    /**
     * getListsIdWithImageNameOfPosition description
     * @return Array [description]
     */
    public static function getListsIdWithImageNameOfPosition()
    {
        $listsIdWithImageNameOfPosition = [];
        $templates = TemplateManagerModelMongo::all();
        foreach ($templates as $key => $template) {
            foreach ($template['sections'] as $key => $position) {
                if (!isset( $position['file_name'])) {
                    $position['file_name'] = '';
                }
                $listsIdWithImageNameOfPosition[$position['variable']] = $position['file_name'];
            }
        }
        return $listsIdWithImageNameOfPosition;
    }

}