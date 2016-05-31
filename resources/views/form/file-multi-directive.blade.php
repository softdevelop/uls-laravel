<div class="form-group drop-file  col-lg-12">
    <div>
        <file-upload ng-model="{{$ngModel}}" @if(isset($placeholder)) placeholder="{{$placeholder}}" @endif></file-upload>
    </div>
</div>