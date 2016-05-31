@extends('configurator')
@section('content')
<style>
.find-representative .scroll-pane #product-listing #system, .configure .step2 .scroll-pane #product-listing #system{float:left !important;}
.find-representative .scroll-pane #product-listing #learnmore, .configure .step2 .scroll-pane #product-listing #learnmore{padding:30px 10px; border-bottom:1px dotted #CCCCCC; border-left:1px dotted #CCCCCC; width:100px;}
.find-representative .scroll-pane #product-listing  img, .configure .step2 .scroll-pane #product-listing img{border-bottom:1px dotted #CCCCCC;}
.find-representative .scroll-pane #product-listing .clearall, .configure .step2 .scroll-pane #product-listing .clearall{display:none;}
</style>

<script type="text/javascript">

	animatedcollapse.addDiv('ils1275', 'fade=1, hide=1');
	animatedcollapse.addDiv('ils975', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls6150d_ss', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls6150d', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls675', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls475', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls6mw', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls660', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls460', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls360', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls350', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls230', 'fade=1, hide=1');
	animatedcollapse.addDiv('xls10150d', 'fade=1, hide=1');
	animatedcollapse.addDiv('xls10mwh', 'fade=1, hide=1');
		
	animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}
	
	animatedcollapse.init()
 
</script>
<div id="title">
<h1>{!! $results['select']['all_configurator_text2']['select_your_laser_platform'] !!}</h1>

<div id="next"><a href="{{URL::to('products/configurator/select-platform')}}">‹ {!! $results['snippet']['back'] !!}</a></div>

<br class="clearall">
</div>

<div id="page-wrap" class="step2">

<div id="main">

@foreach ($results['query']['all_platforms'] as $key => $value)
<div id="{{$value['lasers']['link']}}">
<div id="close"><a title="close" id="change" onClick="changeText(this);" href="javascript:animatedcollapse.toggle('{{$value['lasers']['link']}}')"><img src="{{getBaseUrl()}}/imgs/close.png" alt="close"></a></div><br class="clearall">
<div id="product-main">
<div id="overview">
<img src="{{getBaseUrl()}}/imgs/products/{{ $value['lasers']['image'] }}.jpg" alt="{{strip_tags($value['title'])}}">

<div id="specs"><h3>{!! $value['title'] !!}</h3></div>

<div id="specs"><h3>{!! $results['snippet']['work_area'] !!}</h3>{!! $value['work_area'] !!}</div>

<div id="specs"><h3>{!! $results['max_options']['max_part_size'] !!}</h3>{!! $value['spec']['part_size_text'] !!}</div>

<div id="specs"><h3>{!! $results['max_options']['laser_options'] !!}</h3><strong>{!! $value['spec']['options_text'] !!}</strong>

<br/>{!! @$value['spec']['dual_laser_optional'] !!}</div>

</div> 
<!-- Uniquely Universal Features --> 
<div id="uu">
<!--<h3><?php //echo $query[$i][0]['title']; ?> <?php //echo $work_platform->platform_overview; ?></h3>-->


{!! $value['overview'] !!}

</div>


<br class="clearall" />

</div>

<p></p>


<div id="line"></div>

</div>
@endforeach


<div id="product-listing-title">

<div id="platform">{!! $results['snippet']['laser_platform'] !!}</div>
<div id="workarea">{!! $results['snippet']['work_area'] !!}</div>
<div id="workarea">{!! $results['snippet']['laser_power'] !!}</div>
<!-- Help link -->
<br class="clearall">

</div>

<div class="scroll-pane">

@foreach ($results['query']['all_platforms'] as $key => $value)
<div id="product-listing">

<div id="system">
<a href="{{URL::to('products/configurator/select-power/'.$value['lasers']['full_link'])}}">

	<img src="{{getBaseUrl()}}/imgs/products/{{$value['lasers']['image']}}.jpg" alt="{{strip_tags($value['title'])}}">
	<div id="platform">
		<div id="vert-align">
			{!! $value['title'] !!}
        </div>
 	</div>
		<div id="workarea">			
        <div id="vert-align">
			<p>{!! $value['work_area'] !!}</p>
        </div>
        </div>
    
    <div id="power">
	<div id="vert-align">
	<dl>
		<dt>{!! $results['select']['all_configurator_text']['single_laser_configuration'] !!}</dt>

	     <dd>{!! $value['lasers']['sl_10'] !!}</dd>	     
         <dd>{!! $value['lasers']['sl_25'] !!}</dd>	     
         <dd>{!! $value['lasers']['sl_30'] !!}</dd>	     
         <dd>{!! $value['lasers']['sl_40'] !!}</dd>	     
         <dd>{!! $value['lasers']['sl_50'] !!}</dd>	     
         <dd>{!! $value['lasers']['sl_60'] !!}</dd>	     
         <dd>{!! $value['lasers']['sl_75'] !!}</dd>		
	</dl>
	<br class="clearall">
	
	@if(isset($value['lasers']['dl_20']))

        <dl>
            <dt>{!! $results['select']['all_configurator_text']['dual_laser_configuration'] !!}</dt>
            <dd>{!! $value['lasers']['dl_20'] !!}</dd>		
            <dd>{!! $value['lasers']['dl_50'] !!}</dd>		
            <dd>{!! $value['lasers']['dl_60'] !!}</dd>		
            <dd>{!! $value['lasers']['dl_80'] !!}</dd>		
            <dd>{!! $value['lasers']['dl_100'] !!}</dd>		
            <dd>{!! $value['lasers']['dl_120'] !!}</dd>		
            <dd>{!! $value['lasers']['dl_150'] !!}</dd>			
        </dl>
    @endif

    @if(isset($value['lasers']['nine_30']))
    	<dl>
            <dt>{!! $results['select']['all_configurator_text']['nine_three_configuration'] !!}</dt>
            <dd>{!! $value['lasers']['nine_30'] !!}</dd>
            <dd>{!! $value['lasers']['nine_50'] !!}</dd	
        ></dl>
    @endif

   
    @if(isset($value['lasers']['fl_30']))
    <br class="clearall">
    	<dl>
    	 <dt>{!! $results['select']['all_configurator_text']['one_oh_six_configuration'] !!}</dt>
            <dd>{!! $value['lasers']['fl_30'] !!}></dd>	
            <dd>{!! $value['lasers']['fl_40'] !!}</dd>
        </dl>
    @endif
 
	<br class="clearall">
		</div>
	</div>    
	
	<br class="clearall">
</a>
</div>
<div id="learnmore"><a href="javascript:animatedcollapse.toggle('{{$value['lasers']['link']}}')">{{$results['snippet']['learn_more']}}</a></div>
<br class="clearall">
</div>
@endforeach
</div>
</div>
</div>

<div id="bottom">
<div id="progress">
<div id="step1-on">{{$results['select']['all_configurator_text2']['select_platform']}}</div>
<div id="step2"> {{$results['select']['all_configurator_text']['select_laser_power']}}</div>
<div id="step3">{{$results['select']['all_configurator_text']['select_options_accessories']}}</div>
<div id="step4">{{$results['select']['all_configurator_text2']['submit_configuration']}}</div>
</div>
</div>

@endsection