@extends('configurator')
@section('content')

	<form action="{{URL::to('products/configurator/select-wattage-xls10mwh-form/xls10mwh')}}" method="post" accept-charset="utf-8">
	<div id="title">
		<h1>XLS10MWH | {!! $results['query']['all_configurator_text2']['select_your_laser_power'] !!}</h1>

		<div id="next">
			<input type="submit" name="submit" value="{{$results['snippet']['continue']}} ›"  />
		</div>
		<div id="back">
			<a href="{{URL::to('products/configurator/select-power/xls10mwh')}}">‹ {{$results['snippet']['back']}}</a>
		</div>

		<br class="clearall">
	</div>

	<div id="page-wrap">


		<div id="left">





			<p>{{$results['query']['all_configurator_text2']['overview_xls10mwh']}}
				<br>


			</p>


			<div id="product-listing-title">

				<div id="column">{!! $results['query']['all_configurator_text2']['one_oh_six'] !!}</div>
				<div id="learnmore"><a href="javascript:animatedcollapse.toggle('fiber')">{{$results['snippet']['learn_more']}}</a></div>
				<br class="clearall">

			</div>

			<div id="fiber">
				<p>{{$results['query']['all_configurator_text2']['materials_fiber_xls10mwh']}} </p>
			</div>

			<div id="column">

				@foreach($results['laseronea'] as $key => $laser1a)
				<div id="power-listing" class="enable">
					<div id="system">
						<a href="#">
							<label>
								<div id="radio">
									<div id="vert-align">
										@if($laser1a['power_level'] == '40 watts')
										<input type="radio" name="laser1" value="{{$laser1a['power_id']}}|{{$laser1a['power_level']}}|1.06 µm" checked="checked"  />
									@else
										<input type="radio" name="laser1" value="{{$laser1a['power_id']}}|{{ $laser1a['power_level']}}|1.06 µm" />
									@endif
									</div>
								</div>
								<div id="platform">
									<div id="vert-align">
									{{$laser1a['power_level']}}
									</div>
								</div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
				@endforeach
			</div>

			<div id="column">
				@foreach ($results['laseroneb'] as $key => $laser1b)

				<div id="power-listing" class="enable">
					<div id="system">
						<a href="#">
							<label>
								<div id="radio">
								<div id="vert-align"><input type="radio" name="laser1" value="{{$laser1b['power_id']}}|{{$laser1b['power_level']}}|1.06 µm"  />
								</div>
								</div>
								<div id="platform"><div id="vert-align">{{$laser1b['power_level']}}</div></div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
			@endforeach

			</div>



			<br class="clearall">

			<div id="product-listing-title">

				<div id="column">{!! $results['query']['all_configurator_text2']['ten_six'] !!}</div>
				<div id="learnmore"><a href="javascript:animatedcollapse.toggle('co2-10')"> {{ $results['snippet']['learn_more']}}</a></div>
				<br class="clearall">

			</div>

			<div id="co2-10">
				<p>{{ $results['query']['all_configurator_text2']['materials_106_xls10mwh'] }}</p>
			</div>

			<div id="column">
				@foreach ($results['lasertwoa'] as $laser2a)
				<div id="power-listing" class="enable" style="height: 20px;">
					<div id="system" style="height: 23px;">
						<a href="#">
							<label style="height: 25px;">
								<div id="radio"><div id="vert-align">
								<input type="radio" name="laser2" value="{{$laser2a['power_id']}}|{{$laser2a['power_level']}}|10.6 µm"  />
								</div></div>
								<div id="platform"><div id="vert-align">{{$laser2a['power_level']}}</div></div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
			@endforeach

			@foreach ($results['lasertwob'] as $laser2b)
				<div id="power-listing" class="enable" style="height: 20px;">
					<div id="system" style="height: 23px;">
						<a href="#">
							<label style="height: 25px;">
								<div id="radio"><div id="vert-align"><input type="radio" name="laser2" value="{{$laser2b['power_id']}}|{{$laser2b['power_level']}}|10.6 µm"  />
</div></div>
								<div id="platform"><div id="vert-align">{{$laser2b['power_level']}}</div></div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
			@endforeach

			</div>


			<div id="column">
				@foreach ($results['lasertwoa'] as $laser2a)
				<div id="power-listing" class="enable" style="height: 20px;">
					<div id="system" style="height: 23px;">
						<a href="#">
							<label style="height: 25px;">
								<div id="radio"><div id="vert-align"><input type="radio" name="laser3" value="{{$laser2a['power_id']}}|{{$laser2a['power_level']}}|10.6 µm"  />
</div></div>
								<div id="platform"><div id="vert-align">{{$laser2a['power_level']}}</div></div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
			@endforeach

				@foreach ($results['lasertwob'] as $laser2b)
				<div id="power-listing" class="enable" style="height: 20px;">
					<div id="system" style="height: 23px;">
						<a href="#">
							<label style="height: 25px;">
								<div id="radio"><div id="vert-align"><input type="radio" name="laser3" value="{{$laser2b['power_id']}}|{{$laser2b['power_level']}}|10.6 µm"  />
