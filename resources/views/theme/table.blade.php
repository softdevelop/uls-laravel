<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->


@extends('app')

@section('content')
<div>
	<div class="top-content">
	    <label class="c-m">Table
	    	<a data-toggle="modal" data-target=".bs-example-modal-lg"><i title="Help Information" class="fa fa-info-circle help-infor-icon"></i></a>
	        <!-- <a class="btn btn-primary pull-right fixed-add"><i class="fa fa-plus"></i> Add Role</a> -->
	    </label>
	</div>

	<div class="content">
		<div class="logo" style="position:relative;">
			<a href="#sidebar-menu-toggle" class="btn-on-off hidden-xs" id="sidebar-menu-toggle">
		        <span id="switch"></span>
		    </a>
		</div>

<!-- 		<div class="page-header">
		  <h1>All Table</h1>
		</div> -->

		<!-- table sub table no user ngtable - can't use search and Function sort, filter... -->
		<div class="wrap-children-ticket">
		    <h3>Child Tickets</h3>
		    <div class="table-responsive wrap-box-content">
		        <table class="table table-striped center-td table-for-child-ticket-details">
		            <thead>
		                <tr>
		                    <th colspan="9" class="padding-none">
		                        <div>
		                            <table class="table center-td margin-none min-width-1010">
		                                <tr>
		                                    <td class="w70"></td>
		                                    <td class="text-hightlight-head-table w-104">Ticket ID</td>
		                                    <td class="text-hightlight-head-table w100">Ticket Type</td>
		                                    <td class="text-hightlight-head-table w100">Description</td>
		                                    <td class="text-hightlight-head-table w100">Status</td>
		                                    <td class="text-hightlight-head-table w100">Priority</td>
		                                    <td class="text-hightlight-head-table w100">Assignee</td>
		                                    <td class="text-hightlight-head-table w150">Date Started</td>
		                                    <td class="text-hightlight-head-table w150">Due Date</td>
		                                    <td class="text-hightlight-head-table w200">Percent Complete</td>
		                                </tr>
		                            </table>
		                        </div>
		                    </th>
		                </tr>
		            </thead>

		            <tbody id="responsive-table-body" class="table-child-ticket-details">
		                <tr class="pointer">
		                    <td class="show-gradation padding-none">
								<div class="show-animate">
									<ul class="style-ul">
							            <li id="li-select-tag-id1">
							                
							                    <a class="a-wrap-table padding-none" href="/support/show/id1">
							                        <!-- table for child ticket details -->
							                        <table class="table center-td margin-none min-width-1160">
							                            <tr class="child-active child-tag">
							                                <td class="text-center child-plus-or-minus w70 border-bottom padding-none" data-title="''" >
							                                    <a class="btn-toggle-id1 block-c-000" data-toggle="collapse" data-target="#show-sub-select-id1" >
							                                        <i class="fa fa-plus" ng-click="showSubSelect($event, value.id)"></i>
							                                    </a>
							                                </td>
							                                <td data-title="'Ticket ID'" class="w-104 border-bottom">id1</td>

							                                <td data-title="'Ticket Type'" class="w100 border-bottom">Page Html</td>

							                                <td data-title="'Description'" class="w100 border-bottom">Page 3</td>

							                                <td data-title="'Status'" class="w100 border-bottom" >New</td>

							                                <td data-title="'Priority'" class='w100 border-bottom' >Medium</td>

							                                <td data-title="'Assignee'" class="w100 border-bottom">Unassignee</td>

							                                <td data-title="'Date Started'" class="w150 border-bottom" >1/1/1</td>

							                                <td data-title="'Due Date'" class="w150 border-bottom" >
							                                    <span ng-if="!hideDueDate">
							                                        1/1/1       
							                                    </span>
							                                </td>

							                                <td data-title="'Percent Complete'" class="w200 border-bottom" >
							                                    <span class="fix-space-progress progress progress-normal col-lg-12 padding-none">
							                                    <span class="progress-bar progress-bar-primary" style="width:50%"></span>
							                                </td>
							                            </tr>
							                        </table>
							                        <!-- table for child ticket details -->
							                    </a>
							                    
							                    <ul class="style-ul collapse show-inset" id="show-sub-select-id1">
							                        <li id="li-select-tag-id1">
							                
									                    <a class="a-wrap-table padding-none" href="/support/show/id1">
									                        <!-- table for child ticket details -->
									                        <table class="table center-td margin-none min-width-1160">
									                            <tr class="child-active child-tag">
									                                <td class="text-center child-plus-or-minus w70 border-bottom padding-none" data-title="''" >
									                                    <a class="btn-toggle-id1 block-c-000" data-toggle="collapse" data-target="#show-sub-select-id2" >
									                                        <i class="fa fa-plus p-15" ng-click="showSubSelect($event, value.id)"></i>
									                                    </a>
									                                </td>
									                                <td data-title="'Ticket ID'" class="w-104 border-bottom">id1</td>

									                                <td data-title="'Ticket Type'" class="w100 border-bottom">Page Html</td>

									                                <td data-title="'Description'" class="w100 border-bottom">Page 3</td>

									                                <td data-title="'Status'" class="w100 border-bottom" >New</td>

									                                <td data-title="'Priority'" class='w100 border-bottom' >Medium</td>

									                                <td data-title="'Assignee'" class="w100 border-bottom">Unassignee</td>

									                                <td data-title="'Date Started'" class="w150 border-bottom" >1/1/1</td>

									                                <td data-title="'Due Date'" class="w150 border-bottom" >
									                                    <span ng-if="!hideDueDate">
									                                        1/1/1       
									                                    </span>
									                                </td>

									                                <td data-title="'Percent Complete'" class="w200 border-bottom" >
									                                    <span class="fix-space-progress progress progress-normal col-lg-12 padding-none">
									                                    <span class="progress-bar progress-bar-primary" style="width:50%"></span>
									                                </td>
									                            </tr>
									                        </table>
									                        <!-- table for child ticket details -->
									                    </a>
									                    
									                    <ul class="style-ul collapse show-inset" id="show-sub-select-id2">
									                        <li ng-repeat="(index, value) in value.children" ng-include="'subSelect-@{{index}}'"></li>
									                    </ul>
									                     
									            </li>
							                    </ul>
							                     
							            </li>
							        </ul>
							    </div>
							</td>
		                </tr>
		            </tbody>
		        </table>
		    </div>
		</div>

		<!-- <div class="table-responsive list-ticket wrap-box-content">
		    <table class="table table-list table-list-ticket">
		        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		            <i class="fa fa-search"></i>
		        </a>
		        <thead>
		        	<tr>
		        		<th>1</th>
		        		<th>2</th>
		        		<th>ID</th>
		        		<th>Type</th>
		        		<th>Subject</th>
		        		<th>Status</th>
		        		<th>Priority</th>
		        		<th>Assignee</th>
		        		<th>Date Started</th>
		        		<th>Due Date</th>
		        		<th>Percent Complete</th>
		        		<th>Action</th>
		        	</tr>
		        </thead>
		        <tbody id="responsive-table-body">
		            <tr class="pointer">
		                <td colspan="13" class="padding-none">
		                    <a class="a-wrap-table" href="#">
		                        <table class="full-width">
		                            <tr>
		                                <td class="text-center">
		                                    <a class="c-000" href="javascript:void(0)">
		                                        <i class="fa fa-minus p-15"></i>
		                                    </a>
		                                </td>

		                                
		                                <td>
		                                    

		                                    <div class="checkbox checkbox-success fix-label-checkbox">
		                                        <input  type="checkbox" id="checkbox-id1"/>
		                                        <label for="checkbox-id1">
		                                        </label>
		                                    </div>
		                                </td>
		                                

		                                <td data-title="'Id'">id1</td>

		                                <td class=" position-select" data-title="'Type'">Create New Page</td>
		                                
		                                <td class="" data-title="'Subject'">Page 3</td>

		                                <td  class="" data-title="'Status'">
		                                    New
		                                </td>

		                                <td  class=" position-select" data-title="'Priority'">Medium</td>

		                                <td  class="" data-title="'Assignee'">
		                                    <span>Unassigned</span>
		                                </td>
		                                
		                                <td  class="" data-title="'Date Started'">1/1/1</td>

		                                <td class="w-110" data-title="'Due Date'">
		                                    <span >
		                                        1/1/1
		                                    </span>
		                                </td>
		                                <td class="fix-space-progress" data-title="'Percent Complete'">
		                                    <span class="progress progress-normal full-left">
		                                        <span class="progress-bar progress-bar-primary">50%</span>    
		                                    </span>
		                                </td>
		                            </tr>
		                        </table>
		                    </a>
		                </td>
		                
		            </tr>
		            <tr class="child-active">
		                <td colspan="12" class="padding-none">
		                    <a class="a-wrap-table" href="#">
		                        <table class="full-width">
		                            <tr>
		                                <td></td>

		                                
		                                <td>
		                                    

		                                    <div class="checkbox checkbox-success fix-label-checkbox">
		                                        <input id="checkbox-id1" type="checkbox"/>
		                                        <label for="checkbox-id1">
		                                        </label>
		                                    </div>
		                                </td>
		                                
		                                <td data-title="'Id'">id1</td>
		                                <td class=" position-select" data-title="'Type'">Create New Page</td>
		                                <td class="" data-title="'Subject'">Page3</td>
		                                <td  class="" data-title="'Status'">New</td>
		                                <td  class=" position-select" data-title="'Priority'">Medium</td>
		                                <td  class="" data-title="'Assignee'">
		                                    <span>Unassigned</span>
		                                </td>
		                               
		                                <td  class="" data-title="'Date Started'">1/1/1</td>
		                                <td class=" w-110" data-title="'Due Date'">
		                                    <span>
		                                        1/1/1
		                                    </span>
		                                </td>
		                                <td data-title="'Percent Complete'">
		                                    <span class="progress progress-normal full-left">
		                                        <span class="progress-bar progress-bar-primary">50%</span>    
		                                    </span>
		                                </td>
		                            </tr>
		                        </table>
		                    </a>
		                </td>
		                
		            </tr>
		        </tbody>
		    </table>
		</div> -->


		<!-- base table -->
		<div class="page-header">
			<h4 class="text-center c-primary">Table center Striped</h4>
		</div>

		<div class="table-responsive">
			<table class="table center-td table-striped">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-center c-primary">Table center hover</h4>
		</div>

		<div class="table-responsive">
			<table class="table center-td table-hover">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-center c-primary">Table center border</h4>
		</div>

		<div class="table-responsive">
			<table class="table center-td table-bordered">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<!-- table border radius with white background-->
		<div class="page-header">
			<h4 class="text-center c-primary">Table center Striped</h4>
		</div>

		<div class="table-responsive wrap-box-content white-bg">
			<table class="table center-td table-striped">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-center c-primary">Table center hover</h4>
		</div>

		<div class="table-responsive wrap-box-content white-bg">
			<table class="table center-td table-hover">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-center c-primary">Table center border</h4>
		</div>

		<div class="table-responsive wrap-box-content white-bg">
			<table class="table center-td table-bordered">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<!-- base table -->
		<div class="page-header">
			<h4 class="text-left c-primary">Table left Striped</h4>
		</div>

		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-left c-primary">Table left hover</h4>
		</div>

		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-left c-primary">Table left border</h4>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<!-- table border radius with white background-->
		<div class="page-header">
			<h4 class="text-left c-primary">Table left Striped</h4>
		</div>

		<div class="table-responsive wrap-box-content white-bg">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-left c-primary">Table left hover</h4>
		</div>

		<div class="table-responsive wrap-box-content white-bg">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>

		<div class="page-header">
			<h4 class="text-left c-primary">Table left border</h4>
		</div>

		<div class="table-responsive wrap-box-content white-bg">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Action</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>

					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>	
		</div>






		<!-- 
		<div class="checkbox checkbox-circle">
		    <input id="checkbox7" class="styled" type="checkbox">
		    <label for="checkbox7">
		        Simply Rounded
		    </label>
		</div>


		<div class="dropdown">
		  <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		    Dropdown trigger
		    <span class="caret"></span>
		  </a>

			<ul class="dropdown-menu" aria-labelledby="dLabel">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="#">Separated link</a></li>
			</ul>
		</div>


		<fieldset class="scheduler-border">
		    <legend class="scheduler-border">Start Time</legend>
		    <div class="control-group p-t--50">
		        hoanheo
		    </div>
		</fieldset>

		<div class="wrap-box-title">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default have-border">
			    <div class="panel-heading have-bg fix-height" role="tab" id="headingOne">
			      <h4 class="panel-title">
			        <a data-toggle="collapse"  data-target="#blockid1" class="capitalize accordion-toggle">
			        
			          Click to collapse block 1
			        </a>
			      </h4>
			    </div>

			    <div id="blockid1" class="panel-collapse collapse in bg-fff" role="tabpanel">
				      <div class="panel-body">
				      	Content Block 1
				        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

				        <fieldset class="scheduler-border">
						    <legend  data-toggle="collapse" data-target="#sub-blockid1" class="scheduler-border pointer capitalize accordion-toggle">
						    	Sub Block 1
								<a class="pointer p-10">
		                            <i class="fa fa-times"></i>
		                        </a>
						    </legend>
						    <div id="sub-blockid1" class="panel-collapse collapse in bg-fff control-group" role="tabpanel">
						        hoanheo
						        uck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						    </div>
						</fieldset>
				      </div>
			    </div>
			  </div>

			</div>
		</div> -->

		<!-- <div class="nav-icon">
		  <span></span>
		  <span></span>
		  <span></span>
		</div> -->

	</div>  
</div>

@stop

