<?php namespace App\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Rowboat\FormBuilder\Models\Mongo\FieldMongo;
use Rowboat\FormBuilder\Models\Mongo\FiledTypeMongo;
use Former\Facades\Former;
use Rowboat\FormBuilder\Services\DirectiveService;
use Rowboat\FormBuilder\Services\FormBuilderService;

class TermTemplateManagerMongo extends Eloquent {

    protected $collection = 'terms-template';
    protected $connection = 'mongodb';
    protected $fillable = ['name','type', 'termId','html', 'description', 'thumbnail'];

    public static $templateType = ['email' => 'Email','detail' => 'Detail'];
	
	/**
     * edit a template
     * @param object $data data
     * @param int $id   id of template
     */
    public function createTemplate($data)
    {
        $status = 0;
        $template = $this;
        $check = $template->where('termId',$data['termId'])->where('type',$data['type'])->count();

        if($check == 0) {
            $status = 1;
            $template = $template->create($data);
        }

        return ['status' => $status, 'template' => $template];
    }
    
}