<div class="modal-header">
    <h4 class="modal-title">{{trans('cms_page/page-edit-folder.header_title')}} {{$folder->name}}</h4>
</div>
<div class="modal-body" ng-init="folder={{$folder}}">
    <strong>{{trans('cms_page/page-edit-folder.folder_name')}}:<span class="text-require"> *</span> </strong>
    <span>
        <a href="#" editable-text="folder.name"
                    e-name="folder.name"
                    onbeforesave="checkEmtypeName($data)">
            @{{folder.name || 'empty'}}
        </a>
    </span>
    <span class="text-require">
        @{{emtypeName}}
    </span>
</div>
