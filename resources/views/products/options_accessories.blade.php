@extends('configurator')
@section('content')
<form action="{{URL::to('products/configurator/view-configuration/'.\Request::segment(4))}}" method="post" accept-charset="utf-8">
<div id="title">
<h1>{{session('platform_interest')}} | {!! $results['query']['all_configurator_text2']['select_your_options_and_accessories'] !!}</h1>

@if (\Request::segment(4) == 'pls6mw')
	<?php  $path = 'select-wattage-pls6mw'; ?>
@elseif(\Request::segment(4) == 'xls10mwh')
	<?php $path = 'select-wattage-xls10mwh';  ?>
@else
	<?php $path = 'select-wattage'; ?>
@endif

<div id="next">
<input type="submit" name="submit" value="{!! $results['snippet']['continue'] !!} ›"  />
</div>
<div id="back">
<a href="{{URL::to('products/configurator/'.$path.'/'.\Request::segment(4))}}">‹ {!! $results['snippet']['back'] !!}</a>
</div>

<br class="clearall">
</div>

<div id="page-wrap">

@foreach($results['options'] as $key => $option)
<div id="{!! $option['link'] !!}">
<div id="main">
<div id="close"><a href="javascript:animatedcollapse.toggle('{!! $option['link'] !!}')"><img src="/imgs/close.png"></a></div>

@if(!empty($option['video_names']['video_name']))
  <div id="videoholder">
  <object>
     <param name="movie" value="http://www.youtube.com/v/{!! $option['video_names']['video_name'] !!}?modestbranding=1&amp;version=3&amp;hl=en_US&amp;rel=0"></param>
     <param name="allowFullScreen" value="true"></param>
     <param name="allowscriptaccess" value="always"></param>
     <param name="wmode" value="opaque" />
     <embed src="http://www.youtube.com/v/{!! $option['video_names']['video_name'] !!}?modestbranding=1&amp;version=3&amp;hl=en_US&amp;rel=0" 
     type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"></embed>
</object>
  </div>
  
<div id="video-desc">
<div id="vert-align">
<h3>{!! $option['option_name'] !!}</h3>
<p>{!! $option['option_description'] !!}</p>
</div>
</div>
<br class="clearall">
@else
<div id="accessory">
	<img src="{{URL::to('/')}}/imgs/{!! $option['image_name'] !!}" alt="{!! $option['option_name'] !!}"/>
</div>
<div id="accessory-desc">
<div id="vert-align">
<h3>{!! $option['option_name'] !!}</h3>
{!! $option['option_description'] !!}
</div>
</div>
<br class="clearall">
@endif

</div>
</div>
@endforeach

@foreach ($results['accessories']['accessories_text'] as $accessory)
<div id="{{$accessory['all_links_configurator_accessories']['link'] }}">
<div id="main">
<div id="close"><a href="javascript:animatedcollapse.toggle('{!! $accessory['all_links_configurator_accessories']['link'] !!}')"><img src="/imgs/close.png"></a></div>

@if(!empty($accessory['all_links_configurator_accessories']['video_names']['video_name']))
  
  <div id="videoholder">
  <object>
     <param name="movie" value="http://www.youtube.com/v/{!! $accessory['all_links_configurator_accessories']['video_names']['video_name'] !!}?modestbranding=1&amp;version=3&amp;hl=en_US&amp;rel=0"></param>
     <param name="allowFullScreen" value="true"></param>
     <param name="allowscriptaccess" value="always"></param>
     <param name="wmode" value="opaque" />
     <embed src="http://www.youtube.com/v/{!! $accessory['all_links_configurator_accessories']['video_names']['video_name'] !!}?modestbranding=1&amp;version=3&amp;hl=en_US&amp;rel=0" 
     type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"></embed>
</object>
  </div>
  
<div id="video-desc">
<div id="vert-align">
<h3>{!! $accessory['accessory_name'] !!}</h3>
<p>{!! $accessory['accessory_description'] !!}</p>
</div>
</div>
<br class="clearall">
@else
<div id="accessory">
	<img src="{{getBaseUrl()}}/imgs/{!! $accessory['accessories_images']['image_name'] !!}" alt="{!! $accessory['accessory_name'] !!}"/>
</div>
<div id="accessory-desc">
<div id="vert-align">
<h3>{!! $accessory['accessory_name'] !!}</h3>
{!! $accessory['accessory_description'] !!}
</div>
</div>
<br class="clearall">
@endif

</div>
</div>
@endforeach

<div id="left">





<h2> {!! $results['query']['all_configurator_text2']['step_3'] !!}</h2>
<h3>{!! $results['query']['all_configurator_text2']['select_your_options_and_accessories'] !!}</h3>
{!! $results['query']['all_configurator_text2']['options_accessories_text'] !!}
</div>


<div id="right">

<div id="product-listing-title" style="height:25px;">
<div id="main" style="width:261px; float:left;"><img src="/imgs/standard.png"><em>{{ $results['snippet']['uu_features']}}</em></div> <!-- Uniquely Universal Features -->

<!-- Help link -->
<div id="learnmore"><a href="{{URL::to('products/configurator/help')}}">{{$results['snippet']['help']}}</a></div>
<br class="clearall">

</div>


<div class="scroll-pane">

@foreach($results['options'] as $key => $option)
<div id="options-listing">
<div id="system">
<a href="#">
<label>
	<div id="checkbox">
		<div id="vert-align">
			<input type="checkbox" name="{!! $option['link'] !!}" value="{!! $option['_id'] !!}|{!! $option['option_name'] !!}" id="id-{!! $option['link'] !!}"><br>
        </div>
 	</div>
 	<img src="{{getBaseUrl()}}/imgs/{!! $option['image_name'] !!}" alt="{!! $option['option_name'] !!}">
