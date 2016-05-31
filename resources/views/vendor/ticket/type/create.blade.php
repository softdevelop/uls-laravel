
<div class="modal-content">

    <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         @if(!empty($item->id))
            <h4 class="modal-title">{{ trans('tickets/type-create.edit_type') }} {{$item->name}}</h4>
            @else
            <h4 class="modal-title">{{ trans('tickets/type-create.add_type') }}</h4>
        @endif
    </div>

    <div class="modal-body user-modal">
        <form class="form-horizontal" method="POST" accept-charset="UTF-8" name="formData" ng-init="setValue()">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <div class="form-group fix-margin">
              	<label class="label-form">{{ trans('tickets/type-create.name') }}</label>
                <div class="wrap-form" ng-class="{'has-error':formData.name.$touched && formData.name.$invalid}">
                    <input ng-required="true" type="text"  class="form-control" id="name" ng-model="type.name" name="name"  placeholder="Enter a name of type ticket">
                </div>
            </div>
            <div class="form-group fix-margin">
                <label class="label-form">{{ trans('tickets/type-create.position') }}</label>
                <div class="fix-select">
                    <select ng-model="type.position_show" class="form-control" ng-init="transString()" name="position_show">
                        <option value="">{{ trans('tickets/type-create.select_show_position') }}</option>
                        <option value="1">{{ trans('tickets/type-create.show_sidebar_menu') }}</option>
                        <option value="2">{{ trans('tickets/type-create.show_dropdow_ticket') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group fix-margin" ng-init="terms={{$terms}}">
                <label class="label-form">{{ trans('tickets/type-create.term') }}</label>
                <div class="fix-select">
                    <select ng-model="type.term_id" class="form-control" name="term_id">
                        <option value="">{{ trans('tickets/type-create.select_term') }}</option>
                        <option ng-repeat="term in terms" value="@{{term._id}}" >@{{term.name}}</option>
                    </select>
                </div>
            </div>
            <div class="alert alert-error alert-danger" ng-show="errors" >
               <p ng-repeat="error in errors"> @{{error}}</p>
            </div>

        </form>
        <div ng-show="type.id">
        <div class="form-group">
            <label class="label-form">{{ trans('tickets/type-create.ticket_admin') }}</label>
            <div class="wrap-form">
                <select ng-model="type.ticketAdmin" class="form-control" name="" ng-options="item.id as item.name for item in ticketAdmin">
                    
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <label class="label-form">{{ trans('tickets/type-create.ticket_assignee') }}</label>
            <div class="wrap-form">
               <select ng-model="type.ticketAssignee" class="form-control" name="" ng-options="item.id as item.name for item in ticketAssignee">
                    
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        </div>

    </div>
    <div class="modal-footer">
        <div class="form-group center-block">
            <button type="button" class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{ trans('tickets/type-create.close') }}</button>
            <button type="submit" ng-click="create(type.id)" ng-disabled="formData.$invalid" class="btn btn-primary"><i class="fa fa-check"></i> @{{type.id ? 'Update':'Save'}}</button>
            
        </div>
    </div>
</div><!-- /.modal-content -->

<script>    
    window.type = {!! json_encode($item) !!}
</script>