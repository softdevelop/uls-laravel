<?php namespace App\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Rowboat\FormBuilder\Models\Mongo\FieldMongo;
use Rowboat\FormBuilder\Models\Mongo\FiledTypeMongo;
use Former\Facades\Former;
use Rowboat\FormBuilder\Services\DirectiveService;
use App\Models\Mongo\TermsModel;

class ManageTermModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $guarded =  [];

    /**
     * [setCollectionAndFillable description]
     * @param int $id         term id
     * @param none
     */
	public function setCollection ($id)
	{
		$term = TermsModel::find($id);

		/* Set collection */
		self::getTable(); 
        self::setTable(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '_', $term->name)));
        
		return $term->name;
	}

	public function saveData($data, $user)
	{

		$this->user_id = $user->id;
		/* Each data */
		foreach ($data as $key => $value) {
			$this->$key = $data[$key];
		}

		$status = $this->save();	

		return $status;	
	}

	public function updateData($id, $data, $termId)
	{	
		/* Unset id */
		unset($data['_id']);

		/* Set collection */
		self::setCollection ($termId);

		/* Update item */
		$status = \DB::connection('mongodb')->table(self::getTable())->where('_id', $id)->update($data);

		return $status;
	}

}