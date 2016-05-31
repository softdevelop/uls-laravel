
    <div class="div modal-header">
        <button aria-label="Close" ng-click="cancel()"  class="close" type="button"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Override Field</h4>
    </div>
    <div class="modal-body" ng-init="orveride = {{json_encode($orveride)}}">
        <form method="post" name="formData">
            <div class="form-group" ng-if="!isFieldTerm">

                <label class="col-lg-12">Placeholder: </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" ng-model="orveride.placeholder" ng-blur="updatePlaceholder(orveride.placeholder)" name="placeholder">
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-if="!isFieldTerm">
                <label class="col-lg-12">Pre-Field: </label>
                <div class="col-lg-6 form-group">
                    <input type="text" class="form-control" ng-blur="updatePreAddon(orveride.pre_addon.html, orveride.pre_addon.glyphicon)" ng-model="orveride.pre_addon.html" name="pre_addon_html">
                </div>
                <div class="col-lg-6 form-group">
                    <ui-iconpicker groups="font-awesome" ng-click="updatePreAddon(orveride.pre_addon.html, orveride.pre_addon.glyphicon)" value="@{{orveride.pre_addon.glyphicon}}" ng-model="orveride.pre_addon.glyphicon"></ui-iconpicker>
                    <a href="" ng-click="preAddonEntry(); orveride.pre_addon.html = ''; orveride.pre_addon.glyphicon = ''" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-if="!isFieldTerm">
                <label class="col-lg-12">Post-Field: </label>
                <div  class="col-lg-6 form-group">
                    <input type="text" class="form-control" ng-blur="updatePostAddon(orveride.post_addon.html, orveride.post_addon.glyphicon)" ng-model="orveride.post_addon.html" name="post_addon_html">
                </div>
                <div class="col-lg-6 form-group">
                    <ui-iconpicker groups="font-awesome" ng-click="updatePostAddon(orveride.post_addon.html, orveride.post_addon.glyphicon)" value="@{{orveride.post_addon.glyphicon}}" ng-model="orveride.post_addon.glyphicon"></ui-iconpicker>
                    <a href="" ng-click="postAddonEntry(); orveride.post_addon.html = ''; orveride.post_addon.glyphicon = ''" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="col-lg-12">Colum Size: </label>
                <div  class="col-lg-6">
                    <input type="number" ng-disabled="true" id="col" min="0" max="12" class="form-control" ng-model="col" name ="col">

                    <span ng-show="colValidate" class="span-error">Colum Size invalid (1 - 12)</span>
                </div>
                <div class="col-lg-6 form-group">
                    <a id="reduction" href="javascript:void(0)" ng-click="reductionCol(col)" class="btn btn-default"><i class="fa fa-angle-double-left"></i></a>
                    <a id ="augment" href="javascript:void(0)" ng-click="augmentCol(col)" class="btn btn-default"><i class="fa fa-angle-double-right"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn-default btn" ng-click="cancel()" ><i class="fa fa-times"></i> Close</button>
    </div>

    <script>
        window.col = {!!json_encode($orveride['col'])!!};
    </script>

