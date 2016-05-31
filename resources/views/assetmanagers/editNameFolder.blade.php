<div class="modal-header">
    <h4 class="modal-title">Edit Folder Name {{$folder->name}}</h4>
</div>
<div class="modal-body" ng-init="folder={{$folder}}">
    <strong>Folder name<span class="text-require"> *</span>: </strong>
    <span>
        <a href="#" editable-text="folder.name"
                    e-name="folder.name"
                    onbeforesave="checkEmtypeName($data)">
            @{{folder.name || 'empty'}}
        </a>
    </span>
    <span class="has-error">
        @{{emtypeName}}
    </span>
</div>
