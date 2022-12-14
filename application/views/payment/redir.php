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
      		                      <form method="POST" action="<?php echo site_url('daftar/form');?>" id="paymentform" enctype="multipart/form-data">
                            <div class="tab-content panel-body">
                <div class="tab-pane fade in active" id="basic-tab1">
                                        
                    <div id="paymentcode" name="paymentcode" class="form-group has-feedback">
                      <label>Kode Bayar:</label>
                      <input type="text" class="form-control" name="PAYMENT_CODE" id="PAYMENT_CODE" readonly="readonly" value="<?php echo $paymentcode;?>">
                                        </div>
                    
                    <!-- edit by irma, 30 oct 2018 -->
                    <div class="form-group has-feedback">
                      <h4><span class="text-danger"><b>Harap selalu mencatat / menyalin 'Nomor Referensi' !</b></span></h4>
                                        </div>
                    <div class="form-group has-feedback">
                      <label>Nomor Referensi:</label>
                      <input type="text" class="form-control" name="ORDER_ID" id="ORDER_ID" readonly="readonly" value="<?php echo $orderid;?>">
                      </div>
                    
                    <div class="form-group has-feedback">
                      <label>Jumlah:</label>
                      <input type="text" class="form-control" name="AMOUNT" id="AMOUNT" readonly="readonly" value="<?php echo 'Rp. '.$totalpayment;?>">
                                        </div>
                    
                    <div class="form-group has-feedback">
                      <label>Pembayaran Melalui:</label>
                      <input type="text" class="form-control" name="PAYMENT_CHANNEL" id="PAYMENT_CHANNEL" readonly="readonly" value="<?php echo $paymentchannelname;?>">
                                        </div>
                    
                    <div class="form-group has-feedback">
                      <label>Status:</label>
                      <input type="text" class="form-control" name="PAYMENT_STATUS_DESC" id="PAYMENT_STATUS_DESC" readonly="readonly" value="<?php echo $realstatus;?>">
                                        </div>
                    

                       <!--                  <div class="form-group has-feedback">
                      <span style="font-size: 12px"><b>* Untuk mengecek status pembayaran terkini, silahkan catat / salin 'Nomor Referensi' lalu masuk ke menu 'Cek Transaksi'</b></span><br/><br/>
                      <span id="lb1" style="font-size: 12px"><b>* Untuk langkah selanjutnya, silahkan lengkapi data dengan klik tombol 'Isi Data' dibawah ini</b></span>
                                        </div> -->
                    <input type="hidden" id="merchantid" name="merchantid" value="<?php echo $merchantid;?>">
                    <input type="hidden" id="amount" name="amount" value="<?php echo $amount;?>">
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