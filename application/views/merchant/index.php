<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Wajib Pajak
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info">
                    <div class="box-body table-responsive">
                        <div class="row">
                             <?php if ($rights == 3): ?>
                                <div class="col-lg-12">
                                    <a class="btn btn-rounded btn-primary btn-air btn-add-control" href="<?php echo base_url('merchant/create');  ?>">
                                        <span class="btn-icon">
                                            <span class="fa fa-plus"></span>
                                            Tambah Wajib Pajak
                                        </span>
                                    </a>  
                                </div>
                            <?php endif ?>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="merchant-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Nama Wajib Pajak</th>
                                            <th>Shared key</th>
                                            <th>Format Tanggal</th>
                                            <th>No telepon</th>
                                            <th>Email</th>
                                            <th>Nama Owner</th>
                                            <th>Lokasi Owner</th>
                                            <?php if ($rights == 3): ?>
                                                <th></th>    
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