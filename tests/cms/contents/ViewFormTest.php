<?php 
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel;
use Way\Tests\Factory;
use Rowboat\CmsContent\Services\ViewFormService;
use Former\Facades\Former;
class ViewFormTest extends TestCase {



    public function testSynchElement()
    {
        $attributes = [
            'class'=> 'form-control',
            'id' => ' thantest'
        ];

        $formObject = ViewFormService::synchElement('text', $attributes);
        
       dd($formObject);
    }
}