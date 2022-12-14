<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=$title.xlsx");

header("Pragma: no-cache");

header("Expires: 0");

?>
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
			foreach ($fetch as $index => $rows) {
				foreach ($rows as $key => $value) {
					echo "<tr>
						<td>".$value['merchant_name']."</td>
						<td>".$value['branch_name']."</td>
						<td>".$value['bill_no']."</td>
						<td>".date('d-m-Y', strtotime($value['bill_date']))."</td>
						<td>".$value['item_name']."</td>
						<td>".$value['item_type']."</td>
						<td class='text-right'>".number_format($value['item_price'])."</td>
						<td class='text-right'>".number_format($value['quantity'])."</td>
						<td class='text-right'>".number_format($value['item_amount'])."</td>
					</tr>";	
				}	
			}
		?>
	</tbody>
</table>
		