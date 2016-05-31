@extends('app')
@section('content')


@stop

@section('script')

    {!! Html::script('app/tests/spec/cms/blocks/TestDemo.js?v='.getVersionScript())!!}

@stop
