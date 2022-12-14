  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembayaran Pajak Auto Debet
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Pembayaran Pajak Auto Debet</a></li>
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
                                    <option value="">--Pilih--</option>
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
                                </select>
                                </div>
                            </div>
                        </div>
                        <?php if ($_SESSION['level']<5): ?>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="merchant_id">Wajib Pajak :</label>
                                    <div class="col-sm-8">
                                        <select name="merchant_id" id="merchant_id" class="select form-control">
                                        <?php if ($_SESSION['level']<4): ?>
                                            <option value="">--Pilih Wajib pajak--</option>
                                        <?php endif ?>
                                            <?php for ($i=0;$i<count($merchants);$i++): ?>
                                                <option value=<?php echo $merchants[$i]['merchant_id'] ?> ><?php echo $merchants[$i]['merchant_name'] ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>                                
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Outlet :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                            <option value="">--Pilih Outlet--</option>
                                            <?php if ($_SESSION['level']==4): ?>
                                                <?php for ($i=0;$i<count($branch);$i++): ?>
                                                    <option value=<?php echo $branch[$i]['branch_id'] ?> ><?php echo $branch[$i]['branch_name'] ?></option>
                                                <?php endfor ?> 
                                            <?php endif ?>
                                        </select>
                                    </div>                                
                                </div>
                            </div>
                           
                        <?php else: ?>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Outlet :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                        <?php if ($_SESSION['level']==5): ?>
                                            <option value="">--Pilih Outlet--</option>
                                        <?php endif ?>
                                            <?php for ($i=0;$i<count($branch);$i++): ?>
                                                <option value=<?php echo $branch[$i]['branch_id'] ?>><?php echo $branch[$i]['branch_name'] ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>                                
                                </div>                     
                            </div>
                        <?php endif ?>
                       
                        </form>
                        <br />
                        <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10">
                                <input type="submit" name="btn_get_data" id="btn_get_data" value="Tampilkan Data" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>                                     
                        <br />
                        <br />
                        <span id="message" style="background-color: lime;"></span>
                </div>
            </div>
      	</div>
      </div>
      <!-- /.row -->
      <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="payment_autodebet" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Wajib Pajak</th>
                                            <th>Outlet</th>
                                            <th>Periode Pembayaran</th>
                                            <th>Pajak</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
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