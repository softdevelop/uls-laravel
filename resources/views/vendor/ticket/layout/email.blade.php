<div id="main" role="main">
	<div>
		<p>
			Dear {{ !empty($name) ? $name : 'User' }},</p>
		<p>
		<p>
			@yield('body')
		</p>
	</div>
</div>