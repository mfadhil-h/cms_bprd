<div class="container create-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('UserPrevilage/save') ?>" method="post" id="user-previlage-form" class="form-horizontal">     
                <input type="hidden" name="up_id" value="<?php echo $row[0]->up_id ?>">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="up_name">Nama Hak Akses* :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="up_name" id="up_name" value="<?php echo $row[0]->up_name  ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="up_level">Level* :</label>
                    <div class="col-sm-10">
                        <select name="up_level" id="up_level" class="select form-control">
                        <option value="">-- Choose --</option>
                        <option value="1" <?php echo $row[0]->up_level == 1 ? 'selected' : 'null' ?> >Super Admin</option>
                        <option value="2" <?php echo $row[0]->up_level == 2 ? 'selected' : 'null' ?> >Admin</option>
                        <option value="3" <?php echo $row[0]->up_level == 3 ? 'selected' : 'null' ?> >Suban</option>
                        <option value="4" <?php echo $row[0]->up_level == 4 ? 'selected' : 'null' ?> >NPWP</option>
                        <option value="5" <?php echo $row[0]->up_level == 5 ? 'selected' : 'null' ?> >Merchant</option>
                        <option value="6" <?php echo $row[0]->up_level == 6 ? 'selected' : 'null' ?> >Branch / NOPD</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>