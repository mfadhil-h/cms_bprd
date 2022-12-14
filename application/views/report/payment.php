<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Pembayaran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Laporan</a></li>
        <li class="active">Pembayaran</li>
      </ol>
    </section>

    <section class="content">
        <div class="row selector">
            <div class="col-lg-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form name="summary_report" id="summary_report" class="form-horizontal" action="#" method="post">
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="year">Tahun :</label>
                                    <div class="col-sm-8">
                                        <select name="year" id="year" class="select form-control">
                                            <?php
                                                $yearCount  = 3;
                                                $yearnow    = date('Y');
                                                for ($i=0; $i < $yearCount ; $i++) { 
                                                    $year = $yearnow - $i;
                                                    echo '<option value ="'.$year.'">'.$year.'</option>';           
                                                }
                                            ?>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="month">Bulan :</label>
                                    <div class="col-sm-8">
                                        <select name="month" id="month" class="select form-control">
                                            <option value="" selected="selected">--Pilih Bulan--</option>
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <?php if ($_SESSION['level'] < 5) {
                                    ?>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="merchant_id">Wajib Pajak :</label>
                                        <div class="col-sm-8">
                                            <select name="merchant_id" id="merchant_id" class="select form-control">
                                            <?php if ($_SESSION['level']<4): ?>
                                                <option value="ALL">ALL</option>
                                            <?php endif ?>
                                            <?php
                                                foreach ($merchants as $rowMerchant) {
                                                    echo '<option value="'.$rowMerchant['merchant_id'].'">'.$rowMerchant['merchant_name'].'</option>';
                                                }
                                            ?>
                                            </select>                               
                                        </div>
                                    </div>
                                    <?php
                                }  ?>
                                
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Outlet :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                            <?php if ($_SESSION['level']<=5): ?>
                                            <option value="ALL">ALL</option>
                                            <?php endif ?>
                                            <?php
                                                foreach ($branch as $rowBranch) {
                                                    echo '<option value="'.$rowBranch['branch_id'].'">'.$rowBranch['branch_name'].'</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="invoice_no">No Invoice :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="invoice_no" id="invoice_no" size="50">
                                    </div>                                
                                </div>
                                <?php if ($_SESSION['level'] != 3): ?>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="suban_id">Suku Badan Pajak:</label>
                                    <div class="col-sm-8">
                                        <select name="suban_id" id="suban_id" class="select form-control">
                                            <option value="ALL">ALL</option>
                                            <?php foreach ($subans as $rowSuban): ?>
                                               <option value="<?php echo $rowSuban->suban_id ?>" ><?php echo $rowSuban->suban_name ?></option> 
                                            <?php endforeach ?>
                                        </select>
                                    </div>                                
                                </div>
                                <?php endif ?>
                            </div>
                            <br/>
                        </form>
                        <br/>
                        <?php
                            $class = '';
                            if ($_SESSION['level'] != 6) {
                                $class = 'hide-btn';
                            }
                        ?>
                        <input type="submit" name="btnSubmitPayment" id="btnSubmitPayment" value="Tampilkan Data" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportPaymentCsv" id="btnExportPaymentCsv" value="Export Data (.CSV)" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportPaymentXlsx" id="btnExportPaymentXlsx" value="Export Data (.XLSX)" class="btn btn-success"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" href="<?php echo base_url('ReportPayment/print_report') ?>" name="btnExportPaymentPdf" id="btnExportPaymentPdf" class="btn btn-danger">Export Data (.PDF)</button>
                        
                        
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
                                <table id="report_payment" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Wajib Pajak</th>
                                            <th>Outlet</th>
                                            <th>Npwp</th>
                                            <th>Nopd</th>
                                            <th>Kode Bayar</th>
                                            <th>Total Pembayaran Pajak</th>
                                            <th>Periode</th>
                                            <th>Tanggal Pembayaran</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>`
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>