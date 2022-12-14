<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Suku Badan Pajak
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <?php if ($rights == 3): ?>
                                <div class="col-lg-12">
                                    <a class="btn btn-rounded btn-primary btn-air btn-add" href="<?php echo base_url('suban/create');  ?>">
                                        <span class="btn-icon">
                                            <span class="fa fa-plus"></span>
                                            Add Suban
                                        </span>
                                    </a>
                                </div>
                            <?php endif ?>  
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="suban-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Suku Badan Pajak </th>
                                            <?php if ($rights == 3): ?>
                                            <th class="no-sort"></th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($fetch as $index => $row):
                                            $id = $row['suban_id'];
                                        ?>
                                            <tr>
                                                    <td><?php echo ++$index ?></td>
                                                    <td><?php echo $row['suban_name'] ?></td>
                                                    <?php if ($rights == 3): ?>
                                                    <td class="text-center">
                                                        <a href="<?php echo base_url("suban/edit/$id");  ?>" class="edit-control ext-light mr-3 font-16" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                                        <a href="<?php echo base_url("suban/delete/$id");  ?>" class="delete-control font-16" data-suban-id = "<?php echo $id ?>" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                    <?php endif ?>
                                                </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>`
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>