
@if($page == 'draft' || $page == 'preview' || $page == 'history')
	@include('page-demo.header-draft')
@else
	@include('page-demo.header-revision')
@endif
<iframe id="ifrm" onload="setIframeHeight(this.id)" src="/cms/pages/view-content-of-page/{{$contents->_id}}/{{$page}}" width="100%" height="100%"></iframe>