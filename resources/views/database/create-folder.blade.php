<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Create New Folder</h4>
</div>
<div>@{{error}}</div>
<div class="modal-body">
    <form role="form" name="createFolderForm" novalidate>

        <!-- Input Name-->
        <div class="form-group full-width" ng-class="{true: 'error'}[submitted && (createFolderForm.name.$invalid || nameExists)]">
          <div class="form-group" ng-show='!exists'>
            <label class="label-form" for="name">Name:</label>
            <div class="wrap-form">
                <input type="text" class="form-control" name="name" placeholder="Folder name" 
                   ng-model="folder.name" 
                   ng-minlength=1 
                   ng-maxlength=50 
                   ng-required="true" />
                <div>
                    <small class="error" ng-show="submitted && nameExists">Folder name is exists</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.required">Name is required.</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.minlength">Name is required to be at least 1 characters</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.maxlength">Name cannot be longer than 50 characters</small>
                </div>                

                <div class="checkbox checkbox-success checkbox-inline fix-label">
                    <input ng-model="exists" type="checkbox" id="inlineCheckbox2" value="option1" checked="">

                    <label for="inlineCheckbox2"> Exists Name </label>
                </div>
            </div>
            
          </div>
            <div class="clearfix"></div>

            <div ng-show='exists' class="col-lg-12">
              <label class="label-form" for="name">Name</label>

                <select class="form-control col-lg-12" name='type' ng-model='folder.name' placeholder='Select Name Database' ng-required='true'>
                    @foreach ($listsFolder as $key => $value)
                      <option value="{{$value}}">{{$value}}</option>
                    @endforeach
                </select>
                <div>
                  <small class="error" ng-show="submitted && createFolderForm.type.$error.required">Type is required.</small>
                </div> 
                <div class="checkbox checkbox-success checkbox-inline fix-label">
                    <input ng-model="exists" type="checkbox" id="inlineCheckbox2" value="option1" checked="">

                    <label for="inlineCheckbox2"> Exists Name </label>
                </div>
            </div>  
            
            <div class="clearfix"></div>

            <div class="wrap-form">
              <label class="label-form padding-none" for="name">Type</label>

                  <select class="form-control" name='type' ng-model='folder.type' ng-required='true'>
                    <option value="mysql">Mysql</option>
                    <option value="mongodb">Mongodb</option>
                  </select>

                  <div>
                    <small class="error" ng-show="submitted && createFolderForm.type.$error.required">Type is required.</small>
                </div>  
            </div>  

            <div class="clearfix"></div>

            <div class="wrap-form">
              <label class="label-form padding-none" for="name">Status</label>
                 <select class="form-control" name='status' ng-model='folder.status' ng-required='true'>
                    <option value="visible">Visible</option>
                    <option value="hidden">Hidden</option>
                  </select>
                  <div>
                    <small class="error" ng-show="submitted && createFolderForm.status.$error.required">Status is required.</small>
                </div>  
                </div>  
            </div>
            <div class="clearfix"></div>
        </div>
        
    </form>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> Cancel</button>
    <button class="btn btn-primary" ng-click="submit(createFolderForm.$invalid)"><i class="fa fa-plus"></i> Add</button>
</div>