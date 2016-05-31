<div class="modal-header">
    <h4 class="modal-title break-word">{{trans('cms_block/edit-folder.header_title')}} {{$folder->name}}</h4>
</div>
<div class="modal-body" ng-init="folder={{$folder}}">
    <strong>{{trans('cms_block/edit-folder.folder_name')}}:<span class="text-require"> *</span> </strong>
    <span class="break-word">
        <a href="#" editable-text="folder.name"
                    e-name="folder.name"
                    onbeforesave="checkEmtypeName($data)">
            @{{folder.name || 'empty'}}
        </a>
    </span>
</div>
