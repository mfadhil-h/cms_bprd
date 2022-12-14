<div class="container create-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('branch/store') ?>" method="post" id="branch-form" class="form-horizontal">     
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">Nama Outlet :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="branch_name" id="branch_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">Wajib Pajak :</label>
                    <div class="col-sm-10">
                        <select name="merchant_id" id="merchant_id" class="select form-control">
                        <?php
                            foreach ($merchants as $val => $rowMerchant) {

                                echo '<option value ="'.$rowMerchant['merchant_id'].'">'.$rowMerchant['merchant_name'].'</option>';   
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">Jenis Outlet :</label>
                    <div class="col-sm-10">
                        <select name="bt_id" id="bt_id" class="select form-control">
                        <?php
                            foreach ($branchsType as $val => $rowBt) {

                                echo '<option value ="'.$rowBt['bt_id'].'">'.$rowBt['bt_desc'].'</option>';   
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">Kecamatan :</label>
                    <div class="col-sm-10">
                        <select name="kec_id" id="kec_id" class="select form-control">
                        <?php
                            foreach ($kecamatans as $val => $rowKec) {

                                echo '<option value ="'.$rowKec['kec_id'].'">'.$rowKec['kec_name'].'</option>';   
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">Lokasi :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="location" id="location">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">NPWP :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="npwp" id="npwp">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">NOPD :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nopd" id="nopd">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">PIC :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pic" id="pic">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">Kode Pos :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pos_code" id="pos_code">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">No Telepon :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="no_tlp" id="no_tlp">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="year">email :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="rekening_number">No Rekening :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rekening_number" id="rekening_number">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>