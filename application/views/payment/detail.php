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
      		      <form action = "#" method="POST" id="detailform" enctype="multipart/form-data">
                  <div class="tab-content panel-body">
                    <div class="tab-pane fade in active" id="basic-tab1">
                    
                      <div class="form-group has-feedback">
                         <label>NPWP :</label>
                        <input type="text" class="form-control" name="npwp" id="npwp" readonly="readonly" value="<?php echo $npwp;?>">
                      </div>
                      
                      <div class="form-group has-feedback">
                         <label>Outlet (NOPD) :</label>
                        <input type="text" class="form-control" name="nopd" id="nopd" readonly="readonly" value="<?php echo $branch_name.' ('.$nopd.')';?>">
                      </div>

                      <div class="form-group has-feedback">
                         <label>Periode :</label>
                        <input type="text" class="form-control" name="period" id="period" readonly="readonly" value="<?php echo $month.' / '.$year;?>">
                      </div>
                    <?php if ($branch_id != 'ALL') {?>
                      <div class="form-group has-feedback">
                        <label>Jumlah :</label>
                        <input type="text" class="form-control" name="tagihan" id="tagihan" readonly="readonly" value="<?php echo number_format($total,0,',','.');?>">
                      </div>
                      <?php $status = 'false';
                        if ($statusPayment == 'true') {
                        $status = 'true'; ?>
                        <div class="form-group has-feedback">
                          <label>Jumlah Yang Akan Di Bayar :</label>
                          <input type="text" class="form-control" name="tax" id="tax" value="<?php echo number_format($total,0,',','.');?>" maxlength="30">
                        </div>
                      <?php } else { ?>
                      <div class="form-group has-feedback">
                        <label>Jumlah Yang Akan Di Bayar :</label>
                        <input type="text" disabled class="form-control" name="tax" id="tax" value="<?php echo number_format($detailBranch[0]['tax'],0,',','.');?>" maxlength="30">
                      </div>
                      <?php }  ?>
                       <div class="form-group has-feedback">
                        <input type="button" class="btn btn-sm btn-outline-primary btn_note" href="<?php echo base_url("note/create/$month/$year/$merchantid/$branchid") ?>" name="btn_note" id="btn_note" value="+ Notes">
                        <input type="hidden" class="form-control" name="note" id="note" value="" maxlength="255" disabled="disabled">
                      </div>
                    <?php } else { ?>
                      <div class="form-group has-feedback box-body table-responsive">
                        <input type="hidden" class="form-control" name="tagihan" id="tagihan" readonly="readonly" value="<?php echo number_format($total,0,',','.');?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="tax-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Wajib Pajak</th>
                                            <th>Nama Outllet</th>
                                            <th>Pajak</th>
                                            <th>Adjustment</th>
                                            <th>Note</th>
                                            <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                                            <th>SPTPD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                      $status = 'false';
                                      foreach ($detailBranch as $index => $row) { 
                                      $data_merchant_id = $row['merchant_id'];
                                      $data_branch_id = $row['branch_id'];                                      
                                      ?>
                                    <tr>
                                      <?php if ($row['status'] == 'false') {
                                        $status = 'true';
                                      ?>
                                      <td><?php echo ++$index;  ?></td>
                                      <td><?php echo $row['merchant_name'];  ?></td>
                                      <td><?php echo $row['branch_name'];  ?></td>
                                      <td class="text-right tax-amount">Rp.<?php echo number_format($row['tax']);  ?></td>
                                      <td class="text-right"><input type="text" class="form-control text-right tax-adjustment" data-banch ="<?php echo $data_branch_id ?>" name="tax_adjustment" id="tax_adjustment" value='<?php echo number_format($row['tax']); ?>' ></td>
                                      <td><input type="button" class="btn btn-sm btn-outline-primary btn_note" href="<?php echo base_url("note/create/$month/$year/$data_merchant_id/$data_branch_id") ?>" name="btn_note" id="btn_note" value="+ Notes"></td>
                                      <td><input type="checkbox" class="check" name="check" id="check" data-merchant-id = '<?php echo number_format($row['merchant_id']); ?>' data-branch-id = '<?php echo number_format($row['branch_id']); ?>' ></td>
                                      <td class="text-center"><input disabled="" href="<?php echo base_url("sptpd/report/$month/$year/$data_merchant_id/$data_branch_id") ?>" type="button" class="btn btn-sm btn-danger fa fa-pencil btn_sptpd" name="btn_sptpd" id="btn_sptpd" value="SPTPD"></td>
                                      <?php
                                      } else {
                                      ?>
                                      <td><?php echo ++$index;  ?></td>
                                      <td><?php echo $row['merchant_name'];  ?></td>
                                      <td><?php echo $row['branch_name'];  ?></td>
                                      <td class="text-right tax-amount">Rp.<?php echo number_format($row['tax']);  ?></td>
                                      <td class="text-right">Rp.<?php echo number_format($row['tax']);  ?></td>
                                      <td><input type="button" class="btn btn-sm btn-outline-primary btn_note" href="<?php echo base_url("note/create/$month/$year/$data_merchant_id/$data_branch_id") ?>" name="btn_note" id="btn_note" value="+ Notes"></td>
                                      <td></td>
                                      <td class="text-center"><input href="<?php echo base_url("sptpd/report/$month/$year/$data_merchant_id/$data_branch_id") ?>" type="button" class="btn btn-sm btn-danger fa fa-pencil btn_sptpd_payment" name="btn_sptpd" id="btn_sptpd" value="SPTPD"></td>
                                      <?php
                                      } ?>
                                      
                                    </tr>
                                    <?php }  ?>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="3">Total Pajak Yang Di Bayarkan</th>
                                            <th align="right"><input disabled="" type="text" class="form-control text-right" name="tax_total" id="tax_total" value="0" maxlength="30"></th>
                                            <th align="right"><input type="hidden" name="tax" id="tax" value=""></th>
                                            <th align="right"></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                    <input type="hidden" name="detail_tax" value="10909">
                                    <input type="hidden" name="detail_branch" value="10909">
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php }  ?>
                    
                    
                        <div class="form-group has-feedback">
                          <input type="radio" name="paymentgateway" value="bni" checked="true"> BNI Virtual Account</br>
                        </div>
                        <?php if ($status == 'true') { ?>
                        <input type="button" name="btnKlaim" href="<?php echo base_url("payment2/checkout") ?>" id="btnKlaim" value="Next" class="btn btn-primary" onclick="success()">
                        <?php
                        } else { ?>
                        <input type="button" disabled name="btnKlaim" href="<?php echo base_url("payment2/checkout") ?>" id="btnKlaim" value="Bayar" class="btn btn-primary" onclick="success()">
                        <?php }  ?>
                        <?php if ($branch_id != 'ALL') { ?>
                                               
                        <?php }  ?>
                        <input type="hidden" id="merchantid" name="merchantid" value="<?php echo $merchantid;?>">
                        <input type="hidden" id="branchid" name="branchid" value="<?php echo $branchid;?>">
                        <input type="hidden" id="month_pay" name="month_pay" value="<?php echo $month;?>">
                        <input type="hidden" id="year_pay" name="year_pay" value="<?php echo $year;?>">
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