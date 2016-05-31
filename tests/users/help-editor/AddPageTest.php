<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\Mongo\HelpEditorModelMongo;

class AddPageTest extends TestCase
{
    public function testAddNewPageWithWrongData()
    {
        $helpModelMongo = new HelpEditorModelMongo();

        $data = [
            'title' => '',
            'parent_id' => '0'
        ];

        $request = $this->post('/api/help-editor/add-page', $data);
        
        $request->seeJson([
            'status' => 0,
        ]);
    }

    /**
     * test add new page with right data
     *
     * @author Quang <quang@httsolution.com>
     * 
     * @return [type] [description]
     */
    public function testAddNewPageWithRightData()
    {
        $helpModelMongo = new HelpEditorModelMongo();

        $data = [
            'title' => 'Quang',
            'parent_id' => '0'
        ];

        $request = $this->post('/api/help-editor/add-page', $data);
        
        $request->seeJson([
            'status' => 1,
        ]);
    }

}
