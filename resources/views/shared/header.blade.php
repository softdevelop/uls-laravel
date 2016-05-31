	<header>
		@if($contents->content_status == 'draft')
			@include('page-demo.header-draft')
		@else	
			@include('page-demo.header-revision')		
		@endif
		<!-- black top warning -->
		<div id="blacktop">
			<!-- top navigation -->
			<div id="logo" class="hidden-min-790">
				<a hreflang="en-us" href="#">
					<img src="/images/tpl/ulslogo.png" alt="Universal Laser Systems">
				</a>
			</div>

			<div id="page-wrap" class="page-wrap-toplinks">
				<div id="toplinks">
					<ul>
						<li><a hreflang="en-us" href="#">Home</a></li>
						<li><a hreflang="en-us" href="#">About Us</a></li>
						<li><a hreflang="en-us" href="#">Contact Us</a></li>
						<!-- Language selection -->	
					</ul>

					<div id="search">
						<form action="" method="post" accept-charset="utf-8">
							<input class="search" name="search" type="search" value="">
							<input type="submit" disabled="disabled" name="submit" value="" class="submit"  />
						</form>
					</div>
					<br class="clearall" />
				</div>
				<div id="world-map">
					<a hreflang="en-us" href="#">United States - Change Country or Region</a>
					<a></a>
				</div>
			</div>
			<a href="" class="menu-o" style="display:none">
				<span class=" fa fa-bars"></span>
			</a> 
		</div>
		<!-- logo and newsticker -->
		<div id="page-wrap" class="margin-mobile">
			<div id="logo" class="hidden-790">
				<a hreflang="en-us" href="#">
					<img src="/images/tpl/ulslogo.png" alt="Universal Laser Systems">
				</a>
			</div>

			<br class="clearall">
			<a href="" class="menu-o hidden-790" style="display:none">
				<span class=" fa fa-bars"></span>
			</a> 

			<nav>
			  <!-- main navigation -->
			  <div id="header">
			    <div class="nav" id="navigation">
			     <ul>
			       <li  class="level-1">
			        <a href="#">&nbsp;<span>Products</span> <span class="ti-icon ti-angle-right"></span></a>
			        <ul>
			          
			          <li><a hreflang="en-us" href="#">Product Line</a></li>
			          
			          <li><a hreflang="en-us" href="#">Explore System Configurations</a></li>
			          
			          <li><a hreflang="en-us" href="#">Accessories</a></li>
			          
			          <li><a hreflang="en-us" href="#">1-Touch Laser Photo</a></li>
			          
			          <li><a hreflang="en-us" href="#">Uniquely Universal Features</a></li>
			          
			          <li><a hreflang="en-us" href="#">Laser Interface+™</a></li>
			          
			        </ul>
			      </li>                        

			      <li class="level-1">
			        <a href="#">&nbsp;<span>Markets</span> <span class="ti-icon ti-angle-right"></span></a>
			        <ul>
			            <li><a hreflang="en-us" href="#">Markets</a></li>
			                        <li>
			              <a hreflang="en-us" href="#">Rapid Prototyping and 3D Modeling</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Consumer Goods Manufacturing</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Education Sales</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Appliqués and Fabric Cutting</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">General Manufacturing</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Gift Manufacturing</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Government Sales</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Graphic Imaging</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">ID and Asset Management</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Packaging Development</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Paper Crafts and Goods</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Personalization</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Prototyping</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Rubber Stamp Manufacturing</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Awards and Recognition</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Making Signage with Laser Technology</a>
			            </li>

			                        <li>
			              <a hreflang="en-us" href="#">Woodworking Machinery</a>
			            </li>

			                      </ul>
			        </li>


			        <li class="level-1">
			          <a href="#">&nbsp;<span>Materials</span><span class="ti-icon ti-angle-right"></span></a>
			          <ul>
			              <li><a hreflang="en-us" href="#">Materials</a></li>
			                            <li>
			                <a hreflang="en-us" href="#">Search Materials Library</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Laser Processes</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Wood</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Stone</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Rubber</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Plastic</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Paper</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Natural Materials</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Metal</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Glass</a>
			              </li>

			                              <li>
			                <a hreflang="en-us" href="#">Fabric and Leather</a>
			              </li>

			                          </ul>
			          </li>
			                               
			      	<li class="level-1">
				        <a href="#">&nbsp;<span>Resources</span><span class="ti-icon ti-angle-right"></span></a>
				        <ul>
				          	<li><a hreflang="en-us" href="#">Resources</a></li>
				            <li><a hreflang="en-us" href="#">Applications Lab</a></li>
				            <li><a hreflang="en-us" href="#">Materials Suppliers</a></li>
				            <li><a hreflang="en-us" href="#">Financing Information</a></li>
				            <li><a hreflang="en-us" href="#">Support</a></li>
				        </ul>
			      	</li>

			           

			      <li class="level-1">
			         <a href="#">&nbsp;<span>Find a Representative</span> <span class="ti-icon ti-angle-right"></span></a>
			        <ul>
			            <li><a hreflang="en-us" href="#">Find a Representative</a></li>
			            <li><a hreflang="en-us" href="#">Education Sales</a></li>
			            <li><a hreflang="en-us" href="#">Government Sales</a></li>
			        </ul>
			      </li>

			      <li class="level-1">
			       <a href="#">&nbsp;<span>Contact Us</span><span class="ti-icon ti-angle-right"></span></a>
			        <ul>
			          <li><a hreflang="en-us" href="#">Contact Us</a></li>
			          <li><a hreflang="en-us" href="#">Our Location</a></li>
			          <li><a hreflang="en-us" href="#">Submit a Support Request</a></li>
			        </ul>
			      </li>
			      </ul>
			      <br class="clearall" />
			    </div>                
			  </div>
			</nav>
		</div>
		<br class="clearall" />
	</header>