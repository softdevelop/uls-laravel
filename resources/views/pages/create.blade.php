<div class="div modal-header">
        <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" ng-if="!page._id">{{trans('cms_page/page-propose.request_page')}}</h4>
        <h4 class="modal-title" ng-if="page._id && page.modal == 'request_translation'">{{trans('cms_page/page-propose.request_translation')}}</h4>
        <h4 class="modal-title" ng-if="page._id && page.modal == 'request_region'">{{trans('cms_page/page-propose.request_region_variation')}} | @{{page.modal}}</h4>
        <h4 class="modal-title" ng-if="page._id && page.modal == 'request_revision'">{{trans('cms_page/page-propose.request_revision')}}</h4>

</div>

<div class="modal-body">
    <form role="form" name="ProposePageForm" ng-init='parents = {{json_encode($parents)}};versions = {{json_encode($versions)}}; selectedItem = {{json_encode($selectedItem)}};page={{json_encode($page)}}' novalidate>
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && ProposePageForm.name.$invalid]">

            <label class="label-form" ng-if="page._id && (page.modal == 'request_region' || page.modal == 'request_translation')" for="name">{{trans('cms_page/page-propose.page')}}</label>

            <label class="label-form" ng-if="!(page._id && (page.modal == 'request_region' || page.modal == 'request_translation'))" for="name">{{trans('cms_page/page-propose.name')}} 
                <span class="text-require" ng-if="!(page._id && (page.modal == 'request_revision' || (page.modal == 'request_region' || page.modal == 'request_translation')))"> *</span>
            </label>

            <div class="wrap-form">
                <span ng-if="page._id && (page.modal == 'request_revision' || (page.modal == 'request_region' || page.modal == 'request_translation'))">@{{page.name}}</span>

                <span ng-if="!(page._id && (page.modal == 'request_revision' || (page.modal == 'request_region' || page.modal == 'request_translation')))">
                    <input class="form-control name" placeholder="{{trans('cms_page/page-propose.name')}}" type="text" name="name" ng-model="page.name" ng-required = "true"  ng-change="changeName()"/>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && ProposePageForm.name.$error.required">{{trans('cms_page/page-propose.name_required')}}</small>
                        <small class="help-inline" ng-show="submitted && checkName">{{trans('cms_page/page-propose.name_existed')}}</small>
                        <small class="help-inline" ng-show="submitted && checkUrl">{{trans('cms_page/page-propose.name_invalid')}}</small>
                    </div>
                </span>
            </div>

            <div class="clearfix"></div>
        </div>

        <!-- Parent Page-->
        <div class="form-group">
            <label class="label-form" for="name">
                <span>{{trans('cms_page/page-propose.type')}}
                @if($page->_id && ($page->modal == "request_revision" || $page->modal == "request_translation" || $page->modal == "request_region"))
                @else
                    <span class="text-require"> *</span>
                @endif
                </span>
            </label>
            <div class="wrap-form">
                @if($page->_id && ($page->modal == "request_revision" || $page->modal == "request_translation" || $page->modal == "request_region"))
                    <label class="form-label">@{{page.parent_name}}</label>
                @else
                    <select-level items="parents" text="Select Folder" text-filter="Filter page" ng-model="page.parent_id" selected-item="selectedItem"></select-level>
                    <small class="help-inline" ng-show="submitted && !page.parent_id">{{trans('cms_page/page-propose.type_required')}}</small>
                @endif

            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input Date Live By -->
        <div class="form-group" ng-class="[submitted && ProposePageForm.due_date.$invalid]">
            <label class="label-form" for="due_date">{{trans('cms_page/page-propose.requested_date')}} <span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input type="text" placeholder="{{trans('cms_page/page-propose.mm_dd_yyyy')}}" class="form-control" name="due_date"
                        datepicker-popup="@{{format}}"
                        ng-model="page.due_date"
                        is-open="opened['due_date']"
                        ng-click="open($event,'due_date')"
                        ng-change="changeDate()"
                        min-date = "minDate"
                        ng-required="true"/>
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && ProposePageForm.due_date.$error.required">{{trans('cms_page/page-propose.requested_date_required')}}</small>
                    <small class="help-inline" ng-show="submitted && validatedue_date">{{trans('cms_page/page-propose.requested_date_invalid')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        @if($page->_id && $page->modal == 'request_translation')
            <div class="form-group">
             <label class="label-form" for="due_date">{{trans('cms_page/page-propose.requested_languages')}} <span class="text-require"> *</span></label>
             <div class="clearfix"></div>
                <multi-select items = "{{json_encode($languagesUnselected)}}" required-item="requiredLanguage" items-assigned = "languages_selected"></multi-select>
                <div class="clearfix"></div>
                <small class="help-inline  ng-invalid" ng-show="submitted && requiredLanguage">{{trans('cms_page/page-propose.requested_languages_required')}}</small>
            </div>
        @endif

        @if($page->_id && $page->modal == 'request_region')
            <div class="form-group" >
               <label class="label-form" for="due_date">{{trans('cms_page/page-propose.requested_regions')}} <span class="text-require"> *</span></label>
               <div class="clearfix"></div>
                <multi-select items = "{{json_encode($regionsUnselected)}}" required-item="requiredRegion" items-assigned = "regions_selected"></multi-select>
                <div class="clearfix"></div>
                <small class="help-inline col-lg-12 ng-invalid" ng-show="submitted && requiredRegion">{{trans('cms_page/page-propose.requested_regions_required')}}</small>
                <div class="clearfix"></div>
            </div>

        @endif
         <!-- slected Version-->
        <div class="form-group" >
            <div class="wrap-form"><label class="hightlight-lb" for="">{{trans('cms_page/page-propose.version')}} <span class="text-require"> *</span></label></div>
            <div class="wrap-form">
               <select ng-model="page.version" >
                    <option  ng-repeat="(key, value) in versions" value="@{{value | number:1}}">@{{value | number:1}}</option>
               </select>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- Input Description-->
        <div class="form-group" >
            <div class="wrap-form"><label class="hightlight-lb" for="">{{trans('cms_page/page-propose.description')}} <span class="text-require"> *</span></label></div>
            <div class="wrap-form">
                <textarea id="content" name="description" class="form-control" ng-init="initRedactor()" placeholder="{{trans('cms_page/page-propose.description')}}"></textarea>

                <div class="pull-left">
                    <small class="help-inline ng-invalid" ng-show="submitted && requiredDescription">{{trans('cms_page/page-propose.description_requied')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Attach File -->
        <div class="form-group" >
            <div class="form-group drop-file col-lg-12 padding-none">
                <div>
                    <file-upload ng-model="filesUpload" placeholder="">{{trans('cms_page/page-propose.file_placeholder')}}</file-upload>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Ticket child -->
        <div class="form-group space-box" ng-if="!page._id" ng-init="page.page_html = true;page.page_content = true;page.page_visual = true;page.page_seo = true;page.page_build = true; ">
            <div><b>{{trans('cms_page/page-propose.create_child_tasks_for_the_following')}}:</b></div>
            <div class="col-lg-6 col-md-6 padding-none">
                <div class="checkbox checkbox-info">
                    <input type="checkbox" id="checkbox1" ng-model="page.page_html" ng-checked="page.page_html == true">
                    <label for="checkbox1">{{trans('cms_page/page-propose.page_html')}}</label>
                </div>

                <div class="checkbox checkbox-info">
                    <input id="checkbox2" type="checkbox" ng-model="page.page_content" ng-checked="page.page_content == true">
                    <label for="checkbox2">{{trans('cms_page/page-propose.page_content')}}</label>
                </div>

                <div class="checkbox checkbox-info">
                    <input id="checkbox5" type="checkbox" ng-model="page.page_build" ng-checked="page.page_build == true">
                    <label for="checkbox5">{{trans('cms_page/page-propose.page_build')}}</label>
                </div>

            </div>

            <div class="col-lg-6 padding-none">
                <div class="checkbox checkbox-info">
                    <input id="checkbox3" type="checkbox" ng-model="page.page_visual" ng-checked="page.page_visual == true">
                    <label for="checkbox3">{{trans('cms_page/page-propose.page_visual')}}</label>
                </div>

                <div class="checkbox checkbox-info">
                    <input id="checkbox4" type="checkbox" ng-model="page.page_seo" ng-checked="page.page_seo == true">
                    <label for="checkbox4">{{trans('cms_page/page-propose.page_seo')}}</label>
                </div>

            </div>
            <div class="clearfix"></div>
        </div>

    </form>
</div>

<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()" ><i class="fa fa-times"></i> {{trans('cms_page/page-propose.cancel')}}</button>
    <button class="btn btn-primary" id="btnSubmit" ng-click="submit(ProposePageForm.$invalid)"><i class="fa fa-check"></i> {{trans('cms_page/page-propose.request_page')}}</button>
</div>

<script type="text/javascript">
    window.parents = {!!json_encode($parents)!!}
    window.page = {!!json_encode($page)!!}
</script>
