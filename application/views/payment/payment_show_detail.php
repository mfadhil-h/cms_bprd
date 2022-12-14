<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class=row>
                            <div class="col-md-5">Wajib Pajak</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6"> <?php echo $merchant_name ?></div>
                        </div>
                        <p></p>
                        <div class=row>
                            <div class="col-md-5">Wajib Pajak</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6"> <?php echo $branch_name ?></div>
                        </div>
                         <p></p>
                        <div class=row>
                            <div class="col-md-5">NPWP</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6"> <?php echo $npwp ?></div>
                        </div>
                         <p></p>
                        <div class=row>
                            <div class="col-md-5">NOPD</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6"> <?php echo $nopd ?></div>
                        </div>
                         <p></p>
                        <div class=row>
                            <div class="col-md-5">Periode</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6"> <?php echo $periode ?></div>
                        </div>
                        <p></p>
                        <div class=row>
                            <div class="col-md-5">Tanggal Pembayaran</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6"> <?php echo date('d F Y', strtotime($payment_date)) ?></div>
                        </div>
                        <p></p>
                        <div class=row>
                            <div class="col-md-5">Kode bayar</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6"> <?php echo $kode_bayar ?></div>
                        </div>
                        <p></p>
                        <div class=row>
                            <div class="col-md-5">total Pembayaran</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6">Rp. <?php echo number_format($total_payment) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>