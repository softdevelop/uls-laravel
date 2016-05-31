<?php
/**
 * Link view Draft
 *
 * Change link view draft when user in live
 *
 * @author Thanh Tuan <tuan@httsolution.com>
 *
 * @return Response Link
 */
function linkViewDraft()
{
    return  env('url_front_end', 'http://demo.ulsinc.com');
}

/**
 * Link view Draft
 *
 * Change link view task
 *
 * @author Quang <quang@httsolution.com>
 *
 * @return Response Link
 */
function urlViewTask()
{
    return  env('url_view_task', 'http://admin.ulsinc.com');
}
