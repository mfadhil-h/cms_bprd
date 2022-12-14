  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Menunggu Pembayaran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Menunggu Pembayaran</a></li>
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
                                  <label class="col-sm-4 control-label" for="year">Tahun :</label>
                                    <div class="col-sm-8">
                                      <select name="year" id="year" class="select form-control">
                                        <option value="ALL">ALL</option>
                                        <?php 
                                          $yearstart=2017;
                                          $yearnow=date("Y");
                                          for($i=$yearnow;$i>=$yearstart;$i--){
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                          }
                                        ?>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="month">Bulan :</label>
                                    <div class="col-sm-8">
                                    <select name="month" id="month" class="select form-control">
                                    <option value="ALL">ALL</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if($_SESSION['level'] <= 4){
                              echo 
                                '<div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="merchant_id">Wajib Pajak :</label>
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
                                        <label class="col-sm-4 control-label" for="branch_id">Outlet :</label>
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
                                        <label class="col-sm-4 control-label" for="branch_id">Outlet :</label>
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
                            </form>
                            <br />
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-sm-10">
                                <input type="submit" name="btn-view" id="btn-view" value="Lihat Data" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp; 
                                <span class="Waiting"></span>
                            </div>
                                                                           
                            <br />
                            <br />
                            <span id="message" style="background-color: lime;"></span>
                    </div>
                </div>
          	</div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="table-waiting-payment" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>TAHUN</th>
                                            <th>BULAN</th>
                                            <th>PAJAK YANG DIBAYARKAN</th>
                                            <th>VIRTUAL NUMBER</th>
                                            <th class="no-sort"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        foreach ($fetch as $index => $row) {
                                        echo '
                                        <tr>
                                            <td>'.$row["year"].'</td>
                                            <td>'.$row["month"].'</td>
                                            <td class="text-right">'.number_format($row["total_ppn"]).'</td>
                                            <td>'.$row["va_number"].'</td>
                                            <td class="text-center"><a order-id="'.$row["order_id"].'" class="show-control ext-light mr-3 font-16 '.$row["order_id"].'" data-toggle="tooltip" title="Show Detail"><i class="fa fa-eye"></i></a></td>
                                        </tr>';
                                    }  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>`
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>