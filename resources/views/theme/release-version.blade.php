<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->


@extends('app')

@section('content')

<div>
    <div class="top-content">
        <label class="c-m"> General Element
            <a data-toggle="modal" data-target=".bs-example-modal-lg"><i title="Help Information" class="fa fa-info-circle help-infor-icon"></i></a>
            <!-- <a class="btn btn-primary pull-right fixed-add"><i class="fa fa-plus"></i> Add Role</a> -->
        </label>
    </div>

    <div class="content">
	
        <div class="box-with-title">
            <div class="box-with-title-top">
                <p class="title">Active Release Version</p>
            </div>
            <div class="box-with-title-body">
				<div>
					<span>www.ulsinc.com</span>
	                <span><a href="">1.0</a></span>
				</div>

				<div>
					<span>www.ulsinc.com</span>
	                <span><a href="">1.1</a></span>
				</div>
                
                
            </div>

            
        </div>

        <div class="box-with-title">
            <div class="box-with-title-top h51">
                <label class="title m-t-5">Version History</label>
                <a href="" class="btn btn-default btn-sm pull-right">
                	<i class="fa fa-eye"></i> Show Past Version
                </a>
            </div>

            <div class="box-with-title-body">

				<div class="table-responsive">
					<table class="table center-td table-bordered">
						<thead>
							<tr>
								<th>Release Version</th>
								<th>Status</th>
								<th>Not Stared</th>
								<th>In Process</th>
								<th>Ready for Review</th>
								<th>Approved</th>
								<th>Live</th>
								<th>Language</th>
								<th>Regions</th>
								<th>Description</th>
								<th>Action</th>

							</tr>
						</thead>

						<tbody>
							<tr>
								<td>1.1</td>
								<td>
									<div class="vertical-box">
							            <span class="fa fa-circle yellow-status" tooltip="Not Started" tooltip-trigger tooltip-animation="true" tooltip-placement="top"></span>

							        </div>
								</td>

								<td>12</td>
								<td>2</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								<td>1</td>
								<td>n/a</td>
								<td>Add in confuguration</td>
								<td>action</td>
							</tr>

							<tr>
								<td>1.1</td>
								<td>
									<div class="vertical-box">
							            <span class="fa fa-circle yellow-status" tooltip="Not Started" tooltip-trigger tooltip-animation="true" tooltip-placement="top"></span>

							        </div>
								</td>

								<td>12</td>
								<td>2</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								<td>1</td>
								<td>n/a</td>
								<td>Add in confuguration</td>
								<td>action</td>
							</tr>
						</tbody>
					</table>	
				</div>
	                
	                
	        </div>

            
        </div>
 	
    </div>  
</div>


@stop

