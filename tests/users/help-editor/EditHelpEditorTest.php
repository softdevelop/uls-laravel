<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\Mongo\HelpEditorModelMongo;

class EditHelpEditorTest extends TestCase
{
    
    public function testCreateNewHelpEditorWithRightData()
    {
        $helpModelMongo = new HelpEditorModelMongo();

        $help = $helpModelMongo->first();

        $data = [
            '_id' => $help->_id,
            'title' => 'Quang123',
            'description' => 'Description123',
            'parent_id' => '0'
        ];

        $request = $this->post('/api/help-editor/'.$help->_id, $data);
        
        $request->seeJson([
            'status' => true,
        ]);
    }

}
