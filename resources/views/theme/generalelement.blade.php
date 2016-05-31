<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->


@extends('app')

<style>
    body {
    padding: 20px;
}
.slides {
    list-style: none;
    margin: 0;
    padding: 0;
    width: 300px;
}
.slide {
    padding: 15px;
    background-color: #2F2F2F;
    margin: 0 0 15px;
    text-align: center;
    color: #FFF;
    border: 2px solid #444;
    cursor: move;
}
ul .slide:first-of-type{
    background: red;
}

.slide-placeholder {
    background: #DADADA;
    position: relative;
}
.slide-placeholder:after {
    content: " ";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 15px;
    background-color: #FFF;
}

.slide2 {
    height: 30px;
}
.slide3 {
    height: 50px;
}
.slide4 {
    height: 90px;
}
.slide5 {
    height: 35px;
}

</style>
@section('content')

<div>
    <div class="top-content">
        <label class="c-m"> General Element
            <a data-toggle="modal" data-target=".bs-example-modal-lg"><i title="Help Information" class="fa fa-info-circle help-infor-icon"></i></a>
            <a class="btn btn-primary pull-right fixed-add"><i class="fa fa-plus"></i> Add Role</a>
        </label>
    </div>

    <div class="content">
        <!-- Responsive Web Design in Sass: Using media queries in Sass 3.2 -->
        <div class="profile-pic">
            Hoan heo
        </div>
        <!-- end -->

        <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
              Launch demo modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg full-modal" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Guide Configurator</h4>
                  </div>
                  <div class="modal-body padding-none">
                    <wizard on-finish="finishedWizard()"> 
                        <wz-step wz-title="Step 0" wz-disabled="{{}}">
                            <div class="p-15">
                                <label class="label-form">
                                    Email
                                </label>
                                <div class="wrap-form">
                                    <input class="form-control" placeholder="Email" type="text" name="">
                                </div>
                            </div>

                            <div class="p-15">
                                <a class="btn btn-primary" type="submit" wz-next value="Continue">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i> Continue
                                </a>
                            </div>

                        </wz-step>

                        <wz-step wz-title="Step 1">
                        <div class="content margin-top-0 height-50-percent">
                            <div id="resize-left">
                                <!-- <div data-toggle="tree" id="tree"></div> -->
                            </div>

                            <div id="resize-right" class="fix-td-tb">
                                <!-- <div class="table-responsive table-database">
                                    <a class="fixed-search" ng-click="btnSearch()">
                                        <i class="fa fa-search"></i>
                                    </a>

                                    <table class="table set-padding table-min-1200" show-filter="isSearch">
                                        <thead>
                                            <tr>
                                                <th>Material ID</th>
                                                <th>Parent Category ID</th>
                                                <th>Material Name</th>

                                                <th>Engrave Mark Recommended Power</th>
                                                <th>Min Thickness</th>

                                                <th>PowerAtMinThickness</th>

                                                <th>Max Thickness</th>
                                                <th>Power AtMax Thickness</th>
                                                <th>Laser Type</th>
                                                <th>Fixed Thickness</th>
                                                <th>Can Be Cut</th>
                                                <th>Can Be Rastered</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody-animate">
                                        
                                            <tr class="parent-active">

                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>

                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                                <td>N/A</td>
                                                <td>N/A</td>
                                                <td>N/A</td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    

                                </div> -->

                                <div class="table-responsive wrap-box-content full-height-1">
                                    <!-- <a class="fixed-search" ng-click="btnSearch()">
                                        <i class="fa fa-search"></i>
                                    </a> -->
                                    <table class="table center-td table-striped table-min-1500">
                                        <thead>
                                            <tr>
                                                <th>Material ID</th>
                                                <th>Category ID</th>
                                                <th>Material Name</th>

                                                <th>Engrave/Mark Recommended Power</th>
                                                <th>Min Thickness</th>
                                                <th>Recommended Power For Min Thickness</th>

                                                <th>Max Thickness</th>
                                                <th>Recommended Power For Max Thickness</th>
                                                <th>Laser Type</th>
                                                

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>
                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                                
                                            </tr>

                                            <tr>
                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>
                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                            </tr>

                                            <tr>
                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>
                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                            </tr>

                                            <tr>
                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>
                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                            </tr>

                                            <tr>
                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>
                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                            </tr>

                                            <tr>
                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>
                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                            </tr>

                                            <tr>
                                                <td> 61006</td>
                                                <td>61</td>
                                                <td>2019M-74 Adhesive</td>

                                                <td>0</td>
                                                <td>0.018</td>
                                                <td>30</td>

                                                <td>0.018</td>
                                                <td>30</td>
                                                <td>CO2</td>
                                            </tr>
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="sidebar-resizer" resizer="vertical" resizer-width="0" resizer-left="#resize-left" resizer-right="#resize-right" resizer-max="500" resizer-position-left="300">
                            </div>

                        </div>

                            <div class="p-15">
                                <a class="btn btn-primary pull-right" type="submit" wz-next value="Continue">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i> Continue
                                </a>
                                <div class="clearfix">
                                    
                                </div>
                            </div>
                            
                        </wz-step>

                        <wz-step wz-title="Step 2">
                            
                            <a class="btn btn-primary" type="submit" wz-next value="Continue">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i> Continue
                            </a>
                        </wz-step>
                    </wizard>
                  </div>
                  <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div> -->
                </div>
              </div>
            </div>

        <!-- for example dynamically change text color based on its background -->
        <div class="">
            <p class="notification notification-confirm">Confirm Notification</p>
            <p class="notification notification-warning">Warning Notification</p>
            <p class="notification notification-alert">Alert Notification</p>
        </div>
        <!-- end -->
        <div class="">
            <button class="button1">semi-transparent colors</button>
        </div>

        <div class="">
            <button class="button2">semi-transparent colors</button>
        </div>
        <div class="box-with-title">
            <div class="box-with-title-top">
                <p class="title">Title</p>
            </div>
            <div class="box-with-title-body">

                <div class="box-child">
                    <div class="box-child-top">
                        <span>04-04-2016 11:14:42 AM</span>
                        <span>Name 
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="box-child-body">
                        <div class="m-b-10">
                            <span>Action:</span>
                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> Update</a>    
                        </div>
                        
                        <div class="message-box">
                            <i class="fa fa-comment"></i>
                            <span>Scenario Desk Admin is attached to role Super Admin by Jacob111 Sparks</span>
                        </div>
                    </div>
                </div>

                <div class="box-child">
                    <div class="box-child-top">
                        <span>04-04-2016 11:14:42 AM</span>
                        <span>Name 
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="box-child-body">
                        <div class="m-b-10">
                            <span>Action:</span>
                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> Update</a>    
                        </div>
                        
                        <div class="message-box">
                            <i class="fa fa-comment"></i>
                            <span>Scenario Desk Admin is attached to role Super Admin by Jacob111 Sparks</span>
                        </div>
                    </div>
                </div>

                <div class="box-child">
                    <div class="box-child-top">
                        <span>04-04-2016 11:14:42 AM</span>
                        <span>Name 
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="box-child-body">
                        <div class="m-b-10">
                            <span>Action:</span>
                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> Update</a>    
                        </div>
                        
                        <div class="message-box">
                            <i class="fa fa-comment"></i>
                            <span>Scenario Desk Admin is attached to role Super Admin by Jacob111 Sparks</span>
                        </div>
                    </div>
                </div>

                <div class="box-child">
                    <div class="box-child-top">
                        <span>04-04-2016 11:14:42 AM</span>
                        <span>Name 
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="box-child-body">
                        <div class="m-b-10">
                            <span>Action:</span>
                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> Update</a>    
                        </div>
                        
                        <div class="message-box">
                            <i class="fa fa-comment"></i>
                            <span>Scenario Desk Admin is attached to role Super Admin by Jacob111 Sparks</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <nav>
                        <ul class="pagination">
                            <li class="disabled">
                                <a href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>

                            <li class=""><a href="#">2 <span class="sr-only">(current)</span></a></li>

                            <li class=""><a href="#">3 <span class="sr-only">(current)</span></a></li>

                            <li class=""><a href="#">4 <span class="sr-only">(current)</span></a></li>

                            <li class="disabled">
                                <a href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            
                        </ul>
                    </nav>    
                </div>
            </div>
        </div>
        
        <div class="vertical-box">
            <span class="fa fa-circle yellow-status" tooltip="Not Started" tooltip-trigger tooltip-animation="true" tooltip-placement="top"></span>
        </div>

        <div><i class="fa fa-spinner fa-spin"></i></div>

        <div class="wrap-progress-circle">
            <div class="c100 p10 small">
                <span>10%</span>
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
        </div>

        <div class="wrap-box-title">
            <label class="label-form">
                <a data-toggle="collapse"  data-target="#parentBlockid1" class="capitalize accordion-toggle have-bg-grey collapsed">
                    <span class="f16">Parent Name &nbsp</span>
                </a>
            </label>

            <a  class="pointer btn btn-xs btn-upload m-l-20 pull-right">
                <i class="fa fa-plus-square"></i>  Add
            </a>
            
            <!-- wrap first -->
            <div id="parentBlockid1" class="collapse">

                <div class="panel-group">
                    <div class="panel panel-default have-border">
                        <div class="panel-heading have-bg fix-height">
                            <h4 class="panel-title relative">
                                <span class="position-close">
                                    <i class="ti-close"></i>
                                </span>

                                <span class="position-move c-828282" tooltip="Click to move down" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                    <i class="fa fa-arrow-down"></i>
                                </span>

                                <a data-toggle="collapse"  data-target=".blockid1" class="capitalize accordion-toggle">
                                
                                    Name 1 &nbsp
                                </a>
                                <div class="clearfix"></div>
                            </h4>
                        </div>

                        <div id="blockid1" class="collapse in bg-fff">
                            
                        </div>
                    </div>
                    <div class="panel-body wrap-nested collapse blockid1">

                        <label for=""> dfdfdf</label>
                        Content Block 1
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 

                        <div>
                            <div class="panel-group" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default have-border">
                                    <div class="panel-heading have-bg fix-height" role="tab" id="headingOne">
                                        <h4 class="panel-title relative">
                                            <span class="position-close">
                                                <i class="ti-close"></i>
                                            </span>

                                            <span class="position-move c-828282" tooltip="Click to move down" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                                <i class="fa fa-arrow-down"></i>
                                            </span>
                                            <a data-toggle="collapse"  data-target="#nestedblock1" class="capitalize accordion-toggle">
                                            Name
                                            </a>
                                            <div class="clearfix"></div>
                                        </h4>
                                    </div>

                                    <div id="nestedblock1" class="panel-collapse collapse in bg-fff" role="tabpanel">
                                        <div class="panel-body">
                                            Content Block 1
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="panel-group" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default have-border">
                                    <div class="panel-heading have-bg fix-height" role="tab" id="headingOne">
                                        <h4 class="panel-title relative">
                                            <span class="position-close">
                                                <i class="ti-close"></i>
                                            </span>

                                            <span class="position-move c-828282" tooltip="Click to move down" tooltip-trigger tooltip-animation="true" tooltip-placement="top">
                                                <i class="fa fa-arrow-down"></i>
                                            </span>
                                            <a data-toggle="collapse"  data-target="#nestedblock2" class="capitalize accordion-toggle">
                                            
                                                Name &nbsp
                                            </a>
                                            <div class="clearfix"></div>
                                        </h4>
                                    </div>

                                    <div id="nestedblock2" class="panel-collapse collapse in bg-fff" role="tabpanel">
                                        <div class="panel-body">
                                            Content Block 1
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        
                    </div>
                </div>

                

            </div>

        </div>

        <div class="dropdown">
          <button class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown trigger
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Separated link</a></li>
          </ul>
        </div>

        <div class="page-header">
          <h3>Tab</h3>
        </div>

        <div class="tab-border">

           <!-- Nav tabs -->
           <ul id="tab-border" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#tab-border1" aria-controls="home" role="tab" data-toggle="tab">Home</a>
                </li>
                <li role="presentation">
                    <a href="#tab-border2" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
                </li>
                <li role="presentation">
                    <a href="#tab-border3" aria-controls="messages" role="tab" data-toggle="tab">Messages</a>
                </li>
                <li role="presentation">
                    <a href="#tab-border4" aria-controls="settings" role="tab" data-toggle="tab">Settings</a>
                </li>
           </ul>

          <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="tab-border1">1</div>
              <div role="tabpanel" class="tab-pane fade" id="tab-border2">2</div>
              <div role="tabpanel" class="tab-pane fade" id="tab-border3">3</div>
              <div role="tabpanel" class="tab-pane fade" id="tab-border4">4</div>
            </div>
        </div>

        <div class="tab-primary">
            <ul id="tab-primary" class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#tab-primary1" role="tab" data-toggle="tab">
                        <i class="fa fa-list-alt"></i> Detail
                    </a>
                </li>
                <li class="">
                    <a href="#tab-primary2" role="tab" data-toggle="tab">
                        <i class="fa fa-file-code-o"></i> Content
                    </a>
                </li>
                <li>
                    <a href="#tab-primary3" role="tab" data-toggle="tab">
                        <i class="fa fa-file-code-o"></i> Usage
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="tab-primary1">1</div>
              <div role="tabpanel" class="tab-pane fade" id="tab-primary2">2</div>
              <div role="tabpanel" class="tab-pane fade" id="tab-primary3">3</div>              
            </div>
        </div>

        <div class="large-tab">
            <ul id="large-tab" class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#large-tab1" role="tab" data-toggle="tab">
                         
                        <div class="thumbnail-page">
                            <figure>
                                <span class="fa fa-info-circle f-80"></span>
                            </figure>
                            <span class="name">Details
                                <i class="fa fa-check-circle"></i>
                            </span>
                        </div>
                    </a>
                </li>
                <li class="">
                    <a href="#large-tab2" role="tab" data-toggle="tab">
                         
                        <div class="thumbnail-page">
                            <figure>
                                <img width="100%" ng-src="/thumbnail_default.jpg" alt="" src="/thumbnail_default.jpg">
                            </figure>
                            <span class="name">Details
                                <i class="fa fa-check-circle"></i>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#large-tab3" role="tab" data-toggle="tab">
                         
                        <div class="thumbnail-page">
                            <figure>
                                <span class="fa fa-info-circle f-80"></span>
                            </figure>
                            <span class="name">Details
                                <i class="fa fa-check-circle"></i>
                            </span>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="large-tab1">1</div>
              <div role="tabpanel" class="tab-pane fade" id="large-tab2">2</div>
              <div role="tabpanel" class="tab-pane fade" id="large-tab3">3</div>              
            </div>
        </div>

        <div class="tab-alert">
            <ul id="tab-alert" class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#tab-alert1" role="tab" data-toggle="tab">
                        
                        <div class="thumnail-page box">
                            <span class="name">
                                Detail
                                <i class="status ti-alert"></i>
                            </span>
                        </div>
                    </a>
                </li>
                <li class="">
                    <a href="#tab-alert2" role="tab" data-toggle="tab">
                     
                        <div class="thumnail-page box">
                            <span class="name">
                                    Content
                                    <i class="status ti-alert"></i>       
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#tab-alert3" role="tab" data-toggle="tab">
                     
                        <div class="thumnail-page box">
                            <span class="name">
                                Usage
                                <i class="status ti-alert"></i>
                            </span>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="tab-alert1">1</div>
              <div role="tabpanel" class="tab-pane fade" id="tab-alert2">2</div>
              <div role="tabpanel" class="tab-pane fade" id="tab-alert3">3</div>              
            </div>
        </div>

        <div class="bs-example" data-example-id="panel-with-list-group">
            <div class="panel panel-default"> 
                <div class="panel-heading">Panel heading</div>
            <div class="panel-body">
                <p>Some default panel content here. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            </div> 
            <ul class="list-group">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Morbi leo risus</li>
                <li class="list-group-item">Porta ac consectetur ac</li>
                <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
    </div>  
</div>


@stop

