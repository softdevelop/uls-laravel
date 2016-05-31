<div class="modal-header">
    <h3 class="modal-title">{{trans('cms_page/page-view-detail.details_page')}}</h3>
</div>
<div class="modal-body">
    <form role="form" name="ViewPageForm">
        <!-- Input Name-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="name">{{trans('cms_page/page-view-detail.name')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="name" value="{{$page->name}}" disabled="disabled"/>  
            </div>
        </div>

        <!-- Input Url-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="url">{{trans('cms_page/page-view-detail.url')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="url" value="{{$page->url}}" disabled="disabled" />  
            </div>
        </div>
        
        <div class="clearfix"></div>

        <!-- Input Date Live By-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="dateLiveBy">{{trans('cms_page/page-view-detail.date_live_by')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="dateLiveBy" value="{{$page->dateLiveBy}}" disabled="disabled" />  
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Date Available-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="dateAvailable">{{trans('cms_page/page-view-detail.date_available')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="dateAvailable" value="{{$page->dateAvailable}}" disabled="disabled" />  
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input To Date-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="toDate">{{trans('cms_page/page-view-detail.to_date')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="toDate" value="{{$page->toDate}}" disabled="disabled" />  
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Region-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="region">{{trans('cms_page/page-view-detail.region')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="region" value="{{$regions}}" disabled="disabled" />
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Market Segment-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="marketSegment">{{trans('cms_page/page-view-detail.market_segment')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="marketSegment" value="{{$marketsegments}}" disabled="disabled" />
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Languages-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="language">{{trans('cms_page/page-view-detail.language')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="language" value="{{$languages}}" disabled="disabled" />
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Meta-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="meta">{{trans('cms_page/page-view-detail.meta')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="meta" value="{{$page->meta}}" disabled="disabled" />
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Title-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="title">{{trans('cms_page/page-view-detail.title')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="title" value="{{$page->title}}" disabled="disabled" />
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Heading-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="heading">{{trans('cms_page/page-view-detail.heading')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="heading" value="{{$page->heading}}" disabled="disabled" />
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Subheading-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="subHeading">{{trans('cms_page/page-view-detail.subheading')}}</label>
            <div class="control col-md-9">
                <input class="form-control" type="name" name="subHeading" value="{{$page->subHeading}}" disabled="disabled" />
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Input Description-->
        <div class="control-group full-width">
            <label class="control-label col-md-3" for="description">{{trans('cms_page/page-view-detail.description')}}</label>
            <div class="control col-md-9" >
                {!!$page->description!!}
            </div>
        </div>
        <div class="clearfix"></div>
        <!--End form-->
    </form>
</div>

<script type="text/javascript">
    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>
