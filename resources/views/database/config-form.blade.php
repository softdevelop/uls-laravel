@extends('app')
@section('title')
	Config Form Database
@stop
@section('content')
	<div class="wrap-branch" data-ng-controller="ConfigFormDatabaseManagerController">
		<div class="top-content">
		    <label class="c-m"> Config Database Form </label>
		    <a href="javascript:void(0)" ng-click="generalForm(table.name)" ng-if="table.fields.length <= 0" class="btn btn-primary fix-btn-top-content pull-right">
				<i class="fa fa-cog"></i> General Form
			</a>
		</div>
		<div class="content language-manager">
			<form role="form" name="formData" novalidate>
				<div ng-repeat="field in table.fields">
					<label>@{{field.name | formatText}}</label>
					<form-builder content="field.form"> </form-builder>
					<div class="clearfix"></div>
				</div>
				<button class="btn btn-primary" ng-click="submit(table.name, formData.$invalid)">Submit</button>
			</form>
		</div>
	</div>
@stop
@section('script')
	<script type="text/javascript">
		window.table = {!!json_encode($table)!!}
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/database/ConfigFormDatabaseManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/database/ConfigFormDatabaseManagerController.js?v='.getVersionScript())!!}
		{!! Html::script('/app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/databases/database.js') }}"></script>
	@endif
@stop
