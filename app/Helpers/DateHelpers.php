<?php 
/**
 * get all date in range day input
 * @param  date $strDateFrom start date of array day
 * @param  date $strDateTo   end date of array day
 * @return Array             array day result
 */
function createDateRangeArray($strDateFrom,$strDateTo)
{
    $aryRange = array();

    /* First day */
    $iDateFrom = mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    /* End day */
    $iDateTo   = mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));
    /* If End day bigger Start day */
    if ($iDateTo >= $iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo)
        {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}