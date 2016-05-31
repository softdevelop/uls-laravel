{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script> --}}
{!! Html::script('bower_components/jquery/dist/jquery.min.js')!!}
<script>

		$(document).ready(function(){
		  var $content = $(".label-demo .content-label-demo").show();
		  $(".label-demo .toggle").on("click", function(e){
		  	$('.label-demo .icon-toogle').toggle();
		    $(this).toggleClass("expanded");
		    $content.slideToggle();

		  });

	        $("a").click(function(e){
	            if( $(this).attr("href").indexOf("#") >= 0 || $(this).attr("href").indexOf("javascript:void()") >= 0 || $(this).find("img").length > 0 || $(this).attr("target") == "_blank"){
	                return;
	            }
	            e.preventDefault();
	            parent.document.location.href = $(this).attr("href");
	        });
	        var index = 0;
	        $(".label-demo .navbar-toggle").click(function() {
	        	index++;
	        	if(index % 2 === 0) {
	        		parent.document.getElementById('ifrm').height = '60px';
	        	}else{
		        	parent.document.getElementById('ifrm').height = '120px';

	        	}
				$( ".label-demo .wrap-toogle-button-action" ).toggle('easing');
			});

		});

</script>

	{!! Html::script('bower_components/magnific-popup/dist/jquery.magnific-popup.js')!!}
	{!! Html::script('bower_components/magnific-popup/dist/jquery.magnific-popup.min.js')!!}
	

  	{!! Html::script('bower_components/angular/angular.min.js')!!}
  	{!! Html::script('bower_components/angular-resource/angular-resource.js')!!}

  	{!! Html::script('app/template/app.js') !!}
  	{!! Html::script('app/template/config.js') !!}

  	<script type="text/javascript">
		window.baseUrl = '{{URL::to("")}}'
	  	window.contents = {!!json_encode($contents)!!}
	</script>

@yield('script')
