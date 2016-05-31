<div id="myModal" class="modal-help" role="dialog">    
    <div class="modal-header">
       <button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title">Help</h4>
    </div>

    <div class="modal-body modal-user" ng-init="items={{json_encode($items)}}">
        @if (empty($items))
            No Help
        @else
            <help-editor-directive items="items"></help-editor-directive>
        @endif
        <div class="clearfix"></div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" ng-click="cancel()"><i class="fa fa-times"></i> Close</button>
    </div>
</div>