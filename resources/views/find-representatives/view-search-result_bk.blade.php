@extends('app')
@section('title')
    Find Representative by Address
@stop
@section('content')
<div class="wrap-branch" ng-controller="BaseController">
    <div class="top-content">
        <label class="c-m">Find Representative by Address</label>
    </div>
	<section class="wrap-result-search">
	    	<div class="col-sm-12 col-md-8 col-lg-9 box-maps">
	    		<form method="POST" accept-charset="UTF-8" action="/find-by-address">
					<div class="input-group input-search">
						<input class="form-control" type="text" name="address" placeholder="Enter your address, city, and postal code for best results…" id="address" maxlength="200" size="60" value="{{$address}}">
						<span class="input-group-addon">
							<button style="background: transparent;border: none; padding: 0px;"  type="submit">
								<i class="ti-search"></i>
							</button>
						</span>
					</div>
				</form>
				@if(empty($results) || (isset($results) && $results[0]['cpInfo']['channel_partner_id'] == 62501 && count($results) == 1))
					<div class="no-result">
						<div class="alert alert-danger">
						  <strong>No results found in your area !</strong> Please try your search again with more specific terms.
						</div>
						<p>For example, if you entered the name of a state, try entering the name of a city as well. If you are still unable to find a local representative using your location, please 
						<a lang="en-us" href="#">contact us</a>
						so we can help you find the best representative to fit your needs.
						</p>
					</div>
				@else
					<div id="load-maps">
						

					</div>
				@endif
	    	</div>
	    	@if(!empty($results))
		    	<div class="col-sm-12 col-md-4 col-lg-3 box-list-rep">
		    		@foreach($results as $key => $item)
					<div id="support">
						<h2>
						    <img src="{{URL::to("")}}/images/google-icon.png" alt="ULS">
						    <a href="http://www.{{$item['cpInfo']['location']['channel_partner_tld']}}/cp/en/{{$item['cpInfo']['location']['name_url']}}/{{$item['cpInfo']['location']['location_url']}}">
						    	{{$item['cpInfo']['company']}}
						    </a>
						</h2>
						<div id="tabs-text">
							<h3>{{$item['cpInfo']['location']['city']}} Office</h3>
						    <p>
							    {{$item['cpInfo']['location']['address_1']}}
							    @if(!empty($item['cpInfo']['location']['address_2']))
							    	<br />{{$item['cpInfo']['location']['address_2']}}
							    @endif
							    <br />{{$item['cpInfo']['location']['city']}}, {{$item['cpInfo']['location']['state']}} {{$item['cpInfo']['location']['zip']}}
							    <br /> {{$item['cpInfo']['location']['country']}}
						    </p>
						    @if(!empty($item['miles']) && !empty($item['km']))
							<span id="distance">Distance to Channel Partner:  <br><strong>{{$item['miles']}} miles</strong> <em>{{$item['km']}} km</em></span>
							@endif
						</div>
						<div id="learnmore" class="text-right">
							<a href="">Contact Us</a> <a>|</a> <a href="#">Request a Quote</a>
						</div>
					</div>
					@endforeach
		    	</div>
	    	@endif
	    	<div class="clearfix"></div>
	</section>
</div>
@stop
@section('script')
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&language=en"></script>
	<script type="text/javascript">
		window.options = [];
	</script>
	@if(empty($results) || (isset($results) && $results[0]['cpInfo']['channel_partner_id'] == 62501 && count($results) == 1))
		<script type="text/javascript"></script>
	@else
		<script type="text/javascript">

			function initialize()
			{
				var locations = [
						<?php 
							$location = '';

							foreach($results as $key => $item) {

								$location .= '[' . $item['coordinates']['latitude'] . ', ' . $item['coordinates']['longitude'] . '], ';

							}
							echo substr($location, 0, -2); 
						?>
					];

				var cp = [
						<?php 
							$channelPpartner = '';

							foreach ($results as $key => $cp) {

								$channelPpartner .= '["' . $cp['cpInfo']->company . '", "' . $cp['cpInfo']['location']['address_1'] . '", "' .$cp['cpInfo']['location']['address_2'] . '", "' . $cp['cpInfo']['location']['city'] . '", "' . $cp['cpInfo']['location']['state'] . '", "' . $cp['cpInfo']['location']['zip'] . '", "' . $cp['cpInfo']['location']['phone_1'] .  '", "' . 'cp/' . $cp['cpInfo']['location']['language_code'] . '/' . $cp['cpInfo']['location']['name_url'] . '/' . $cp['cpInfo']['location']['location_url'] . '"], ';	
							}
							echo substr($channelPpartner, 0, -2);	
						?>
						];

				var map = new google.maps.Map(document.getElementById('load-maps'), {

					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
			
				var infowindow = new google.maps.InfoWindow();
				var uls = 'http://www.ulsinc.com/imgs/google-icon.png';
				var marker, i;
				
				if (locations.length > 1) { 
					var bounds = new google.maps.LatLngBounds();
					for (i = 0; i < locations.length; i++) {  
						marker = new google.maps.Marker({
							position: new google.maps.LatLng(locations[i][0], locations[i][1]),
							map: map,
						    icon: uls
						});
						
						//Extends bounds to contain marker position
						bounds.extend(marker.getPosition());
						
						google.maps.event.addListener(marker, 'click', (function(marker, i) {
							return function() {
								infowindow.setContent(infowindowContent(cp[i][0], cp[i][1], cp[i][2], cp[i][3], cp[i][4], cp[i][5], cp[i][6], cp[i][7]));  // company, address, city, state, zip, phone, website
							  	infowindow.open(map, marker);
							}
						})(marker, i));
					}
					
					map.fitBounds(bounds);
				} else {
					var myOptions = {
		          		scaleControl: true,
		          		center: new google.maps.LatLng(locations[0][0], locations[0][1]),
		          		zoom: 14,
		          		mapTypeId: google.maps.MapTypeId.ROADMAP
		         		};

		       		var map = new google.maps.Map(document.getElementById('load-maps'), myOptions);
					
					var marker = new google.maps.Marker({
		          		position: new google.maps.LatLng(locations[0][0], locations[0][1]),
						map: map,
						icon: uls
		       	 	});

					infowindow.setContent(infowindowContent(cp[0][0], cp[0][1], cp[0][2], cp[0][3], cp[0][4], cp[0][5], cp[0][6], cp[0][7]));

					infowindow.open(map, marker);
				}
			}

			function infowindowContent(company, address, address2, city, state, zip, phone, website)
			{
				var html  = '<div class="info-bubble"><h3><a target="_blank" href="' + website + '">' + company + '</a></h3>';
				html += '<p>' + address + '</p>';
		        html += '<p>' + address2 + '</p>';
				html += '<p>' + city + ' ' + state + ' ' + zip + '</p>';
				html += '<p><strong>' + phone + '</strong></p></div>';
				
				return html;
			}
			
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	@endif
	@if(!isProduction() && !isDev())
        {!! Html::script('app/components/data-option/dataOptionController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/data-option/dataOptionService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/dataoption.js') }}"></script>
    @endif
@stop
