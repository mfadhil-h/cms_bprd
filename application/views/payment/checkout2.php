  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembayaran Pajak
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Pembayaran Pajak</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- ./box -->
            <div class="box box-default">
                <div class="box-body">
                                <form action = "<?php echo site_url('payment2/result');?>" method="POST" id="checkoutform" enctype="multipart/form-data">
                            <div class="tab-content panel-body">
                <div class="tab-pane fade in active" id="basic-tab1">
                    
                    <div class="form-group has-feedback">
                       <label>NPWP :</label>
                      <input type="text" class="form-control" name="pname" id="pname" readonly="readonly" value="<?php echo $npwp;?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Total Yang Akan Di Bayar :</label>
                      <input type="text" class="form-control" name="total_bayar" id="total_bayar" readonly="readonly" value="<?php echo number_format($total,0,',','.');?>">
                    </div>
                    <hr>
                    <div class="form-group has-feedback">
                      <label>Masukkan Nama Sesuai KTP :</label>
                      <input type="text" class="form-control" name="nama" id="nama" required="required" maxlength="50" value="<?php echo $name ?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Masukkan Nomor HP :</label>
                      <input type="text" class="form-control" name="nohp" id="nohp" required="required" maxlength="20" value="<?php echo $no_tlp ?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Masukkan Email :</label>
                      <input type="email" class="form-control" name="email" id="email" required="required" maxlength="100" value="<?php echo $email ?>">
                    </div>

                    <input type="submit" name="btnKlaim" id="btnKlaim" value="Proses" class="btn btn-primary">
                    <input type="hidden" id="merchantid" name="merchantid" value="<?php echo $merchantid;?>">
                    <input type="hidden" id="branchid" name="branchid" value="<?php echo $branchid;?>">
                    <input type="hidden" id="productcode" name="productcode" value="<?php echo $productcode;?>">  
                    <input type="hidden" id="productname" name="productname" value="<?php echo $productname;?>"> 
                    <input type="hidden" id="amount" name="amount" value="<?php echo $amount;?>">
                    <input type="hidden" id="tagihan" name="tagihan" value="<?php echo $tagihan;?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $orderid;?>">
                    <input type="hidden" id="note" name="note" value="<?php echo $note;?>">
                    <input type="hidden" id="pgid" name="pgid" value="">
                    <input type="hidden" id="yearperiod" name="yearperiod" value="<?php echo $year;?>">
                    <input type="hidden" id="monthperiod" name="monthperiod" value="<?php echo $month;?>">
                                </div>
                            </div>
               </form>
                </div>
                <!-- ./box-body -->
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