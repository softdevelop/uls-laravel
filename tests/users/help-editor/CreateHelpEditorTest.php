<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateHelpEditorTest extends TestCase
{
    
    public function testCreateNewHelpEditorWithWrongData()
    {
        $data = [
            // 'title' => 'Quang',
            'description' => 'Description',
            'parent_id' => '0'
        ];

        $request = $this->post('/api/help-editor', $data);
        
        $return = json_decode($request->response->getContent(),true);
        
        $request->seeJson([
            'status' => 0,
        ]);
    }

    public function testCreateNewHelpEditorWithRightData()
    {
        $data = [
            'title' => 'Quang',
            'description' => 'Description',
            'parent_id' => '0'
        ];

        $request = $this->post('/api/help-editor', $data);
        
        $return = json_decode($request->response->getContent(),true);

        $request->seeJson([
            'status' => true,
        ]);
    }

}
