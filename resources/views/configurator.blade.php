<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="content-language" content="en-us">

<!-- title -->
<title>
		
	 
	

	</title>
<!-- keywords/description -->
<meta name="keywords" content="" />
<meta name="description" content="">
<meta name="copyright" content="Universal Laser Systems logo and name, are registered trademarks of Universal Laser Systems, Inc." />
<!-- seo site validation -->
<meta name="msvalidate.01" content="D28348FEC42B2B365C579EA9C16AB812" />
<meta name="google-site-verification" content="cl2z9MrI4-lfHkHAfcQrNvhHJaA3ibeQkf8kPQyhpRU" />
<meta name="alexaVerifyID" content="N1OAYoKg7qi1XG5Mf8JfwbI8-3o" />

<!-- other meta tags -->
<meta name="distribution" content="global" />
<meta name="robots" content="noodp, noydir" />
<meta name="revisit-after" content="7 days" />
<meta name="organization" content="Universal Laser" />
<!-- favicon -->
<link rel="icon" href="{{getBaseUrl()}}/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="{{getBaseUrl()}}/favicon.ico" type="image/x-icon" />

{!!Html::style('universal/css/main.css?v='.getVersionCss()) !!}

{!! Html::script('bower_components/jquery/dist/jquery.min.js')!!}  
{!! Html::script('universal/scripts/animatedcollapse.js')!!} 
{!! Html::script('universal/scripts/cookie.js')!!} 
<!--<script src="http://www.ulsinc.com/scripts/collapse.js" type="text/javascript"></script>-->
<script type="text/javascript">

	animatedcollapse.addDiv('learn-more', 'fade=1, hide=1')
	
	animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}
	
	animatedcollapse.init()

</script>
{!! Html::script('universal/scripts/jquery.jscrollpane.min.js')!!} 

<script type="text/javascript" id="sourcecode">
			$(function()
			{
				//$('.scroll-pane').jScrollPane();	
			});
</script>

<script type="text/javascript">
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '']);

  

  _gaq.push(['_trackPageview']);

 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 
</script>

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"Zyjfl1ao9rD0em", domain:"ulsinc.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=Zyjfl1ao9rD0em" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->  

</head>
<body class="configure" >
@yield('content')

</body>

<script type="text/javascript" charset="utf-8">
		//$(document).ready(function(){
		//	$(".gallery a[rel^='prettyPhoto']").prettyPhoto({theme:'light_square'});
		//});
</script>


<div style="display:none;">
</div>



</html>
