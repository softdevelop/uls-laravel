
@if(isset($label))
	<strong class="font-13">{{$label}}</strong>
@endif 
<a ng-controller="TermController" href="javascript:void(0)" ng-click="showModal('{{$name}}', '{{$label}}', '{{$save_to_field}}', '{{$parent_model}}')" class="btn btn-primary btn-xs">
	<i class="fa fa-plus"></i>
</a>


<script type="text/javascript">
	
	window["{{$name}}"] = {!! json_encode($field) !!};
</script>