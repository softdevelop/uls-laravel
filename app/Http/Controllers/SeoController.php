<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mongo\SeoModelMongo;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SeoController extends Controller
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
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $seoModelMongo = new SeoModelMongo;
        $url = 'http://www.ulsinc.com/markets';
        $id = 1;
        $saveSeo  = $seoModelMongo->saveSeoData($id, $url); 
        d($saveSeo);die;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        abort(404);
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
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
