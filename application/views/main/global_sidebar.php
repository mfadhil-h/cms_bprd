<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-circle-o"></i> <span>Dashboard</span></a></li>
            <li class="header">MASTERS</li>
            <?php if ($accessModule['mod_user'] != 1 || $accessModule['mod_up'] != 1): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span class="side-bar">User</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($accessModule['mod_user'] != 1): ?>
                            <li><a href="<?php echo base_url('user'); ?>"><i class="fa fa-user"></i> <span class="side-bar">User</span></a></li>
                        <?php endif ?>
                        <?php if ($accessModule['mod_up'] != 1): ?>
                            <li><a href="<?php echo base_url('UserPrevilage/index'); ?>"><i class="las la-key"></i> <span class="side-bar">Hak Akses</span></a></li>
                        <?php endif ?>
                    </ul>
                </li>
            <?php endif ?>

            <?php if ($accessModule['mod_merchant'] != 1 || $accessModule['mod_branch'] != 1): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span class="side-bar">Wajib Pajak</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($accessModule['mod_merchant'] != 1): ?>
                            <li>
                                <a href="<?php echo base_url('merchant/index'); ?>">
                                    <i class="fa fa-gears"></i>
                                    <span class="side-bar">Wajib Pajak</span>
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if ($accessModule['mod_branch'] != 1): ?>
                            <li>
                                <a href="<?php echo base_url('branch/index'); ?>">
                                    <i class="fa fa-gears"></i>
                                    <span class="side-bar">Outlet / Cabang</span>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </li>
            <?php endif ?>

            <?php if ($accessModule['mod_suban'] != 1 || $accessModule['mod_kec'] != 1): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span class="side-bar">Suku Badan Pajak</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($accessModule['mod_suban'] != 1): ?>
                            <li><a href="<?php echo base_url('suban/index'); ?>"><i class="fa fa-building "></i> <span class="side-bar">Suku Badan Pajak </span></a></li>
                        <?php endif ?>
                        <?php if ($accessModule['mod_kec'] != 1): ?>
                            <li><a href="<?php echo base_url('kecamatan/index'); ?>"><i class="fa fa-map-marker"></i> <span class="side-bar">Kecamatan</span></a></li>
                        <?php endif ?>
                    </ul>
                </li>
            <?php endif ?>

            <?php if ($accessModule['mod_summary'] != 1 || $accessModule['mod_tax_rep'] != 1 || $accessModule['mod_sspd_sptpd'] != 1): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i>
                        <span class="side-bar">Aktivitas Pajak</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($accessModule['mod_summary'] != 1): ?>
                            <!-- <li><a href="<?php //echo base_url('payment'); ?>"><i class="fa fa-money"></i>
                            <span class="side-bar">Pembayaran Pajak</span></a></li> -->

                            <li><a href="<?php echo base_url('payment_autodebet/index'); ?>"><i class="fa fa-money"></i>
                            <span class="side-bar">Auto debet</span></a></li>
                        <?php endif ?>

                        <?php if ($accessModule['mod_tax_rep'] != 1): ?>
                            <li><a href="<?php echo base_url('taxreport/index'); ?>"><i class="fa fa-file-text "></i>
                            <span class="side-bar">Lapor Pajak</span></a></li>
                        <?php endif ?>
                        <?php if ($accessModule['mod_sspd_sptpd'] != 1): ?>
                            <li><a href="<?php echo base_url('reportSspdSptpd/index') ?>"><i class="fa fa-file-text-o"></i>
                                <span class="side-bar">e-SSPD & e-SPTPD</span></a>
                            </li>
                        <?php endif ?>
                    </ul>
                </li>
            <?php endif ?>

            <?php if ($accessModule['mod_check_billing'] != 1 || $accessModule['mod_wait_payment'] != 1): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span class="side-bar">Pembayaran BNI</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($accessModule['mod_check_billing'] != 1): ?>
                            <li><a href="<?php echo base_url('payment2/checkbilling'); ?>"><i class="fa fa-gears"></i>
                            <span class="side-bar">Cek Pembayaran</span></a></li>
                        <?php endif ?>

                        <?php if ($accessModule['mod_wait_payment'] != 1): ?>
                            <li><a href="<?php echo base_url('payment/waitingpayment'); ?>"><i class="fa fa-credit-card"></i>
                            <span class="side-bar">Menunggu Pembayaran</span></a></li>
                        <?php endif ?>
                    </ul>
                </li>
            <?php endif ?>

        <?php if ($accessModule['mod_rep_paym'] != 1 || $accessModule['mod_rep_trans'] != 1 || $accessModule['mod_rep_realtrans'] != 1 || $accessModule['mod_rep_detail'] != 1 || $accessModule['mod_rep_data_monitor'] != 1 || $accessModule['mod_rep_summary'] != 1 || $accessModule['mod_sspd_sptpd'] != 1 ): ?>
             <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span class="side-bar">Reports</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    <?php if ($accessModule['mod_rep_paym'] != 1): ?>
                        <li><a href="<?php echo base_url('reportPayment/index'); ?>"><i class="fa fa-book text-green"></i>
                            <span class="side-bar">Laporan Pembayaran</span></a>
                        </li>
                    <?php endif ?>

                    <?php if ($accessModule['mod_rep_trans'] != 1): ?>
                        <li><a href="<?php echo base_url('ReportTransaction/index'); ?>"><i class="fa fa-book text-red"></i>
                            <span class="side-bar">Transaksi</span></a>
                        </li>
                    <?php endif ?>
                    
                    <?php if ($accessModule['mod_rep_realtrans'] != 1): ?>
                        <li><a href="<?php echo base_url('reportOnlineTransaction/index'); ?>"><i class="fa fa-book text-blue"></i>
                            <span class="side-bar">Daring Transaksi</span></a>
                        </li>
                    <?php endif ?>

                    <?php if ($accessModule['mod_notakredit'] != 1): ?>
                        <li><a href="<?php echo base_url('Notakredit/index') ?>"><i class="fa fa-book text-info"></i>
                            <span class="side-bar">Nota Kredit</span></a>
                        </li>
                    <?php endif ?>
                    
                    <?php if ($accessModule['mod_rep_detail'] != 1): ?>
                        <li><a href="<?php echo base_url('reportDetail/index'); ?>"><i class="fa fa-book text-yellow"></i>
                            <span class="side-bar">Detil</span></a>
                        </li>
                    <?php endif ?>
                   
                    <?php if ($accessModule['mod_rep_data_monitor'] != 1): ?>
                        <li><a href="<?php echo base_url('reportDataMonitoring/index'); ?>"><i class="fa fa-book text-green"></i>
                            <span class="side-bar">Data Monitoring</span></a>
                        </li>
                    <?php endif ?>

                    <?php if ($accessModule['mod_rep_summary'] != 1): ?>
                        <li><a href="<?php echo base_url('ReportSummary/index') ?>"><i class="fa fa-book text-info"></i>
                            <span class="side-bar">Laporan Rekapitulasi</span></a>
                        </li>
                    <?php endif ?>
                    <?php if ($accessModule['mod_rep_livebranch'] != 1): ?>
                        <li><a href="<?php echo base_url('reportbranchlive/index') ?>"><i class="fa fa-book text-info"></i>
                            <span class="side-bar">Laporan Live outlet</span></a>
                        </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif ?>
        </ul>
    </section>
</aside>
