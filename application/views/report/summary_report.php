<thead>
	<title>CPMS</title>
</thead>
<tbody>
	<div id="page-wrapper">
		<div id="tools-section">
			<button class="print-report">Print</button>
			<button class="close-report">Keluar</button>
		</div>
	</div>
</tbody>
<div class="report" id="report">
	<div class="row">
		<br>
		<div class="col-lg-1"></div>
		<div class="col-lg-10">
			<div class="col-lg-5">
				<span>Laporan Rekapitulasi</span>
			</div>
			<table  class="table table-bordered" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Wajib Pajak</th>
						<th>Outlet</th>
						<th>PPn</th>
						<th>Total Transaksi</th>
		            </tr>
				</thead>
				<tbody>
					<?php
						foreach ($fetch as $index => $value) {
							echo "<tr>
									<td>".$value['date_transaction']."</td>
									<td>".$value['merchant_name']."</td>
									<td>".$value['branch_name']."</td>
									<td class='text-right'>".number_format($value['daily_tax'])."</td>
									<td class='text-right'>".number_format($value['daily_transaction'])."</td>
								</tr>";	
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-1"></div>	
	</div>
	
</div>
