<div class="container create-form">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('UserPrevilage/save_access') ?>" method="post" id="user-previlage-form" class="form-horizontal">     
                <input type="hidden" name="up_id" value="<?php echo $fetch[0]->up_id ?>">
                <div class="box box-info access-module">
                    <div class="box-body table-responsive">
                        <div class="row">
                            <table id="give-access-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>Nama Modul</th>
                                        <th>Akses</th>
                                        <th>Approver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fetch as $index => $row): ?>
                                        <tr>
                                            <td><?php echo $row->mod_name ?>
                                                <input type="hidden" name="<?php echo 'mod_id_'.$index ?>" value="<?php echo $row->mod_id ?>">
                                            </td>
                                            <td>
                                                <select name="<?php echo 'ma_previlage_'.$index ?>" id="<?php echo 'ma_previlage_'.$index ?>" class="select select-picker form-control acc" data-live-search="true">
                                                    <option value="1" <?php echo $row->ma_previlage == 1 ? 'selected' : 'null' ?> >Disable</option>
                                                    <option value="2" <?php echo $row->ma_previlage == 2 ? 'selected' : 'null' ?> >View</option>
                                                    <option value="3" <?php echo $row->ma_previlage == 3 ? 'selected' : 'null' ?> >View & Update</option>
                                                </select>
                                            </td>
                                                
                                            <td>
                                                <select name="<?php echo 'ma_approver_'.$index ?>" id="<?php echo 'ma_approver_'.$index ?>" class="select select-picker form-control acc" data-live-search="true">
                                                    <option value="1" <?php echo $row->ma_approver == 1 ? 'selected' : 'null' ?> >Yes</option>
                                                    <option value="2" <?php echo $row->ma_approver == 2 ? 'selected' : 'null' ?> >No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>