<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;

use Rowboat\BlocksManagement\Http\Controllers\BlockController;

// use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Testing\CrawlerTrait;

class TestController extends Controller
{

    /**
     *call.
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     *
     * call one url with method.
     *
     * @return [type] [description]
     */
    public function call($method, $uri, $parameters = [])
    {
        $kernel = \App::make('Illuminate\Contracts\Http\Kernel');

        $request = Request::create(
            $uri, $method, $parameters
        );
        $response = $kernel->handle($request);

        // $kernel->terminate($request, $response);
        return $response;
    }
    // use CrawlerTrait;
    /**
     * getIndex.
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     * @return [type] [description]
     */
    public function getIndex()
    {
        return view('tests.index');
    }

    public function getTestCreateTemplate()
    {
        $response = $this->call('GET',getBaseUrl().'/cms/template-content-manager/request-propose-new-template', ['selectedItemId' => '569ced28d64791071f8b4569', 'selectedItemName' => 'Templates']);

        $result = $response->original;

        $content = $result->render();

        return view('tests.template', compact('content'));
    }

        public function getTestAddNewTemplate()
    {
        $response = $this->call('GET',getBaseUrl().'/cms/template-content-manager/new', ['selectedItemId' => '569ced28d64791071f8b4569', 'selectedItemName' => 'Templates']);

        $result = $response->original;

        $content = $result->render();

        return view('tests.templateAddNew', compact('content'));
    }


    /**
     * getTestBlocK.
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     *
     * @return [type] [description]
     */
    public function getTestBlock()
    {
        //create new block.
        $response = $this->call('GET',getBaseUrl().'/cms/block-manager/create-new-block', ['selectedItemId' => '569ced28d64791071f8b4568', 'selectedItemName' => 'Blocks']);
        $result = $response->original;

        $section = $result->renderSections();

        $content = $section['content'];

        //create folder.
        $response = $this->call('GET',getBaseUrl().'/cms/block-manager/create-folder', ['selectedItemId' => '569ced28d64791071f8b4568', 'selectedItemName' => 'Blocks']);
        $result = $response->original;

        $contentCreateFolder = $result->render();

        //create request block.
        $response = $this->call('GET',getBaseUrl().'/cms/block-manager/create', ['selectedItemId' => '569ced28d64791071f8b4568', 'selectedItemName' => 'Blocks']);
        $result = $response->original;

        $contentRequestBlock = $result->render();

        return view('tests.block', compact('content', 'contentCreateFolder', 'contentRequestBlock'));
    }

    /**
     * getTestPage.
     *
     * @author  Nhut <nhut@httsolution.com>
     *
     * @return [type] [description]
     */
    public function getTestPage()
    {
        $response = $this->call('GET',getBaseUrl().'/cms/pages/create', ['selectedItemId' => '56c17d5cd64791a06a8b4567', 'selectedItemName' => 'Pages']);

        $result = $response->original;

        $content = $result->render();

        return view('tests.page', compact('content'));
    }
}
