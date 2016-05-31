
<div class="tab-primary">
    <ul id="tab-primary" class="nav nav-tabs" role="tablist">
        <li ng-class="{'active': isShowFieldCurrentBlock}" ng-if="block.fields && block.fields.length > 0">
          <a ng-click="chooseFieldsCurrentBlock()" role="tab" data-toggle="tab" id="popular_@{{baseId}}">
<!--             <i class="status ti-alert" ng-show="!successFieldsCurrentBlock"></i>
            <i class="ti-check" ng-show="successFieldsCurrentBlock"></i> -->
              Fields
          </a>
        </li>
        <li ng-class="{'active': activeBlockTab[$index]}" ng-repeat="item in fieldsBlocks">
            <a ng-click="chooseBlockInject($index, item['_id'])" role="tab" data-toggle="tab" id="inject_@{{item['_id']}}">
<!--                 <i class="status ti-alert" ng-show="!successInjectBlock[item['_id']]"></i>
                <i class="ti-check" ng-show="successInjectBlock[item['_id']]"></i> -->
                @{{item.name}}
            </a>
        </li>
    </ul>
    <div ng-if="isManage">
      <div ng-if="isShowFieldCurrentBlock" class="form-group" ng-repeat="field in block.fields" ng-init="currentTabId = ''">
          @include('cms-content.partial.show-fields')
      </div>
      <div ng-if="isShowFieldBlockInject" class="form-group" ng-repeat="field in fieldsBlocks[currentIndexBlockInject]['fields']" ng-init="currentTabId = currentBlockInject">
          @include('cms-content.partial.show-fields-inject')
      </div>
    </div>
</div>





