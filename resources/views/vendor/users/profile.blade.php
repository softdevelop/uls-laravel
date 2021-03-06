@extends('app')
@section('title')
    {{ trans('User/user-index.breadcrum') }}
@stop
@section('content')
    <div class="top-content">
        <label class="c-m">

            <span class="wrap-breadcrumb">
                @if(Auth::user()->is('super_admin') || Auth::user()->can('user_admin'))
                <span class="breadcrumb-level">
                    <a class="c-breadcrumb" href="{{ URL::to('admin/user')}}">{{ trans('User/user-index.breadcrum') }} /</a>
                </span>
                @endif

                <span class="breadcrumb-level active">
                    <span >{{ trans('User/user-profile.breadcrumb_for') }}
                        <strong>{{$item['first_name']}} {{$item['last_name']}}</strong>
                    </span>
                </span>

            </span>
        </label>
    </div>

    <div class="content content-profile" id="module_profile" ng-controller="UserDetailController">
        <div class="user-profile-info" ng-init="userProfile={{json_encode($item)}}; isPermission={{(Auth::user()->is('super_admin')) || (Auth::user()->can('user_admin')) || (Auth::user())}}">
            <div class="col-fix col-xs-4 col-sm-6 col-md-4 col-lg-2">
                <div class="text-center">
                    <img class="full-width" ng-src="@{{userProfile.avatar}}">
                    <a class="camera" type="submit" data-toggle="modal" data-target="#change_avatar" class="glyphicon glyphicon-camera edit-image" ng-model="file"  accept="image/*" ngf-select ngf-drop ngf-change="upload($files)"><i class="fa fa-camera"></i></a>
                </div>

                <div class="btn-change margin-none">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#change_password">
                         {{ trans('User/user-profile.change_passwords') }}
                    </button>
                </div>
            </div>
            <div class="col-fix personal-info col-sm-6 col-xs-8 col-md-4 col-lg-5">
                <div>
                    <dl class="dl-horizontal">
                        <h3>{{ trans('User/user-profile.personal_information') }}</h3>
                        <p class="first">
                            <strong>{{ trans('User/user-profile.first_name') }}: </strong>
                            <span>
                                <a href="#" editable-text="userProfile.first_name"
                                            e-name="userProfile.first_name"
                                            onbeforesave="checkFirstName($data)">
                                    @{{userProfile.first_name || 'empty'}}
                                </a>
                            </span>

                            <p><strong>{{ trans('User/user-profile.last_name') }}: </strong>
                            <span>
                                <a href="#" editable-text="userProfile.last_name"
                                            e-name="userProfile.last_name"
                                            onbeforesave="checkLastName($data)">
                                    @{{userProfile.last_name || 'empty'}}
                                </a>
                            </span>
                            </p>
                        </p>
                    </dl>
                </div>
            </div>
            <div class="group-info col-xs-12 col-sm-12 col-sm-12 col-md-4 col-lg-5">
                <div class="other-information">

                    <dl class="dl-horizontal">
                    <h3>{{ trans('User/user-profile.other_information') }}</h3>
                    <p class="first">
                        <strong>{{ trans('User/user-profile.phone_number') }}: </strong>
                        <span>
                            <a editable-text="userProfile.personal_information.phone_number"
                                e-name="userProfile.personal_information.phone_number"
                                e-id="phone_number"
                                e-data-ng-init="formatPhoneNumber()"
                                onbeforesave="checkPhoneNumber($data)">
                                @{{(userProfile.personal_information.phone_number || 'empty')}}
                            </a>
                        </span>
                        <br/>
                        <p></p><strong>{{ trans('User/user-profile.email') }}: </strong>
                        <span>
                            <a editable-text="userProfile.email" e-name="userProfile.email" onbeforesave="checkEmail($data,userProfile.id)" >@{{userProfile.email || 'empty'}} </a>
                        </span>
                    </p>
                    </dl>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="modal fade mod_profile" id="change_password">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{ trans('User/user-profile.change_password') }}</h4>
                    </div>
                    <div class="modal-body sizer">
                        <form name="formChangePassword" method="PUT" accept-charset="UTF-8">
                            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}}" />
                            <div ng-hide="{{  Auth::user()->can('user_admin')  == 1 || Auth::user()->is('super_admin') == 1}}"  ng-class="{'has-error':formChangePassword.current_password.$touched && formChangePassword.current_password.$invalid}" class="form-group">
                                <label for="current_password">{{ trans('User/user-profile.current_password') }}</label>
                                <div>
                                    <input  type="password"  class="form-control" id="current_password" name="current_password" ng-model="user.current_password" ng-required="!isPermission">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password">{{ trans('User/user-profile.new_password') }}<span class="text-require"> *</span></label>
                                <div>
                                    <input type="password" name="password" ng-model="user.password" class="form-control" id="new_password" ng-required="true">
                                    <label class="control-label has-error" ng-show="formChangePassword.password.$touched && formChangePassword.password.$invalid">
                                        {{ trans('User/user-profile.required_new_password') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_password"> {{ trans('User/user-profile.confirm_new_password') }}<span class="text-require"> *</span></label>
                                <div>
                                    <input  type="password" class="form-control" id="confirm_new_password" name="password_confirmation" ng-model="user.password_confirmation" ng-required="true">
                                    <label class="control-label" ng-show="formChangePassword.password_confirmation.$touched && formChangePassword.password_confirmation$invalid">
                                        {{ trans('User/user-profile.confirm_password_invalid') }}
                                    </label>
                                    <label class="control-label has-error" ng-show="formChangePassword.password_confirmation.$touched && user.password_confirmation!=user.password">
                                        {{ trans('User/user-profile.password_not_match') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="alert alert-error alert-danger" ng-show="error">
                                    @{{error}}
                                </div>

                                <div class="alert alert-success" ng-show="message_success">
                                    @{{message_success}}
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group center-block">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>{{ trans('User/user-profile.close') }}</button>

                            <button ng-disabled="formChangePassword.$invalid || user.password_confirmation!=user.password"
                                    class="btn btn-primary" ng-click="changePassword(userProfile.id)">
                                <i class="fa fa-refresh"></i> {{ trans('User/user-profile.change_password') }}
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/user/profileUserController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/user/userService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/profile.js') }}"></script>
    @endif

    <script type="text/javascript">
        jQuery.noConflict();
        jQuery( document ).ready(function( $ ) {
            // replace image when changing image
            $('#profile_change_picture').change(function(){
                var oFReader = new FileReader();
                oFReader.readAsDataURL(this.files[0]);
                console.log(this.files[0]);
                oFReader.onload = function (oFREvent) {
                    $('#current_profile_img').attr("src", oFREvent.target.result);
                };
            });
        });
    </script>
@stop
