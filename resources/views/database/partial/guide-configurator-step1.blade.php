<div id="resize-left" style="height:500px">
    <input type="text" name="" ng-model='treeFilter' ng-change="filterTree()">
    <div data-toggle="tree" id="tree"></div>
</div>

<div id="resize-right" style="height:500px" class="fix-td-tb">
    <div class="table-responsive table-animate table-database">
        <table class="table set-padding table-min-1200" ng-init="size()" show-filter="isSearch"  ng-table="tableParams">
            <tbody class="tbody-animate">
                <tr class="parent-active" ng-repeat="item in $data">
                    <td class="show-action text-left parent-td9" data-title="'{{trans('cms_database/database-index.action')}}'">
                        <a href="" ng-click="configMaterial(item)"><span class="fa fa-pencil"></span></a>
                        <a href="" ng-click="removeMaterial(item.id, item.name)"><span class="fa fa-times"></span></a>
                    </td>

                    <td data-title="'{{trans('cms_database/database-index.name')}}'" filter="{ 'name': 'text' }" sortable="'name'">@{{item.name}}</td>
                    <td data-title="'{{trans('cms_database/database-index.category')}}'" filter="{ 'category': 'text' }" sortable="'category'">@{{item.categoryName}}</td>
                    <td data-title="'{{trans('cms_database/database-index.cut')}}'" sortable="'cut'" >
                        <div class="checkbox checkbox-inline p-l-40">
                            <span ng-class="{'fa fa-check': item.content.cut}"></span>
                        </div>
                    </td>

                    <td data-title="'{{trans('cms_database/database-index.engrave_mark')}}'" sortable="'engrave_mark'" >
                        <div class="checkbox checkbox-inline">
                            <span ng-class="{'fa fa-check': item.content.engrave_mark}"></span>
                        </div>
                    </td>

                    <td data-title="'{{trans('cms_database/database-index.min_thickness')}}'" filter="{ 'min_thickness': 'text' }" sortable="'min_thickness'" >
                        @{{ item.content.min_thickness || '0' }} @{{config.content.unit == 'inches' ? ' in' : ' mm'}}
                    </td>

                    <td data-title="'{{trans('cms_database/database-index.max_thickness')}}'" filter="{ 'max_thickness': 'text' }" sortable="'max_thickness'">
                        @{{ item.content.max_thickness || '0' }} @{{config.content.unit == 'inches' ? ' in' : ' mm'}}
                    </td>

                    <td data-title="'{{trans('cms_database/database-index.past_material_size')}}'">
                        @{{item.content.width || 0}} @{{config.content.unit == 'inches' ? ' in' : ' mm'}} x @{{item.content.height || 0}} @{{config.content.unit == 'inches' ? ' in' : ' mm'}} x @{{item.content.depth || 0}} @{{config.content.unit == 'inches' ? ' in' : ' mm'}}
                    </td>                           
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="clearfix"></div>

<div id="sidebar-resizer" resizer="vertical" resizer-width="0" resizer-left="#resize-left" resizer-right="#resize-right" resizer-max="500" resizer-position-left="300">
</div>