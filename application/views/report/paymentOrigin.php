  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payment
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Report</a></li>
        <li class="active">Payment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- ./box -->
            <div class="box box-default">
                <div class="box-body">
                  <form name="frmReportPayment" id="frmReportPayment" class="form-horizontal" action="<?php echo base_url('report/payment_report_pdf') ?>" method="post">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-6">
                                <label class="col-sm-4 control-label" for="year">Year :</label>
                                <div class="col-sm-8">
                                  <select name="year" id="year" class="select form-control">
                                    <option value="ALL" selected="selected">ALL</option>';
                                    <?php 
                                      $yearCount  = 3;
                                          $yearnow  = date('Y');
                                          for ($i=0; $i < $yearCount ; $i++) { 
                                            $year = $yearnow - $i;
                                            echo '<option value ="'.$year.'">'.$year.'</option>';     
                                          }
                                    ?>
                                  </select>
                                   <!--  <div class="input-group date">
                                        <input class="form-control" type="text" name="start_date" id="start_date" data-date-end-date="0d" value="<?php echo date('d-m-Y');?>" style="cursor: pointer;">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="col-sm-4 control-label" for="month">Month :</label>
                                <div class="col-sm-8">
                                   <select name="month" id="month" class="select form-control">
                                    <option value="ALL" selected="selected">ALL</option>';
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                  </select>
                                    <!-- <div class="input-group date">
                                        <input class="form-control" type="text" name="end_date" id="end_date" data-date-end-date="0d" value="<?php echo date('d-m-Y');?>" style="cursor: pointer;">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <?php 
                        if($_SESSION['level']<4 || $_SESSION['level'] == 6){
                          echo 
                            '<div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="merchant_id">Merchant :</label>
                                    <div class="col-sm-8">
                                        <select name="merchant_id" id="merchant_id" class="select form-control">
                                                ';if($_SESSION['level']<3 || $_SESSION['level'] == 6){
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
                                    <label class="col-sm-4 control-label" for="invoice_no">Invoice No :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="invoice_no" id="invoice_no" size="50">
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
                                    <label class="col-sm-4 control-label" for="invoice_no">Invoice No :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="invoice_no" id="invoice_no" size="50">
                                    </div>                                
                                </div>
                            </div>';
                        }
                        ?>
                        <br />
                        <input type="checkbox" name="hide_rawdata" id="hide_rawdata" value="true" checked="checked">Sembunyikan rawdata
                        </form>
                        <br />
                        <input type="submit" name="btnSubmitPayment" id="btnSubmitPayment" value="View Records" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportPaymentCsv" id="btnExportPaymentCsv" value="Export Records (.CSV)" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportPaymentXlsx" id="btnExportPaymentXlsx" value="Export Records (.XLSX)" class="btn btn-success"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" name="btnExportPaymentPdf" id="btnExportPaymentPdf" class="btn btn-danger">Export Records (.PDF)</button>
                                                
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
                                    <th>NPWP</th>
                                    <th>NOPD</th>
                                    <th>INVOICE NO</th>
                                    <th>PPN</th>
                                    <th>ASSESSMENT</th>
                                    <th>PAID</th>
                                    <th>NOTE</th>
                                    <th>PAYMENT CHANNEL</th>
                                    <th>RECEIPT</th>
                                    <th>YEAR</th>
                                    <th>MONTH</th>
                                    <th>PAID DATE</th>
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