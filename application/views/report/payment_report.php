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
				<span>Laporan Pembayaran</span>
			</div>
			<table  class="table table-bordered" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th>Wajib Pajak</th>
						<th>Outlet</th>
						<th>Npwp</th>
						<th>Nopd</th>
						<th>No Invoice</th>
						<th>Ppn</th>
						<th>Assestment</th>
						<th>Pembayaran</th>
						<th>Chanel Pembayaran</th>
						<th>Tahun</th>
						<th>Bulan</th>
						<th>Tanggal Pembayaran</th>
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
									<td>".$value['invoice_no']."</td>
									<td class='text-right'>".number_format($value['ppn'])."</td>
									<td class='text-right'>".number_format($value['assessment'])."</td>
									<td class='text-right'>".number_format($value['paid'])."</td>
									<td>".$value['payment_channel']."</td>
									<td>".$value['year']."</td>
									<td>".$value['month']."</td>
									<td>".date('d-m-Y', strtotime($value['paid_date']))."</td>
								</tr>";	
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-1"></div>	
	</div>
	
</div>
