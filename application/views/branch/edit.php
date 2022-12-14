<div class="container create-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('branch/save') ?>" method="post" id="branch-form" class="form-horizontal">     
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                <input type="hidden" name="merchant_id" value="<?php echo $row['merchant_id'] ?>">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="branch_name">Nama Outlet :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="branch_name" id="branch_name" value="<?php echo $row['branch_name'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="merchant_id">Wajib Pajak :</label>
                    <div class="col-sm-10">
                        <select name="merchant_id" id="merchant_id" class="select form-control">
                        <?php 
                            foreach ($merchants as $val => $rowMerchant) {
                                if ($rowMerchant['merchant_id'] == $row['merchant_id']) {
                                    $act = 'selected';
                                    echo '<option value ="'.$rowMerchant['merchant_id'].'"'.$act.'>'.$rowMerchant['merchant_name'].'</option>'; 
                                } else {
                                    echo '<option value ="'.$rowMerchant['merchant_id'].'">'.$rowMerchant['merchant_name'].'</option>'; 
                                }  
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="bt_id">Jenis Outlet :</label>
                    <div class="col-sm-10">
                        <select name="bt_id" id="bt_id" class="select form-control">
                         <?php
                            foreach ($branchsType as $val => $rowBt) {
                                if ($rowBt['bt_id'] == $row['bt_id']) {
                                    $act = 'selected';
                                    echo '<option value ="'.$rowBt['bt_id'].'"'.$act.'>'.$rowBt['bt_desc'].'</option>'; 
                                } else {
                                    echo '<option value ="'.$rowBt['bt_id'].'">'.$rowBt['bt_desc'].'</option>'; 
                                }  
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="kec_id">Kecamatan :</label>
                    <div class="col-sm-10">
                        <select name="kec_id" id="kec_id" class="select form-control">
                       <?php
                            foreach ($kecamatans as $val => $rowKec) {
                                if ($rowKec['kec_id'] == $row['kec_id']) {
                                    $act = 'selected';
                                    echo '<option value ="'.$rowKec['kec_id'].'"'.$act.'>'.$rowKec['kec_name'].'</option>'; 
                                } else {
                                    echo '<option value ="'.$rowKec['kec_id'].'">'.$rowKec['kec_name'].'</option>'; 
                                }  
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location">Lokasi :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="location" id="location" value="<?php echo $row['location'] ?>">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label" for="npwp">NPWP :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="npwp" id="npwp" value="<?php echo $row['npwp'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nopd">NOPD :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nopd" id="nopd" value="<?php echo $row['nopd'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="pic">PIC :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pic" id="pic" value="<?php echo $row['pic'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="pos_code">Kode Pos :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pos_code" id="pos_code" value="<?php echo $row['pos_code'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="no_tlp">No Telepon :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="no_tlp" id="no_tlp" value="<?php echo $row['no_tlp'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="email">email :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['email'] ?>">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="rekening_number">No Rekening :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rekening_number" id="rekening_number" value="<?php echo $row['rekening_number'] ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>