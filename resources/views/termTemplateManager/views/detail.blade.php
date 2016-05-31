@extends('termTemplateManager.views.app')
@section('title')
	{{strtoupper($data['name'])}} Detail
@stop
@section('content')
	<div ng-controller="BaseController">
		{!!html_entity_decode($data['content'])!!}
	</div>
@stop