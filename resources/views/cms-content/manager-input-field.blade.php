        <form role="form" name="formData" novalidate id="tesst">
            <!-- Info, Template Extend -->
            <tabset>
                <tab ng-repeat="(key,value) in templates[page.template]['extends']" ng-click="chooseCurrentTemplate(formData.$invalid, key, indexCurrentTemplate, value.stepTemplate)" disabled="(indexCurrentTemplate < value.stepTemplate) && (!successForm[indexCurrentTemplate] || !successForm[value.stepTemplate])" active="activeTemplate[value.stepTemplate]">
                    <tab-heading class="thumbnail-page">
                        <figure>
                            <img width="100%" ng-if="templates[key]['thumbnail'] != null" ng-src="/admin/file/@{{templates[key]['thumbnail']}}" alt="">
                            <img width="100%" ng-if="templates[key]['thumbnail'] == null" ng-src="/thumbnail_default.jpg" alt="">
                        </figure>
                        <span class="name">@{{templates[key]['name']}}
                          <i class="status ti-alert" ng-show="!successForm[value.stepTemplate]"></i>
                          <i class="fa fa-check-circle" ng-show="successForm[value.stepTemplate]"></i>
                        </span>
                    </tab-heading>
                </tab>

                <tab ng-click="chooseCurrentTemplate(formData.$invalid, page.template, indexCurrentTemplate, lastTemplate)" ng-if="templates[page.template]" disabled="indexCurrentTemplate < lastTemplate && (!successForm[indexCurrentTemplate] || !successForm[lastTemplate])" active="activeTemplate[lastTemplate]">
                  <tab-heading class="thumbnail-page">
                        <figure>
                            <img width="100%" ng-if="templates[page.template]['thumbnail'] != null" ng-src="/admin/file/@{{templates[page.template]['thumbnail']}}" alt="">
                            <img width="100%" ng-if="templates[page.template]['thumbnail'] == null" ng-src="/thumbnail_default.jpg" alt="">    
                        </figure>
                        
                        <span class="name">@{{templates[page.template]['name']}}
                          <i class="status ti-alert" ng-show="!successForm[lastTemplate]"></i>
                          <i class="fa fa-check-circle" ng-show="successForm[lastTemplate]"></i>
                        </span>
                  </tab-heading>
                </tab>

            </tabset>

            <tabset ng-show="!isDetails && isShowInputDataPage" class="child-tab">
                <tab ng-click="chooseFields(formData.$invalid, indexCurrentTemplate)" ng-if="templates[currentChosseTemplate]['fields'].length > 0">
                    <tab-heading class="thumbnail-page box" ng-click="setDIVHeight()">
                        <span class="name">
                          <i class="status ti-alert" ng-show="!successField[indexCurrentTemplate]"></i>
                          <i class="ti-check" ng-show="successField[indexCurrentTemplate]"></i>
                          Fields
                        </span>
                    </tab-heading>

                </tab>
                <tab ng-repeat="(key,inject) in templates[currentChosseTemplate]['injects']" ng-click="chooseInject(formData.$invalid, key, indexCurrentTemplate)" ng-if="templates[currentChosseTemplate]['injects'] && exitsFieldBlock[key]">
                    <tab-heading class="thumbnail-page box" ng-click="setDIVHeight()">
                        <span class="name">
                          <i class="status ti-alert" ng-show="!successInject[indexCurrentTemplate][key]"></i>
                          <i class="ti-check" ng-show="successInject[indexCurrentTemplate][key]"></i>
                          @{{inject.name}}
                        </span>
                    </tab-heading>
                </tab>
                
                <tab ng-repeat="section in templates[currentChosseTemplate]['sections']" ng-click="chooseSection(formData.$invalid, section.variable, section._id, indexCurrentTemplate)" ng-if="templates[currentChosseTemplate]['sections'].length > 0">
                  <tab-heading class="thumbnail-page box" ng-click="setDIVHeight()">
                        <span class="name">
                          <i class="status ti-alert" ng-show="!successSection[indexCurrentTemplate][section._id]"></i>
                          <i class="ti-check" ng-show="successSection[indexCurrentTemplate][section._id]"></i>
                          @{{section.name}}
                        </span>
                  </tab-heading>
                </tab>
            </tabset>
            <!-- show page detail -->
            @include('pages.partial.pages-detail')
            <!-- end show page detail -->

            <!-- show extend template fields -->
            <div ng-if="isShowField" class="form-group" ng-repeat="field in templates[currentChosseTemplate].fields">
                @include('pages.partial.show-fields-template-extends')
            </div>
            <!-- end show extend template fields -->
            <!-- show block fields -->
            <div ng-if="isShowInject" class="form-group" ng-repeat="field in templates[currentChosseTemplate].injects[curSecIndex].fields">
                @include('pages.partial.show-fields-template-inject-block')
            </div>
            <!-- Input Description-->
            
            <!-- <div class="set-height"> -->

                <div ng-show="isShowContentSection">
                    @include('pages.partial.show-sections-template')
                </div>
            <!-- </div> -->

            <div class="alert alert-danger" ng-show="warningError">
                <button class="close" ng-click="closeAlert()" aria-label="close">&times;</button>
                <span>Please complete all information before saving</span>
            </div>

            <!--show error minimum field-->
            <div class="form-group control-label col-lg-12 help-inline" ng-repeat="(key, value) in listErrorListFile">@{{value}}</div>

            <div class="text-right" style="padding: 20px 15px;margin-bottom:20px;border-top:1px solid #e2e2e2;margin-top:40px">
                <a ng-if="!checkPage" class="btn btn-default" href="@{{baseUrl}}/support/show/@{{page['ticket_id']}}"><i class="fa fa-times"></i> Cancel</a>
                <a ng-if="checkPage" class="btn btn-default" href="@{{baseUrl}}/cms/pages"><i class="fa fa-times"></i> Cancel</a>
                <button ng-show="page.template" class="btn btn-primary" id="btnSubmit" ng-click="prevStepPage(indexCurrentTemplate)">
                    <i class="fa fa-arrow-left"></i> Prev
                </button>
                <button class="btn btn-primary" id="btnSubmit" ng-click="nextStepPage(formData.$invalid, indexCurrentTemplate)" ng-if="indexCurrentTemplate < lastTemplate">
                    <i class="fa fa-arrow-right"></i> Next
                </button>
                <button  class="btn btn-primary" id="btnSubmit" ng-click="submit(formData.$invalid)">
                    <i class="fa fa-check"></i> Save
                </button>

                <!-- <button ng-show="!page.template" class="btn btn-primary" id="btnSubmit" ng-click="saveDetailPage()"> -->
                    <!-- <i class="fa fa-check"></i> Save -->
                <!-- </button> -->

                <button class="btn btn-upload" id="btnSubmit" ng-click="previewDraff(formData.$invalid)" ng-if="indexCurrentTemplate==lastTemplate">
                    <i class="fa fa-eye"></i> Preview
                </button>
            </div>

            <a href="@{{urlPre}}" target="_blank" id="preview-draft"></a>

        </form>