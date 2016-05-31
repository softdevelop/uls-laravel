<?php 
/**
 * get all date in range day input
 * @param  date $strDateFrom start date of array day
 * @param  date $strDateTo   end date of array day
 * @return Array             array day result
 */
function getFileImagesAsset()
{
    $assets = \DB::connection('mongodb')->collection('cms.assets.file')->lists('name', '_id');
    return $assets;
}