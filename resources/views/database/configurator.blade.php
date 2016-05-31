@extends('app')
@section('title')
    Configurator Manage
@stop
<style type="text/css">
    .table td, th {
       text-align: center;   
    }
</style>
@section('content')
<div data-ng-controller="TypeController">
    <table class="table table-striped">
        <thead align="justify">
            <th>ID</th>
            <th>Email</th>
            <th>Url</th>
            <th>Last Step Completed</th>
        </thead>
        <tbody>
            @foreach($configurator as $configurator)
            <tr onclick="window.document.location='{{$configurator['linkConfigurator']}}';">
                <td>
                    {{$configurator['_id']}}
                </td>
                <td>
                    @if(isset($configurator['email']) && !empty($configurator['email']))
                        {{$configurator['email']}}
                    @endif
                </td>
                <td>
                    @if(isset($configurator['url']) && !empty($configurator['url']))
                        {{$configurator['url']}}
                    @endif
                </td>
                <td>
                    @if(isset($configurator['last_step_completed']) && !empty($configurator['last_step_completed']))
                        {{$configurator['last_step_completed']}}
                    @endif
                </td>
            </tr>
            </a>
            @endforeach
        </tbody>
    </table>
</div>
    
@stop
@section('script')
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/type/typeController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/type/typeService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/type.js') }}"></script>
    @endif
@stop