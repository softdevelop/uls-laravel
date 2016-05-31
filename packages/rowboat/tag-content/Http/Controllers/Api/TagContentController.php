<?php

namespace Rowboat\TagContent\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rowboat\TagContent\Models\Mongo\TagContentModelMongo;
use Rowboat\CmsContent\Events\CmsContent\ClearCacheCMS;

class TagContentController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Tag Content Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

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
     * Stores new account
     *
     */
    public function store(Request $request)
    {
        // Status = 1 is create success
        $status = 1;

        // Show error
        $error = '';

        // Request all data
        $data = $request->all();

        // Init model to call function in it
        $tagContentModel = new TagContentModelMongo;

        // Create new tag content
        $tagsContent = $tagContentModel->createNewTagContent($data);

        // if create successfull
        if (!$tagsContent) {
            $status = 0;
            $error = 'Name is has been exists!';
        }

        // Clear cache 
        event(new ClearCacheCMS('tagsContent'));

        return new JsonResponse(['status' => $status, 'error' => $error, 'tagsContent' => $tagsContent]);
    }

    /**
     * Update the tag content
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        // Status = 1 is create success
        $status = 1;

        // Show error
        $error = '';

        // Request all data
        $data = $request->all();
        unset($data['parent_id']);

        // Find tag content with id
        $tagContent = TagContentModelMongo::find($id);

        // Update tag content and get all tag content
        $tagsContent = $tagContent->updateTagContent($data);

        // if create successfull
        if (!$tagsContent) {
            $status = 0;
            $error = 'Name is has been exists!';
        }

        // Clear cache 
        event(new ClearCacheCMS('tagsContent'));

        return new JsonResponse(['status' => $status, 'error' => $error, 'tagsContent' => $tagsContent]);
    }

    /**
     * Remove the resource.
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $status = 0;

        // Init Model to call function in it
        $tagContentModel = new TagContentModelMongo;

        // Delete all child tag of current tag want delete
        $status = $tagContentModel->deleteAllChildTagOfTagWantDelete($id);

        // Get tag content tree
        $tagsContent = $tagContentModel->getTreeTagContent('0');

        // Clear cache 
        event(new ClearCacheCMS('tagsContent'));

        return new JsonResponse(['status' => 1, 'tagsContent' => $tagsContent]);
    }

}
