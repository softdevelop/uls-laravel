<div class="modal-body" ng-show="isShowDetail">
    <div class=""><strong>Email</strong>: @{{dataInput.email || 'empty'}}</div>
    <div class="">
        <div><span class=""><strong>Detail</strong>: </span></div>
        <div ng-repeat="(key, value) in dataInput.materials">
            <div><em>Material</em>: <span>@{{value.name}}</span></div>
            <div class="">
                <span>Max thickness: </span>
                <span>@{{value.content.max_thickness || 0}}</span>
            </div>
            <div class="">
                <span>Min thickness: </span>
                <span>@{{value.content.min_thickness || 0}}</span>
            </div>
            <div class="">
                <span>Power at max thickness: </span>
                <span>@{{value.content.power_at_max_thickness || 0}}</span>
            </div>
            <div class="">
                <span>Power at min thickness: </span>
                <span>@{{value.content.power_at_min_thickness || 0}}</span>
            </div>
            <div class="">
                <span>Unit: </span>
                <span>@{{value.content.unit || 0}}</span>
            </div>
            <div class="">
                <span>With: </span>
                <span>@{{value.content.width || 0}}</span>
            </div>
            <div class="">
                <span>Height: </span>
                <span>@{{value.content.height || 0 }}</span>
            </div>
            <div class="">
                <span>Dept: </span>
                <span>@{{value.content.depth || 0}}</span>
            </div>
            <div class="">
                <span>Other select: </span>
                <span>@{{value.content.otherSelect || false}}</span>
            </div>
            <div class="">
                <span>Other name: </span>
                <span>@{{value.content.other || 'empty'}}</span>
            </div>
            <div class="">
                <span>Multiple laser configuaration: </span>
                <span>@{{value.content.mlcc || false}}</span>
            </div>
            <div class="">
                <span>Dual laser system: </span>
                <span>@{{value.content.dlsc || false}}</span>
            </div>
            <div class="">
                <span>Global minimum recommended laser power: </span>
                <span>@{{value.content.min_global_laser || 0}}</span>
            </div>
            <div class="">
                <span>Global maximum recommended laser power: </span>
                <span>@{{value.content.max_global_laser || 0}}</span>
            </div>
            <div class="">
                <span>Laser Marking : </span>
                <span>@{{value.content.marking || false}}</span>
            </div>
            <div class="">
                <span>Laser Engraving: </span>
                <span>@{{value.content.engraving || false}}</span>
            </div>
            <div class="">
                <span>Engrave mark recommended power: </span>
                <span>@{{value.content.engrave_mark_recommended_power || 0}}</span>
            </div>
        </div>
    </div>
    <div class="">
        <div class=""><strong>Question</strong>:</div>
        <div class="">
            <span>Question 1: </span>
            <span>@{{listAnswerMapData[dataInput.question_first] || 'empty'}}</span>
        </div>
        <div class="">
            <span>Question 2: </span>
            <span>@{{listAnswerMapData[dataInput.question_second] || 'empty'}}</span>
        </div>
        <div class="">
            <span>Question 3: </span>
            <span>@{{listAnswerMapData[dataInput.question_third] || 'empty'}}</span>
        </div>
    </div>
    <div  class="" ng-show="currentPlatForm.result.name">
        <div class="">
            <strong class="">Platform: </strong><span>@{{currentPlatForm.result.name}}</span>
        </div>
    </div>
</div>