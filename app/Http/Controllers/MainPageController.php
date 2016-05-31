<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PageModel;
use App\Models\TemplateManagerModel;
use App\Models\PositionModel;
use App\Models\BlockModel;
use App\Services\PageService;

class MainPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $menuPages = new PageService;

        $menuPages = $menuPages->getMenuPage();

        return view('main', compact('menuPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $page = PageModel::find($id);
        if(!empty($page)) {
            $page['template'] = $page->templates()->first();

            $page['positions'] = $page['template']->positions()->where('block_id',0)->get();
            foreach ($page['positions'] as $key => $value) {
                $value->blocks;
            }
        }
        $currentTemplate = 'templates.'.$page['templates']['alias_title'];
        return view('main-page.view', compact('page','currentTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
