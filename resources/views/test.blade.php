@extends('app')
@section('content')
<div class="wrap-group-option" data-ng-controller="testCtrl">
    <section class="group-checked top">
      <h4 class="title">
         <a class="text-more" data-toggle="collapse" href="#brand" aria-expanded="true" aria-controls="brand">
         <span class="more text-red">Brand <i class="fa fa-caret-right"></i> <i class="fa fa-caret-down"></i></span>
         </a>
      </h4>
      <div class="wrap collapse in" id="brand" aria-expanded="true">
        <div class="form-group">
          <div class="item">
              <input type="checkbox" value=".3m" ng-model="id['3m']" ng-click="getTags(id)" ng-true-value="'56ab6164df3576b2358b4568'" ng-false-value="''"><span class="tage_name">3M</span>
             </div>
          </div>
                                                         <div class="form-group">
          <div class="item">
                <input type="checkbox" value=".dupont" ng-model="id['dupont']" ng-click="getTags(id)" ng-true-value="'56ab6164df3576b2358b4569'" ng-false-value="''"><span class="tage_name">DuPont</span>
          </div>
        </div>
        <div class="form-group">
          <div class="item">
                <input type="checkbox" value=".rowmark"><span class="tage_name">Rowmark</span>
          </div>
        </div>
        <div class="form-group">
          <div class="item">
                <input type="checkbox" value=".stahls"><span class="tage_name">Stahls</span>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </section>
    <section class="group-checked ">
      <h4 class="title">
         <a class="text-more" data-toggle="collapse" href="#end_products" aria-expanded="true" aria-controls="end_products">
         <span class="more text-red">End Products <i class="fa fa-caret-right"></i> <i class="fa fa-caret-down"></i></span>
         </a>
      </h4>

                    <div class="wrap collapse in" id="end_products" aria-expanded="true">

                                                   <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".sign_signage"><span class="tage_name">Sign/Signage</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".award_recognition_personalization"><span class="tage_name">Award/Recognition/Personalization</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".model"><span class="tage_name">Model</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".guitar"><span class="tage_name">Guitar</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".gasket"><span class="tage_name">Gasket</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".sporting_goods"><span class="tage_name">Sporting Goods</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".brick"><span class="tage_name">Brick</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".tool"><span class="tage_name">Tool</span>
                     </div>
                  </div>
                                             <div class="clearfix"></div>
               </div>
         </section>
    <section class="group-checked ">
      <h4 class="title">
         <a class="text-more" data-toggle="collapse" href="#materials" aria-expanded="true" aria-controls="materials">
         <span class="more text-red">Materials <i class="fa fa-caret-right"></i> <i class="fa fa-caret-down"></i></span>
         </a>
      </h4>

                    <div class="wrap collapse in" id="materials" aria-expanded="true">

                                               <div class="form-group">
                  <h5 class="text-red sub-title">
                     <a class="text-more" data-toggle="collapse" href="#plastic" aria-expanded="true" aria-controls="plastic">
                     <span class="more text-red">Plastic <i class="fa fa-caret-right"></i> <i class="fa fa-caret-down"></i></span>
                     </a>
                  </h5>
                  <div class="collapse in" id="plastic" aria-expanded="true">
                                             <div class="item">
                           <input type="checkbox" value=".acrylic"><span class="tage_name">Acrylic</span>
                        </div>
                                             <div class="item">
                           <input type="checkbox" value=".kapton"><span class="tage_name">Kapton</span>
                        </div>
                                             <div class="item">
                           <input type="checkbox" value=".thin_film_polymer"><span class="tage_name">Thin Film Polymer</span>
                        </div>
                                       </div>
               </div>
                                                             <div class="form-group">
                  <h5 class="text-red sub-title">
                     <a class="text-more" data-toggle="collapse" href="#metal" aria-expanded="true" aria-controls="metal">
                     <span class="more text-red">Metal <i class="fa fa-caret-right"></i> <i class="fa fa-caret-down"></i></span>
                     </a>
                  </h5>
                  <div class="collapse in" id="metal" aria-expanded="true">
                                             <div class="item">
                           <input type="checkbox" value=".stainless_steel"><span class="tage_name">Stainless Steel</span>
                        </div>
                                             <div class="item">
                           <input type="checkbox" value=".anodized_aluminum"><span class="tage_name">Anodized Aluminum</span>
                        </div>
                                             <div class="item">
                           <input type="checkbox" value=".aluminium"><span class="tage_name">Aluminium</span>
                        </div>
                                             <div class="item">
                           <input type="checkbox" value=".anodized"><span class="tage_name">Anodized</span>
                        </div>
                                             <div class="item">
                           <input type="checkbox" value=".titanium"><span class="tage_name">Titanium</span>
                        </div>
                                             <div class="item">
                           <input type="checkbox" value=".brass"><span class="tage_name">Brass</span>
                        </div>
                                       </div>
               </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".glass"><span class="tage_name">Glass</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".stone"><span class="tage_name">Stone</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".ceramic"><span class="tage_name">Ceramic</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".wood"><span class="tage_name">Wood</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".paper"><span class="tage_name">Paper</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".fabric"><span class="tage_name">Fabric</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".rubber___elastomers"><span class="tage_name">Rubber / Elastomers</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".foam"><span class="tage_name">Foam</span>
                     </div>
                  </div>
                                             <div class="clearfix"></div>
               </div>
         </section>
    <section class="group-checked ">
      <h4 class="title">
         <a class="text-more" data-toggle="collapse" href="#other" aria-expanded="true" aria-controls="other">
         <span class="more text-red">Other <i class="fa fa-caret-right"></i> <i class="fa fa-caret-down"></i></span>
         </a>
      </h4>

                    <div class="wrap collapse in" id="other" aria-expanded="true">

                                                   <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".industrial"><span class="tage_name">Industrial</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".3d"><span class="tage_name">3D</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".checkered"><span class="tage_name">Checkered</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".photo_photography"><span class="tage_name">Photo/Photography</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".serialization"><span class="tage_name">Serialization</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".bar_code"><span class="tage_name">Bar Code</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".code"><span class="tage_name">Code</span>
                     </div>
                  </div>
                                             <div class="clearfix"></div>
               </div>
         </section>
    <section class="group-checked ">
      <h4 class="title">
         <a class="text-more" data-toggle="collapse" href="#process" aria-expanded="true" aria-controls="process">
         <span class="more text-red">Process <i class="fa fa-caret-right"></i> <i class="fa fa-caret-down"></i></span>
         </a>
      </h4>

                    <div class="wrap collapse in" id="process" aria-expanded="true">

                                                   <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".cut"><span class="tage_name">Cut</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".engrave"><span class="tage_name">Engrave</span>
                     </div>
                  </div>
                                                                 <div class="form-group">
                     <div class="item">
                        <input type="checkbox" value=".mark"><span class="tage_name">Mark</span>
                     </div>
                  </div>
                                             <div class="clearfix"></div>
               </div>
         </section>
        <div class="clearfix"></div>
</div>
@stop
@section('script')
  {!! Html::script('app/components/test/TestController.js?v='.getVersionScript())!!}
  {!! Html::script('app/components/test/TestService.js?v='.getVersionScript())!!}
@stop
