  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Staff
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Staff</a></li>
        <li class="active">Staff</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-lg-12">
      		<div class="box box-info collapsed-box">
      			<div class="box-header with-border">
      				<h3 class="box-title">Create New Staff</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" type="button" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
      			</div>
      			<form role="form" id="form_add" action="<?php echo base_url('staff/save');?>" method="POST">
					<div class="box-body">
						<div class="form-group">
			                <label>Role</label>
			                <select class="form-control select2" name="role_id" id="role_id" style="width: 100%;">
			                  <?php foreach ($role as $row) : ?>
			                  	<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
			                  <?php endforeach; ?>
			                </select>
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input id="username" name="username" class="form-control" placeholder="Username" type="text">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input id="password" name="password" class="form-control" placeholder="Password" type="password">
						</div>
						<div class="form-group">
							<label for="firstname">First Name</label>
							<input id="firstname" name="firstname" class="form-control" placeholder="First Name" type="text">
						</div>
						<div class="form-group">
							<label for="lastname">Last Name</label>
							<input id="lastname" name="lastname" class="form-control" placeholder="Last Name" type="text">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input id="email" name="email" class="form-control" placeholder="Email" type="email">
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label for="phone">Phone</label>
									<input id="phone" name="phone" class="form-control" placeholder="Phone" type="text">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="phone_ext">Phone Ext</label>
									<input id="phone_ext" name="phone_ext" class="form-control" placeholder="Ext" type="text">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="mobile">Mobile</label>
							<input id="mobile" name="mobile" class="form-control" placeholder="Mobile" type="text">
						</div>
					</div>
					<div class="box-footer">
						<button class="btn btn-info pull-right" id="btn_submit" type="submit">Save</button>
					</div>
				</form>
      		</div>
      		<!-- ./box -->
      	</div>
      	<!-- ./col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row">
      	<div class="col-lg-12">
      		<div class="box box-info">
      			<div class="box-header with-border">
      				<h3 class="box-title">List Staff</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" type="button" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
      			</div>
				<div class="box-body">
					<div class="row">
						<div class="col-lg-12">
						<table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
					        <thead>
					            <tr>
					                <th>Id</th>
					                <th>Product Group Name</th>
					                <th>Product Subgroup Name</th>
					                <th>Product Name</th>
					                <th>Code</th>
					                <th>Status</th>
					                <th>Created</th>
					                <th>Modified</th>
					                <!-- <th>Action</th> -->
					            </tr>
					        </thead>
					    </table>
						</div>
					</div>
				</div>
      		</div>
      		<!-- ./box -->
      	</div>
      	<!-- ./col-lg-12 -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->