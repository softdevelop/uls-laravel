
@extends('configurator')
@section('content')

<div id="title">
<h1>{!! session('platform_interest') !!} | {!! $results['thank_you']['title'] !!}</h1>
<!--<div id="next"><form action="step2.html"><input type="submit" value="Continue ›"></form></div>-->

<br class="clearall">
</div>
<div id="page-wrap">


<div id="left">

<!-- Thank you -->
<h2>{!! $results['thank_you']['title'] !!}</h2>
<!-- Your message has been sent -->
<h3>{!! $results['thank_you']['subtitle'] !!}</h3>
<p>{!! $results['thank_you']['will_be_in_touch'] !!}</p>

<div id="product-main">
<?php
	if (session('platform') != 'pls6150d-superspeed')
		$image = session('platform');
	else 
		$image = 'pls6150';
?>
<img src="{{getBaseUrl()}}/imgs/products/<?php echo $image ?>.jpg">
<div id="uu">
<div id="specs"><h2>{{session('platform_interest')}}</h2></div>

<div id="specs"><h3>{!! $results['snippet']['laser_power'] !!}</h3>

<?php 
	if ( isset($_COOKIE['dual_laser_configuration']) &&  $_COOKIE['dual_laser_configuration'] == 1)
	{
		$laser1_text = session('laser1_en') . '<br/>';
		echo $laser1_text;
		if (session('laser2_en'))
		{
		  $laser2_text =  session('laser2_en') . '<br/>'; 
		  echo $laser2_text; 
		}
		else
		{
		  echo $results['snippet']['laser2_not_configured'] . '<br/>';
		}
	}
	else
	{
		/*if ($this->session->userdata('laser2_en'))
			$laser2 = $this->session->userdata('laser2_en') . '<br/>';
		else 
			$laser2 = '<br/>';*/
		echo session('power_laser1') . '<br/>';
		echo session('power_laser2') . '<br/>';	
		/*if ($this->session->userdata('laser1_en'))
		{
			$laser1_text = $this->session->userdata('laser1_en') . '<br/>';
			echo $laser1_text;
		}
		if ($this->session->userdata('laser2_en'))
		{
			$laser2_en = $this->session->userdata('platform_interest');
			if ($laser2_en == 'pls6mw' && $laser2_en != 'null')
			{
				echo $this->session->userdata('laser2_en') . '<br/>';	
			}
			else
			{	
				$this->session->set_userdata('laser2_en', '');
			}
		}*/
	}
	
	/*if ($this->session->userdata('laser3_en') != '') 
	{
		if ($this->session->userdata('laser1_en') && $this->session->userdata('laser2_en'))
			$laser3 = $this->session->userdata('laser3_en') . '<br/>';
		elseif ($this->session->userdata('laser3_en'))
			$laser3 = $this->session->userdata('laser3_en');
		else 
			$laser3 = '<br/>';
			
		
		$laser3_text = $laser3 . '<br/>';
		echo $laser3_text;
	}*/
	

   if ( isset($_COOKIE['dual_laser_configuration']) && $_COOKIE['dual_laser_configuration'] == 1)
	  echo $results['query']['all_configurator_text']['configured_for_dual_laser'];
?>

</div>


</div>
<br class="clearall">

<div id="overview">
<h3>{!! $results['query']['all_configurator_text']['options_accessories'] !!}</h3>
<?php
	if ( session('accessories') != '' || session('options') != '')
	{
		echo session('options');
		if ( session('options')  != '') echo ', ';
		echo session('accessories');
	}
	else
	{
		echo $results['snippet']['no_options_accessories_chosen']; 	
	}
?></div>

<br class="clearall">

<div id="learnmore">
<a href="{{getBaseUrl()}}/downloads/spec-sheets/XLS_Platform.pdf" target="_blank">{!! $results['snippet']['download'] !!}</a>
</div>

</div>





</div>

<div id="right">

<div id="vert-align">
<div id="big-button"> <a href="{{URL::to('products/configurator/platforms')}}"><img src="{{getBaseUrl()}}/imgs/right-arrow.png">{!! $results['snippet']['configure_another_laser_system'] !!}</a></div>
</div>
</div>

<br class="clearall">



</div>

<div id="bottom">
<div id="progress">
<div id="step1-on">{!!  $results['query']['all_configurator_text2']['select_platform'] !!}</div>
<div id="step2-on">{!! $results['query']['all_configurator_text']['select_laser_power'] !!}</div>
<div id="step3-on">{!! $results['query']['all_configurator_text']['select_options_accessories']  !!} </div>
<div id="step4-on"> {!! $results['query']['all_configurator_text2']['submit_configuration']  !!}</div>
</div>
<!--<div id="next"><a href="#">Continue ›</a></div>
<div id="back"><a href="#">‹ Back</a></div>-->
</div>

<script type="text/javascript">

	animatedcollapse.addDiv('help', 'fade=1, hide=1');
	animatedcollapse.addDiv('more', 'fade=1, hide=1');
	animatedcollapse.addDiv('ils975', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls6mw', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls6150d-ss', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls6150d', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls675', 'fade=1, hide=1');
	animatedcollapse.addDiv('pls475', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls660', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls460', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls360', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls350', 'fade=1, hide=1');
	animatedcollapse.addDiv('vls230', 'fade=1, hide=1');	
	
	animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}
	
	animatedcollapse.init()

</script>
@endsection