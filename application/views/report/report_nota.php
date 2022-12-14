<tbody>
	<div id="page-wrapper">
		<div id="tools-section">
			<button class="print">print</button>
		</div>
	</div>
</tbody>
<div class="report" id="report" style="width: 611px;height:940px;margin: 0 auto;background-color:#FFFFFF ;">
	<BODY>
		<DIV id="page_1">
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<DIV class="row">
				<DIV class="col-sm-6"><img src="<?php echo base_url('assets/images');?>/logo_BNI.png" style="width: 70%;display: block;">
			</DIV></DIV>
					
			<DIV class="row">
					<DIV class="col-sm-10">
						<DIV class="col-sm-4">Nomor Rekening</DIV>
						<DIV class="col-sm-2">:</DIV>
						<DIV class="col-sm-6">6000878786</DIV>
					</DIV>
			</DIV>
			<DIV class="row">
					<DIV class="col-sm-10">
						<DIV class="col-sm-4">Kepada</DIV>
						<DIV class="col-sm-2">:</DIV>
						<DIV class="col-sm-6">Penerimaan Pajak Daerah Online BPKD DKI Jakarta</DIV>
					</DIV>
			</DIV>
			
				
				
			<DIV class="row">
				<DIV class="col-lg-12 text-center"><h1>NOTA KREDIT</h1></DIV>
			</DIV>
				<P>Kami kredit rekening Saudara atas penerimaan pajak online tanggal <?= $startdate ?>, sbb :</P>
			<DIV class="row">
				<DIV class="col-lg-12">
				<DIV class="col-lg-6 text-center" style="border-width:1px;border-style: solid;">URAIAN</DIV>
				<DIV class="col-lg-6 text-center"style="border-width:1px;border-style: solid;border-left: none;">JUMLAH</DIV>
			</DIV>
			</DIV>
			<!-- <TABLE style="border: 1px;">
				<TH>
					<TD>URAIAN</TD>
					<TD>JUMLAH</TD>
				</TH> -->

			<?php
			if(!empty($kredit)) {
				$jumlahtotal=0;
				foreach($kredit as $rows) {
			?>
				<div class="row">
					<DIV class="col-lg-12">
						<DIV class="col-sm-6 text-left" style="border-width:1px;border-style: solid;padding-left: 15px;border-top: none;"><?= $rows->bt_desc ?></DIV>
						<DIV class="col-sm-2 text-left" style="border-width:1px;border-style: solid;padding-left: 15px;border-top: none;border-left: none;border-right: none">Rp</DIV>
						<DIV class="col-sm-4 text-right "style="border-width:1px;border-style: solid;padding-right:20px;border-top: none;border-left: none;"><?= number_format($rows->total,2); ?></DIV>
					</DIV>
				</div>
				<!-- <TR>
					<TD><?= $rows->bt_desc ?></TD>
					<TD>Rp <?= number_format($rows->total,2); ?></TD>
				</TR> -->
			<?php

				}
			}
			?>

			
				<!-- <TR>
					<TD><?= $rows->bt_desc ?></TD>
					<TD>Rp <?= number_format($rows->total,2); ?></TD>
				</TR> -->
			<!-- </TABLE> -->
			<DIV class="row">
				<DIV class="col-lg-12">
						<DIV class="col-sm-6 text-left" style="border-width:1px;border-style: solid;padding-left: 15px;border-top: none;">TOTAL</DIV>
						<DIV class="col-sm-2 text-left" style="border-width:1px;border-style: solid;padding-left: 15px;border-top: none;border-left: none;border-right: none">Rp</DIV>
						<DIV class="col-sm-4 text-right "style="border-width:1px;border-style: solid;padding-right:20px;border-top: none;border-left: none;"><?= number_format($maxtotal,2); ?></DIV>
					</DIV>
			</DIV>
			<DIV class="row">
				<DIV class="col-lg-12">
						<DIV class="col-sm-12 text-left" style="border-width:1px;border-style: solid;padding-left: 15px;border-top: none;">TERBILANG : <?= $terbilang ?></DIV>
					</DIV>

			<br/>
			<br/>
			<br/>
			<br/>
			<DIV class="row">
				<DIV class="col-lg-7"></DIV>
				<DIV class="col-lg-5">Jakarta, <?= $now ?></DIV>
			</DIV>
			<br/>
			<DIV class="row">
				<DIV class="col-lg-12">Jumlah tersebut diatas telah dikreditkan dalam rekening Saudara</DIV>
			</DIV>
			<DIV class="row">
				<DIV class="col-lg-12">Nota kredit ini sebagai bukti transaksi yang sah</DIV>
			</DIV>
		
		</DIV>
	</BODY>
</div>