@extends('app')
@section('title')
	Test Insert Page
@endsection
@section('content')
	itemSelected = @{{itemSelected}}
	<modal-select-page ng-model="itemSelected" item-selected="itemSelected"></modal-select-page>
@stop

@section('script')
	<script>
		window.pages = {!!json_encode(listsPage())!!};
		window.listsIdsMapPageAndContent = {!!json_encode(listIdsMapPageAndContent())!!};
	</script>
	{!! Html::script('app/shared/modal-select-page/selectLevelDirective.js?v='.getVersionScript())!!}

@stop

