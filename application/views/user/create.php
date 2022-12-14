<div class="container create-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('user/store') ?>" method="post" id="user-form" class="form-horizontal">
                <input type="hidden" name="level" id="level" value="">
                <div class="form-group">
                    <label for="username" class="col-sm-2 col-form-label text-md-right">User Name*</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" id="username" class="col-sm-4 form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 col-form-label text-md-right">Kata sandi*</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" id="password" class=" col-sm-4 form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirm" class="col-sm-2 col-form-label text-md-right">Konfirmasi Sandi*</label>
                    <div class="col-sm-10">
                        <input type="password" name="password_confirm" id="password_confirm" class=" col-sm-4 form-control">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="up_id" class="col-sm-2 col-form-label text-md-right">Hak Akses*</label>
                    <div class="col-sm-10">
                        <select name="up_id" id="up_id" class="select form-control">
                            <option value="">--Choose--</option>
                            <?php foreach ($userPrevilages as $rowUp): ?>
                                <option value= "<?php echo $rowUp->up_id ?>" data-level="<?php echo $rowUp->up_level ?>" ><?php echo $rowUp->up_name ?></option>
                            <?php endforeach ?>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group suban">
                    <label for="suban_id" class="col-sm-2 col-form-label text-md-right">Suku Badan Pajak</label>
                    <div class="col-sm-10">
                        <select name="suban_id" id="suban_id" class="select form-control">
                            <option value="">--Choose--</option>
                            <?php foreach ($subans as $rowSuban): ?>
                                <option value= "<?php echo $rowSuban->suban_id ?>" ><?php echo $rowSuban->suban_name ?></option>
                            <?php endforeach ?>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group merchant">
                    <label for="merchant_id" class="col-sm-2 col-form-label text-md-right">Wajib Pajak</label>
                    <div class="col-sm-10">
                        <select name="merchant_id" id="merchant_id" class="select form-control">
                            <option value="">--Choose--</option>
                            <?php foreach ($merchants as $rowMerchant): ?>
                                <option value= "<?php echo $rowMerchant['merchant_id'] ?>" ><?php echo $rowMerchant['merchant_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group branch">
                    <label for="branch_id" class="col-sm-2 col-form-label text-md-right">Outlet</label>
                    <div class="col-sm-10">
                        <select name="branch_id" id="branch_id" class="select form-control">
        
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>