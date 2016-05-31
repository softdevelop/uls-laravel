<?php namespace App\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Former\Facades\Former;

class TemplateManagerModelMongo extends Eloquent {
    protected $collection = 'cms.templates';
    protected $connection = 'mongodb';
    protected $fillable = ['name','file','thumbnail', 'fields', 'sections','description'];

    /**
     * create a new template
     * @param  object $data data
     * @return array       status, error, template
     */
    public function createTemplate($data)
    {
        $check = $this->where('file',$data['file'])->count();
        if($check == 0) {
            $data['thumbnail'] = '';
            foreach ($data['fields'] as &$field) {
                $field['variable'] = strtolower(str_replace(' ','_',$field['name']));
                $field['type'] = 'input';
                $field['size'] = 50;
            }

            foreach ($data['sections'] as &$section) {
                $section['type'] = 'wysiwyg editor';
                $section['variable'] = strtolower(str_replace(' ','_',$section['name']));
            }

            $template = $this->create($data);
            return ['status' => 1, 'template' => $template];
        } else {
            return ['status' => 0, 'template' => $this];
        }        
    }

    public function checkName($id,$name)
    {
        /*can edit*/
        $status = 1;
        $templateManagerModelMongo = new TemplateManagerModelMongo();
        $count = $templateManagerModelMongo->where('name',$name)->where('_id','!=',$id)->count();
        if($count>0) {
            $status = 0; // can not edit
        }
        return $status;
    }

    /**
     * edit a template
     * @param object $data data
     * @param int $id   id of template
     */
    public function EditTemplate($data)
    {
        $status = 1;
        $template = new TemplateManagerModelMongo();
        $check = self::checkName($this->_id,$data['name']);

        if($check) {
            
            foreach ($data['fields'] as &$field) {
               /* $field['variable'] = '$'.strtolower(str_replace(' ','_',$field['name']));*/
                $field['type'] = 'input';
                $field['size'] = 50;
            }

            foreach ($data['sections'] as &$section) {
                $section['type'] = 'wysiwyg editor';
                /*$section['variable'] = '$'.strtolower(str_replace(' ','_',$section['name']));*/
            }

            $this->update($data);
            $template = TemplateManagerModelMongo::find($this->_id);
        } else {
            $status = 0;
        }
        return ['status' => $status,'template' => $template];
    }

   
}