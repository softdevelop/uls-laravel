<div class="modal-content" ng-init="path = {{json_encode($path)}}">
    {{-- <a href="uploads\templates\@{{path}}" type="button" class="close pull-left">
        <i class="fa fa-download"></i>
         <span style="font-size:15px">Download</span>
    </a> --}}
    <button ng-click="cancel()" type="button" class="close" data-dismiss="modal-content">
        <i class="fa fa-times"></i>
    </button>
    <img class="img-responsive" src="uploads\templates\@{{path}}" alt="Place" style="width:100%;height:auto">
</div><!-- /.modal-content -->