</div></div>
								<div id="platform"><div id="vert-align">{{$laser2b['power_level']}}</div></div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
			@endforeach
			</div>

			<br class="clearall">


			<div id="product-listing-title">

				<div id="column"> {!! $results['query']['all_configurator_text2']['nine_three'] !!}</div>
				<div id="learnmore"><a href="javascript:animatedcollapse.toggle('co2-9')">{{$results['snippet']['learn_more']}}</a></div>
				<br class="clearall">

			</div>

			<div id="co2-9">
				<p> {{$results['query']['all_configurator_text2']['materials_93_xls10mwh']}} </p>
			</div>

			<div id="column">


			
					@foreach ($results['laserthreea'] as $laser3a)
				<div id="power-listing" class="enable">
					<div id="system">
						<a href="#">
							<label style="height: 25px;">
								<div id="radio"><div id="vert-align"><input type="radio" name="laser3" value="{{$laser3a['power_id']}}|{{$laser3a['power_level']}}|9.3 µm"  />
</div></div>
								<div id="platform"><div id="vert-align">{{$laser3a['power_level']}}</div></div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
				@endforeach


			</div>


			<div id="column">
				@foreach ($results['laserthreeb'] as $laser3b)
		
				<div id="power-listing" class="enable">
					<div id="system">
						<a href="#">
							<label style="height: 25px;">
								<div id="radio"><div id="vert-align"><input type="radio" name="laser3" value="{{$laser3b['power_id']}}|{{$laser3b['power_level']}}|9.3 µm"  />
</div></div>
								<div id="platform"><div id="vert-align">{{$laser3b['power_level']}}</div></div>
								<br class="clearall">
							</label>
						</a>
					</div>
					<br class="clearall">
				</div>
			@endforeach


			</div>


			<br class="clearall">

		</div>

		<div id="right">

			<div id="product-listing-title" style="height:25px;">

				<div id="learnmore"><a href="{{URL::to('products/configurator/help')}}"> {{$results['snippet']['help']}}</a></div>
				<br class="clearall">

			</div>

			<div id="laser-power">
		
				<div><strong> {{$results['query']['all_configurator_text2']['w10_watts']}} </strong><br>
				{!! $results['query']['all_configurator_text2']['w10_watts_text'] !!}
				</div>

				<div><strong> {{$results['query']['all_configurator_text2']['w20_30_watts']}}</strong><br>
				{!! $results['query']['all_configurator_text2']['w20_30_watts_text'] !!}
				</div>

				<div><strong> {{$results['query']['all_configurator_text2']['w40_60_watts']}}</strong><br>
				{!! $results['query']['all_configurator_text2']['w40_60_watts_text'] !!}
				</div>

				<div><strong> {{$results['query']['all_configurator_text2']['w60_75_watts']}}</strong><br>
				{!! $results['query']['all_configurator_text2']['w60_75_watts_text'] !!}
				</div>

				<div><strong> {{$results['query']['all_configurator_text2']['w75_150_watts']}} </strong><br>
				{!! $results['query']['all_configurator_text2']['w75_150_watts_text'] !!}
					<br><br>
					<em> {!! $results['query']['all_configurator_text2']['laser_power_above_75'] !!}</em>
				</div>

			</div>

						

		</div>


			<br class="clearall">



	</div>

	<div id="bottom">
		<div id="progress">
		
			<div id="step1-on">
			{{ $results['query']['all_configurator_text2']['select_platform'] }}
			</div>
			<div id="step2-on">
				{{ $results['query']['all_configurator_text']['select_laser_power'] }}
			</div>
			<div id="step3">

				{{ $results['query']['all_configurator_text']['select_options_accessories'] }}

			</div>
			<div id="step4">
			{{ $results['query']['all_configurator_text2']['submit_configuration'] }}
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">

animatedcollapse.addDiv('help', 'fade=1, hide=1');
animatedcollapse.addDiv('more', 'fade=1, hide=1');
animatedcollapse.addDiv('multi-wavelength', 'fade=1, hide=1');
animatedcollapse.addDiv('fiber', 'fade=1, hide=1');
animatedcollapse.addDiv('co2-10', 'fade=1, hide=1');
animatedcollapse.addDiv('co2-9', 'fade=1, hide=1');


	animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}
	
	animatedcollapse.init()

	</script>
	<script>
$(function() {
	$('input[name="laser1"]').click(function() {
		var l1 = $(this).val();
		l1 = l1.split('|');
		$.cookie('laser1p_power_level_jq', l1[1] + ' 1.06 µm', {path: '/'});
		$.cookie('laser2p_power_level_jq', 'null', {path: '/'});	
	});

	$('input[name="laser2"]').click(function() {
		var l2 = $(this).val();
		l2 = l2.split('|');
		$.cookie('laser2p_power_level_jq', l2[1] + ' 10.6 µm', {path: '/'});		
	});

	$('input[name="laser3"]').click(function() {
		var l3 = $(this).val();
		l3 = l3.split('|');
		$.cookie('laser3p_power_level_jq', l3[1] + ' 9.3 µm', {path: '/'});		
	});

	if ($('input[name="laser1"]').is(':checked')) {
				//
			} else {
				$.cookie('laser1p_power_level_jq', '', {path: '/'});	
			}

			if ($('input[name="laser2"]').is(':checked')) {
				//
			} else {
				$.cookie('laser2p_power_level_jq', '', {path: '/'});	
			}

			if ($('input[name="laser3"]').is(':checked')) {
				//
			} else {
				$.cookie('laser3p_power_level_jq', '', {path: '/'});	
			}

			$.cookie('dual_laser_configuration', 0, {path: '/'});
		});
</script>
@endsection
