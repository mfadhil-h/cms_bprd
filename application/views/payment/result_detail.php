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
                 <form action = "<?php echo site_url('/payment2/updatebilling');?>" method="POST" id="frmUpdate" enctype="multipart/form-data">
                            <div class="tab-content panel-body">
                      <div class="tab-pane fade in active" id="basic-tab1">
                    <div class="form-group has-feedback">
                       <label>VA Number :</label>
                      <input type="text" class="form-control" name="virtual_account" id="virtual_account" readonly="readonly" value="<?php echo $virtual_account;?>">
                    </div>

                    <div class="form-group has-feedback">
                       <label>Billing Number :</label>
                      <input type="text" class="form-control" name="billing_number" id="billing_number" readonly="readonly" value="<?php echo $billing_number;?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Billing ID :</label>
                      <input type="text" class="form-control" name="trx_id" id="trx_id" readonly="readonly" value="<?php echo $trx_id;?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Billing Amount :</label>
                      <input type="text" class="form-control" name="total_bayar" id="total_bayar" readonly="readonly" value="<?php echo 'IDR '.number_format($trx_amount,0,',','.');?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Name :</label>
                      <input type="text" class="form-control" name="customer_name" id="customer_name" readonly="readonly" value="<?php echo $customer_name;?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Email :</label>
                      <input type="text" class="form-control" name="customer_email" id="customer_email" readonly="readonly" value="<?php echo $customer_email;?>">
                    </div>

                    <div class="form-group has-feedback">
                      <label>Phono No :</label>
                      <input type="text" class="form-control" name="customer_phone" id="customer_phone" readonly="readonly" value="<?php echo $customer_phone;?>">
                    </div>

                    <input type="hidden" name="datetime_expired" id="datetime_expired" value="<?php echo $datetime_expired;?>">
                    <input type="hidden" name="description" id="description" value="<?php echo $description;?>">
                    <input type="hidden" name="trx_amount" id="trx_amount" value="<?php echo $trx_amount;?>">
                    <input type="hidden" name="customer_name_ori" id="customer_name_ori" value="<?php echo $customer_name;?>">
                    <input type="hidden" name="customer_email_ori" id="customer_email_ori" value="<?php echo $customer_email;?>">
                    <input type="hidden" name="customer_phone_ori" id="customer_phone_ori" value="<?php echo $customer_phone;?>">

                    <input type="hidden" name="addl_label_1" id="addl_label_1" value="<?php echo $addl_label_1;?>">
                    <input type="hidden" name="addl_label_2" id="addl_label_2" value="<?php echo $addl_label_2;?>">
                    <input type="hidden" name="addl_label_3" id="addl_label_3" value="<?php echo $addl_label_3;?>">

                    <input type="hidden" name="addl_value_1" id="addl_value_1" value="<?php echo $addl_value_1;?>">
                    <input type="hidden" name="addl_value_2" id="addl_value_2" value="<?php echo $addl_value_2;?>">
                    <input type="hidden" name="addl_value_3" id="addl_value_3" value="<?php echo $addl_value_3;?>">

                    <input type="hidden" name="addl_label_1_en" id="addl_label_1_en" value="<?php echo $addl_label_1_en;?>">
                    <input type="hidden" name="addl_label_2_en" id="addl_label_2_en" value="<?php echo $addl_label_2_en;?>">
                    <input type="hidden" name="addl_label_3_en" id="addl_label_3_en" value="<?php echo $addl_label_3_en;?>">

                    <input type="hidden" name="addl_value_1_en" id="addl_value_1_en" value="<?php echo $addl_value_1_en;?>">
                    <input type="hidden" name="addl_value_2_en" id="addl_value_2_en" value="<?php echo $addl_value_2_en;?>">
                    <input type="hidden" name="addl_value_3_en" id="addl_value_3_en" value="<?php echo $addl_value_3_en;?>">

                    <input type="button" name="btnUpdate" id="btnUpdate" value="Edit" class="btn btn-primary">
                    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="btn btn-primary">
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