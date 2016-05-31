@extends('configurator')
@section('content')
<div id="title">
<h1>{!! $results['snippet']['help'] !!}</h1>

<div id="next">
<a hreflang="en-us" href="{{session('uri')}}">‹ {!! $results['snippet']['back'] !!}</a></div>

<br class="clearall">
</div>

<div id="page-wrap" class="step2">

<div id="main">
<div id="help">
<?php 
	$universal = $results['expert']['contact']; 
	$vowels = array('A', 'E', 'I', 'O', 'U');
?>
<h3>{!! $universal !!}</h3>

<p>{!! $results['expert']['questions'] !!}</p>

<div id="line"></div>
<form action="{{URL::to('products/configurator/help')}}" method="post" accept-charset="utf-8">
<div id="contact-form">
<p id="req" style="font-size:12px; font-weight:bold;">{{session('thanks')}}</p>
<div>
        <p>
            <label>{!! $results['contact_form']['first_name_required'] !!}</label><br>
            <input type="text" name="FName" value="" maxlength="19">
        </p>
    
        <p>
        
            <label>{!! $results['contact_form']['last_name_required'] !!}</label><br>
            <input type="text" name="LName" value="" maxlength="30">
        </p>

        <p>
            <label>{!! $results['contact_form']['email_address_required'] !!}</label><br>
            <input type="text" name="EmailAddr" value="" maxlength="80">

        </p>
	  
	    
	<p>
		<label>{!! $results['contact_form']['phone_number'] !!}</label><br>
		<input type="text" name="Phone" value="" maxlength="30">
	</p>
    
</div>
<div>

	<p>
		<label>{!! $results['contact_form']['questions_comments'] !!}</label><br>
		<textarea name="GeneralNotes" cols="40" rows="10"></textarea>
	</p>
    
    <p class="submit"><input type="submit" name="submit" value="{{$results['contact_form']['send_message']}}"></p>

</div>


<div>

    <div id="contactinfo"><img src="http://www.ulsinc.com/imgs/telephone.png"><strong>(800) 859-7033</strong> {!! $results['contact_form']['sales'] !!}</div>
    <div id="contactinfo"><img src="{{getBaseUrl()}}/imgs/telephone.png"><strong>+1 480-609-0297 </strong> {!! $results['contact_form']['support'] !!}</div>
    

  
</div>
<br class="clearall">

</div>
</form>
<br class="clearall">

<div id="line"></div>

</div>




</div>

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