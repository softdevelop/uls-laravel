@extends('app')
@section('title')
	Config Form Database
@stop
@section('content')
	<div ng-controller="Step3Controller as step3Ctrl">
		@foreach($accessories as $id => $name)
			<input type="checkbox" ng-model="step3Ctrl.accessories[{{$id}}]"  name="accessories" ng-true-value="{{$id}}" ng-false-value="''" option="step3Ctrl.option" />{{$name}} <br>
		@endforeach
		<br>
		<button confirm="'Does the User need to select another Accessory?'" on-confirm="step3Ctrl.addingAccessory()" option="step3Ctrl.option">Next</button>

	</div>
@stop
@section('script')
	<script>
		var modules = ['confirmDirective'];
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/database/GuideConfiguratorService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/database/step3Controller.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/confirm/confirmDirective.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/databases/database.js') }}"></script>
	@endif
@stop
