<?php 
namespace Rowboat\ES\Services;

use Rowboat\AssetsManagement\Models\Mongo\AssetsFileModelMongo;
use Rowboat\AssetsManagement\Services\AssetsService;
use Rowboat\AssetsManagement\Services\FileService;

class ElasticSearchService
{


    /**
     * update elasticsearch 
     *
     * @author Minh than <than@httsolution.com>
     *
     * 
     * @param  [string] $index         [index name search]
     * @param  [object] $contentObject [content model page]
     * @param  [array] $dataPage          [dataPage fields of page]
     * @param  [string] $html          [content html view page]
     * @return [void]                [description]
     */
    public function updateElasticSearch($index, $contentObject, $dataPage, $html)
    {
        if(empty($contentObject->region )) $contentObject->region = 'us';

        $data = ['title' => '', 'description' => '']; // default title and description

        if(!empty($dataPage)) {

            foreach ($dataPage as $key => $value) {
                 // field is tittle page
                if(strpos($key, '_56be0c11d64791fe6f8b45a4_field_title') !== false && empty($title)) {

                    $data['title'] = $value;

                }
                // fields is description page
                if(strpos($key, '_56be0c11d64791fe6f8b45a4_field_metadescription') !== false && empty($description)) {

                    $data['description'] = $value;

                }

                if(!empty($title) && !empty($description)) break;
            }

            foreach ($dataPage as $key => $value) {


                
                if(is_string($value)) {

                    $file = self::getAssetPage($value,  $index, $contentObject);

                    if($file) continue;

                    // add search data suggestion
                    self::putDataToSuggestion($index, $contentObject, $value, $data);
                }

                if(is_array($value)) {
                    
                    foreach ($value as $k1 => $item1) {

                        if(empty($item1) || !is_array($item1)) continue;

                        foreach ($item1 as $k2 => $item2) {

                            if(is_string($item2)) {

                                $file = self::getAssetPage($item2, $index, $contentObject);

                                if($file) continue;
                                // add search data suggestion
                                self::putDataToSuggestion($index, $contentObject, $item2, $data);
                            }
                        }

                    }
                }
            }
        }

        self::putDataDefaultSearch($index, $contentObject, $html, $data);

        die;

    }

    public function putDataDefaultSearch($index, $contentObject, $html, $data)
    {
        // 
        $params = [
            'index' => $index,
            'type' => 'page',
            'id' => $contentObject->id,
            'body' => [
                'language' => $contentObject->language,
                'region' => $contentObject->region,
                'title' => $data['title'],
                'description' => $data['description'],
                'url' => '/' . $contentObject->language . '-' . $contentObject->region . $contentObject->url_build,
                'html' => strip_tags($html, '')
            ]
        ];

        $response = \RES::index($params);  // create search
    }

    /**
     * put data to suggestion auto search
     *
     * @author Minh than <than@httsolution.com>
     * 
     * @param  [type] $contentObject [description]
     * @param  [type] $value         [description]
     * @return [type]                [description]
     */
    public function putDataToSuggestion($index, $contentObject, $content, $data)
    {

        $params = [
            'index' => $index,
            'type' => 'page_suggestion',
            // 'id' => $contentObject->id,
            'body' => [
                'name' => $content,
                'suggest' => [
                    'input' => explode(' ', $content),
                    'output' => $content,
                    "payload" => [ 
                        "url" => '/' . $contentObject->language . '-' . $contentObject->region . $contentObject->url_build, 
                        'content_id' => $contentObject->id,
                        'title' => $data['title'],
                        'description' => $data['description'],
                    ]
                ]
            ]
        ];
        $response = \RES::index($params);  // create search

    }

