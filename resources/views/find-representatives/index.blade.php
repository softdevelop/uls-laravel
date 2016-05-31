@extends('universal')
@section('content')
<script>
	$(function() {
		$('#address').focus(function() {
			$('#address').val('');
		});
	});
</script>

<div id="pagetitle">
	<div id="page-wrap">
	<!-- Select Country or Region -->
	<h1>Find Representative by Address<br> 

	<!-- Choose your country and language. -->
	<span id="subtitle">Locate a representative in your area</span></h1>

	</div>
	</div>

	<div id="page-wrap">

	<div id="column-main" >

	<div id="search">

	<h2>Search by address for a representative in your area.</h2>

	<form action="{{URL::to('find-by-address')}}" method="post" accept-charset="utf-8">
	<input type="text" name="address" value="Enter your address, city, and postal code for best results…" id="address" maxlength="200" size="60"  />

	<div id="submit">
		<input type="submit" name="submit" value="Search"  />
	</div>

	</form>
	<br class="clearall">


	<div id="find-by-address">
	<p>
	Universal Laser Systems has many global representatives. If you cannot find one based on your location, please  <a lang="en-us" href="http://local.ulsinc.com/contact-us/">contact us</a> so we can help you find the best representative to fit your needs.</p>
	</div>


	</div>

</div>



<br class="clearall">

</div>
    
</div>
@endsection