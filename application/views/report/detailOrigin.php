

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Report</a></li>
        <li class="active">Detail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-lg-12">
      		<!-- ./box -->
            <div class="box box-default">
                <div class="box-body">
      		        <form name="frmReportDetail" id="frmReportDetail" class="form-horizontal" action="<?php echo base_url('report/detail_report_pdf') ?>" method="post">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-6">
                                <label class="col-sm-4 control-label" for="start_date">Start Date :</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <input class="form-control" type="text" name="start_date" id="start_date" data-date-end-date="0d" value="<?php echo date('d-m-Y');?>" style="cursor: pointer;">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="col-sm-4 control-label" for="end_date">End Date :</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <input class="form-control" type="text" name="end_date" id="end_date" data-date-end-date="0d" value="<?php echo date('d-m-Y');?>" style="cursor: pointer;">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if($_SESSION['level']<4 || $_SESSION['level'] == 6 ){
                          echo 
                            '<div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="merchant_id">Merchant :</label>
                                    <div class="col-sm-8">
                                        <select name="merchant_id" id="merchant_id" class="select form-control">
                                                ';if($_SESSION['level']<3 || $_SESSION['level'] == 6 ){
                                                  echo '<option value="ALL">ALL</option>';}
                                                for($i=0;$i<count($merchants);$i++){
                                                  echo '<option value="'.$merchants[$i]['merchant_id'].'">'.$merchants[$i]["merchant_name"].'</option>';
                                                }
                                        echo '
                                        </select>
                                    </div>                                
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Branch :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                                <option value="ALL">ALL</option>';if($_SESSION['level']==3 || $_SESSION['level'] == 6){
                                                    for($i=0;$i<count($branch);$i++){
                                                      echo '<option value="'.$branch[$i]['branch_id'].'">'.$branch[$i]["branch_name"].'</option>';
                                                    }
                                                  }echo'
                                        </select>
                                    </div>                                
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="bill_no">Bill No :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="bill_no" id="bill_no" size="50">
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
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="bill_no">Bill No :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="bill_no" id="bill_no" size="50">
                                    </div>                                
                                </div>
                            </div>';
                        }
                        ?> 
                        <br />
                        <input type="checkbox" name="hide_rawdata" id="hide_rawdata" value="true" checked="checked">Sembunyikan rawdata
                        </form>
                        <br />
                        <input type="submit" name="btnSubmitMember" id="btnSubmitMember" value="View Records" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportMemberCsv" id="btnExportMemberCsv" value="Export Records (.CSV)" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportMemberXlsx" id="btnExportMemberXlsx" value="Export Records (.XLSX)" class="btn btn-success"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" name="btnExportMemberPdf" id="btnExportMemberPdf" class="btn btn-danger">Export Records(.PDF)</button>
                                                
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
				<div class="box-body">
					<div class="row">
						<div class="col-lg-12">
						<table id="membertable" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
					        <thead>
					            <tr>
                                    <th>MERCHANT NAME</th>
                                    <th>BRANCH NAME</th>
                                    <th>BILL NO</th>
                                    <th>DATE</th>
									                  <th>ITEM NAME</th>
                                    <th>ITEM TYPE</th>
                                    <th>ITEM PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>ITEM AMOUNT</th>
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