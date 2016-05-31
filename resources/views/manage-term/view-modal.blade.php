

<div class="modal-header">
<button aria-label="Close" data-dismiss="modal" class="close" type="button" ng-click="cancel()"><span aria-hidden="true">×</span></button>

    <h4 class="modal-title">Add @{{term.name}}</h4>
    
</div>
<div class="modal-body">

    <form class="form-horizontal" method="POST" accept-charset="UTF-8" name="formDataModal">
        <div class="col-lg-12">
	        @for($i = 0; $i < $lenght; $i++)
	        	<div ng-class="{'has-error': submitted && formDataModal.{{term.htmlField.htmlArr[<?php print $i?>].attrName}}.$invalid}">
	            	<form-builder content="term.htmlField.htmlArr[{{$i}}].htmlField"></form-builder>
	            	<span ng-show="submitted && formDataModal.{{term.htmlField.htmlArr[<?php print $i?>].attrName}}.$error.required">{{term.htmlField.htmlArr[<?php print $i?>].name}} is a required field</span>
                    <span ng-show="submitted &&formDataModal.{{term.htmlField.htmlArr[<?php print $i?>].attrName}}.$invalid && !formDataModal.{{term.htmlField.htmlArr[<?php print $i?>].attrName}}.$error.required">{{term.htmlField.htmlArr[<?php print $i?>].name}} is a invalid</span>
	            </div>
	        @endfor
        </div>
        <div class="clearfix"></div>
    </form>
</div>
<div class="modal-footer center-block">
    <button id="bt-submit" class="btn btn-primary" ng-click="submit(formDataModal)"><i class="fa fa-check"></i> Save</button>
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> Cancel</button>
</div>