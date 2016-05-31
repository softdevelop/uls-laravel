<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TemplateManagerModel;
use App\Models\Mongo\TemplateManagerModelMongo;
use Illuminate\Http\JsonResponse;

class TemplateManagerController extends Controller
{
    

    /**
      * Create a new controller instance.
      *
      * @return void
      */
     public function __construct()
     {
       $this->middleware('auth');
     }
     
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /* Init model to call function in it */
        $templateManagerModelMongo = new TemplateManagerModelMongo();

        /* Call function get all template */
        $templates = $templateManagerModelMongo->all();
        foreach ($templates as $template) {
            $template->description = nl2br($template->description);
        }
        return view ('templatemanager.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        /* Init model */
        $templateManagerModelMongo = new TemplateManagerModelMongo();

        return view('templatemanager.create', array('template' => $templateManagerModelMongo));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        /* Find template with id */
        $template = TemplateManagerModelMongo::find($id);

        /* Call function to get templates with position and image of template */
        // $template = $template->getTemplate();

        return view('templatemanager.create', compact('template'));
    }

    /**
     * View image of template
     * @param  string $path [description]
     * @return [type]       [description]
     */
    public function viewImage($path)
    {
        return view('templatemanager.viewImage',compact('path'));
    }
    

}