<div id="platform">
<div id="vert-align">
{!! $option['option_name'] !!}
<p></p>

</div>
</div>

<br class="clearall">
</label>
</a>
<br class="clearall">
</div>

<div id="uu">
<div id="uu1">
<div id="vert-align">
	<img src="/imgs/standard.png">
</div>
</div>
<br class="clearall">
</div>

<div id="learnmore"><a href="javascript:animatedcollapse.toggle('{!! $option['link'] !!}')">{!! $results['snippet']['more'] !!}</a></div>

<br class="clearall">

</div>
@endforeach

@foreach($results['accessories']['accessories_text'] as $accessory)
<div id="options-listing">
<div id="system">
<a href="#">
<label>
	<div id="checkbox">
		<div id="vert-align">
		@if(($accessory['all_links_configurator_accessories']['link'] == 'hpdfo') && (\Request::segment(4) == 'xls10mwh'))

			<input type="checkbox" name="{!! $accessory['all_links_configurator_accessories']['link'] !!}" value="{!! $accessory['_id'] !!}| {!! $accessory['accessory_name'] !!}" checked="checked" onclick="this.checked=!this.checked;" id="id-{!! $accessory['all_links_configurator_accessories']['link'] !!}">
		@else
			<input type="checkbox" name="{!! $accessory['all_links_configurator_accessories']['link'] !!}" value="{!! $accessory['_id'] !!}| {!! $accessory['accessory_name'] !!}" id="id-{!! $accessory['all_links_configurator_accessories']['link'] !!}">
		@endif
		<br>
        </div>
 	</div>
 	
 	<img src="{{getBaseUrl()}}/imgs/{!! $accessory['accessories_images']['image_name'] !!}" alt="{{$accessory['accessory_name']}}">

<div id="platform">
<div id="vert-align">
{{$accessory['accessory_name']}}
<p></p>

</div>
</div>

<br class="clearall">
</label>
</a>
<br class="clearall">
</div>

<div id="uu">
<div id="uu1">
<div id="vert-align">
@if($accessory['all_links_configurator_accessories']['uniquely_universal'] == 1)
	<img src="/imgs/standard.png">
@endif
</div>
</div>
<br class="clearall">
</div>

<div id="learnmore"><a href="javascript:animatedcollapse.toggle('{!! $accessory['all_links_configurator_accessories']['link'] !!}')">{!! $results['snippet']['more'] !!}</a></div>

<br class="clearall">

</div>
@endforeach

</div>



</div>

<br class="clearall">



</div>

<div id="bottom">
<div id="progress">

<div id="step1-on">{!! session('platform_interest') !!}</div>
<div id="step2-on">
	<?php 
		$wattages = session('power_laser1'); 

		if (session('power_laser1') && session('power_laser2')) $wattages .= ' | ';
		if (session('power_laser2')) $wattages .= session('power_laser2'); 
		if (session('power_laser2') && session('power_laser3')) $wattages .= ' | '; 
		if (session('power_laser3')) $wattages .= session('power_laser3'); 
		
		echo substr($wattages, 0, 34) . '...';
	?>
</div> 
<div id="step3-on">{!! $results['query']['all_configurator_text']['select_options_accessories'] !!}</div>
<div id="step4">{!! $results['query']['all_configurator_text2']['submit_configuration'] !!}</div>

</div>
<!--<div id="next"><a href="#">Continue ›</a></div>
<div id="back"><a href="#">‹ Back</a></div>-->
</div>
</form>
<script type="text/javascript">

	animatedcollapse.addDiv('help', 'fade=1, hide=1');
	animatedcollapse.addDiv('more', 'fade=1, hide=1');
	animatedcollapse.addDiv('superspeed', 'fade=1, hide=1');
	animatedcollapse.addDiv('pass-through', 'fade=1, hide=1');
	animatedcollapse.addDiv('hpdfo', 'fade=1, hide=1');
	animatedcollapse.addDiv('automation', 'fade=1, hide=1');
	animatedcollapse.addDiv('cutting-table', 'fade=1, hide=1');
	animatedcollapse.addDiv('rotary-fixture', 'fade=1, hide=1');
	animatedcollapse.addDiv('cc-air-assist', 'fade=1, hide=1');
	animatedcollapse.addDiv('back-sweep', 'fade=1, hide=1');
	animatedcollapse.addDiv('cone', 'fade=1, hide=1');
	animatedcollapse.addDiv('compressor', 'fade=1, hide=1');
	animatedcollapse.addDiv('traveling-exhaust', 'fade=1, hide=1');
	animatedcollapse.addDiv('pin-table', 'fade=1, hide=1');
	animatedcollapse.addDiv('air-assist', 'fade=1, hide=1');
	animatedcollapse.addDiv('air-cleaner', 'fade=1, hide=1');
	animatedcollapse.addDiv('dual-head', 'fade=1, hide=1');
	animatedcollapse.addDiv('collimator', 'fade=1, hide=1');
	animatedcollapse.addDiv('dessicant', 'fade=1, hide=1');
	animatedcollapse.addDiv('refrigerated', 'fade=1, hide=1');
	animatedcollapse.addDiv('camera-registration', 'fade=1, hide=1');
	animatedcollapse.addDiv('camera-registration', 'fade=1, hide=1');
	animatedcollapse.addDiv('camera-registration', 'fade=1, hide=1');
	animatedcollapse.addDiv('uacrendering', 'fade=1, hide=1');
	animatedcollapse.addDiv('fsrendering', 'fade=1, hide=1');
	animatedcollapse.addDiv('embeddepc', 'fade=1, hide=1');
	
	animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}
	
	animatedcollapse.init()

</script>
@endsection
