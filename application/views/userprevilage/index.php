<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Hak Akses
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <?php if ($rights == '3'): ?>
                                <div class="col-sm-12">
                                   <a class="btn btn-rounded btn-primary btn-air btn-add-control" href="<?php echo base_url('UserPrevilage/create');  ?>">
                                        <span class="btn-icon">
                                            <span class="fa fa-plus"></span>
                                            Add Hak Akses
                                        </span>
                                    </a>
                                </div>
                            <?php endif ?>
                            
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="user-previlage-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Level</th>
                                            <?php if ($rights == '3'): ?>
                                                <th class="no-sort"></th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $refLevel = ['1' => 'Super Admin', '2' => 'Admin', '3' => 'Suban', '4' => 'NPWP', '5' => 'Merchant', '6' => 'Branch']; 
                                            foreach ($fetch as $index => $row): ?>
                                            <tr>
                                                <td><?php echo ++$index ?></td>
                                                <td><?php echo $row->up_name; ?></td>
                                                <td><?php echo $refLevel[$row->up_level]; ?></td>
                                                <?php if ($rights == 3): ?>
                                                    <td class="text-center">
                                                        <a data-up-id="<?php echo $row->up_id; ?>" class="edit-control ext-light mr-3 font-16" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                                        <a data-up-id="<?php echo $row->up_id; ?>" href="<?php echo base_url('UserPrevilage/delete/'.$row->up_id.'') ?>" class="delete-control ext-light mr-3 font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>
                                                        <a data-up-id="<?php echo $row->up_id; ?>" class="access-control ext-light mr-3 font-16" data-toggle="tooltip" title="Give Access"><i class="fa fa-cog"></i></a>
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