    /**
     * data image search
     *
     * @author Minh than <than@httsolution.com>
     * 
     * @param  [type] $index         [description]
     * @param  [type] $contentObject [description]
     * @return [type]                [description]
     */
    public function putDataImageSearch($index, $file, $contentObject)
    {

        if ($file->folder_id == '0') {

            $urlFile = $file->filename;

        } else {

            $folder = $file->cmsAssetFolder()->first(); // get cms asset
            $urlFile = AssetsService::getUrlfolderAsset($file->folder_id, $folder->name); // get utl folder asset
            $urlFile = 'assets/' . $urlFile . '/' . $file->_id . '/' . $file->filename; // url file asset
        }
        // check is s3
        if (env('disk', 'local') == 's3') {

            $urlImage = getBaseUrlS3() . $urlFile;

        } else {//get url s3

            $urlImage = \URL::to('cms/asset-manager/file/' . $file->_id);
        }

        $name = str_replace('_', ' ', $file->name);

        $params = [
            'index' => $index,
            'type' => 'image',
            'id' => $file->_id,
            'body' => [
                'name' => $name,
                'filename' => $file->filename,
                'description' => $file->description,
                'url_page' => '/' . $contentObject->language . '-' . $contentObject->region . $contentObject->url_build,
                'url_image' => $urlImage,
            ]
        ];

        $response = \RES::index($params);  // create search
    }

    public function putDataToPdfOrWordSearch($index, $asset, $type)
    {

        $fileService = new FileService;

        $folder = $asset->cmsAssetFolder()->first();
        // if  parent id = '0' set url =''
        if ($folder->parent_id == '0') {
            $url = '';
        } else {
            //set url = $this->name
            $url = $folder->name;
        }
        //get url folder
        $path = $folder->getUrlfolder($folder->_id, $url);

        $path = $path . '/' . $asset->_id . '/';

        $file = $fileService->get($asset->filename, $path, 'assets');

        $url = env('url_view_task') . '/cms/asset-manager/file/download/' . $asset->_id;

        $file = base64_encode($file);

        $params = [
            'index' => $index,
            'type' => 'document',
            'id' => $asset->_id,
            'body' => [
                'content' => $file,
                'url' => $url,
                'name' => $asset->name,
                'filename' => $asset->filename,
                'description' => $asset->description,
                'type' => $type,
            ]
        ];

        $response = \RES::index($params);  // create search
    }
    /**
     * get asset page
     *
     *
     * @author Minh than <than@httsolution.com>
     * 
     * @param  [type] $id            [id asset mongo]
     * @param  [type] $index         [index name]
     * @param  [type] $contentObject [description]
     * @return [bool]      true | false
     */
    public function getAssetPage($id, $index, $contentObject)
    {

        $file = AssetsFileModelMongo::find($id);
        
        if(!empty($file) && $file->type == 'image') {

            self::putDataImageSearch($index, $file, $contentObject);

            return true;
        }

        return false;
    }

