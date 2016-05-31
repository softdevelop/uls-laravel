@extends('app')
@section('title')
    {{trans('cms_page/page-redirect.redirects')}}
@endsection
@section('content')
<div ng-controller="RedirectController" class="wrap-content-management  wrap-edit-pages">
    <div class="top-content">
        <label class="c-m">

            <span class="wrap-breadcrumb">
                <span class="breadcrumb-level">
                    <a class="c-breadcrumb" title="@{{baseUrl}}/cms/pages" href="@{{baseUrl}}/cms/pages">{{trans('cms_page/page-redirect.cms_page_manager')}}&nbsp;</a>
                </span>

                @if(isset($breadcrumbData))
                    @foreach($breadcrumbData as $key => $value)
                        <a class="c-breadcrumb" href="@{{baseUrl}}/cms/pages/set-page-selected/{{$value['_id']}}" target="_self" >/&nbsp;{{$value['name']}}&nbsp;</a>
                    @endforeach
                @endif

                <span class="breadcrumb-level">
                    <span title="{{$page->name}}">/ {{$page->name}} / {{trans('cms_page/page-redirect.redirects')}}</span>
                </span>
            </span>

        </label>


    </div>

    <div class="content st-container page-manager">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs fix-normal top-tab" role="tablist">
            <li>
                @if($statusPage == 'live')
                    <a href="{{URL::to('/')}}/cms/pages/page-build/{{$page->content_id}}">
                        <i class="fa fa-list-alt"></i> 
                        {{trans('cms_page/page-edit-draft.page_build')}}
                    </a>
                @else
                    <a href="{{URL::to('/')}}/cms/pages/edit-page/{{$page->content_id}}">
                        <i class="fa fa-list-alt"></i> 
                        {{trans('cms_page/page-history.edit')}}
                    </a>
                @endif
            </li>
            <li>
                <a href="{{URL::to('/')}}/cms/pages/history/{{$page->content_id}}">
                    <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-redirect.history')}}
                </a>
            </li>

            <li class="active">
                <a>
                    <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-redirect.redirects')}}
                </a>
            </li>
        </ul>

        <div class="tab-content fix-tab">
            @include('pages.partial.manage-redirect')
        </div>

    </div>
</div>
@stop

@section('script')
    <script type="text/javascript">
        window.baseUrl = '{{URL::to("")}}'
        window.redirects = {!! json_encode($redirects) !!}
        window.page = {!! json_encode($page) !!}

    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/pages/RedirectService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/RedirectController.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/redirects.js') }}"></script>
    @endif
@stop
