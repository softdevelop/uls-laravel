@extends('Standard Body')
@section('content')


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

				var map = new google.maps.Map(document.getElementById('map-canvas'), {

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

		       		var map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);
					
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

	<!-- start content block -->
    <div id="content">
        <!-- start box header with background red -->
        <section class="divider header-title red">
            <div class="container">
                <div class="wrap-title">
                    <h3 class="text-white">Find A Representative</h3>
                    <h5 class="text-white">Locate a representative in your area</h5>
                </div>
                <div class="wrap-image">
                    <img src="images/contact/map_opacity.png">
                </div>
            </div>
        </section>
        <!-- the end -->
        <!-- start box search top -->
        <section class="search-bar">
            <div class="container">
                <div class="box-search">
                	<form action="{{URL::to('find-by-address')}}" method="post" accept-charset="utf-8">
						<p>
                        	Search by address for a representative in your area.
	                    </p>
	                    <input type="text" name="address" value="{{$address}}" maxlength="200" size="60" class="form-control border-black" placeholder="Search...">
	                    <button class="btn btn-default btn-black">Search</button>

					</form>
                </div>
                <div class="wrap-image">
                    <img src="images/find-representavi/map_search_bar.png">
                </div>
            </div>
        </section>
        <!-- the end -->
        <!-- start box load map and list loction -->
        <section class="map-content">
            <div class="container">
                <div class="col-md-8 map">
                	@if(empty($results) || (isset($results) && $results[0]['cpInfo']['channel_partner_id'] == 62501 && count($results) == 1))
	                    <p class="top">
	                        Universal Laser Systems has many global representatives. If you cannot find one based on your location, please <span class="text-red">contact us</span> so we can help you find the best representative to fit your needs.
	                    </p>
                    @else
                    	<p class="top">
	                    </p>
	                    <div class="box-map">
	                        <div id="map-canvas"></div>
	                    </div>
	                @endif
                </div>
                @if(!empty($results) || (!isset($results) && $results[0]['cpInfo']['channel_partner_id'] != 62501 && count($results) != 1))
                	<div class="col-md-4 list-location" style="border: 1px solid #bebebe;">
	                    <h3 style="text-align:center">Global Locations</h3>
	                    @foreach($results as $key => $item)
	                		<article class="location">
		                        <img src="{{getBaseUrl()}}/imgs/google-icon.png" alt="ULS">
		                        <h4>{{$item['cpInfo']['location']['city']}}</h4>
		                        <p>{{$item['cpInfo']['location']['address_1']}}
								    @if(!empty($item['cpInfo']['location']['address_2']))
								    	<br />{{$item['cpInfo']['location']['address_2']}}
								    @endif
								    <br />{{$item['cpInfo']['location']['city']}}, {{$item['cpInfo']['location']['country']}}
							    </p>

							    <p>{{$item['cpInfo']['location']['phone_1']}}
								    @if(!empty($item['cpInfo']['location']['phone_2']))
								    	<br />{{$item['cpInfo']['location']['phone_2']}}
								    @endif
							    </p>

								<p> 
								    @if(!empty($item['email']))
									    {{$item['email']}}
									@endif
							    </p>
		                    </article>
	                	@endforeach
	                </div>
	                <div class="claerfix"></div>
                @endif
	                
            </div>
        </section>
        <!-- the end -->
    </div>
    <!-- the end block content -->
@stop
<!-- script -->
<script src="scripts/vendor.f5fa505b.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
<script src="scripts/plugins.bde8e777.js"></script>
<script src="scripts/main.8760756f.js"></script>
<!-- the end -->
