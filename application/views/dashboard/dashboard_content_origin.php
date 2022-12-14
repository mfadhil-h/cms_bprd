<?php //var_dump($subanData); exit();  ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <p>
    <?php if ($userLevel == 1 || $userLevel == 6 || $userLevel == 2) {
    ?>
     <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h3 class="box-title">Laporan Data Pajak Yang Masuk</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-2">
                            <div class="callout callout-info" data-suban-id="<?php echo $subanData[0]['suban_id'];  ?>" data-pajak="<?php echo $subanData[0]['ppn'];  ?>">
                                <h4><?php echo $subanData[0]['suban_name'];  ?></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc">Rp. <?php echo number_format($subanData[0]['ppn']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout callout-success" data-suban-id="<?php echo $subanData[1]['suban_id'];  ?>" data-pajak="<?php echo $subanData[1]['ppn'];  ?>">
                                <h4><?php echo $subanData[1]['suban_name'];  ?></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc">Rp. <?php echo number_format($subanData[1]['ppn']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout callout-danger" data-suban-id="<?php echo $subanData[2]['suban_id'];  ?>" data-pajak="<?php echo $subanData[2]['ppn'];  ?>">
                                <h4><?php echo $subanData[2]['suban_name'];  ?></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc">Rp. <?php echo number_format($subanData[2]['ppn']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout callout-warning" data-suban-id="<?php echo $subanData[3]['suban_id'];  ?>" data-pajak="<?php echo $subanData[3]['ppn'];  ?>">
                                <h4><?php echo $subanData[3]['suban_name'];  ?></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc">Rp. <?php echo number_format($subanData[3]['ppn']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout callout-success" data-suban-id="<?php echo $subanData[4]['suban_id'];  ?>" data-pajak="<?php echo $subanData[4]['ppn'];  ?>">
                                <h4><?php echo $subanData[4]['suban_name'];  ?></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc">Rp. <?php echo number_format($subanData[4]['ppn']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="callout callout-success" data-suban-id="all">
                                <h4 class="text-center"> Total</h4>
                                <p class="text-center desc">Pajak :</p>
                                <p class="text-center desc">Rp <?php echo number_format($totalTax);  ?></p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php if ($userLevel == 3 || $userLevel == 4 || $userLevel == 5) {
                    # code...
                ?>
                <div class="callout callout-info">
                    <?php
                    if($_SESSION['level']==5){
                        echo '<h4>Selamat Datang, '.strtoupper($this->session->userdata('username2')).'!</h4>';
                    }else{
                        echo '<h4>Selamat Datang, '.strtoupper($this->session->userdata('username')).'!</h4>';
                    }
                    ?>
                    
                    <p>Silahkan pilih menu disamping untuk mengelola content.</p>
                </div>
                <?php
                }
                ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Laporan Data Transaksi Yang Masuk</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php 
                        if($userLevel < '3' || $userLevel == '6'){
                        ?>
                        <form name="frmDashboard" id="frmDashboard" class="form-horizontal" action="#" method="post">
            
                        </form>
                        <?php
                        } else if($userLevel == 5)  {
                        ?>
                        <form name="frmDashboard" id="frmDashboard" class="form-horizontal" action="#" method="post">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Date Range</div>
                                    <div class="ibox-tools">
                                        <a class="ibox-collapse">
                                            <i class="ti-angle-down"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-body">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <div id="predefined-daterange">
                                                <i class="fa fa-calendar mr-2"></i>
                                                <span></span><b class="caret ml-3"></b>
                                            </div>
                                            <input type="hidden" name="date_range" id="date_range">
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="button" name="btnSubmit" id="btnSubmit" value="Submit" class="col-sm-2 btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        }
                        ?>
                        <div class="chart">                                
                        </div>
                        <div>
	                        <table>
	                        </table>
                        </div>
                    </div>
                </div>
                <?php if ($userLevel == 3 || $userLevel == 4 || $userLevel == 5) {
                ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Laporan Data Pajak Yang Masuk</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="chartContainer" style="height: 230px; width: 100%;"></div>
                    </div>
                </div>
                <?php 
                } else {
                ?>
                    <div class="box box-success el-hidden">
                        <div class="box-header with-border">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="chartContainerkec" style="height: 230px; width: 100%;">
                                <div>
                                    <div class="col-md-6">
                                        <h3 class="data-kecamatan-merchant">Laporan Data Pajak Yang Masuk Per Kecamatan</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="data-kecamatan-merchant">Laporan Data Transaksi Yang Masuk Per Merchant</h3>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-6 chart-kecamatan">
                                    </div>
                                    <div class="col-md-6 chart-merchant">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
               
            </div>
    </section>
</div>