    /**
     * search page
     *
     * @author Minh than <than@httsolution.com>
     * 
     * @param  [string] $index     [name index search]
     * @param  [string] $searchStr [string search]
     * @param  [int] $start     [start result]
     * @return [array]    results            [array when search]
     */
    public function searchResultPages($index, $searchStr, $start)
    {
        // params search
        $params = [
            'index' => $index,
            'type' => 'page',
            'from' => $start,
            'size' => 10,
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => $searchStr
                    ]
                ]
            ]
        ];

        $data = \RES::search($params); // call RES search

        $results = [];

        $total = $data['hits']['total'];

        if(!empty($data['hits']['hits'])) {

            $results = $data['hits']['hits'];

        } else {

                $params = [ // params search
                    'index' => $index,
                    'body' => [
                        'result' => [
                            'text' => $searchStr,
                            'completion' => [
                                'field' => 'suggest'
                            ]
                        ]  
                    ]
                ];

                $dataSearchSuggestion = \RES::suggest($params); // search auto suggestion

                $urlExit = [];
                $count = 0;
                // check exits search suggestion
                if(!empty($dataSearchSuggestion['result'][0]) && !empty($dataSearchSuggestion['result'][0]['options'])) {

                    foreach ($dataSearchSuggestion['result'][0]['options'] as $key => $value) {
                        
                        if(in_array($value['payload']['url'], $urlExit)) continue;
                        // fomat data search
                        $results[$count]['_source'] = [];
                        $results[$count]['_source']['title'] = $value['payload']['title'];
                        $results[$count]['_source']['description'] = $value['payload']['description'];
                        $results[$count]['_source']['url'] = $value['payload']['url'];

                        $urlExit[] = $value['payload']['url'];
                        $count++;
                    }

                }

                $total = $count;

        }

        return ['total' => $total, 'results' => $results];
    }

    /**
     * search auto suggestion pages
     *
     * @author Minh than <than@httsolution.com>
     * 
     * @param  [string] $index     [name index search]
     * @param  [string] $searchStr [string search]
     * @return [array]    results            [array when search]
     */
    public function searchAutosuggestionPages($index, $searchStr)
    {
        $params = [ // params search
            'index' => $index,
            'body' => [
                'result' => [
                    'text' => $searchStr,
                    'completion' => [
                        'field' => 'suggest'
                    ]
                ]  
            ]
        ];

        $dataSearchSuggestion = \RES::suggest($params); // search auto suggestion
        // dd($dataSearchSuggestion);
        $results = [];

        if(!empty($dataSearchSuggestion) && !empty($dataSearchSuggestion['result'])) {
            
            if(!empty($dataSearchSuggestion['result'][0])) {

                $results = $dataSearchSuggestion['result'][0]; // get result search
            }

            $options = $textExits =[];
            foreach ($results['options'] as $key => $value) { // brower option result

                // convert string tolower and cut string when handel search
                $value['text'] = strtolower($value['text']);

                $value['text'] = substr($value['text'], stripos($value['text'], $searchStr));
                $arrayText = explode(' ', $value['text']);
                $value['text'] = $arrayText[0]; // get text default
                
                if(!empty($arrayText[1])) {

                    $value['text'] = $arrayText[0] . ' ' . $arrayText[1];
                    
                    if(strlen($arrayText[1] >= 4)) continue;

                    if(empty($arrayText[2])) continue;

                    // string concatenation text show
                    $value['text'] = $arrayText[0] . ' ' . $arrayText[1] . ' ' . $arrayText[2] ;
                } 
                //  highlight text search
                $value['text'] = str_replace($searchStr, '<b>' . $searchStr . '</b>', $value['text']);

                if(in_array($value['text'], $textExits)) continue;

                $textExits[] = $value['text'];
                $options[] = $value; // push result options search
            }

            $results['options'] = $options;

            return $results;
        }
    }
    /**
     * search files results
     *
     * @author Minh than <than@httsolution.com>
     * 
     * @param  [string] $index     [name index search]
     * @param  [string] $searchStr [string search]
     * @return [array]    results            [array when search]
     */
    public function searchResultFiles($index, $searchStr)
    {
        $params = [
            'index' => $index,
            'type' => 'document',
            'from' => 0,
            'size' => 4,
            'body' => [
                'query' => [
                    "match" => [
                        "content" => $searchStr
                    ]
                ]
            ]
        ];

        $data = \RES::search($params);

        $results = [];

        $total = $data['hits']['total'];

        if(!empty($data['hits']['hits'])) {

            $results = $data['hits']['hits'];

        }

        return $results;
    }

    /**
     * search images result
     *
     * @author Minh than <than@httsolution.com>
     * 
     * @param  [string] $index     [name index search]
     * @param  [string] $searchStr [string search]
     * @return [type]            [description]
     */
    public function searchResultImages($index, $searchStr)
    {
        // params search
        $params = [
            'index' => $index,
            'type' => 'image',
            'from' => 0,
            'size' => 4,
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => $searchStr
                    ]
                ]
            ]
        ];

        $data = \RES::search($params); // call RES search

        $results = [];

        $total = $data['hits']['total'];

        if(!empty($data['hits']['hits'])) {

            $results = $data['hits']['hits'];

        }

        return $results;
    }



}