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
        Live Outlet
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Laporan</a></li>
        <li class="active">Live Outlet</li>
      </ol>
    </section>

    <section class="content">
        <div class="row selector">
            <div class="col-lg-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form name="live_branch" id="live_branch" class="form-horizontal" action="#" method="post">
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="year">Tahun :</label>
                                    <div class="col-sm-8">
                                        <select name="year" id="year" class="select form-control">
                                            <option value="ALL">--Semua Tahun--</option>
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
                                            <option value="ALL">--Semua Bulan--</option>
                                            <?php
                                            foreach ($month as $val => $desc): ?>
                                                <option value="<?php echo $val ?>" > <?php echo $desc ?> </option>
                                                
                                            <?php endforeach ?>
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
                                             <option value="ALL">--Semua Wajib Pajak--</option>
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
                                            <option value="ALL">--Semua Outlet--</option>
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
                                                <option value="ALL">--Semua Suku Badan Pajak--</option>
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
                       
                        <input type="button" name="btn_get_data" id="btn_get_data" value="Tampilkan Data" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" href="<?php echo base_url('/reportbranchlive/excel') ?>" name="btnExportXlsx" id="btnExportXlsx" value="Export Data (.XLSX)" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        
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
                        <table id="table-live-branch" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>Wajib Pajak</th>
                                    <th>Outlet</th>
                                    <th>Npwp</th>
                                    <th>Nopd</th>
                                    <th>Tanggal live</th>
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