<div class="container create-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('merchant/store') ?>" method="post" id="merchant-form" class="form-horizontal">
                <div class="form-group">
                    <label for="merchant_name" class="col-sm-2 col-form-label text-md-right">Nama Wajib Pajak*</label>
                    <div class="col-sm-10">
                        <input type="text" name="merchant_name" id="merchant_name" class="col-sm-4 form-control">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="date_format" class="col-sm-2 col-form-label text-md-right">Format Tanggal*</label>
                    <div class="col-sm-10">
                        <input type="text" name="date_format" id="date_format" class=" col-sm-4 form-control" value="dd/MM/yyyy HH:mm:ss">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="no_tlp" class="col-sm-2 col-form-label text-md-right">Nomor Telepon</label>
                    <div class="col-sm-10">
                        <input type="text" name="no_tlp" id="no_tlp" class=" col-sm-4 form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 col-form-label text-md-right">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="email" id="email" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="owner_name" class="col-sm-2 col-form-label text-md-right">Nama Owner</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="owner_name" id="owner_name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="owner_location" class="col-sm-2 col-form-label text-md-right">Lokasi Owner</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="owner_location" id="owner_location" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="pos_code" class="col-sm-2 col-form-label text-md-right">Kode Pos</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="pos_code" id="pos_code" />
                    </div>
                </div>
                 <div class="form-group">
                    <label for="rt" class="col-sm-2 col-form-label text-md-right">Rt</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="rt" id="rt" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="rw" class="col-sm-2 col-form-label text-md-right">Rw</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="rw" id="rw" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>