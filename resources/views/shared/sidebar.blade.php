<div class="box-wrap-toogle-sidebar">
	<a class="caret-off btn-on-off hidden-xs" href="#" id="sidebar-menu-toggle">
		<i class="fa fa-angle-double-right"></i>		
	</a>
	
</div>

<div class="search-form">
	<a class="s-open" href="#">
		<i class="ti-search"></i>
	</a>
	<form class="navbar-form" role="search">
		<a class="s-remove" href="#" ng-toggle-class="search-open">
		<i class="ti-close"></i>
		</a>
		<div class="box-s-s">
			<input type="text" class="form-control" placeholder="Search">
			<button class="search-button" type="submit">
			<i class="ti-search"></i>
			</button>
		</div>
	</form>
</div>

<ul class="main-navigation-menu">
	<li @if(Request::is('/')) class="active open" @endif>
		<a href="{{URL::to('/')}}">
			<div class="item-content">
				<div class="item-media">
					<i class="ti-home"></i>
				</div>
				<div class="item-inner">
					<span class="title"> {{ trans('sidebar.dashboard') }} </span>
				</div>
			</div>
		</a>
	</li>
	<li>
	<li @if(Request::is('support*') && !Request::is('support/new/*') && !Request::is('support/type')) class="active open" @endif>
		<a  href="{{URL::to('support')}}">
			<div class="item-content u-open">
				<div class="item-media">
					<i class="fa fa-server"></i>
				</div>
				<div class="item-inner">
					<span class="title"> {{trans('tickets/sidebar.left.title')}} </span>
				</div>
			</div>
		</a>

	</li>
	
	<li @if(Request::is('seo/*') || Request::is('seo')) class="hasmenu" @endif>
			<a>
				<div class="item-content u-open">
					<div class="item-media">
						<i class="fa fa-line-chart"></i>
					</div>
					<div class="item-inner">
						<span class="title"> SEO </span><i class="icon-arrow ti-angle-right"></i>
					</div>
				</div>
			</a>

			<ul class="sub-menu">
				<li @if(Request::is('seo/pages') || Request::is('seo/pages/*')) class="active" @endif>
					<a href="{{URL::to('seo/pages')}}">
						<span class="title"> Pages </span>
					</a>
			    </li>
			    <li @if(Request::is('seo/overview')) class="active" @endif>
					<a href="{{URL::to('seo/overview')}}">
						<span class="title"> SEO </span>
					</a>
			    </li>

			</ul>
	</li>

	@if(Auth::user()->can('user_admin'))
		<li @if(Request::is('campaign')) class="active open" @endif>
			<a href="{{URL::to('/campaign')}}">
				<div class="item-content">
					<div class="item-media">
						<i class="ti-arrow-circle-right"></i>
					</div>
					<div class="item-inner">
						<span class="title"> Campaign Management </span>
					</div>
				</div>
			</a>
		</li>

	    <li @if(Request::is('cms/*')) class="active open" @endif>
			<a href="{{URL::to('cms/pages')}}">
				<div class="item-content u-open">
					<div class="item-media">
						<i class="ti-support"></i>
					</div>
					<div class="item-inner">
						<span class="title">Content Management</span>
					</div>
				</div>
			</a>
		</li>
		@endif
		@if(Auth::user()->can('document_manger'))
		<li @if(Request::is('/document-manager*')) class="active open" @endif>
			<a  href="{{URL::to('document-manager')}}">
				<div class="item-content u-open">
					<div class="item-media">
						<i class="fa fa-server"></i>
					</div>
					<div class="item-inner">
						<span class="title">Document Management</span>
					</div>
				</div>
			</a>

		</li>
		@endif
		@if(Auth::user()->can('user_admin'))
		<li class="header-gr">
			<span class="title administrator"> Administration </span>
		</li>

		<li @if(Request::is('admin/user/*') || Request::is('admin/user') || Request::is('support/type') || Request::is('user/profile/*')) class="hasmenu user" @endif>
			<a>
				<div class="item-content u-open">
					<div class="item-media">
						<i class="ti-user"></i>
					</div>
					<div class="item-inner">
						<span class="title"> {{ trans('sidebar.users') }} </span><i class="icon-arrow ti-angle-right"></i>
					</div>
				</div>
			</a>

			<ul class="sub-menu">
				<li @if(Request::is('admin/user') || Request::is('admin/user/show-permissions/*') || Request::is('user/profile/*')) class="active open" @endif>
					<a href="{{URL::to('admin/user')}}">
					<span class="title"> {{ trans('sidebar.users') }} </span>
					</a>
				</li>
				<li @if(Request::is('admin/user/roles')) class="active open" @endif>
					<a href="{{URL::to('admin/user/roles')}}">
					<span class="title"> {{ trans('sidebar.roles') }} </span>
					</a>
				</li>
				<li @if(Request::is('admin/user/permissions')) class="active open" @endif>
					<a href="{{URL::to('admin/user/permissions')}}">
					<span class="title"> {{ trans('sidebar.permissions') }} </span>
					</a>
				</li>
				<li @if(Request::is('support/type')) class="active open" @endif>
					<a href="{{URL::to('support/type')}}">
					<span class="title"> Types </span>
					</a>
				</li>
				<li @if(Request::is( 'admin/user/roles/user-group') || Request::is( 'admin/user/roles/user-group/*')) class="active" @endif>
                    <a href="{{Url::to('admin/user/roles/user-group')}}"><span>User Groups</span></a>
                </li>
			</ul>
		</li>

		<li @if(Request::is('site-configuration/*') || Request::is('site-configuration') || Request::is('pages-sync')) class="hasmenu site" @endif>
			<a>
				<div class="item-content">
					<div class="item-media">
						<i class="ti-settings"></i>
					</div>
					<div class="item-inner">
						<span class="title"> {{ trans('sidebar.site_configuration') }} </span><i class="icon-arrow ti-angle-right"></i>
					</div>
				</div>
			</a>
			<ul class="sub-menu">
				<li @if(Request::is('site-configuration/languages')) class="active open" @endif>
					<a href="{{URL::to('site-configuration/languages')}}">
					<span class="title"> {{ trans('sidebar.languages') }} </span>
					</a>
				</li>
				<li @if(Request::is('site-configuration/market-segments')) class="active open" @endif>
					<a href="{{URL::to('site-configuration/market-segments')}}">
					<span class="title"> {{ trans('sidebar.market_segments') }} </span>
					</a>
				</li>
				<li @if(Request::is('site-configuration/regions')) class="active open" @endif>
					<a href="{{URL::to('site-configuration/regions')}}">
					<span class="title"> {{ trans('sidebar.regions') }} </span>
					</a>
				</li>

				<li class="test hidden" @if(Request::is('channel-partners')) class="active open" @endif>
					<a href="{{URL::to('channel-partners')}}">
					<span class="title">Channel Partners</span>
					</a>
				</li>

				<li @if(Request::is('translation-queue')) class="active open" @endif class="test hidden">
					<a href="{{URL::to('translation-queue')}}">
					<span class="title">Translation Queue</span>
					</a>
				</li>

				<li @if(Request::is('site-configuration/data-option')) class="active open" @endif>
					<a href="{{URL::to('site-configuration/data-option')}}">
					<span class="title">Data Option</span>
					</a>
				</li>

				<li @if(Request::is('site-configuration/tag-content')) class="active open" @endif>
					<a href="{{URL::to('site-configuration/tag-content')}}">
					<span class="title">Tag Content</span>
					</a>
				</li>

				<li @if(Request::is('site-configuration/release-manager')) class="active open" @endif>
					<a href="{{URL::to('site-configuration/release-manager')}}">
					<span class="title">Release Manager</span>
					</a>
				</li>
			</ul>
		</li>

		<li @if(Request::is('admin/terms*')) class="active open" @endif>
			<a href="{{URL::to('admin/terms')}}">
				<div class="item-content">
					<div class="item-media">
						<i class="ti-support"></i>
					</div>
					<div class="item-inner">
						<span class="title"> Terms </span>
					</div>
				</div>
			</a>
	    </li>

		<li @if(Request::is('manage-term/*')) class="active open" @endif class="test hidden" >
			<a>
				<div class="item-content">
					<div class="item-media">
						<i class="ti-layout"></i>
					</div>
					<div class="item-inner">
						<span class="title"> Content Type </span><i class="icon-arrow ti-angle-right"></i>
					</div>
				</div>
			</a>
			<ul class="sub-menu">
				@foreach(getAllContentType() as $contentType)
					<li @if(Request::is('manage-term/'.$contentType["_id"])) class="active open" @endif>
						<a href="{{URL::to('manage-term/')}}/{{$contentType['_id']}}">
							<span class="title"> {{$contentType['name']}} </span>
						</a>
					</li>
				@endforeach
			</ul>
		</li>
	@endif
		@if(Auth::user()->can('activity_log') || Auth::user()->can('document_manger'))
			<li @if(Request::is('admin/activity-log/*')) class="active" @endif>
				<a href="{{URL::to('admin/activity-log')}}">
					<div class="item-content">
						<div class="item-media">
							<i class="ti-ink-pen"></i>
						</div>
						<div class="item-inner">
							<span class="title"> Activity Logs </span>
						</div>
					</div>
				</a>
		    </li>
		@endif

		@if(Auth::user()->can('help_content_writer'))
			<li @if(Request::is('admin/help-editor/*')) class="active" @endif>
				<a href="{{URL::to('admin/help-editor')}}">
					<div class="item-content">
						<div class="item-media">
							<i class="ti-help-alt"></i>
						</div>
						<div class="item-inner">
							<span class="title"> Help Editor </span>
						</div>
					</div>
				</a>
		    </li>
		@endif	
</ul>

