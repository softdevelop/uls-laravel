<div class="modal-header">
    <h4 class="modal-title">Edit name category {{$category->name}}</h4>
</div>

<div class="modal-body" ng-init="category={{$category}}">
    <strong>Category name: </strong>
    <span>
        <a href="#" editable-text="category.name"
                    e-name="category.name"
                    onbeforesave="checkEmtypeName($data)">
            @{{category.name || 'empty'}}
        </a>
    </span>
    <div class="clearfix"></div>
    <small class="help-inline" ng-show="nameExists">Name is already exists!</small>
</div>
