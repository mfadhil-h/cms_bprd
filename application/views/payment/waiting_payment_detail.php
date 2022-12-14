<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body table-responsive">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table-waiting-payment-detail" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Wajib Pajak</th>
                                    <th>Outlet</th>
                                    <th>Kode Bayar</th>
                                    <th>Detil Pajak</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($fetch as $index => $row): ?>
                                <tr>
                                    <td><?php echo $row['year'] ?></td>
                                    <td><?php echo $row['month'] ?></td>
                                    <td><?php echo $row['merchant_name'] ?></td>
                                    <td><?php echo $row['branch_name'] ?></td>
                                    <td><?php echo $row['kode_bayar'] ?></td>
                                    <td class="text-right"><?php echo number_format($row['total_ppn']) ?></td>
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