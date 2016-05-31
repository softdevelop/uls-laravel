<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\PositionModel;
use App\Models\Mongo\TemplateManagerModelMongo;
use App\Services\TemplateManagerService as TemplateService;

class TemplateManagerModel extends Model
{
	protected $table = 'templates';
	protected $fillable = ['title', 'description','alias_title'];

	public function images()
    {
        return $this->morphMany('App\Models\ImageTemplate', 'imageable');
    }

    public function positions()
    {
        return $this->belongsToMany('App\Models\PositionModel', 'template_position', 'template_id', 'position_id')->withPivot('block_id');
    }

    public function blocks()
    {
        return $this->belongsToMany('App\Models\BlockModel', 'template_position', 'template_id', 'block_id')->withPivot('position_id');
    }

    public function pages()
    {
    	return $this->hasMany('App\Models\PageModel','template_id');
    }
	
    /**
     * get all templates
     * @return array templates
     */
    public function getAllTemplate()
    {
    	/* Get all template */
        $templates = $this->all();
        for($i = 0; $i < count($templates); $i++) {
        	/* Get images of templates */
            $templates[$i]->images;
            /* Get position of template */
            $templates[$i]['positions'] = $templates[$i]->positions()->where('block_id',0)->get();

        }
        
        return $templates;
    }

	/**
	 * create a new template
	 * @param  object $data data
	 * @return array       status, error, template
	 */
	public function createTemplate($data)
	{
		/* Create new template */
		$template = $this->create($data);

		$templateManagerModelMongo = new TemplateManagerModelMongo();
		$data['template_id'] = $template->id;
		foreach ($data as $item) {
			$item['fields'];
		}
		$templateManagerModelMongo -> create($data);
		/* Init Position model to call function in it */
		// $positionModel = new PositionModel;

		/* Init array to contain position ids */
		// $positionIds = [];

		/* If isset position input then get positions of template */
		// if(!isset($data['set_position'])) {
			// $template->positions;
			// return $template;
		// }

		/* Each postion input */
		// foreach ($data['set_position'] as $key => $value) {
			/* Alias name is string lower of name and replace white character to _ character */
			// $alias_name = str_replace(" ", "_", strtolower($value['name']));
			/* Set alias name */
			// $value['alias_name'] = $alias_name;
			/* Create new position */
			// $position = $positionModel->create($value);
			/* Add id of position created to array */
			// $positionIds[] = $position->id;
		// }

		/* sync position for template */
		// $template->positions()->sync($positionIds, ['block_id' => 0]);
		
		/* get position of template */
		// $template->positions;

		return $template;
	}

	/**
	 * [getTemplate description]
	 * @return [type] [description]
	 */
	public function getTemplate()
	{
		//return images
		$this->images;

		//return positions
		$this->positions;

		return $this;
	}
	/**
	 * edit a template
	 * @param object $data data
	 * @param int $id   id of template
	 */
	public function EditTemplate($data)
	{
		/* Update template */
		$this->update($data);

		/* Array to contain Position ids */
		$positionsIds = array_fetch($data['set_position'], 'id');

		/* Init Model to call function in it */
		$positionModel = new PositionModel;

		/* If position has id in array positionIds then delete position */
		$positionModel->whereIn('id', $positionsIds)->delete();
		
		/* Init positionIds is null array */
		$positionIds = [];

		/* Each positions fields */ 
		foreach ($data['set_position'] as $key => $value) {
			/* Alias name is string lower of name and replace white character to _ character */
			$alias_name = str_replace(" ", "_", strtolower($value['name']));
			/* Set alias name */
			$value['alias_name'] = $alias_name;
			/* Create new position */
			$position = $positionModel->create($value);
			/* Add id of position created to array */
			$positionIds[] = $position->id;
		}

		/* sync position for template */
		$this->positions()->sync($positionIds, ['block_id' => 0]);
		
		/* get position of template */
		$this->positions;

		return $this;
	}

    /**
     * get Position of template
     * @param  int $templateId 
     * @return Array             Position
     */
    public function getPositionOfTemplate()
    {
        return $this->positions()->get();
    }
}