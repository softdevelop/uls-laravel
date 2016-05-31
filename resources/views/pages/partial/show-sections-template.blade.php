    <label class="label-form" for="">{{trans('cms_page/page-edit-draft.description')}}</label>
    <div class="clearfix"></div>
    <div class="wrap-content-review-and-code">
        <div class="tab-content m-t--10">
            <div role="tabpanel" class="tab-pane in active padding-none" id="code">
                <div class="col-lg-12 padding-none set-height">
                    <textarea class="form-control" rows="4" cols="50" name="editor" id="editor"></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="wrap-link-input" ng-if="!isDisable">
                    <a class="link-insert-code" ng-click="callModalInsert('insert-link', page.language, page.region,'page')">{{trans('cms_page/page-edit-draft.insert_link')}}</a> <span class="insert-object"> | </span>
                    <a class="link-insert-code" ng-click="callModalInsert('insert-block', page.language == 'en'? null : page.language, page.region)">{{trans('cms_page/page-edit-draft.insert_block')}}</a> <span class="insert-object"> | </span>
                    <a class="link-insert-code" ng-click="callModalInsert('insert-asset', page.language == 'en'? null : page.language, page.region)">{{trans('cms_page/page-edit-draft.insert_asset')}}</a>
                </div>
            </div>
   
        </div>

        <div class="clearfix"></div>
    </div>