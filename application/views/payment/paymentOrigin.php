  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Summary
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Summary</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-lg-12">
      		<!-- ./box -->
            <div class="box box-default">
                <div class="box-body">
      		        <form name="frmReport" id="frmReport" class="form-horizontal" action="#" method="post">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-6">
                              <label class="col-sm-4 control-label" for="year">Year :</label>
                                <div class="col-sm-8">
                                  <select name="year" id="year" class="select form-control">
                                    <?php 
                                      $yearstart=2017;
                                      $yearnow=date("Y");
                                      for($i=$yearnow;$i>=$yearstart;$i--){
                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                      }
                                    ?>
                                  </select>
                                </div>
                                <!-- <label class="col-sm-4 control-label" for="start_date">Start Date :</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <input class="form-control" type="text" name="start_date" id="start_date" data-date-end-date="0d" data-date-start-date="-3y" value="<?php echo date('d-m-Y');?>" style="cursor: pointer;">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group col-sm-6">
                                <!-- <label class="col-sm-4 control-label" for="end_date">End Date :</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <input class="form-control" type="text" name="end_date" id="end_date" data-date-end-date="0d" data-date-start-date="-3y" value="<?php echo date('d-m-Y');?>" style="cursor: pointer;">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div> -->
                                <label class="col-sm-4 control-label" for="month">Month :</label>
                                <div class="col-sm-8">
                                <select name="month" id="month" class="select form-control">
                                  </select>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if($_SESSION['level']<4){
                          echo 
                            '<div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="merchant_id">Merchant :</label>
                                    <div class="col-sm-8">
                                        <select name="merchant_id" id="merchant_id" class="select form-control">
                                                ';if($_SESSION['level']<3){
                                                  echo '<option value="ALL">ALL</option>';}
                                                for($i=0;$i<count($merchants);$i++){
                                                  echo '<option value="'.$merchants[$i]['merchant_id'].'">'.$merchants[$i]["merchant_name"].'</option>';
                                                }
                                        echo '</select>
                                    </div>                                
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Branch :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                                <option value="ALL">ALL</option>';if($_SESSION['level']==3){
                                                    for($i=0;$i<count($branch);$i++){
                                                      echo '<option value="'.$branch[$i]['branch_id'].'">'.$branch[$i]["branch_name"].'</option>';
                                                    }
                                                  }echo'
                                        </select>
                                    </div>                                
                                </div>
                            </div>';
                        }else{
                          echo 
                            '<div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Branch :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                                ';if($_SESSION['level']==4){
                                                  echo '<option value="ALL">ALL</option>';}
                                                for($i=0;$i<count($branch);$i++){
                                                  echo '<option value="'.$branch[$i]['branch_id'].'">'.$branch[$i]["branch_name"].'</option>';
                                                }
                                        echo '</select>
                                    </div>                                
                                </div>
                            </div>';
                        }
                        ?>
                        <!-- <br />
                        <input type="checkbox" name="hide_rawdata" id="hide_rawdata" value="true" checked="checked">Sembunyikan rawdata -->
                        </form>
                        <br />
                        <input type="submit" name="btnSubmitTransaction" id="btnSubmitTransaction" value="View Records" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" name="btnPay" id="btnPay" value="Pay" class="btn btn-success"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- <input type="button" name="btnExportTransactionCsv" id="btnExportTransactionCsv" value="Export Records (.CSV)" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportTransactionXlsx" id="btnExportTransactionXlsx" value="Export Records (.XLSX)" class="btn btn-success"> -->
                                                
                        <br />
                        <br />
                        <span id="message" style="background-color: lime;"></span>
                </div>
                <!-- ./box-body -->
            </div>
            <!-- ./box -->
      	</div>
      	<!-- ./col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row">
      	<div class="col-lg-12">
      		<div class="box box-info">
      			<!-- <div class="box-header with-border">
      				<h3 class="box-title">List Staff</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" type="button" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
      			</div> -->
				<div class="box-body">
					<div class="row">
						<div class="col-lg-12">
						<table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
					        <thead>
					            <tr>
                                    <th>MERCHANT NAME</th>
                                    <th>BRANCH NAME</th>
                                    <th>DATE</th>
                                    <th>TAX</th>
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