<div class="content-wrapper">
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
    <?php if ($userLevel <= 3 ) {
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
                            <div class="callout call-suban callout-info id-suban-1" data-suban-id="" data-pajak="">
                                <h4 class="name-suban-1"></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc ppn-suban-1"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout call-suban callout-success id-suban-2" data-suban-id="" data-pajak="">
                                <h4 class="name-suban-2"></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc ppn-suban-2"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout call-suban callout-danger id-suban-3" data-suban-id="" data-pajak="">
                                <h4 class="name-suban-3"></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc ppn-suban-3"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout call-suban callout-warning id-suban-4" data-suban-id="" data-pajak="">
                                <h4 class="name-suban-4"></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc ppn-suban-4"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="callout call-suban callout-success id-suban-5" data-suban-id="" data-pajak="">
                                <h4 class="name-suban-5"></h4>
                                <p class="desc">Pajak :</p>
                                <p class="desc ppn-suban-5"></p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="callout call-suban callout-success" data-suban-id="all">
                                <h4 class="text-center"> Total</h4>
                                <p class="text-center desc">Pajak :</p>
                                <p class="text-center desc suban-all"></p>
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
                <?php if ($userLevel >= 4) {
                ?>
                <div class="callout callout-info">
                    <?php
                     if($_SESSION['level']==6){
                        echo '<h4>Selamat Datang, '.strtoupper($_SESSION['branch_name']).'!</h4>';
                    }else{
                        echo '<h4>Selamat Datang, '.strtoupper($_SESSION['merchant_name']).'!</h4>';
                    }
                    ?>
                    
                    <p>Silahkan pilih menu disamping untuk mengelola content.</p>
                </div>
                <?php
                }
                ?>
                <div class="<?php echo $_SESSION['level'] < 4 ? 'col-sm-8' : 'null'  ?>">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $_SESSION['level'] < 4 ? 'Laporan Jumlah Daring Outlet '.date('M-Y') : 'Laporan Data Transaksi Yang Masuk'  ?></h3>
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
                            if($userLevel <= '3'){
                            ?>
                            <form name="frmDashboard" id="frmDashboard" class="form-horizontal" action="#" method="post">
                
                            </form>
                            <?php
                            } else if($userLevel == 6)  {
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
                                <p>.</p>
                                <div>
                                    <table>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['level'] < 4): ?>

                    <div class="col-sm-4">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Daring Outlet <?php echo  date('d M Y',strtotime("-1 days")); ?></h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                 <div class="col-md-12">
                                    <div class="">
                                        <div class="col-sm-12">
                                            
                                            <h4 class="col-sm-12 text-center">Restoran</h4>
                                    
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="callout callout-info col-sm-4 dota">
                                            <h4>Online</h4>
                                            <h4 class="online-branch"></h4>
                                        </div> 
                                         <div class="col-sm-2"></div>
                                        <div class="callout callout-danger col-sm-4 dota">
                                            <h4>Offline</h4>
                                            <h4 class="offline-branch"></h4>
                                        </div>
                                        <div class="col-sm-1"></div>   
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="">
                                        <div class="col-sm-12">
                                            
                                            <h4 class="col-sm-12 text-center">Hotel</h4>
                                    
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="callout callout-info col-sm-4 dota">
                                            <h4>Online</h4>
                                            <h4>-</h4>
                                        </div> 
                                         <div class="col-sm-2"></div>
                                        <div class="callout callout-danger col-sm-4 dota">
                                            <h4>Offline</h4>
                                            <h4>-</h4>
                                        </div>
                                        <div class="col-sm-1"></div>   
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="col-sm-12">
                                            <h4 class="col-sm-12 text-center">Hiburan</h4>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="callout callout-info col-sm-9 dota">
                                            <h4>Online</h4>
                                            <h4>-</h4>
                                        </div> 
                                        <div class="col-sm-2"></div>
                                        <div class="callout callout-danger col-sm-4 dota">
                                            <h4>Offline</h4>
                                            <h4>-</h4>
                                        </div>
                                        <div class="col-sm-1"></div>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                <?php endif ?>
                
                
                <?php if ($userLevel >= 4) {
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
                    <div class="box box-success el-hidden col-md-12">
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