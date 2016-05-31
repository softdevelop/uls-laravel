<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\UploadFilesAssetManagerModel;

class TreeFoldersAssetManagerModel extends Model
{
	protected $table 	= 'folders_assetmanager';
	protected $fillable = ['name', 'parent_id', 'user_id'];

	/**
	 * Show all folder on tree folder
	 * @return Array
	 */
	public function getTreeFolder($parent_id = 0){
		/* If emtype parent_id then parent_id = 0 */
		if(empty($this->parent_id)){
			$this->parent_id = 0;
		}

		/* Get folder have parent_id is $parent_id*/
		$items = $this->where('parent_id', $parent_id)->get();

		/* Foreach lists folder */
		foreach ($items as $item) {
			/* Count subfolder of item */
			$hasSubFolder = $this->where('parent_id', $item->id)->count();

			/* If folder has sub folder */
			if($hasSubFolder){
				/* Assign subfolder for array children of item */
				$item->children = $this->getTreeFolder($item->id);
				/* Assign item is folder */
				$item->folder = true;
				// $item->lazy = true;
			}

			/* Set data of folder to show in tree folder */
			$item->title  = $item->name;
			$item->key 	  = $item->id;

			/* Unset id and name */
			unset($item->id);
			unset($item->name);	
		}
		
		$files = UploadFilesAssetManagerModel::where('folder_id', $parent_id)->get();
		foreach ($files as $file) {
			$file->key = $file->id;
			$file->title = $file->file_name;
			unset($file->id);
			unset($file->name);
			$items[] = $file;
		}
		return $items;
	}

	/**
	 * Show all folder on tree folder
	 * @return Array
	 */
	public function getFolderAndFilebyId($id)
	{
		$items = $this->where('parent_id', $id)->get();
		foreach ($items as $item) {
			$item->folder = true;
			$item->title = $item->name;
			$item->key = $item->id;
			unset($item->id);
			unset($item->name);
		}

		$files = UploadFilesAssetManagerModel::where('folder_id', $id)->get();
		foreach ($files as $file) {
			$file->folder = false;
			$file->key = $file->id;
			$file->title = $file->file_name;
			unset($file->id);
			unset($file->name);
			$items[] = $file;
		}
		return $items;
	}

	/**
	 * create folder.
	 * @author van linh <vanlinh@httsolution.com>
	 * @param  int  $id
	 * @return Response
	 */
	public function createFolder($data) 
	{
		$data['user_id'] = \Auth::user()->id;
		// count  folder is exist name = $data['name']
		$exists = $this->where('name', $data['name'])->count();
		// if is exist name = $data['name']
		if($exists > 0){
			$status = 0;
			$item 	= [];

		}else{
			//create new folder
			$item = $this->create($data);
			$item->folder = true;
			$item->title  = $item->name;		
			$item->key 	  = $item->id;
			unset($item->name);
			unset($item->id);
			$status = 1;
		}
		return ['item' => $item, 'status' => $status];
	}

	/**
	 * Edit folder
	 * @return Array
	 */
	public function editFolder($id, $data)
	{
		$item = $this->find($id);

		$exists = $this->where('name', $data['name'])->where('id', '!=', $id)->count();

		if($exists > 0){
			$status = 0;
			$item = [];

		}else{
			$status = 1;
			$item->name = $data['name'];
			$item->save();
			$item->folder = true;
			$item->title = $item->name;		
			$item->key = $item->id;
			unset($item->name);
			unset($item->id);
		}
		return ['item' => $item, 'status' => $status];
	}
}