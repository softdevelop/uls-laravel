<div class="modal-header">
    <button ng-click="cancel()" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
    <h4 class="modal-title"><span>{{ trans('Role/role-create-group-user.group_user') }}</span></h4>
</div>

<div class="modal-body share-pw">
    <form name="formGroupUser">
        <div class="input-group form-group add-user-group">
            <input class="form-control name" id="appendedInputButtons" type="text" name="name_group" ng-model="groupUser.name" ng-required = 'true'>
            <div class="input-group-btn">
                <button class="btn btn-primary fix-buttom" type="submit" ng-click="create(formGroupUser.$invalid)" ng-disabled="isDisabled"><i class="fa fa-check"></i></button>
            </div>
        </div>
        <div>
            <span class="help-inline" ng-show="formGroupUser.name_group.$error.required && formGroupUser.name_group.$dirty
                  || submitted && formGroupUser.name_group.$error.required">{{ trans('Role/role-create-group-user.group_name_required') }}</span>
        </div>
    </form>
    <div ng-show="addGrouped">
        <div class="action-add">
            <div class="select-add">
            <search items="users" type="false" ng-model="userShareId" user-id="userId" component="share" on-change="shareToUser(userShareId)" data-placeholder="Select User"></search>
            <div class="clearfix"></div>  
            </div>
             
        </div>
        <div class="wrap-table table-responsive">
            <table class="table table-hover">
                <thead class="f15">
                    <tr class="h35">
                        <th class="w60"></th>
                        <th class="">{{ trans('Role/role-create-group-user.name') }}</th>
                        <th class="w60">{{ trans('Role/role-create-group-user.remove') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="user in list_user | orderBy:'first_name':reverse">
                        <td>
                            <img width="30" class="img-circle" ng-src="@{{ users_map[user.id].avatar }}">
                        </td>
                        <td class="text-center">
                            <h5>
                                @{{user.first_name }} @{{ user.last_name }}
                            </h5>
                        </td>
                        <td class="text-center icon">
                            <a title="{{ trans('Role/role-create-group-user.remove_user') }}" ng-click="removeUser(user.id)" href="javascript:void(0)" class="fa fa-user user-icon"><i class="fa fa-minus"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button class="btn btn-default pull-right" ng-click="cancel()" ><i class="fa fa-times"></i> Close</button>
</div>
