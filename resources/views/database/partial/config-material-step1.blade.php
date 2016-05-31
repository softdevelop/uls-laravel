<!-- <form name='formData'> -->
    <div class="modal-header">
        <h4>Config Material</h4>
        <button ng-click="cancel()" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <p><b>Material Entry:
        <a href="#" editable-text="config.name" onbeforesave="changeNameMaterial($data)">@{{ config.name || 'empty' }}</a>
        <!-- <a href="#" editable-text="config.name">@{{ config.name || 'empty' }}</a></b></p> -->
        <p><b>Measurement</b></p>
        <p>
            <input type="radio" id="unit" name="unit" value="inches" ng-model="config.content.unit" ng-change="convertUnit()"> Inches
            <input type="radio" id="unit" name="unit" value="milimeters" ng-model="config.content.unit" ng-change="convertUnit()"> Milimeters
        </p>
        <p>
            <input ng-disabled="checkCutting" type="checkbox" ng-checked="config.content.cut || config.content.cut == 1" ng-model="config.content.cut"> <b>Laser Cutting</b><br>
            <span ng-if="config.content.cut">
                <b>Min Cutting Thickness</b> <input type="number" step="0.001" name="minThick" ng-model="config.content.min_thickness"> <br>
                <b>Max Cutting Thickness</b> <input type="number" step="0.001" ng-model="config.content.max_thickness"> <br>         
            </span>
        </p>
        <p>
            <span class="error" ng-show="submitted && minMaxThicknessInvalid">Min/Max Cutting Thickness invalid!</span>
        </p>
        <p ng-init="config.content.marking = true; config.content.otherSelect = true">
            <input ng-disabled="engrave" type="checkbox" ng-checked="config.content.engraving" ng-model="config.content.engraving"> Laser Engraving <br>
            <input type="checkbox" ng-checked="config.content.marking" ng-model="config.content.marking"> Laser Marking <br>
            <input type="checkbox" ng-checked="config.content.otherSelect" ng-model="config.content.otherSelect"> Other
                <form name="formData">
                    <input ng-if="config.content.otherSelect" type="text" ng-model="config.content.other" name="other" ng-required='true'>
                    <span class="error" ng-show="submitted && config.content.otherSelect && formData.other.$error.required">Other is required field.</span>
                </form>
        </p>
        <p>
            <b>Width</b> <b>Height</b> <b>Depth</b>
            <input type="number" ng-model="config.content.width">
            <input type="number" ng-model="config.content.height">
            <input type="number" ng-model="config.content.depth">
        </p>
        <p>
            <span class="error" ng-show="submitted && minWidthInvalid">Width invalid!</span>
            <span class="error" ng-show="submitted && minHeightInvalid">Height invalid!</span>
            <span class="error" ng-show="submitted && minDepthInvalid">Depth invalid!</span>
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" ng-click="cancel()"> <i class="fa fa-times"></i> CANCEL</button>
        <button class="btn btn-default" ng-click="next()"> <i class="fa fa-times"></i> DONE</button>
    </div>
<!-- </form> -->