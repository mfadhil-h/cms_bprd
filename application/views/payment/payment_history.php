<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body table-responsive">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table-history-payment" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>Wajib Pajak</th>
                                    <th>Outlet</th>
                                    <th>Kode Bayar</th>
                                    <th>Periode</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Total Pajak</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $status = ['1' => 'Success Bayar', '2' => 'Gagal Bayar']; 
                                foreach ($fetch as $index => $row) : ?>
                                <tr>
                                    <td><?php echo $row->merchant_name ?></td>
                                    <td><?php echo $row->branch_name ?></td>
                                    <td><?php echo $row->kode_bayar ?></td>
                                    <td><?php echo $row->periode ?></td>
                                    <td><?php echo $row->payment_date ?></td>
                                    <td class="text-right"><?php echo number_format($row->total_payment) ?></td>
                                    <td><?php echo $status[$row->payment_status] ?></td>
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