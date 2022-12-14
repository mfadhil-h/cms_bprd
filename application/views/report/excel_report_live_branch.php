<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
<table  class="table table-bordered" role="grid" aria-describedby="example1_info">
	<thead>
		<tr>
			<th>Wajib Pajak</th>
			<th>Outlet</th>
			<th>Npwp</th>
			<th>Nopd</th>
			<th>Tanggal Live</th>
        </tr>
	</thead>
	<tbody>
		<?php
			foreach ($fetch as $index => $row) {
				
					echo "<tr>
						<td>".$row->merchant_name."</td>
						<td>".$row->branch_name."</td>
						<td>".$row->npwp."</td>
						<td>".$row->nopd."</td>
						<td>".$row->date_live."</td>
					</tr>";	
					
			}
		?>
	</tbody>
</table>
		