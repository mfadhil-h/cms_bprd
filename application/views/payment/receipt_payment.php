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
		<div class="col-lg-2"></div>
		<div class="col-lg-4">
			<div align="center" class="logo-jakarta" style="float: left;height: 50px;">
		        <img src="<?php echo assets_site; ?>login/bprd_bni.png" style="max-height: 90%;width: auto;top: 0;bottom: 0;margin: auto;position: absolute;">
		    </div>
		</div>
		<div class="col-lg-5">
			<div align="center" class="logo-jakarta" style="float: left;height: 50px;">
		        <img src="<?php echo assets_site; ?>login/bprd2.png" style="max-height: 100%;width: auto;">
		    </div>
		</div>
		<div class="col-lg-1"></div>
	</div>
	<div class="row">
		<br>
		<div class="col-lg-11">
			<div class="col-lg-4">
				<span class="title"></span>
			</div>
			<div class="col-lg-8">
				<span class="title">Pembayaran Pajak</span>
			</div>
		</div>
		<div class="col-lg-1"></div>	
	</div>
	<br>
	<?php foreach ($fetch as $key => $value): ?>
		<div class="row">
		<div class="col-lg-11">
			<div class="col-lg-5">
				<span><?php echo $key ?></span>
			</div>
			<div class="col-lg-1">
				<span>:</span>
			</div>
			<div class="col-lg-4">
				<span><?php echo $value ?></span>
			</div>
		</div>
		<div class="col-lg-1"></div>
	</div> 
	<p></p>
	<?php endforeach ?>
	
	<div class="row">
		<br>
		<div class="col-lg-11">
			<div class="col-lg-12">
				<p class="text-center">RESI INI SEBAGAI BUKTI PEMBAYARAN YANG SAH</p>
			</div>
		</div>
		
	</div>
	
</div>
