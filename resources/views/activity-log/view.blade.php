@extends('app')
@section('title') NLC - Logs | @stop
@section('content')
	<div class="wrap-branch-on">
		<div class="content-branch-on">
			<div class="detail-task-label margin-left-0">
				<div class="content-dtl">
					<div class="col-lg-12 info-task-label padding-none">

							<div class="top-task-lbl">
								<h5 class="margin-none">{{!empty($logs) ? 'Logs' : 'Empty Logs'}}</h5>
							</div>
							<div class="body-task-lbl font-15">
								<div class="col-task-pen">
									@if(!empty($logs))
										<!-- foreach -->
								 @foreach($logs as $key => $value)
								<div class="pen-task">

									<p class="clock-pen">

										<span><span class="fa fa-clock"></span>
											{{date("m-d-Y", strtotime($value['created_at']) - intval($user->time_zone * 60))}}
											{{date("g:i A", strtotime($value['created_at']) - intval($user->time_zone * 60))}}
										</span>
										(<span>{{ !empty($value['message']['user_created']) ? $value['message']['user_created'] : ''}} <span class="fa fa-user"></span></span>)
									</p>
									<hr>
									<p class="action-pen">Action:
									@if($value['action'] == 'create' || $value['action'] == 'show-contact')

									 	<label for="" class="label label-warning">{{$actions[$value['action']]}}</label>


									@elseif($value['action'] == 'update' || $value['action'] == 'asignee' || $value['action'] == 'invite')

									 	<label for="" class="label label-success">{{$actions[$value['action']]}}</label>

									@elseif($value['action'] == 'internal' || $value['action'] == 'rollback')

										<label for="" class="label label-danger">{{$actions[$value['action']]}}</label>

									@elseif($value['action'] == 'comment' || $value['action'] == 'approved')

										<label for="" class="label label-info">{{$actions[$value['action']]}}</label>

									@else
										<label for="" class="label label-default">{{$actions[$value['action']]}}</label>

									@endif
									</p>
									<p class="status-pen"><span class="fa fa-comment"> </span>
									@if (!isset($value['position']))
										{{
											trans('activity_log.' . $value['message_key'] . '.' . $value['module'] . '.' . $value['action'],$value['message'])
										}}
									@else
										{{
											Lang::choice('activity_log.' . $value['message_key'] . '.' . $value['module'] . '.' . $value['action'], $value['position'], $value['message'])
										}}
									@endif
									</p>
								</div>
								@endforeach
								{!! $logs->render() !!}
									@endif
								</div>
							</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div>

	</div>
@stop
@section('scripts-modules')
<script type="text/javascript">
    var modules = ['timer', 'ngSanitize','xeditable'];
</script>
@stop
@section('scripts')
 @if(!isProduction() && !isDev())
        {!! Html::script('app/components/activity-log/activityLogController.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/activity-log.js') }}"></script>
    @endif
@stop
