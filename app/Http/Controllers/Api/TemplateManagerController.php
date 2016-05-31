<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\TemplateManagerModel;
use App\Models\Mongo\TemplateManagerModelMongo;
use App\Services\TemplateManagerService as TemplateService;
use App\Http\Requests\TemplateFormRequest;

class TemplateManagerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        /* Get all data input */
        $data = $request->all();

        /* Init template model to call function in it */
        $templateManagerModelMongo = new TemplateManagerModelMongo();

        /* Call function create new template */
        extract($templateManagerModelMongo->createTemplate($data));

        return new JsonResponse(['status' => $status, 'template' => $template]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        /* Get all data input */
        $data = $request -> all();

        /* Init template model to call function in it */
        $templateManagerModelMongo = new TemplateManagerModelMongo();

        /* Find template with id input */
        $template = $templateManagerModelMongo::findOrFail($id);

        /* If finded template */
        if(!empty($template)) {
            /* Call function to edit template*/
            extract($template -> EditTemplate($data));
            return new JsonResponse(['status' => $status, 'template' => $template]);
        } else {
            /* Set status is 0 if update faild */
            $status = 0;
        }

        return new JsonResponse(['status' => 0,'errors' => [['Error']], 'template' => (new TemplateManagerModelMongo)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        /* Set status is 0 */
        $status = 0;

        /* Find template with id input */
        $template = TemplateManagerModelMongo::findOrFail($id);

        /* Init template service to call function in it */
        $templateService = new TemplateService;

        /* If isset template then delete this template */
        if(!empty($template)) {
            $status = $templateService->deleteTemplate($template);
        }

        return new JsonResponse(['status'=>$status]);
    }

    /**
     * upload image
     * @param  Request $request request
     * @return array           status, template, file
     */
    public function uploadFile(Request $request)
    {
        /* Get all data input */
        $data = $request -> all();

        /* Init template service to call function in it */
        $templateService = new TemplateService;

        /* Call function to upload file in template service */
        $result = $templateService->uploadFile($data);
        return new JsonResponse($result);
    }

    /**
     * delete a image of template
     * @param  int $templateId id of template
     * @param  file $image      image of template
     * @return Respone             response status
     */
    public function deleteThumbnail($templateId)
    {
        /* Init template service to call function in it */
        $templateService = new TemplateService;
        /* Call function to delete image of template */
        $result = $templateService->deleteThumbnail($templateId);

        return new JsonResponse($result);
    }

    /**
     * delete a image position template
     * @param  int $templateId id of template
     * @param  int $fileName id of template
     * @return Respone             response status
     */
    // public function deleteThumbnailPosition($templateId, $fileName)
    // {
        
    //     $templateService = new TemplateService;

    //     extract($templateService->deleteThumbnailPosition($templateId,$fileName));

    //     return new JsonResponse(['status' => $status,'sections' => $sections]);
    // }

    /**
     * [uploadFileForPosition description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function uploadFileForPosition(Request $request)
    {
        if(empty($_FILES['file'])) return;

        /* The path is contain file uploaded */
        $dir = public_path().'/files/positions/';
 
        $_FILES['file']['type'] = strtolower($_FILES['file']['type']);
         
        if ($_FILES['file']['type'] == 'image/png'
        || $_FILES['file']['type'] == 'image/jpg'
        || $_FILES['file']['type'] == 'image/gif'
        || $_FILES['file']['type'] == 'image/jpeg'
        || $_FILES['file']['type'] == 'image/pjpeg')
        {
            // setting file's mysterious name
            $filename = md5(date('YmdHis')).'.jpg';
            $file = $dir.$filename;
         
            // copying
            move_uploaded_file($_FILES['file']['tmp_name'], $file);
            
            return new JsonResponse(['thumbnail' => $filename]);

        }
    }
}
