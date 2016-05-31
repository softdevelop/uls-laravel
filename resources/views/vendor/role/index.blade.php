@extends('app')
@section('title')
    {{ trans('role-index.breadcrum') }}
@stop
@section('content')

<div data-ng-controller="RoleController">
    <div class="top-content">
        <label class="c-m">{{ trans('Role/role-index.breadcrum') }}
            <a data-toggle="modal" data-target=".bs-example-modal-lg">
                <i title="Help Information" class="fa fa-info-circle help-infor-icon"></i>
            </a>
        </label>
        
        <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalCreateRole()" class="btn btn-primary pull-right fix-btn-top-content">
            <i class="fa fa-plus"></i> &nbsp {{ trans('Role/role-index.add_role') }}
        </a>

    </div>
    <div class="content content-role">
        <div ng-include="featureTemplate"></div>
        <div id="fix-modal-top" class="modal fade bs-example-modal-lg modal-help-infor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title">{{ trans('Role/role-index.breadcrum') }}</h4>
                    </div>

                    <div class="modal-body modal-user">
                        
                        <div class="col-lg-4 col-md-4 help-infor-modal hidden-sm-down">
                        <p class="c-transparent">text-hide</p>
                            <ul class="fixed-ul-user">
                                <li> <a class="f700" data-toggle="collapse" href="#collapseAd" aria-expanded="false" aria-controls="collapseExample">{{ trans('Role/role-index.user_administration') }}</a>
                                    <ul class="session-user-admin ls-none collapse" id="collapseAd">
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-access')">{{ trans('Role/role-index.access') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-users')">{{ trans('Role/role-index.users') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-search-users')">{{ trans('Role/role-index.search_users') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-edit-user-profile')">{{ trans('Role/role-index.edit_user_profile') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-add-user')">{{ trans('Role/role-index.add_user') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-update-permission')">{{ trans('Role/role-index.update_permissions') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-password-reset')">{{ trans('Role/role-index.password_reset') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-become-user')">Become User</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-edit-user-details')">Edit User Detail</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('ad-deactive-user')">Deactivate User</a></li>
                                    </ul>
                                </li>
                                <li><a class="f700" data-toggle="collapse" href="#collapseRoles" aria-expanded="false" aria-controls="collapseExample">Roles</a>
                                    <ul class="session-roles ls-none collapse in" id="collapseRoles">
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('roles-access')">{{ trans('Role/role-index.access') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('roles-edit-role-permissions')">{{ trans('Role/role-index.action_Edit_role_permissions') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('roles-edit-role-user-groups')">{{ trans('Role/role-index.edit_role_users_and_groups') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('roles-edit-role-details')">{{ trans('Role/role-index.edit_role_details') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('roles-delete-a-role')">{{ trans('Role/role-index.delete_a_role') }}</a></li>
                                    </ul>
                                </li>
                                    
                                <li><a class="f700" data-toggle="collapse" href="#collapsePermission" aria-expanded="false" aria-controls="collapseExample">{{ trans('Role/role-index.permissions') }}</a>
                                    <ul class="session-permissions ls-none collapse" id="collapsePermission">
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('per-access')">{{ trans('Role/role-index.access') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('per-edit-per-user-group')">{{ trans('Role/role-index.edit_permission_users_and_Groups') }}</a></li>
                                        <li><a href="javascript:void(0)" ng-click="goToAnchorWithId('per-edit-per-details')">{{ trans('Role/role-index.edit_permission_details') }}</a></li>
                                        <li><a  href="javascript:void(0)" ng-click="goToAnchorWithId('per-delete-a-per')">{{ trans('Role/role-index.delete_a_permission') }}</a></li>
                                    </ul>
                                </li>
                                <!-- <li><a class="f700" href="">Types</a></li>
                                <li><a class="f700" href="">User Group</a></li> -->
                            </ul>
                            
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <h4 id="user-administration" class="c-primary">{{ trans('Role/role-index.user_administration') }}</h4>
                            <div class="space-area user-ad-area">
                                <div class="m-b-20">
                                User Administration allows website administrators to manage user access and permissions.
                                Administrators can create and utilize any combination of Roles, Permissions, Types,
                                and User Groups to tailor permission as broadly or as specifically as needed for one or multiple users.
                                </div>

                                <strong id="ad-access">{{ trans('Role/role-index.access') }}</strong>
                                <div class="m-b-20">
                                    Access the User Administration page by selecting  <strong>{{ trans('Role/role-index.users') }}</strong> from the Administration/Users section of the Left Navigation menu.
                                </div>
                                <div class="m-b-20">
                                    <img class="border-img fix-mobile" src="/images/help1.png" alt="">    
                                </div>
                                


                                <strong id="ad-users">{{ trans('Role/role-index.users') }}</strong>
                                <div class="m-b-20">
                                    All users who have been given access by an administrator are listed.
                                    View deactivated users by first clicking the Search icon <i class="fa fa-search blue"></i> and then clicking the green checkmark <i class="fa fa-check-square c-5CB85C"></i>  above the <strong>Status</strong> column.
                                </div>

                                <strong id="ad-search-users">{{ trans('Role/role-index.search_users') }}</strong>
                                <div class="m-b-20">
                                    Click the Search icon  <i class="fa fa-search blue"></i> at the top left of the user list to open the <strong>Name</strong> and  <strong>Email</strong> search fields.
                                    Enter information into either field to filter the list of users.
                                    Sort the user list in ascending or descending order by Name, Email, Date Created, or Last Login by clicking on the column header. 
                                </div>
                                
                                <strong id="ad-edit-user-profile">{{ trans('Role/role-index.edit_user_profile') }}</strong>
                                <div class="m-b-20">
                                    Select a user’s name to view and edit the user’s name, phone number, email, picture, and password.
                                </div>

                                <strong id="ad-add-user">{{ trans('Role/role-index.add_user') }}</strong>
                                <div class="m-b-20">
                                <div class="m-b-20">
                                    New users added by authorized ULS site administrators when someone requires access in order to manage content or administrate the site or other users.
                                To add a new user, click the <strong>{{ trans('Role/role-index.add_user') }}</strong> button on the top right of the User Administration page and then enter the user’s first and last names, email address, and phone number.
                                Click the <strong>Add</strong> button to submit the information and return to the user list page.
                                </div>
                                
                                <div class="m-b-20">Once submitted, an email will be generated to the user within 10 minutes that will prompt them to click an activation link.
                                Once the new user enters their email address and creates a password, and then enters the password again for verification, they will be logged into the site.
                                </div>
                                <div class="m-b-20">Users can access the site in the future by logging in at admin.ulsinc.com.</div>

                                </div>

                                <strong id="ad-update-permission">{{ trans('Role/role-index.update_permissions') }}</strong>
                                <div class="m-b-20">
                                    Update a user’s Role, Permissions, and/or Group by selecting <strong>{{ trans('Role/role-index.update_permissions') }}</strong> from the <strong>Action</strong> menu for that user.
                                    Once on the Update permissions page, take one of the following actions to customize the selected user’s access and activities:
                                </div>
                                <div class="m-b-20">
                                    Assign a Role to a user to give the user a specific set of pre-determined permissions that will be the same as others who are given this Role. 
                                </div>
                                <div class="m-b-20">Assign a Permission to a user in order to provide them additional permissions that are not typically a part of the assigned Role,
                                but that the user needs in order to perform their tasks.
                                </div>
                                <div class="m-b-20">Assign a user to a Group when that Group has a certain set of permissions that the user should inherit.
                                Many users can be added to one Group, and a group can be edited or deleted when those permissions need to be changed or removed from from the users.
                                </div>
                                <div class="m-b-20">Learn more about creating and managing <a id="tag-roles" href="javascript:void(0)" ng-click="goToAnchorWithId('container-roles')" class="c-primary-h">Roles</a> and <a id="tag-permission" href="javascript:void(0)" ng-click="goToAnchorWithId('container-permission')" class="c-primary-h">{{ trans('Role/role-index.permissions') }}</a> in those sections of this Help guide. </div>

                                <strong id="ad-password-reset">{{ trans('Role/role-index.password_reset') }}</strong>
                                <div class="m-b-20">Initiate a password reset in cases of lost or forgotten passwords by selecting <strong>{{ trans('Role/role-index.password_reset') }}</strong> from the <strong>Action</strong> menu for that user.
                                Once selected, the user will receive an email with a link that will prompt them to enter and save their new password.</div>
                                
                                <strong id="ad-become-user">Become User</strong>
                                <div class="m-b-20">View the site as any user by selecting <strong>Become User</strong> from the <strong>Action</strong> menu for that user.
                                To return to your own view, click Logout on the menu next to their name at the top right of the page, and then log back into the site as yourself.
                                The Become User function is helpful when another user is having trouble performing a specific task and it is necessary to see what they see in order to help troubleshoot their problem.
                                </div>
                                <div class="m-b-20">
                                    <i>Warning: Any actions taken while assuming another user’s identity will be recorded as being taken by that user.</i>
                                </div>

                                <strong id="ad-edit-user-details">Edit User Detail</strong>
                                <div class="m-b-20">
                                    Update a user’s name, email, and phone number by selecting <strong>Edit User Detail</strong> from the <strong>Action</strong> menu for that user. All changes are reflected on the user’s profile page.
                                </div>
                                <div class="m-b-20">
                                    <i>Note:</i> When a user’s email address is changed, the user will log in using the new email, and all future notifications to that user will be sent to the new email.
                                    The user’s password will remain the same unless manually reset using the Password Reset function.
                                    The administrator should notify the user when the email address is changed, so that the user knows to log in using their new email address.
                                </div>

                                <strong id="ad-deactive-user">Deactivate User</strong>
                                <div class="m-b-20">
                                    <div>
                                    Users are Deactivated by authorized ULS site administrators when that user should no longer have access to the site.
                                        Users who are deactivated can no longer log into the site and can no longer have tickets assigned to them.
                                        Tickets previously generated or assigned to that user will still exist, and that user’s information will still display in relation to tickets and events as normal. 
                                    </div>
                                </div>
                                <div>
                                    <div class="m-b-20">Deactivate a user by selecting <strong>Deactivate user</strong> from the <strong>Action</strong> menu for that user on the User Administration page. Click <strong>OK</strong> on the verification popup.</div>
                                    <div>Deactivated users can be made active again by taking the following steps:</div>
                                    <p class="m-l-30 m-b-5"><strong>1.</strong> Click the Search icon on the User Administration page.</p>
                                    <p class="m-l-30 m-b-5"><strong>2.</strong> Click the green checkmark in the Status column to view only deactivated users</p>
                                    <p class="m-l-30 m-b-5"><strong>3.</strong> Enter information into the Name or Email fields to locate the user    </p>
                                    <p class="m-l-30 m-b-5"><strong>4.</strong> Click the Deleted (Click this to rollback) button for that user</p>
                                    <p class="m-l-30 m-b-5"><strong>5.</strong> Click Yes</p>
                                </div>
                            </div>
                            
                            <h4 id="container-roles" class="m-t-30 c-primary">Roles</h4>
                            <div class="space-area roles-area">
                                <div class="m-b-20">Roles are groups of Permissions that can be associated to a user or to groups of users.</div>

                                <strong id="roles-access">{{ trans('Role/role-index.access') }}</strong>
                                <div class="m-b-20">Access the Role Administration page by selecting  <strong>Roles</strong> from the Administration/Users section of the Left Navigation menu.</div>
                                <div class="m-b-20">
                                    <img class="border-img fix-mobile" src="/images/help4.png" alt="">    
                                </div>

                                <strong id="roles-edit-role-permissions">{{ trans('Role/role-index.action_Edit_role_permissions') }}</strong>
                                    <div>Click the Permission icon <i class="fa fa-key c-primary"></i> next to the role name. </div>
                                    <div class="m-b-20">
                                        <ul>
                                            <li> Add a Permission to a Role: Click the Add icon <i class="fa fa-plus-square c-primary"></i>  next to the desired permission in the Available Permissions table.</li>
                                            <li> Remove a Permission from a Role: Click the Remove icon <i class="fa fa-minus-square c-primary"></i> next to the desired permission in the Assigned Permissions table.</li>
                                        </ul>
                                    </div>

                                <strong id="roles-edit-role-user-groups">{{ trans('Role/role-index.edit_role_users_and_groups') }}</strong>
                                    <div>
                                        Click the Users icon <i class="fa fa-users c-primary"></i> next to the role name.   
                                    </div>
                                    <div class="m-b-20">
                                        <ul>
                                            <li> Search for a User or Group: Toggle the icon above the search bar to User or Group, and then type the user or group name in the search bar.</li>
                                        </ul>
                                        <div class="m-b-20 m-t-20">
                                            <img class="fix-mobile" src="/images/help2.png" alt="">
                                        </div>
                                        <ul>
                                            <li> Add a User or Group to a Role: Click the Add icon <i class="fa fa-plus-square c-primary"></i> next to the desired user or group in the Available Users and Groups table </li>
                                            <li> Remove a User or Group from a Role: Click the Remove icon <i class="fa fa-minus-square c-primary"></i> next to the desired user or group in the Assigned Users and Groups table.</li>
                                        </ul>
                                        
                                    </div>
                                    
                                    <strong id="roles-edit-role-details">{{ trans('Role/role-index.edit_role_details') }}</strong>
                                    <div class="m-b-20">
                                        Click the Edit icon <i class="ti-pencil c-primary"></i> next to the role name.
                                        <ul>
                                            <li> Change the Role name: Click the blue role name text and edit the name. Click the checkmark to save the change.</li>
                                            <li> Edit the Role Description: Click the text box that contains the description text and make changes. Click the checkmark to save the change.</li>
                                        </ul>
                                    </div>

                                    <strong id="roles-delete-a-role">{{ trans('Role/role-index.delete_a_role') }}</strong>
                                    <div>
                                        Click the Delete icon <i class="fa fa-trash-o c-primary"></i> next to the Role name. Click OK  to confirm deletion. All users who were associated to this role will no longer have the permissions associated to the role.
                                    </div>
                            </div>

                            <h4 id="container-permission" class="m-t-30 c-primary">{{ trans('Role/role-index.permissions') }}</h4>
                            <div class="space-area permission-area">
                                <div class="permission-area m-b-20">
                                    Permissions are specific activities that can be associated to a user or to a group of users.
                                </div>

                                <strong id="per-access">{{ trans('Role/role-index.access') }}</strong>
                                <div class="m-b-20">
                                    Roles are groups of Permissions that can be associated to a user or to groups of users.
                                    Access the Permission Administration page by selecting <strong>{{ trans('Role/role-index.permissions') }}</strong> from the Administration/Users section of the Left Navigation menu.

                                </div>
                                <div class="m-b-20">
                                    <img class="border-img fix-mobile" src="/images/help3.png" alt="">    
                                </div>
                                

                                <strong id="per-edit-per-usedit_permission_users_and_Groupser-group">{{ trans('Role/role-index.edit_permission_users_and_Groups') }}</strong>
                                <div>Click the Users icon <i class="fa fa-users c-primary"></i> next to the permission name. </div>
                                <div class="m-b-20">
                                    <ul>
                                        <li> Search for a User or Group: Toggle the icon above the search bar to User or Group, and then type the user or group name in the search bar.</li>
                                    </ul>
                                    <div class="m-b-20 m-t-20">
                                        <img class="fix-mobile" src="/images/help2.png" alt="">    
                                    </div>
                                    <ul>
                                        <li> Add a User or Group to a Role: Click the Add icon <i class="fa fa-plus-square c-primary"></i> next to the desired user or group in the Available Users and Groups table </li>
                                        <li> Remove a User or Group from a Role: Click the Remove icon <i class="fa fa-minus-square c-primary"></i> next to the desired user or group in the Assigned Users and Groups table.</li>
                                    </ul>
                                        
                                        

                                    
                                </div>

                                <strong id="per-edit-per-details">{{ trans('Role/role-index.edit_permission_details') }}</strong>
                                <div>
                                    Click the Edit icon <i class="ti-pencil c-primary"></i> next to the permission name.
                                </div>
                                <div class="m-b-20">
                                    <ul>
                                        <li> Change the Permission name: Click the blue role name text and edit the name. Click the checkmark to save the change.</li>
                                        <li> Edit the Permission Description: Click the text box that contains the description text and make changes. Click the checkmark to save the change.</li>
                                    </ul>
                                </div>
                                
                                <strong id="per-delete-a-per">{{ trans('Role/role-index.delete_a_permission') }}</strong>
                                <div class="m-b-20">Click the Delete icon <i class="fa fa-trash-o c-primary"></i> next to the permission name. Click <strong>OK</strong> to confirm deletion.
                                All users who were associated to this permission will lose the ability to perform the functions associated to the permission.</div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    window.dataRoles = {
        items: {!! json_encode($items) !!},
        permissionList: {!! json_encode($permissionList) !!}
    };
    modules = ['xeditable','ngTable'];  
</script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/role/roleController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/role/roleEditorController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/role/roleService.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/role/roleuserController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/role/roleuserService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/role.js') }}"></script>
    @endif
@stop