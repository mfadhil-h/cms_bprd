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
      		                      <form action = "<?php echo site_url('payment/pay');?>" method="POST" id="checkoutform" enctype="multipart/form-data">
                            <div class="tab-content panel-body">
                <div class="tab-pane fade in active" id="basic-tab1">
                    
                    <div class="form-group has-feedback">
                       <label>NPWP :</label>
                      <input type="text" class="form-control" name="pname" id="pname" readonly="readonly" value="<?php echo $npwp;?>">
                                        </div>
                    
                    <div class="form-group has-feedback">
                      <label>Jumlah :</label>
                      <input type="text" class="form-control" name="jumlah" id="jumlah" readonly="readonly" value="<?php echo number_format($total,0,',','.');?>">
                                        </div>
                    
                    <div class="form-group has-feedback">
                      <label>MDR :</label>
                      <input type="text" class="form-control" name="mdr" id="mdr" readonly="readonly">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Total Yang Akan Di Bayar :</label>
                      <input type="text" class="form-control" name="total_bayar" id="total_bayar" readonly="readonly">
                    </div>

                    <div class="form-group has-feedback has-feedback-left">
                      <?php
                        for($i=0;$i<count($arr['payment_channel_list']);$i++){
                          echo '<input type="radio" name="pg" id="pg'.$arr['payment_channel_list'][$i]['payment_channel_id'].'" value="'.($total+$arr['payment_channel_list'][$i]['payment_channel_mdr']).'" onclick="getmdr(this);"> '.$arr['payment_channel_list'][$i]['payment_channel_name'].'<br>';
                        }
                      ?>  
                    </div>
                    <input type="button" name="btnKlaim" id="btnKlaim" value="Proses" class="btn btn-primary" onclick="pay()">
                    <input type="hidden" id="merchantid" name="merchantid" value="<?php echo $merchantid;?>">
                    <input type="hidden" id="productcode" name="productcode" value="<?php echo $productcode;?>">  
                    <input type="hidden" id="productname" name="productname" value="<?php echo $productname;?>"> 
                    <input type="hidden" id="amount" name="amount" value="<?php echo $amount;?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $orderid;?>">
                    <input type="hidden" id="pgid" name="pgid" value="">
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