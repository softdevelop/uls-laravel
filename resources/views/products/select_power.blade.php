@extends('configurator')
@section('content')
	

<div id="title">
<h1>	{!! session('platform_interest') !!} | {!! $results['query']['all_configurator_text2']['select_your_laser_power'] !!} 		</h1>

@if (\Request::segment(4) == 'pls6mw')
	<?php $path = 'select-wattage-pls6mw/' . \Request::segment(4); ?>
@elseif(\Request::segment(4) == 'xls10mwh')
	<?php $path = 'select-wattage-xls10mwh/' . \Request::segment(4);  ?>
@else
	<?php $path = 'select-wattage/' . \Request::segment(4); ?>
@endif

<div id="next"><a href="{{URL::to('products/configurator/'.$path)}}">{{$results['snippet']['continue']}} ›</a></div>
<div id="back"><a href="{{URL::to('products/configurator/platforms')}}">‹ {{$results['snippet']['back']}}</a></div>

<br class="clearall">
</div>

<div id="page-wrap">


<div id="left">

<h2>{{$results['query']['all_configurator_text2']['step_2']}}</h2>
<h3>{{$results['query']['all_configurator_text2']['select_your_laser_power']}}</h3>
<p>  <a href="{{ URL::to('products/configurator/platforms')}}">‹ {{$results['query']['all_configurator_text2']['select_different']}}</a></p>

{!! $results['query']['all_configurator_text2']['step_2_text'] !!}

<div id="line"></div>

<div id="big-button"><a href="{{URL::to('products/configurator/'.$path)}}">
    <img src="{{URL::to('/')}}/imgs/right-arrow.png" alt="right arrow"/>{{$results['query']['all_configurator_text2']['select_your_laser_power']}}</a></div>
    
  

</div>


<div id="right">

<div id="product-listing-title">

<div id="learnmore"><a hreflang="en-us" href="{{URL::to('products/configurator/help')}}">{{$results['snippet']['help']}}</a></div>
<br class="clearall">

</div>


<div id="laser-power">

<div><strong>{{$results['query']['all_configurator_text2']['w10_watts']}}</strong><br>
{{$results['query']['all_configurator_text2']['w10_watts_text']}}</div>

<div><strong>{{$results['query']['all_configurator_text2']['w20_30_watts']}}</strong><br>
{{$results['query']['all_configurator_text2']['w20_30_watts_text']}}</div>

<div><strong>{{$results['query']['all_configurator_text2']['w40_60_watts']}}</strong><br>
{{$results['query']['all_configurator_text2']['w40_60_watts_text']}}</div>

<div><strong>{{$results['query']['all_configurator_text2']['w60_75_watts']}}</strong><br>
{{$results['query']['all_configurator_text2']['w60_75_watts_text']}}</div>

<div><strong>{{$results['query']['all_configurator_text2']['w75_150_watts']}}</strong><br>
{{$results['query']['all_configurator_text2']['w75_150_watts_text']}}<br><br>
<em>{{$results['query']['all_configurator_text2']['laser_power_above_75']}}</em>
</div>

</div>



</div>

<br class="clearall">



</div>

<div id="bottom">
<div id="progress">
<div id="step1-on">{{session('platform_interest')}}</div>
<div id="step2-on">{{$results['query']['all_configurator_text']['select_laser_power']}}</div>
<div id="step3">{{$results['query']['all_configurator_text']['select_options_accessories']}}</div>
<div id="step4">{{$results['query']['all_configurator_text2']['submit_configuration']}}</div>
</div>

</div>

@endsection