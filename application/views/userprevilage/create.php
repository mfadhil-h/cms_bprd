<div class="container create-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('UserPrevilage/store') ?>" method="post" id="user-previlage-form" class="form-horizontal">     

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="up_name">Nama Hak Akses* :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="up_name" id="up_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="up_level">Level* :</label>
                    <div class="col-sm-10">
                        <select name="up_level" id="up_level" class="select form-control">
                        <option value="">-- Choose --</option>
                        <option value="1">Super Admin</option>
                        <option value="2">Admin</option>
                        <option value="3">Suban</option>
                        <option value="4">NPWP</option>
                        <option value="5">Merchant</option>
                        <option value="6">Branch / NOPD</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>