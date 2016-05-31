<h2>Step 3</h2>
<section>
    <section class="config">
      <div class="wrap-step-tree">
        <div class="top-step margin-bottom-30">
          <div class="col-md-4 margin-bottom-15">
            <h4 class="text-blue margin-bottom-15">Suggested Platform</h4>
            <div class="img">
              <figure class="image">
              <a href="@{{currentPlatForm.result.linkImagePlatform}}">
                <img width="100%" src="@{{currentPlatForm.result.linkImagePlatform}}" alt="img platform">
              </a>
              </figure>
            </div>
          </div>
          <div class="col-md-8 margin-bottom-15">
            <h4 class="text-blue margin-bottom-15">@{{currentPlatForm.result.name}}</h4>
            @{{currentPlatForm.result.description}}
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="bottom-step padding-15">
          <h4 class="text-blue margin-bottom-15">Option</h4>
          <hr>
          <p class="margin-bottom-30">
            Listed are the available options for your platform.  Select the desired options to complete your laser system.
          </p>
          <div class="content-step">
            <div class="col-md-8 padding-0 margin-bottom-15" ng-repeat="(key, value) in currentPlatForm.categories">
              <h4 class="text-blue margin-bottom-15">@{{value}}</h4>
              <div class="box-item border padding-10" ng-repeat="(key1, accessory) in currentPlatForm.accessories[key]">
                <div class="col-md-8 padding-0">
                  <h5 class="margin-bottom-15">@{{accessory.name}}</h5>
                  <p class="line-height-30 margin-bottom-15">
                    @{{accessory.description}}
                  </p>
                  <p class="margin-bottom-15"><strong>Benefits</strong></p>
                  <ul class="padding-left-20">
                    @{{accessory.benefits}}
                   <!--  <li class="margin-bottom-15">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
                    <li class="margin-bottom-15" >Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li> -->
                  </ul>
                </div>
                <div class="col-md-4 text-center padding-0">
                  <div class="image margin-bottom-50">
                    <figure class="image">
                      <a href="@{{accessory.linkImage}}"><img width="90%" src="@{{accessory.linkImage}}"></a>
                    </figure>
                  </div>
                  <button class="btn btn-blue btn-large" ng-click="addAccessories(accessory)">ADD</button>
                </div>
                <div class="clearfix"></div>
                
              </div>
            </div>
            <div class="col-md-4 margin-bottom-15">
              <div class="box-accessories">
                <h4 class="text-center">Selected Accessories</h4>
                <div class="box-content">
                  <div class="item" ng-repeat="(key, value) in dataInput.selectedAccessories">
                    <a href="javascript:void(0)" ng-click="deleteAccessories(value.id)">Delete</a>
                    <a href="@{{accessory.linkImage}}"><img src="@{{value.linkImage}}"></a>
                    <span>@{{value.name}}</span>
                  </div>
                </div>
                <div class="box-bottom text-center">
                  <button class="btn btn-blue btn-large full-width alert-question-finish" href="#alert-question-finish">FINISHED</button>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </section>
</section>

<form id="alert-question-finish" class="mfp-hide">
      <img src="images/page/icon-times.png" class="mfp-close">
      <div class="wrap-box-contact">

        <div class="main-box">
            <p class="title-alert-center">Do you need to select another Accessory?</p>
            <div class="text-center">
              <button class="btn btn-blue btn-large" ng-click="closeSelectedAccessory()">Yes </button>
              <button class="btn btn-blue btn-large" ng-click="finishStep()">No </button>
            </div>
            
        </div>
      </div>
    </form>