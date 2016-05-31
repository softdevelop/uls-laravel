@extends('app')
@section('title')
    Translation Editor
@stop
@section('content')
    <div data-ng-controller="TranslationEditorController" ng-init="page = {{json_encode($page)}};">
        {{-- page = @{{page}} --}}
        <button ng-click="export(page)">export</button>        
    </div>
    
@stop

@section('script')
    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/pages/TranslationEditorService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/TranslationEditorController.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/translation-editor.js') }}"></script>
    @endif
@stop
