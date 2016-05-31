@extends('app')
@section('title')
	Content Management
@stop
@section('content')
<div>
	@if($type == 'mongodb')
		<div class="top-content">
		    <label class="c-m">
		    	<a class="c-breadcrumb" href="cms/database-manager">Database</a>
		    	/
		    	<a class="c-breadcrumb" href="@{{baseUrl}}/cms/databse-manager/set-database-selected/{{$idDatabase}}" target="_self">{{$name}}</a>
		    	/
		    	Detail Record {{$database['title']}}
		    </label>
		</div>
	@else
		<div class="top-content">
		    <label class="c-m">
		    	<a class="c-breadcrumb" href="cms/database-manager">Database</a>
		    	/
		    	<a class="c-breadcrumb" href="@{{baseUrl}}/cms/databse-manager/set-database-selected/{{$idDatabase}}" target="_self">{{$name}}</a>
		    	/
		    	Detail Record {{$database->title}}
		    </label>
		</div>
	@endif

	<div class="content">
		<div class="table-responsive"> 
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Key</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($database as $key => $value)
							<tr>
								<td><strong>{{$key}}</strong></td>
								<td>{{$value}}</td>
							</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
	
@stop
@section('script')
	
	<script src="{{ elixir('app/pages/dataoption.js') }}"></script>
@stop
