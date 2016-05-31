
<div class="form-group  col-lg-12">
    @if(isset($label))
        <strong>
        	{{$label}} 
        	@if(isset($validatiton) && !empty($validatiton['require']) && $validatiton['require'])
        	<span class="text-require"> *</span>
        	@endif
        </strong>
    @endif
    <div ng-class="{'has-error': submitted && formData.{{$name}}.$invalid}">
        {!! $element !!}
        @if(!empty($validatiton['require']) && $validatiton['require'])
            <span class="control-label"ng-show="submitted && formData.{{$name}}.$error.required">@if(isset($label)){{ $label }} @else {{ $name }} @endif is a required field</span>
        @endif
        <span class="control-label"ng-show="submitted && formData.{{$name}}.$invalid && !formData.{{$name}}.$error.required">@if(isset($label)){{ $label }} @else {{ $name }} @endif is a invalid field</span>
    </div> 
</div>