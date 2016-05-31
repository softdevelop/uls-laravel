<div id="Redirects">
    <div class="page-header title-redirects">
      <h3>{{trans('cms_page/page-manager-redirect.add_redirect')}}</h3>
    </div>
    <form role="form" name="formRedirect" novalidate id="tesst">
        <div class="col-lg-8">
            <div class="input-group">
                <span class="input-group-addon">
                  <label class="control-label hightlight-lb">{{trans('cms_page/page-manager-redirect.redirect_url')}}:<small class="text-require"> *</small></label>
                </span>
                <input class="form-control" id="oldUrl" type="text" name="redirectUrl" ng-required="true" ng-model="redirect.url">
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && formRedirect.redirectUrl.$error.required">{{trans('cms_page/page-manager-redirect.url_required')}}.</small>
                    <small class="help-inline" ng-if="uniqueUrl && !formRedirect.redirectUrl.$error.required">@{{messageUniqueUrl}}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="col-lg-6">
                <select name="headerUrl" id="headerUrl" ng-required="true" class="form-control" ng-model="redirect.header">
                    <!-- <option disabled="true" value="?" selected="selected" hidden>Select redirect header</option> -->
                    <option value="301">301</option>
                    <option value="302">302</option>
                </select>
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && formRedirect.headerUrl.$error.required">{{trans('cms_page/page-manager-redirect.header_required')}}.</small>
                </div>
            </div>
            <div class="col-lg-6">
                <button id="btnAddRedirect" ng-click="addRedirect(formRedirect.$invalid)" class="btn btn-primary"><i class="fa fa-plus"></i> {{trans('cms_page/page-manager-redirect.add_redirect')}}</button>
            </div>
        </div>

    <div class="clearfix"></div>
    <div class="page-header title-redirects">
      <h3>{{trans('cms_page/page-manager-redirect.redirect_list')}}</h3>
    </div>
    <div class="table-responsive wrap-box-content">
        <div class="table-responsive">
            <table class="table center-td fix-height-tb wrap-url" ng-table="tableRedirectParams" show-filter="isSearch">
                <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
                    <i class="fa fa-search"></i>
                </a>
                <tbody class="wrap-url">
                    <tr ng-repeat="redirect in $data">
                        <td class="text-center" data-title="'URL'" sortable="'url'" filter="{ 'url': 'text' }">@{{redirect.url}}</td>                        
                        <td class="text-center" data-title="'Type'" sortable="'header'" filter="{ 'header': 'select' }" data-filter-data="headerFilter($column)">@{{redirect.header}}</td>                        
                        <td class="text-center" data-title="'Delete'">
                            <a class="btn btn-sm btn-default btn-mobile m-r-10" ng-click="removeRedirect(redirect._id)">
                                <i class="fa fa-trash-o"></i> {{trans('cms_page/page-manager-redirect.delete')}}
                            </a>
                        </td>                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>