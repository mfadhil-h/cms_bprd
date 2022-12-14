<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Outlet / Cabang
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <?php if ($rights == 3): ?>
                                <div class="col-lg-12">
                                     <a class="btn btn-rounded btn-primary btn-air btn-add" href="<?php echo base_url('branch/create');  ?>">
                                        <span class="btn-icon">
                                            <span class="fa fa-plus"></span>
                                            Tambah Outlet/ Cabang
                                        </span>
                                    </a>
                                </div>
                            <?php endif ?>  
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="branch-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Nama Outlet</th>
                                            <th>Wajib Pajak</th>
                                            <th>NPWP</th>
                                            <th>NOPD</th>
                                            <th>Jenis Pajak</th>
                                            <th>PIC</th>
                                            <th>Lokasi</th>
                                            <th>Kecamatan</th>
                                            <th>Kode Pos</th>
                                            <th>No Telepon</th>
                                            <?php if ($rights == 3): ?>
                                            <th class="no-sort"></th>
                                            <?php endif ?> 
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>