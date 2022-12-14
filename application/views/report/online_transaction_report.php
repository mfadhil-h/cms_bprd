<thead>
	<title>CPMS</title>
</thead>
<tbody>
	<div id="page-wrapper">
		<div id="tools-section">
			<button class="print-report">print</button>
			<button class="close-report">Close</button>
		</div>
	</div>
</tbody>
<div class="report" id="report">
	<div class="row">
		<br>
		<div class="col-lg-1"></div>
		<div class="col-lg-10">
			<div class="col-lg-5">
				<span>Laporan Daring Transaksi(Online)</span>
			</div>
			<table  class="table table-bordered" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th>Wajib Pajak</th>
						<th>Outlet</th>
						<th>Npwp</th>
						<th>Nopd</th>
						<th>No Bill</th>
						<th>Tanggal</th>
						<th>Total Amount</th>
						<th>Service Charge</th>
						<th>Ppn</th>
						<th>Trx Amount</th>
						<th>Jenis Pembayaran</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($fetch as $index => $value) {
							echo "<tr>
									<td>".$value['merchant_name']."</td>
									<td>".$value['branch_name']."</td>
									<td>".$value['npwp']."</td>
									<td>".$value['nopd']."</td>
									<td>".$value['bill_no']."</td>
									<td>".date('d-m-Y', strtotime($value['bill_date']))."</td>
									<td class='text-right'>".number_format($value['total_amount'])."</td>
									<td class='text-right'>".number_format($value['service'])."</td>
									<td class='text-right'>".number_format($value['ppn'])."</td>
									<td class='text-right'>".number_format($value['total_trx_amount'])."</td>
									<td class='text-right'>".$value['payment_type']."</td>
								</tr>";	
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-1"></div>	
	</div>
	
</div>
