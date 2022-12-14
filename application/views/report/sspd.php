<?php  //var_dump($merchant->owner_location); exit();
$monthDesc = ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember']; ?>
<tbody>
	<div id="page-wrapper">
		<div id="tools-section">
			<button class="print">print</button>
		</div>
	</div>
</tbody>
<div class="report" id="report">
	<BODY>
		<DIV id="page_1">
			<DIV id="p1dimg1">
				<img src="<?php echo base_url('assets/images');?>/blackwhitejayaraya.png" style="width: 11%;display: block;">
			</DIV>
			<DIV class="dclr">
				
			</DIV>
			<P class="p0 ft0">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</P>
			<P class="p1 ft1">BADAN PENDAPATAN DAERAH</P>
			<P class="p2 ft2">JALAN ABDUL MUIS NO. 66 Telp. 3865580 – 85 Fax. 3865788</P>
			<P class="p3 ft2">JAKARTA 10160</P>
			<P class="p4 ft3">SURAT SETORAN PAJAK DAERAH</P>
			<P class="p5 ft4">( SSPD )</P>
			<TABLE>
				<TR class="border-top">
					<TD class="tr0 td0"><P class="p6 ft2">1.</P></TD>
					<TD class="tr0 td1"><P class="p7 ft2">Nama Wajib Pajak</P></TD>
					<TD class="tr0 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr0 td3"><P class="p8 ft5"><?php echo $merchant_name ?></P></TD>
				</TR>
				<TR>
					<TD class="tr0 td0"><P class="p6 ft2">2.</P></TD>
					<TD class="tr0 td1"><P class="p7 ft2">Alamat</P></TD>
					<TD class="tr0 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr0 td3"><P class="p8 ft5"> <?php echo (empty($merchant->owner_location) ? '……………………………………………………………………' : $merchant->owner_location) ?></P></TD>
				</TR>
				<TR>
					<TD class="tr1 td0"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td1"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td2"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td4"><P class="p10 ft2">RT <?php echo (empty($merchant->rt) ? '…….' : $merchant->rt) ?> RW <?php echo (empty($merchant->rw) ? '…….' : $merchant->rw) ?> </P></TD>
					<TD class="tr1 td5"><P class="p9 ft2">Kode Pos <?php echo (empty($merchant->pos_code) ? ' …………….' : $merchant->pos_code) ?></P></TD>
				</TR>
				<TR>
					<TD class="tr2 td0"><P class="p6 ft2">3.</P></TD>
					<TD class="tr2 td1"><P class="p7 ft2">NPWPD</P></TD>
					<TD class="tr2 td2"><P class="p11 ft2">:</P></TD>
					<TD colspan=2 class="tr2 td3"><P class="p8 ft5"><?php echo $npwp;  ?></P></TD>
				</TR>
				<TR>
					<TD class="tr2 td0"><P class="p6 ft2">4.</P></TD>
					<TD class="tr2 td1"><P class="p7 ft2">NOPD</P></TD>
					<TD class="tr2 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr2 td3"><P class="p8 ft5"><?php echo $nopd;  ?></P></TD>
				</TR>
				<TR>
					<TD class="tr2 td0"><P class="p6 ft2">5.</P></TD>
					<TD class="tr2 td1"><P class="p7 ft2">Jenis Pajak</P></TD>
					<TD class="tr2 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr2 td3"><P class="p8 ft5">………………………………………………………………………..</P></TD>
				</TR>
				<TR>
					<TD class="tr2 td0"><P class="p6 ft2">6.</P></TD>
					<TD class="tr2 td1"><P class="p7 ft2">Nama Objek Pajak</P></TD>
					<TD class="tr2 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr2 td3"><P class="p8 ft5"><?php echo $branch_name;  ?></P></TD>
				</TR>
				<TR>
					<TD class="tr2 td0"><P class="p6 ft2">7.</P></TD>
					<TD class="tr2 td1"><P class="p7 ft2">Alamat Objek Pajak</P></TD>
					<TD class="tr2 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr2 td3"><P class="p8 ft5"><?php echo $alamat;  ?></P></TD>
				</TR>
				<TR>
					<TD class="tr0 td0"><P class="p6 ft2">8.</P></TD>
					<TD class="tr0 td1"><P class="p7 ft2">Masa Pajak</P></TD>
					<TD class="tr0 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr0 td3"><P class="p8 ft5"></P><?php echo $month ?></TD>
				</TR>
				<TR>
					<TD class="tr2 td0"><P class="p6 ft2">9.</P></TD>
					<TD class="tr2 td1"><P class="p7 ft2">Tahun Pajak</P></TD>
					<TD class="tr2 td2"><P class="p6 ft2">:</P></TD>
					<TD colspan=2 class="tr2 td3"><P class="p8 ft5"><?php echo $year;  ?></P></TD>
				</TR>
				</TABLE>
				<TABLE class="t1">
				<TR>
					<TD colspan=8 class="tr3 td6"><P class="p9 ft2">10. Setoran ( beri tanda <SPAN class="ft7"> </SPAN>pada salah satu kotak dibawah ini )</P></TD>
					<TD class="tr3 td1"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr4 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td8 td-bord"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr4 td9"><P class="p10 ft2">Masa</P></TD>
					<TD colspan=3 class="tr4 td10"><P class="p9 ft2">: Bulan : …………………………..</P></TD>
					<TD class="tr4 td1"><P class="p9 ft2">Tahun : ……………</P></TD>
				</TR>

				<TR>
					<TD class="tr4 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td8 td-bord"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr4 td9"><P class="p10 ft2">SKPD</P></TD>
					<TD colspan=3 class="tr4 td10"><P class="p9 ft2">: No………………………………………</P></TD>
				</TR>

				<TR>
					<TD class="tr4 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td8 td-bord"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr4 td9"><P class="p10 ft2">SKPDKB</P></TD>
					<TD colspan=3 class="tr4 td10"><P class="p9 ft2">: No………………………………………</P></TD>
				</TR>
				<TR>
					<TD class="tr4 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td8 td-bord"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr4 td9"><P class="p10 ft2">SKPKBT</P></TD>
					<TD colspan=3 class="tr4 td10"><P class="p9 ft2">: No………………………………………</P></TD>
				</TR>
				<TR>
					<TD class="tr4 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td8 td-bord"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr4 td9"><P class="p10 ft2">STPD</P></TD>
					<TD colspan=3 class="tr4 td10"><P class="p9 ft2">: No………………………………………</P></TD>
				</TR>
				<TR>
					<TD class="tr4 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td8 td-bord"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr4 td9"><P class="p10 ft2">…………………………</P></TD>
					<TD colspan=3 class="tr4 td10"><P class="p9 ft2">: No………………………………………</P></TD>
				</TR>
				<TR>
					<TD colspan=5 class="tr3 td13"><P class="p9 ft2">11. Besar Setoran :</P></TD>
					<TD class="tr3 td11"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td14"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td15"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td1"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr6 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td8"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td16"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr9 td17"><P class="p7 ft2">No.</P></TD>
					<TD class="tr9 td18"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr9 td19"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr9 td20"><P class="p9 ft0">U R A I A N</P></TD>
					<TD class="tr9 td21"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr9 td22"><P class="p14 ft2">BESAR SETORAN</P></TD>
				</TR>
				<TR>
					<TD class="tr10 td7"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td8"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td16"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr11 td23"><P class="p9 ft9">&nbsp;</P></TD>
					<TD class="tr11 td24"><P class="p9 ft9">&nbsp;</P></TD>
					<TD class="tr11 td25"><P class="p9 ft9">&nbsp;</P></TD>
					<TD class="tr11 td26"><P class="p9 ft9">&nbsp;</P></TD>
					<TD class="tr11 td27"><P class="p9 ft9">&nbsp;</P></TD>
					<TD class="tr11 td28"><P class="p9 ft9">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr3 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td8"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td16"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td23"><P class="p9 ft6">&nbsp;</P>1</TD>
					<TD colspan =2 class="tr6 td24"><P class="p9 ft6">&nbsp;</P>POKOK PAJAK</TD>
					<TD class="tr6 td26"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td27"><P class="p15 ft2 num-font">Rp <?php echo number_format($tax) ?></P></TD>
					<TD class="tr6 td28"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr8 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr8 td8"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr8 td16"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td23"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td24"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td25"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td26"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td27"><P class="p15 ft2">Rp</P></TD>
					<TD class="tr3 td28"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr3 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td8"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td16"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td23"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td24"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td25"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td26"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td27"><P class="p15 ft2">Rp</P></TD>
					<TD class="tr6 td28"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr6 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td8"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td16"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td29"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td30"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td11"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td31"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr6 td15"><P class="p15 ft2">Rp</P></TD>
					<TD class="tr6 td32"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr12 td7"><P class="p9 ft10">&nbsp;</P></TD>
					<TD class="tr12 td8"><P class="p9 ft10">&nbsp;</P></TD>
					<TD class="tr12 td16"><P class="p9 ft10">&nbsp;</P></TD>
					<TD class="tr13 td23"><P class="p9 ft11">&nbsp;</P></TD>
					<TD colspan=2 class="tr13 td33"><P class="p9 ft11">&nbsp;</P></TD>
					<TD class="tr13 td26"><P class="p9 ft11">&nbsp;</P></TD>
					<TD class="tr13 td27"><P class="p9 ft11">&nbsp;</P></TD>
					<TD class="tr13 td28"><P class="p9 ft11">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr8 td7"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr8 td8"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr8 td34"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr8 td35"><P class="p15 ft0">Jumlah Setoran</P></TD>
					<TD class="tr8 td31"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr8 td15"><P class="p15 ft2">Rp</P></TD>
					<TD class="tr8 td32"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr10 td7"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td8"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td34"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td36"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td30"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td11"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr10 td31"><P class="p9 ft8">&nbsp;</P></TD>
					<TD class="tr11 td27"><P class="p9 ft9">&nbsp;</P></TD>
					<TD class="tr11 td28"><P class="p9 ft9">&nbsp;</P></TD>
				</TR>
				</TABLE>
				<P class="p16 ft2 num-font"><SPAN class="ft12">Terbilang </SPAN>: <?php echo $terbilang ?></P>
				<P class="p17 ft2">……………………………………………………………………………………….</P>
				<TABLE class="">
				<TR>
					<TD class="tr4 td37"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td38"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr4 td39"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=2 class="tr4 td40"><P class="p15 ft2">Jakarta, ………………………….</P></TD>
				</TR>
				<TR>
					<TD colspan=2 class="tr1 td41"><P class="p18 ft2">Ruang untuk teraan mesin</P></TD>
					<TD class="tr1 td42"><P class="p19 ft2">Diterima oleh :</P></TD>
					<TD class="tr1 td43"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td44"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD colspan=2 class="tr1 td41"><P class="p18 ft5">Kas Register</P></TD>
					<TD class="tr1 td42"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td43"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td44"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr14 td45"><P class="p9 ft13">&nbsp;</P></TD>
					<TD class="tr14 td46"><P class="p9 ft13">&nbsp;</P></TD>
					<TD class="tr14 td42"><P class="p15 ft14">Petugas :</P></TD>
					<TD colspan=2 class="tr14 td47"><P class="p20 ft14">Penyetor,</P></TD>
				</TR>
				<TR>
					<TD class="tr1 td45"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td46"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td42"><P class="p15 ft2">Tanggal :</P></TD>
					<TD class="tr1 td43"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td44"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD colspan=2 class="tr8 td41"><P class="p21 ft2">Cap</P></TD>
					<TD class="tr8 td42"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr8 td43"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr8 td44"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr3 td45"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td46"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td42"><P class="p15 ft2">Tanda tangan :</P></TD>
					<TD class="tr3 td43"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr3 td44"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr1 td45"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td46"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td42"><P class="p15 ft2">Nama jelas :</P></TD>
					<TD colspan=2 class="tr1 td47"><P class="p22 ft5">(…………………………. )</P></TD>
				</TR>
				<TR>
					<TD class="tr1 td48"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td49"><P class="p9 ft6">&nbsp;</P></TD>
					<TD class="tr1 td50"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=2 class="tr1 td51"><P class="p23 ft2">Nama/Cap/Stempel</P></TD>
				</TR>
				<TR>
					
					<TD colspan=3 class="tr0 td52"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr2 td53"><P class="p9 ft6">&nbsp;</P></TD>
					<TD colspan=3 class="tr0 td54"><P class="p24 ft15">PEMBAYARAN SAH, BILA ADA TERAAN MESIN KAS REGISTER</P></TD>
					<TD class="tr2 td55"><P class="p9 ft6">&nbsp;</P></TD>
				</TR>
				<TR>
					<TD class="tr15 td53"><P class="p9 ft16">&nbsp;</P></TD>
					<TD class="tr16 td56"><P class="p9 ft17">&nbsp;</P></TD>
					<TD class="tr16 td57"><P class="p9 ft17">&nbsp;</P></TD>
					<TD class="tr16 td58"><P class="p9 ft17">&nbsp;</P></TD>
					<TD class="tr15 td55"><P class="p9 ft16">&nbsp;</P></TD>
				</TR>
			</TABLE>
			<table>
				<tr>
					<td>Lembar 1 Wajib Pajak</td>
				</tr>
				<tr>
					<td></td>
					<td>2 Badan Pajak dan Retribusi Daera</td>
				</tr>
				<tr>
					<td></td>
					<td>3 BPKD</td>
				</tr>
				<tr>
					<td></td>
					<td>4 BANK</td>
				</tr>
			</table>
			
		</DIV>
	</BODY>
</div>