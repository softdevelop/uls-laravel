<?php

namespace App\Http\Controllers\Test\Cms\Pages;

use App\Http\Controllers\Controller;

use Rowboat\BlocksManagement\Http\Controllers\BlockController;

use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;
use Rowboat\BlocksManagement\Models\Mongo\BlocksModelMongo;
use Rowboat\BlocksManagement\Models\Mongo\BlocksContentModelMongo;

// use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Testing\CrawlerTrait;

class TestPageController extends Controller
{
    public function getTestDemo()
    {
        return view('tests.cms.blocks.testDemo');
    }

    /**
     * [getTestCreateBlock description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function getTestCreateBlock()
    {
        $blockModel = BlocksFolderModelMongo::first();
        $selectedItemId = $blockModel->_id;
        $selectedItemName = $blockModel->name;
        $url = \URL::to("cms/block-manager/create-new-block");
        $request = \Request::create($url, 'GET', compact('selectedItemId', 'selectedItemName'));

        $requestHandel = \App::handle($request);
        $contentView = $requestHandel->content();
        return view('tests.cms.blocks.testCreateBlock', compact('contentView'));
    }


    /**
     * [getTestCreateDirectory description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function getTestCreateDirectory()
    {
        $blockModel = BlocksFolderModelMongo::first();
        $selectedItemId = $blockModel->_id;
        $selectedItemName = $blockModel->name;
        $url = \URL::to("cms/block-manager/create-folder");
        $request = \Request::create($url, 'GET', compact('selectedItemId', 'selectedItemName'));

        $requestHandel = \App::handle($request);
        $contentView = $requestHandel->content();
        return view('tests.cms.blocks.testCreateDirective', compact('contentView'));
    }

    /**
     * [getTestRequestNewBlock description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function getTestRequestNewBlock()
    {
        $blockModel = BlocksFolderModelMongo::first();
        $selectedItemId = $blockModel->_id;
        $selectedItemName = $blockModel->name;
        $url = \URL::to("cms/block-manager/create");
        $request = \Request::create($url, 'GET', compact('selectedItemId', 'selectedItemName'));

        $requestHandel = \App::handle($request);
        $contentView = $requestHandel->content();
        return view('tests.cms.blocks.testRequestNewBlock', compact('contentView'));
    }

    /**
     * [getTestRequestNewBlock description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function getTestRequestTranslation()
    {
        $blockContent = BlocksContentModelMongo::where('status', 'live')->first();

        if (empty($blockContent)) {
            abort(404);
        }

        $block =  BlocksModelMongo::find($blockContent->base_id);

        if (empty($block)) {
            abort(404);
        }

        $blockFolder = $block->cmsBlockFolder;

        $selectedItemId = $blockFolder->_id;
        $selectedItemName = $blockFolder->name;
        $url = \URL::to("cms/block-manager/request-translation/" . $block->_id);
        $request = \Request::create($url, 'GET', compact('selectedItemId', 'selectedItemName'));

        $requestHandel = \App::handle($request);
        $contentView = $requestHandel->content();
        // dd($contentView);
        return view('tests.cms.blocks.testRequestTranslation', compact('contentView'));
    }
}
