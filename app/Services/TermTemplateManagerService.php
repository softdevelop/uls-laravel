<?php namespace App\Services;

use App\Models\Mongo\TermTemplateManagerMongo;

class TermTemplateManagerService
{
    public function updateThumbnailTemplate($id,$thumbnail)
    {
        $template = TermTemplateManagerMongo::find($id);
        if($template->thumbnail != '') {
            $path = public_path('/uploads/term-templates/').$template['thumbnail'];
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

        /* If file is exists */
        if ($data['file']->isValid()) {
            /* Path is contain file */
            $destinationPath = 'uploads/term-templates';
            /* Get file extension */
            $extendsion = $data['file']->getClientOriginalExtension();
            /* Set file name is encrypt of time with extendion */
            $fileName = md5(date('YmdHis')).'.'.$extendsion;
            /* Move file to path contain file */
            $data['file']->move($destinationPath, $fileName);
            $template = self::updateThumbnailTemplate($data['id_template'], $fileName);
        } else {
            $status = 0;
        }
        return ['status' => $status,'template' => $template,'file' => $fileName];
    }

    public function updateTemplate($template,$data)
    {
        $check = 0;
        $status = 0;
        if($data['thumbnail'] == '' && $template['thumbnail'] != '') {
            $path = public_path('/uploads/term-templates/').$template['thumbnail'];
            \File::delete($path);
        }

        if($data['type'] != $template['type']) {
            $check = TermTemplateManagerMongo::where('termId',$data['termId'])->where('type',$data['type'])->count();
        }
        if(!$check) {
            $status = $template->update($data);
        }
        return ['status' => $status, 'template' => $template];
    }

    public function deleteTemplate($template)
    {
        /* Set status is 0 */
        $status = 0;

        /* If template */
        if(!empty($template)) {
            /* Delete image in path contain */
            if($template['thumbnail'] !='') {
                $path = public_path('/uploads/term-templates/').$template['thumbnail'];
                \File::delete($path);
            }
            
            /* Delete template*/
            $template->delete();
            $status = 1;
        }
        return $status;   
    }

}