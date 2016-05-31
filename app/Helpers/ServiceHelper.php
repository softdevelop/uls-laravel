<?php

    use App\Models\Mongo\BlockModelMongo;
    // use App\Models\Mongo\PageModelMongo;
    use Rowboat\FormBuilder\Models\FileFormBuilderModel;
    use Rowboat\Ticket\Models\TicketModel;
    use Rowboat\Ticket\Models\TypeModel;

    // use App\Models\Mongo\ContentModelMongo;
    // use App\Models\Mongo\UrlModelMongo;
    // use App\Models\Mongo\DraftModelMongo;
    use App\Models\LanguageModel;
    use App\Models\RegionModel;

    function testFuture()
    {
        return env('test_future', false);
    }



    function getListBlocks() {

        $blockModelMongo = new BlockModelMongo();
        $blocks = $blockModelMongo->all();
        $blocks = array_merge($blocks->toArray(),BlockModelMongo::$systemBlocks);
        return $blocks;
    }

    function BlocksMap()
    {
        $blocks = BlockModelMongo::all();

        $blocks = array_merge($blocks->toArray(),BlockModelMongo::$systemBlocks);

        $blocks_map = [];
        foreach ($blocks as $block) {
            // $blocks_map[$block['_id']] = $block['name'];
        }
        return $blocks_map;
    }

    function getListLanguage()
    {
        $languageModel = new LanguageModel();
        $language = $languageModel->lists('name','code');
        return $language;
    }

    function getListRegion()
    {
        $regionModel = new RegionModel();
        $region = $regionModel->lists('name','code');
        return $region;
    }

    function fileManagerTermMap()
    {
        $fileModel = new FileFormBuilderModel();
        // get file manager term
        $files = $fileModel->getFilesManagerTerm();

        $filesmap = [];

        foreach ($files as $key => $value) {

            $filesmap[$value['id']] = $value;
        }

        return $filesmap;
    }

    function checkIsTime($userId)
    {
        $checkUserShowTime = \DB::table('preference')->where('due_show', 'time')->where('user_id', $userId)->first();

        if(!empty($checkUserShowTime))

            return true;

        return false;
    }
