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
				<span>Detail Transaction</span>
			</div>
			<table  class="table table-bordered" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th>Wajib Pajak</th>
						<th>Outlet</th>
						<th>No Bill</th>
						<th>Tanggal</th>
						<th>Nama Item</th>
						<th>Jenis Item</th>
						<th>Harga Item</th>
						<th>Kuantitas</th>
						<th>Harga Item</th>
		            </tr>
				</thead>
				<tbody>
					<?php
						foreach ($fetch as $index => $value) {
							echo "<tr>
									<td>".$value['merchant_name']."</td>
									<td>".$value['branch_name']."</td>
									<td>".$value['bill_no']."</td>
									<td>".date('d-m-Y', strtotime($value['bill_date']))."</td>
									<td>".$value['item_name']."</td>
									<td>".$value['item_type']."</td>
									<td class='text-right'>".number_format(floatval($value['item_price']))."</td>
									<td class='text-right'>".number_format(floatval($value['quantity']))."</td>
									<td class='text-right'>".number_format(floatval($value['item_amount']))."</td>
								</tr>";	
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-1"></div>	
	</div>
	
</div>
