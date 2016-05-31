@extends('configurator')
@section('content')
<div id="title">
<h1>{!! $results['query']['all_configurator_text2']['configure_your_laser_system'] !!}</h1>
<br class="clearall">
</div>

<div id="page-wrap" class="step2">


<div id="left">


<h2>{!! $results['query']['all_configurator_text2']['step_1'] !!}</h2>
<h3>{!! $results['query']['all_configurator_text2']['select_your_laser_platform'] !!}</h3>
{!! $results['query']['all_configurator_text2']['platform_text'] !!}

</div>

<div id="right">

<div id="vert-align">
<div id="big-button"><a href="{{URL::to('products/configurator/platforms')}}"><img src="{{getBaseUrl()}}/imgs/right-arrow.png">{!! $results['query']['all_configurator_text2']['select_platform'] !!}</a></div>
</div>
</div>

<br class="clearall">



</div>

<div id="bottom">
<div id="progress">

<div id="step1-on">{!! $results['query']['all_configurator_text2']['select_platform'] !!}</div>
<div id="step2">{!! $results['query']['all_configurator_text']['select_laser_power'] !!}</div>
<div id="step3">{!! $results['query']['all_configurator_text']['select_options_accessories'] !!}</div>
<div id="step4">{!! $results['query']['all_configurator_text2']['submit_configuration'] !!}</div>
</div>

</div>
@endsection