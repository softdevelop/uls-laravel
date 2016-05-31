<?php

namespace Rowboat\TagContent\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Rowboat\TagContent\Models\Mongo\TagContentModelMongo;


class TagContentController extends Controller
{/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
     * Display all tags content
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Response
     */
	public function index()
	{
        // Init model to call function in it
        $tagContentModel = new TagContentModelMongo;

        // Get all tag content to show parent and child
        $tagsContent = $tagContentModel->getTreeTagContent('0');

        return view('tag-content::index', compact('tagsContent'));
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
        $tagContent = TagContentModelMongo::find($id);

        $parentId = $tagContent->parent_id;

        return view('tag-content::create', compact('tagContent', 'parentId'));
	}

    /**
     * Show modal create new tag content
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Response
     */
    public function create()
    {
        $tagContent = new TagContentModelMongo;

        $parentId = \Request::all()['parentId'];

        return view('tag-content::create', compact('tagContent', 'parentId'));
    }
}
