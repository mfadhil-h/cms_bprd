<?php

$month = [  '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December' ];
            
$selctedMonth = date('n');

?>
<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Rekapitulasi
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Laporan</a></li>
        <li class="active">Rekapitulasi</li>
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
                                            <?php
                                            foreach ($month as $val => $desc): ?>
                                                <option value="<?php echo $val ?>" <?php echo $val == $selctedMonth ? 'selected' : null ?> > <?php echo $desc ?> </option>
                                                
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <?php if ($_SESSION['level'] < 5) {
                                    ?>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="merchant_id_summary">Wajib Pajak :</label>
                                        <div class="col-sm-8">
                                            <select name="merchant_id_summary" id="merchant_id_summary" class="select form-control">
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
                                    <label class="col-sm-4 control-label" for="branch_id_summary">Outlet :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id_summary" id="branch_id_summary" class="select form-control">
                                            <?php
                                                foreach ($branch as $rowBranch) {
                                                    echo '<option value="'.$rowBranch['branch_id'].'">'.$rowBranch['branch_name'].'</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['level'] != 3): ?>
                                <div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="suban_id"> Suku Badan Pajak:</label>
                                        <div class="col-sm-8">
                                            <select name="suban_id" id="suban_id" class="select form-control">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($subans as $rowSuban): ?>
                                                    <option value="<?php echo $rowSuban->suban_id ?>"> <?php echo $rowSuban->suban_name ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>

                            <br/>
                        </form>
                        <br/>
                        <?php
                            $class = '';
                            if ($_SESSION['level'] < 4) {
                                $class = 'hide-btn';
                            }
                        ?>
                        <input type="button" name="btnSubmitSummary" id="btnSubmitSummary" value="Tampilkan Data" class="<?php echo $class ?> btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportSummaryCsv" id="btnExportSummaryCsv" value="Export Data (.CSV)" class="<?php echo $class ?> btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportSummaryXlsx" id="btnExportSummaryXlsx" value="Export Data (.XLSX)" class="<?php echo $class ?> btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" href="<?php echo base_url('ReportSummary/print_report') ?>" name="btnSummaryPpdf" id="btnSummaryPpdf" class="<?php echo $class ?> btn btn-danger">Export Data(.PDF)</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        
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
                        <table id="summary_report_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Wajib Pajak</th>
                                    <th>Outlet</th>
                                    <th>Ppn</th>
                                    <th>Total Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>