<?php namespace App\Services;

use App\Models\TemplateManagerModel;
use App\Models\Mongo\BlockModelMongo;
use DateTime;

class BlockService
{
    /**
     * create a new block
     * @param  object $data object a block
     * @return status, error, block
     */
    public function createBlock($data)
    {
        $status = 0;
        $block = [];

        $blockModelMongo = new BlockModelMongo();
        $check = $blockModelMongo->where('title',$data['title'])->count();

        if(!$check) {
            $block = $blockModelMongo->create($data);
            $status = 1;
        }

        return ['status' =>$status,'block' => $block];
    }

    /**
     * edit a block
     * @param  [object] $data [object block]
     * @param  int $id   id of block to edit
     * @return object       a object block
     */
    public function editBlock($data,$block)
    {
        $status = 0;

        $blockModelMongo = new BlockModelMongo();

        $check = $blockModelMongo->where('title',$data['title'])->where('_id','!=',$data['_id'])->count();
        
        if(!$check) {
            $status = $block->update($data);
        }

        return ['status' =>$status,'block' => $block];

    }

}