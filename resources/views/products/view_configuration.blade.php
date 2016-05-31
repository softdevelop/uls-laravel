
@extends('configurator')
@section('content')


<div id="title">
<h1>
<?php $errors =  $errors->getMessages(); 
?>
{!! session('platform_interest') !!} | {!! $results['query']['all_configurator_text2']['submit_your_configuration'] !!}
</h1>


<div id="next"><a href="{{URL::to('products/configurator/options-accessories/'.\Request::segment(4))}}">‹ {!! $results['snippet']['back'] !!}</a></div>

<br class="clearall">
</div>

<div id="page-wrap">


<div id="left">

<h2>{!! $results['query']['all_configurator_text2']['step_4'] !!}</h2>
<h3>{!! $results['query']['all_configurator_text2']['submit_your_configuration'] !!}</h3>
<p>{!! $results['query']['all_configurator_text2']['fill_out_form_below'] !!}</p>

<div id="product-main">
@if(session('platform') != 'pls6150d-superspeed')
	<?php $image = session('platform'); ?>
@else
	<?php $image = 'pls6150'; ?>
@endif
<img src="{{getBaseUrl()}}/imgs/products/xls10mwh.jpg" alt="{{session('platform_interest')}}">
<div id="uu">
<div id="specs">
<h2>
	{{session('platform_interest')}}
</h2>
</div>

<div id="specs"><h3>{!! $results['snippet']['laser_power'] !!}</h3>

@if( isset($_COOKIE['dual_laser_configuration']) && $_COOKIE['dual_laser_configuration'] == 1)
	{!! session('laser1_en') !!}<br/>
	@if(session('laser2_en'))
		{!! session('laser2_en') !!}<br/>
	@else
		{!! $results['snippet']['laser2_not_configured'] !!}
	@endif
@else
	{!! session('power_laser1') !!}<br/>
	{!! session('power_laser2') !!}<br/>
	@if(session('power_laser3'))
		{!! session('power_laser3') !!}
	@elseif(\Request::segment(4) == 'xls10mwh')
		{!! str_replace('2', '3', $results['snippet']['laser2_not_configured']) !!}
	@endif
@endif

@if( isset($_COOKIE['dual_laser_configuration']) && $_COOKIE['dual_laser_configuration'] == 1)
	{!! $results['snippet']['configured_for_dual_laser'] !!}
@endif
	<?php $wattages = session('laser1_en'); ?>
	@if(session('laser2_en'))
		<?php $wattages .= ' | ' . session('laser2_en') ?>
	@endif
	@if(session('laser3_en'))
		<?php $wattages .= ' | ' . session('laser3_en') ?>
	@endif
	<?php session('wattages', $wattages); ?>
</div>

</div>
<br class="clearall">

<div id="overview">
<h3> {!! $results['query']['all_configurator_text']['options_accessories'] !!}</h3>
<?php
		$string = '';
		session('options', '');
		session('accessories', '');

		// build session variables for options and accessories 
		foreach ($results['post_array'] as $post) {
			if ($post != '') {
				$string =  $post . ', ' . $string;
				if (in_array($post, $results['options_array'])) {
					if (session('options') != '') {
						$options = session('options') . ', ' . $post;
						session('options', $options);
					} else {
						session('options', $post);
					}
				}
				if (in_array($post, $results['accessories_array'])) {
					if (session('accessories') != '') {
						$options = session('accessories') . ', ' . $post;
						session('accessories', $options);
					} else {
						session('accessories', $post);
					}
				}
			} 
		}
		
		if ($string == '') {
			echo  $results['snippet']['no_options_accessories_chosen'];
		} else {
			$acc = substr($string, 0, -2);
			echo $acc;
			session(['accessories' => $acc]);
		}
	
	?>
</div>

</div>




</div>


<div id="right">

<div class="scroll-pane" style="height:415px;">
<form action="{{URL::to('products/configurator/view-configuration-form/'.\Request::segment(4))}}" method="post" accept-charset="utf-8">
<div id="contact-form">
  	<p style="float: left;">
        <label>{!! $results['contact_form']['first_name_required'] !!}</label><br>
        <input type="text" name="FName" value="" maxlength="19" style="width: 135px;">
    </p>
    @if(count($errors) && count($errors['FName']))
    <div class="error">{!! $errors['FName'][0] !!}</div>
    <p></p>
    @endif
    <p>
        <label>{!! $results['contact_form']['last_name_required'] !!}</label><br>
        <input type="text" name="LName" value="" maxlength="30" style="width: 135px;">

    </p>
     @if(count($errors) && count($errors['LName']))
     <div class="error">{!! $errors['LName'][0] !!}</div>
    <p></p>  
    @endif 
	<p style="float: left;">
		<label>{!! $results['contact_form']['email_address_required'] !!}</label><br>
		<input type="text" name="EmailAddr" value="" maxlength="80" style="width: 135px;">

	</p>
	@if(count($errors) && count($errors['EmailAddr']))
    <div class="error">{!! $errors['EmailAddr'][0] !!}</div>
    <p></p>
    @endif 
    <p>
                <label>{!! $results['contact_form']['city'] !!} </label><br>
                <input type="text" name="City" value="" maxlength="30" style="width: 135px;">

            </p>

            <p style="float: left;">
                <label>{!! $results['contact_form']['country'] !!}</label><br>
                <input type="text" name="Country" value="" maxlength="30" style="width: 135px;">

            </p>

            <p>
                <label>{!! $results['contact_form']['state_province'] !!}</label><br>
                <input type="text" name="State" value="" maxlength="30" style="width: 135px;">

            </p>

            <p style="float: left;">
		<label>{!! $results['contact_form']['phone_number'] !!}</label><br>
		<input type="text" name="Phone" value="" maxlength="30" style="width: 135px;">
	     
	</p>
    
	<p>
		<label>{!! $results['contact_form']['company_school'] !!}</label><br>
		<input type="text" name="Company" value="" maxlength="60" style="width: 135px;">
	    
	</p>
 
    
	<p>
		<label>{!! $results['contact_form']['questions_comments'] !!}</label><br>
		<textarea name="GeneralNotes" cols="40" rows="10"></textarea>
	     
	</p>
    
   <p class="submit">
   <input type="submit" name="submit" value="{!! $results['contact_form']['pricing_information'] !!}">
   </p>
    
            <br style="clear:both;">
</div>
</form>
</div>
</div>

<br class="clearall">



</div>

<div id="bottom">
<div id="progress">
<div id="step1-on">{!! session('platform_interest') !!}</div>
<div id="step2-on">
	<?php
		$laze1 = session('power_laser1');
		$laze2 = ' | ' . session('power_laser2');
		
		echo (strlen($laze1) < 30) ? $laze1 : substr($laze1, 0, 30) . '...';
		if ($laze2) {
			echo (strlen($laze2) < 30) ? $laze2 : substr($laze2, 0, 30) . '...';
		}
	?>
</div> 
<div id="step3-on">
@if($string == '')
	{!! $results['snippet']['no_options_accessories_chosen'] !!}
@else
	{{substr($string, 0, 30) . '...'}}
@endif
	
</div>
<div id="step4-on">{!! $results['query']['all_configurator_text2']['submit_configuration'] !!}</div>
</div>
</div>
@endsection

