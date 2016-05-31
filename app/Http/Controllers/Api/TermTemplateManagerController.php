<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use App\Models\Mongo\TermTemplateManagerMongo;
use App\Services\TermTemplateManagerService as TermTemplateService;

class TermTemplateManagerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $status = 0;
        /* Get all data input */
        $data = $request->all();
        $data['thumbnail'] = '';
        /* Init template model to call function in it */
        $template = new TermTemplateManagerMongo();
        extract($template->createTemplate($data));

        return new JsonResponse(['status' => $status, 'template' => $template]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request -> all();

        $termTemplateMongo = new TermTemplateManagerMongo();

        $template = $termTemplateMongo::findOrFail($id);
        $status = 0;

        if(!empty($template)) {
            $termTemplateService = new TermTemplateService();
            extract($termTemplateService->updateTemplate($template,$data));
        }
        return new JsonResponse(['status' => $status, 'template' => $template]);
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
        $template = TermTemplateManagerMongo::findOrFail($id);

        /* Init template service to call function in it */
        $termTemplateService = new TermTemplateService();

        /* If isset template then delete this template */
        if(!empty($template)) {
            $status = $termTemplateService->deleteTemplate($template);
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
        $termTemplateService = new TermTemplateService;

        /* Call function to upload file in template service */
        $result = $termTemplateService->uploadFile($data);

        return new JsonResponse($result);
    }
}
