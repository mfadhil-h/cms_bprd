
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
				<span><?php echo $fetch[0][0];  ?></span>
			</div>
			<p></p>
			<div class="col-lg-5">
				<span>Nama Branch</span>
			</div>
			<div class="col-lg-7">
				<span><?php echo $fetch[0][1];  ?></span>
			</div>
			<table  class="table table-bordered" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th>#</th>
						<th>No Bill</th>
						<th>Tanggal</th>
						<th>Pajak</th>
						<th>Pajak Pembetulan</th>
					</tr>
				</thead>
				<tbody>
					<?php  foreach ($fetch as $index => $row): ?>
						<tr>
							<td> <?php echo ++$index ?> </td>
							<td> <?php echo $row[2] ?> </td>
							<td> <?php echo date('d/m/Y', strtotime($row[3])) ?> </td>
							<td> <?php echo $row[4] ?></td>
							<td> <?php echo (empty($row[5]) ? '-' : ($row[5])) ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-1"></div>	
	</div>
	
</div>
