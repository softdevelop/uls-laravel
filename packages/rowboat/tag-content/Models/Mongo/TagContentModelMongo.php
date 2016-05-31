<?php

namespace Rowboat\TagContent\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Rowboat\CmsContent\Services\CmsContentService;
use Rowboat\CmsContent\Events\CmsContent\ClearCacheCMS;

class TagContentModelMongo extends Eloquent
{
    protected $collection = 'cms.tag-contents';
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'color', 'parent_id', 'ancestor_ids'];

    /**
     * Get tree tag content
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  string $parentId [description]
     *
     * @return Array tagcontent
     */
    public static function getTreeTagContent($parent_id = '0')
    {
        $allTags = self::where('ancestor_ids', $parent_id)->get()->toArray();

        // Array contain array tag reference
        $referenceTags = [];
        foreach ($allTags as &$tag) {
            $tag['children'] = [];
            $referenceTags[$tag['_id']] = $tag;
        }

        // Put a folder to property children of a parent folder that it should belong to
        foreach ($allTags as &$tag) {
            if(!empty($tag['parent_id'])){
                $referenceTags[$tag['parent_id']]['children'][] = &$referenceTags[$tag['_id']];
            }
        }

        // Get root folders
        $hierachyTags = $referenceTags;
        foreach($hierachyTags as $key => $hierachyTag){
            if(!empty($hierachyTag['parent_id']) && ($hierachyTag['parent_id']!= '0')){
                unset($hierachyTags[$key]);
            }
        }
        
        return array_values($hierachyTags);
    }

    /**
     * Create new tag content
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  Array $data Array input
     *
     * @return Object
     */
    public function createNewTagContent($data)
    {
        // Create new tag
        $tag = self::create($data);

        // Add properties ancestor_ids for tag
        $ancestor_ids = [];
        $cmsContentService = new CmsContentService(new TagContentModelMongo);
        $cmsContentService->recursiveAddPropertiesAncestorIdsForFolder(new TagContentModelMongo, $tag, $ancestor_ids);
        $tag->ancestor_ids = $ancestor_ids;
        $tag->save();

        // Clear cache 
        event(new ClearCacheCMS('tagsContent'));

        // Get tree tags
        $tagsContent = self::getTreeTagContent('0');

        return $tagsContent;
    }

    /**
     * Update tag content
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param  Array $data Input
     * @return Array       Array tag content
     */
    public function updateTagContent($data)
    {
        // Update tag content
        $this->update($data);

        // Clear cache 
        event(new ClearCacheCMS('tagsContent'));

        // Get all tags content
        return $this->getTreeTagContent('0');
    }

    /**
     * Delete tag and all child tags of tag
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  String $tagId Id of tag want delete
     *
     * @return Void
     */
    public function deleteAllChildTagOfTagWantDelete ($tagId)
    {
        // Find tag
        $tag = self::find($tagId);

        // Get child tag of tag delete
        $childTagsOfTagDeleted = self::where('parent_id', $tag['_id'])->get();

        if (!empty($childTagsOfTagDeleted)) {
            // Each child tag
            foreach ($childTagsOfTagDeleted as $key => $value) {
                // Call function delete tag and all child tags
                $this->deleteAllChildTagOfTagWantDelete($value['_id']);
            }
        }

        // Delete this tag
        $tag->delete();

        // Clear cache 
        event(new ClearCacheCMS('tagsContent'));
    }
}
