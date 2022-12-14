<div class="container edit-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('merchant/save') ?>" method="post" id="merchant-form" class="form-horizontal">
            	<input type="hidden" name="merchant_id" value=<?php echo $merchant[0]->merchant_id ?>>
                <div class="form-group">
                    <label for="merchant_name" class="col-sm-2 col-form-label text-md-right">Nama Wajib Pajak*</label>
                    <div class="col-sm-10">
                        <input type="text" name="merchant_name" id="merchant_name" class="col-sm-4 form-control" value="<?php echo $merchant[0]->merchant_name ?>">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="date_format" class="col-sm-2 col-form-label text-md-right">Format Tanggal*</label>
                    <div class="col-sm-10">
                        <input type="text" name="date_format" id="date_format" class=" col-sm-4 form-control" value="<?php echo $merchant[0]->date_format ?>">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="no_tlp" class="col-sm-2 col-form-label text-md-right">Nomor Telepon</label>
                    <div class="col-sm-10">
                        <input type="text" name="no_tlp" id="no_tlp" class=" col-sm-4 form-control" value="<?php echo $merchant[0]->no_tlp ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 col-form-label text-md-right">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="email" id="email" value="<?php echo $merchant[0]->email ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="owner_name" class="col-sm-2 col-form-label text-md-right">Nama Owner</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="owner_name" id="owner_name" value="<?php echo $merchant[0]->owner_name ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="owner_location" class="col-sm-2 col-form-label text-md-right">Lokasi Owner</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="owner_location" id="owner_location" value="<?php echo $merchant[0]->owner_location ?>" />
                    </div>
                </div>
                 <div class="form-group">
                    <label for="pos_code" class="col-sm-2 col-form-label text-md-right">Kode Pos</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="pos_code" id="pos_code" value="<?php echo $merchant[0]->pos_code ?>" />
                    </div>
                </div>
                 <div class="form-group">
                    <label for="rt" class="col-sm-2 col-form-label text-md-right">Rt</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="rt" id="rt" value="<?php echo $merchant[0]->rt ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="rw" class="col-sm-2 col-form-label text-md-right">Rw</label>
                    <div class="col-sm-10">
                        <input type="text" class="col-sm-4 form-control" name="rw" id="rw" value="<?php echo $merchant[0]->rw ?>" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>