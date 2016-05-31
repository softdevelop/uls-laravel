@extends('app')
@section('title')
    {{trans('cms_page/page-edit.title')}}
@endsection
@section('content')
<div ng-controller="EditPageController">
    <div class="top-content">
        <label class="c-m">
            <a class="c-breadcrumb" href="/cms/pages">{{trans('cms_page/page-edit.content_management')}}</a> / {{trans('cms_page/page-edit.edit_page')}} {{$page->name}}
        </label>
    </div>

    <div class="content st-container" ng-init="page={{$page}};getPosition({{json_encode($templateIdOfPage)}})">

        <form role="form" name="EditProposePageForm" ng-show="page_number == 1" novalidate>
            <!-- Input Name-->
            <div class="form-group" ng-class="[submitted1 && EditProposePageForm.name.$invalid]">
                <label class="label-form" for="name">{{trans('cms_page/page-edit.name')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control" type="text" name="name" ng-model="page.name" ng-minlength=3 ng-maxlength=20 required />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.name.$error.required">{{trans('cms_page/page-edit.name_required')}}</small>
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.name.$error.minlength">{{trans('cms_page/page-edit.name_minlength')}}</small>
                        <small class="error" ng-show="submitted1 && EditProposePageForm.name.$error.maxlength">{{trans('cms_page/page-edit.name_maxlength')}}</small>
                    </div>
                </div>
                 <div class="clearfix"></div>

            </div>

            <!-- Input URL-->
            <div class="form-group" ng-class="[submitted1 && EditProposePageForm.url.$invalid]">
                <label class="label-form" for="url">{{trans('cms_page/page-edit.url')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control" type="text" name="url"
                            ng-model="page.url"
                            ng-minlength=3
                            ng-maxlength=50
                            ensure-url
                            required />
                            
                    <div class="pull-left">
                        <small class="help-inline" >@{{urlExists}}</small>
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.url.$error.url">{{trans('cms_page/page-edit.url_invalid')}}</small>
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.url.$error.required">{{trans('cms_page/page-edit.url_required')}}</small>
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.url.$error.minlength">{{trans('cms_page/page-edit.url_minlength')}}</small>
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.url.$error.maxlength">{{trans('cms_page/page-edit.url_maxlength')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Input Date Live By-->
            <div class="form-group" ng-class="[submitted1 && EditProposePageForm.dateLiveBy.$invalid]">
                <label class="label-form" for="dateLiveBy">{{trans('cms_page/page-edit.date_live_by')}}:<span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <input  type="text" class="form-control" name="dateLiveBy"
                            datepicker-popup="@{{format}}"
                            ng-model="page.dateLiveBy"
                            is-open="opened['dateLiveBy']"
                            datepicker-options="dateOptions"
                            ng-click="open($event, 'dateLiveBy')"
                            ng-required="true"/>

                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.dateLiveBy.$error.required">{{trans('cms_page/page-edit.date_live_by_required')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Input Date Available-->
            <div class="form-group" ng-class="[submitted1 && EditProposePageForm.dateAvailable.$invalid]">
                <!-- Input Date Available-->
                <label class="label-form" for="dateAvailable">{{trans('cms_page/page-edit.date_available')}}:<span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <input  type="text" class="form-control" name="dateAvailable"
                            datepicker-popup="@{{format}}"
                            ng-model="page.dateAvailable"
                            is-open="opened['dateAvailable']"
                            datepicker-options="dateOptions"
                            date-disabled="disabled(date, mode)"
                            ng-click="open($event, 'dateAvailable')"
                            ng-required="true"
                            close-text="close" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.dateAvailable.$error.required">{{trans('cms_page/page-edit.date_available_required')}}</small>
                        <small class="help-inline" ng-show="submitted1 && errorDateAvailable && !EditProposePageForm.dateAvailable.$error.required">{{trans('cms_page/page-edit.date_available_invaid')}}</small>
                    </div>

                </div>

                <!-- Input Date to-->
                <label class="label-form" for="toDate">{{trans('cms_page/page-edit.to')}}:<span class="text-require"> *</span></label>
                <div class="col-lg-12" ng-class="[submitted1 && (EditProposePageForm.toDate.$invalid || todateBigger)]">
                    <input  type="text" class="form-control" name="toDate"
                            datepicker-popup="@{{format}}"
                            ng-model="page.toDate"
                            is-open="opened['toDate']"
                            datepicker-options="dateOptions"
                            date-disabled="disabled(date, mode)"
                            ng-click="open($event, 'toDate')"
                            ng-required="true"
                            close-text="close" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted1 && EditProposePageForm.toDate.$error.required">{{trans('cms_page/page-edit.to_required')}}</small>
                        <small class="help-inline" ng-show="submitted1 && errortoDate && !EditProposePageForm.toDate.$error.required">{{trans('cms_page/page-edit.to_invalid')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>


            <!-- Tab panel -->
            <div role="tabpanel" class="space-tab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#region" aria-controls="region" data-toggle="tab">{{trans('cms_page/page-edit.region')}}:<span class="text-require"> *</span></a></li>
                    <li role="presentation"><a href="#language" aria-controls="language" data-toggle="tab">{{trans('cms_page/page-edit.language')}}:<span class="text-require"> *</span></a></li>
                    <li role="presentation"><a href="#marketSegment" aria-controls="marketSegment" data-toggle="tab">{{trans('cms_page/page-edit.market_segment')}}:<span class="text-require"> *</span></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content h190">
                    <div role="tabpanel" class="tab-pane active" id="region">
                        <multi-select items = "{{json_encode($region_unselected)}}" required-item="requiredRegion" items-assigned = "region_selected"></multi-select>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="language">
                        <multi-select items = "{{json_encode($language_unselected)}}" required-item="requiredLanguage" items-assigned = "language_selected"></multi-select>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="marketSegment">
                        <multi-select items = "{{json_encode($marketSegment_unselected)}}" required-item="requiredMarketSegment" items-assigned = "marketSegment_selected"></multi-select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-6">
                    <small class="help-inline" ng-show="submitted1 && requiredRegion">{{trans('cms_page/page-edit.region_required')}}</small><br />
                    <small class="help-inline" ng-show="submitted1 && requiredLanguage">{{trans('cms_page/page-edit.language_required')}}</small><br />
                    <small class="help-inline" ng-show="submitted1 && requiredMarketSegment">{{trans('cms_page/page-edit.market_segment_required')}}</small>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="pull-right m-b-30">
                    <button class="btn btn-primary" ng-click="next(EditProposePageForm.$invalid)" ng-show="page_number == 1">{{trans('cms_page/page-edit.next')}}</button>
                    <button class="btn btn-warning" ng-click="cancel()" ng-if="page_number == 1">{{trans('cms_page/page-edit.cancel')}}</button>
                </div>
            </div>
        </form>

        <form role="form" name="EditPageForm" ng-show="page_number == 2" novalidate>
            <div class="form-group" ng-class="[submitted && EditPageForm.name.$invalid]">
                <label class="control-label col-lg-3 hightlight-lb" for="name">{{trans('cms_page/page-edit.name')}}</label>
                <div class="col-lg-12">
                    <label>@{{page.name}}</label>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Input URL-->
            <div class="form-group" ng-class="[submitted && (EditPageForm.url.$invalid || urlExists)]">
                <label class="label-form" for="url">{{trans('cms_page/page-edit.url')}}</label>
                <div class="col-lg-12">
                    <label>@{{page.url}}</label>
                </div>
                <div class="clearfix"></div>
            </div>

           <!-- Input Template-->
            <div class="form-group" ng-class="[submitted && EditPageForm.template.$invalid]">
                <label class="label-form" for="template">{{trans('cms_page/page-edit.template')}}:<span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <select type="text" name="template" class="form-control template-pages"
                            ng-model="page.template"
                            ng-change="getPositionsTemplate(page.template)"
                            ng-required="true" >
                        <option value="">{{trans('cms_page/page-edit.select_a_template')}}</option>
                        <option ng-repeat="template in templates" value="@{{template._id}}">@{{template.template_name}}</option>
                    </select>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && EditPageForm.template.$error.required">{{trans('cms_page/page-edit.template_required')}}</small>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

             <!-- Input Template Fields-->
            <div ng-repeat="templateField in templateFields">
                <div class="form-group">
                    <label class="label-form">@{{templateField.name}}:<span class="text-require"> *</span></label>
                    <div class="col-lg-12">
                        <input id="$index" class="form-control" type="@{{(templateField.type == 'input') ? 'text' : ''}}" name="field@{{$index}}"
                                size="@{{templateField.size}}"
                                ng-init="page.templateField[page.template][templateField.variable]=fields[page.template][templateField.variable]"
                                ng-model="page.templateField[page.template][templateField.variable]"
                                ng-required = "true"/>

                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && EditPageForm.field@{{$index}}.$error.required">@{{templateField.name}} {{trans('cms_page/page-edit.is_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <!-- Input Select Position-->
            <div class="form-group" ng-show="positions">
                <label class="label-form" for="subheading">{{trans('cms_page/page-edit.position')}}</label>
                <div class="col-lg-12">
                    <select type="text" name="position" class="form-control position-template"
                            ng-model="page.position"
                            ng-required="true">
                        <option ng-repeat="position in positions" value="@{{position.variable}}">@{{position.name}}</option>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Input Description-->
            <div class="col-lg-12">
                <label class="hightlight-lb" for="">{{trans('cms_page/page-edit.description')}}:<span class="text-require"> *</span></label>
            </div>
            <div class="col-lg-12">
                <textarea id="content" placeholder="Description"></textarea>
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && requiredDescription">{{trans('cms_page/page-edit.description_required')}}</small>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="clearfix"></div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="previous()" ng-if="page_number == 2">{{trans('cms_page/page-edit.previous')}}</button>
                <button class="btn btn-primary" id="btnSubmit" ng-click="submit(EditPageForm.$invalid)" ng-if="page_number == 2">{{trans('cms_page/page-edit.save')}}</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('script')
    <script type="text/javascript">
        window.baseUrl        = '{{URL::to("")}}';
        window.page           = {!!json_encode($page)!!};
        window.template_lists = {!!json_encode($template_lists)!!};
        window.listsIdWithImageNameOfTemplate = {!!json_encode($listsIdWithImageNameOfTemplate)!!};
        window.positionIdWithImageName = {!!json_encode($positionIdWithImageName)!!};
        window.templateIdOfPage = {!!json_encode($templateIdOfPage)!!};
        window.contents = {!!json_encode($contents)!!};
        window.region_selected        = {!!json_encode($region_selected)!!};
        window.language_selected      = {!!json_encode($language_selected)!!};
        window.marketSegment_selected = {!!json_encode($marketSegment_selected)!!};
        window.list_content = {!!json_encode($list_content)!!};

    </script>
    {!! Html::script('/app/shared/resizer/resizer.js?v='.getVersionScript())!!}
    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/pages/EditPageService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/EditPageController.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/EditPageDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/page-edit.js') }}"></script>
    @endif
@stop
