@extends('app')
@section('title')
    Review Draft
@endsection
@section('content')
'dddd'
@stop

@section('script')
    <script type="text/javascript">
        window.baseUrl = '{{URL::to("")}}'
        window.page = {!!json_encode($page)!!}
        window.template = {!!json_encode($template)!!}

    </script>

  {{--   @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/pages/EditDraftService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/EditDraftController.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/edit-draft.js') }}"></script>
    @endif --}}
@stop