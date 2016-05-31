</head>
<body itemscope itemtype="http://schema.org/WebPage">
<header>
<!-- black top warning -->
<div id="blacktop">
    <!--[if lte IE 7]>
    <script type="text/javascript">
            $('div#ie6 div#x').live('click', function(){
                $('div#browserOverlay, div#ie6').remove();
            });
    </script>
    <div id="browserOverlay"></div>
        <div id="ie6">
            <div id="x">[ X ]</div>
            <h3>
                Uh oh! Looks like you're using an old, unsupported browser (Internet Explorer < 7.0). Microsoft recommends you upgrade for security reasons. Try <a href="http://www.mozilla.com/en-US/firefox/firefox.html">Firefox</a>, <a href="http://www.google.com/chrome">Chrome</a>, <a href="http://www.apple.com/safari/">Safari</a>, or <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">Internet Explorer 10</a>.
            </h3>
        </div>
<![endif]-->
<!-- top navigation -->
<div id="page-wrap" class="page-wrap-toplinks">
<div id="toplinks">
<ul>
<li><a hreflang="en-us" href="http://local.ulsinc.com/">Home</a></li>
<li><a hreflang="en-us" href="http://local.ulsinc.com/about-universal/">About Us</a></li>
<li><a hreflang="en-us" href="http://local.ulsinc.com/contact-us/">Contact Us</a></li>

<!-- Language selection -->	


</ul>
<SCRIPT>
<!--
function clearDefault(el) {
	if (el.defaultValue==el.value) el.value = ""
}
// -->
</SCRIPT>
<div id="search">
	<form action="http://local.ulsinc.com/search/results" method="post" accept-charset="utf-8">
	<input class="search" name="search" type="search" value="" onFocus="clearDefault(this)">
	<input type="submit" name="submit" value="" class="submit"  />
	</form></div>
<br class="clearall" />
</div>


<div id="world-map">

<a hreflang="en-us" href="http://local.ulsinc.com/select-country/">United States - Change Country or Region</a>

<a></a>

</div>
</div>
</div>

<!-- logo and newsticker -->
<div id="page-wrap" class="margin-mobile">
<div id="logo">
<a hreflang="en-us" href="http://local.ulsinc.com/"><img src="http://www.ulsinc.com/imgs/ulslogo.png" alt="Universal Laser Systems"></a>


</div>

<!--<script type='text/javascript'>
(function($){$.fn.newsticker=function(options){var opts=$.extend({},$.fn.newsticker.defaults,options);return this.each(function(){$this=$(this);var o=$.meta?$.extend({},opts,$this.data()):opts;var items=new Array()
$this.children().each(function(index){items.push({'text':$(this).text(),'link':$(this).attr('href')});});var e=$("<div />");$this.replaceWith(e);e.items=items;e.addClass(o.className);e.append($("<a href='#' />").fadeOut(0).attr('target',o.target));showItem(e,o,0);});};function showItem(e,o,i){var item=e.children().filter(':first');var text=item.text();var j=text.length;if(j==0){if(e.items[i].link!=''){item.attr('href',e.items[i].link);}
else{item.attr('href','javascript:void(0)');}
item.fadeIn(0);}
if(j<e.items[i].text.length){item.text(text+e.items[i].text[j]);setTimeout(function(){showItem(e,o,i)},o.typeDelay);j++;}
else{i++;if(i==e.items.length){i=0;}
setTimeout(function(){item.fadeOut(o.fadeOutSpeed,function(){item.text('');showItem(e,o,i);})},o.fadeOutDelay);}};$.fn.newsticker.defaults={typeDelay:50,fadeOutDelay:2000,fadeOutSpeed:750,target:'_self',className:'newsticker'};})(jQuery);


	$(document).ready(function () { 
    $(".TickerItems").newsticker(); 
});

</script>-->
<script type="text/javascript">
    $(function () {
       setInterval(function(){ tick () }, 4000);
    });
	
	function tick(){
	    $('#tickerItems li:first').animate({'opacity':0}, 200, function () { $(this).appendTo($('#tickerItems')).css('opacity', 1); });
	}
</script>

<style>
	#tickerItems {
	    height: 40px;
	    overflow: hidden;
	}
	#tickerItems li {
	    height: 40px;
	}
</style>
<!-- Latest News --> <!-- @anp changes made on 05/16/2014 -->
<!--<div id="newsticker">
  
  <h3></h3>
  
    <ul id="tickerItems">
                                	<li><a href="" onClick="_gaq.push(['_trackEvent', 'Newsticker', 'News  Click', '']);"></a></li>
        </ul>



</div>
-->

    
<br class="clearall">