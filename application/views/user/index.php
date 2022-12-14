<div class="content-wrapper">
    <section class="content-header">
        <h1>
            User
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
                                <div class="col-sm-12">
                                    <a class="btn btn-rounded btn-primary btn-air btn-add-control" href="<?php echo base_url('user/create');  ?>">
                                        <span class="btn-icon">
                                            <span class="fa fa-plus"></span>
                                            Add User
                                        </span>
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="user-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User Name</th>
                                            <th>Hak Akses</th>
                                            <th>User Level</th>
                                            <?php if ($rights == 3): ?>
                                            <th></th>    
                                            <?php endif ?>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $refLevel = [1 => 'Super Admin', 2 => 'Admin', 3 => 'Suban', 4 => 'NPWP', 5 => 'Merchant', 6 => 'Branch / NOPD']; 
                                        foreach ($fetch as $index => $row): ?>
                                            <tr>
                                                <td><?php echo ++$index ?></td>
                                                <td><?php echo $row->username ?></td>
                                                <td><?php echo $row->up_name ?></td>
                                                <td><?php echo $refLevel[$row->up_level] ?></td>
                                                <?php if ($rights == 3): ?>
                                                    <td class="text-center">
                                                        <a data-id="<?php echo $row->id; ?>" class="edit-control ext-light mr-3 font-16" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                                        <a data-id="<?php echo $row->id; ?>" href="<?php echo base_url('user/delete/'.$row->id.''); ?>" class="delete-control ext-light mr-3 font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                <?php endif ?>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>