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
				<span>Nama Merchant</span>
			</div>
			<div class="col-lg-7">
				<span><?php echo $dataMerchant['merchant_name'];  ?></span>
			</div>
			<p></p>
			<div class="col-lg-5">
				<span>Nama Branch</span>
			</div>
			<div class="col-lg-7">
				<span><?php echo $dataBranch['branch_name'];  ?></span>
			</div>
			<table  class="table table-bordered" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th>#</th>
						<th>Bill Number</th>
						<th>Tanggal</th>
						<th>Pajak</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($dataNote as $index => $value) {
							echo "<tr>
									<td>".++$index."</td>
									<td class='text-right'>".$value['bill_number']."</td>
									<td>".date('d-m-Y', strtotime($value['date_transaction']))."</td>
									<td>".number_format($value['adjustment_value'])."</td>
									<td>".$value['note']."</td>
								</tr>";	
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-1"></div>	
	</div>
	
</div>
