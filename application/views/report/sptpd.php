<?php $month = ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember']; ?>
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
				<img src="<?php echo base_url('assets/images');?>/blackwhitejayaraya.png" style="width: 9%;display: block;">
			</DIV>

			<DIV id="id1_1">
			
				<P class="p0 ft0">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</P>

				<P class="p1 ft1">BADAN PENDAPATAN DAERAH</P>
				<P class="p2 ft2">JALAN ABDUL MUIS NO. 66 Telp. 3865580 – 85 Fax. 3865788</P>
				<P class="p3 ft2">JAKARTA 10160</P>
				<div class="bord">
					<TABLE> 
						<TR>
							<TD colspan=4 class="tr0 td0"><P class="p4 ft3">SURAT PEMBERITAHUAN PAJAK DAERAH</P></TD>
							<TD class="tr0 td1"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr0 td2"><P class="p5 ft4">&nbsp;</P></TD>
							<TD rowspan=2 class="tr1 td3"><P class="p6 ft2">Kepada</P></TD>
						</TR>
						<TR>
							<TD colspan=4 rowspan=2 class="tr2 td0"><P class="p7 ft3">( SPTPD )</P></TD>
							
						</TR>
						<TR>
							<TD class="tr4 td1"><P class="p5 ft6">&nbsp;</P></TD>
							<TD rowspan=2 class="tr5 td2"><P class="p5 ft2">Yth</P></TD>
							<TD rowspan=2 class="tr5 td3"><P class="p5 ft2">UPPRD</P></TD>
						</TR>
						<TR>
							<TD colspan=4 rowspan=2 class="tr6 td0"><P class="p8 ft3">PAJAK RESTORAN</P></TD>
							<TD class="tr7 td1"><P class="p5 ft7">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD class="tr8 td1"><P class="p5 ft8">&nbsp;</P></TD>
							<TD class="tr8 td2"><P class="p5 ft8">&nbsp;</P></TD>
							<TD rowspan=2 class="tr5 td3"><P class="p5 ft2"><?php echo $fetch['kecamatan_name'] ?></P></TD>
						</TR>
						<TR>
							<TD rowspan=2 class="tr9 td4"><P class="p9 ft2">Masa Pajak</P></TD>
							<TD colspan=3 rowspan=2 class="tr9 td5"><P class="p10 ft2">: <?php echo $fetch['month'];  ?> </P></TD>
							<TD class="tr10 td1"><P class="p5 ft9">&nbsp;</P></TD>
							<TD class="tr10 td2"><P class="p5 ft9">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD class="tr11 td1"><P class="p5 ft10">&nbsp;</P></TD>
							<TD class="tr11 td2"><P class="p5 ft10">&nbsp;</P></TD>
							<TD rowspan=2 class="tr12 td3"><P class="p5 ft2">di</P></TD>
						</TR>
						<TR>
							<TD class="tr13 td4"><P class="p9 ft2">Tahun Pajak</P></TD>
							<TD colspan=3 class="tr13 td5"><P class="p5 ft2">: <?php echo $fetch['year'];  ?></P></TD>
							<TD class="tr13 td1"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr13 td2"><P class="p5 ft4">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD colspan=2 rowspan=2 class="tr14 td6"><P class="p9 ft2">Pembetulan ke</P></TD>
							<TD class="tr15 td7"><P class="p5 ft11">&nbsp;</P></TD>
							<TD class="tr16 td8"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td1"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td2"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td3"><P class="p6 ft13">Jakarta</P></TD>
						</TR>
						<TR>
							<TD class="tr17 td9"><P class="p5 ft14">&nbsp;</P></TD>
							<TD class="tr18 td8"><P class="p5 ft15">&nbsp;</P></TD>
							<TD class="tr18 td1"><P class="p5 ft15">&nbsp;</P></TD>
							<TD class="tr18 td2"><P class="p5 ft15">&nbsp;</P></TD>
							<TD class="tr18 td3"><P class="p5 ft15">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD class="tr17 td10"><P class="p5 ft14">&nbsp;</P></TD>
							<TD class="tr17 td11"><P class="p5 ft14">&nbsp;</P></TD>
							<TD class="tr17 td12"><P class="p5 ft14">&nbsp;</P></TD>
							<TD class="tr17 td13"><P class="p5 ft14">&nbsp;</P></TD>
							<TD class="tr17 td14"><P class="p5 ft14">&nbsp;</P></TD>
							<TD class="tr17 td15"><P class="p5 ft14">&nbsp;</P></TD>
							<TD class="tr17 td16"><P class="p5 ft14">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD class="tr19 td4"><P class="p11 ft16">Perhatian :</P></TD>
							<TD class="tr19 td17"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr19 td18"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr19 td19"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr19 td1"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr19 td2"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr19 td3"><P class="p5 ft4">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD colspan=2 class="tr20 td20"><P class="p5 ft17">&nbsp;</P></TD>
							<TD class="tr20 td12"><P class="p5 ft17">&nbsp;</P></TD>
							<TD colspan=2 class="tr20 td21"><P class="p5 ft17">&nbsp;</P></TD>
							<TD class="tr20 td15"><P class="p5 ft17">&nbsp;</P></TD>
							<TD class="tr20 td16"><P class="p5 ft17">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD colspan=5 class="tr2 td22"><P class="p11 ft18">1. Harap diisi dalam rangkap 2 dan ditulis dengan huruf CETAK.</P></TD>
							<TD class="tr2 td2"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr2 td3"><P class="p5 ft4">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD class="tr16 td4"><P class="p11 ft18">2. Beri nomor pada kotak</P></TD>
							<TD class="tr16 td17"><P class="p5 ft12">&nbsp;</P></TD>
							<TD colspan=5 class="tr16 td23"><P class="p12 ft18">yang tersedia untuk jawaban yang diberikan.</P></TD>
						</TR>
						</TABLE>
						<P class="p13 ft19"><SPAN class="ft19">3. Setelah diisi dan ditandatangani, harap diserahkan kembali kepada Unit Pajak dan Retribusi Daerah dimana Wajib Pajak terdaftar, paling lambat tanggal 20 bulan berikutnya.</SPAN>
						<P class="p14 ft18"><SPAN class="ft18">4. Keterlambatan Penyerahan SPTPD, dikenakan sanksi sesuai ketentuan yang berlaku.</SPAN></P>
						<P class="p15 ft16">I. Identitas Wajib Pajak :</P>
						<TABLE cellpadding=0 cellspacing=0 class="t1">
						<TR>
							<TD class="tr19 td2"><P class="p16 ft2">a.</P></TD>
							<TD class="tr19 td24"><P class="p5 ft2">Nama Wajib Pajak</P></TD>
							<TD class="tr19 td25"><P class="p17 ft2">:</P></TD>
							<TD colspan=6 class="tr19 td26"><P class="p18 ft2"><?php echo $fetch[0]['merchant_name'] ?></P></TD>
						</TR>
						<TR>
							<TD class="tr16 td2"><P class="p16 ft13">b.</P></TD>
							<TD class="tr16 td24"><P class="p5 ft13">Alamat</P></TD>
							<TD class="tr16 td25"><P class="p17 ft13">:</P></TD>
							<TD colspan=6 class="tr16 td26"><P class="p18 ft13"><?php echo (empty($fetch['merchant']->owner_location) ? '………………………' : $fetch['merchant']->owner_location) ?></P></TD>
						</TR>
						<TR>
							<TD class="tr21 td2"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr21 td24"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr21 td25"><P class="p5 ft4">&nbsp;</P></TD>
							<TD colspan=5 class="tr21 td27"><P class="p18 ft2">RT <?php echo(empty($fetch['merchant']->rt) ? '………' : $fetch['merchant']->rt) ?> RW <?php echo(empty($fetch['merchant']->rw) ? '………' : $fetch['merchant']->rw) ?></P></TD>
							<TD class="tr21 td28"><P class="p19 ft2">Kode Pos <?php echo(empty($fetch['merchant']->pos_code) ? '………' : $fetch['merchant']->pos_code) ?></P></TD>
						</TR>
						<TR>
							<TD colspan=2 class="tr21 td29"><P class="p16 ft2">c. NPWPD</P></TD>
							<TD class="tr21 td25"><P class="p17 ft2">:</P></TD>
							<TD colspan=6 class="tr21 td26"><P class="p18 ft2"><?php echo $fetch['npwp'] ?></P></TD>
						</TR>
						<TR>
							<TD class="tr21 td2"><P class="p16 ft2">d.</P></TD>
							<TD class="tr21 td24"><P class="p5 ft2">NOPD</P></TD>
							<TD class="tr21 td25"><P class="p17 ft2">:</P></TD>
							<TD colspan=6 class="tr21 td26"><P class="p18 ft2"><?php echo $fetch['nopd'] ?></P></TD>
						</TR>
						<TR>
							<TD class="tr21 td2"><P class="p16 ft2">e.</P></TD>
							<TD class="tr21 td24"><P class="p5 ft2">Nama Objek/Usaha</P></TD>
							<TD class="tr21 td25"><P class="p17 ft2">:</P></TD>
							<TD colspan=6 class="tr21 td26"><P class="p18 ft2"><?php echo $fetch[0]['branch_name'] ?></P></TD>
						</TR>
						<TR>
							<TD class="tr21 td2"><P class="p16 ft2">f.</P></TD>
							<TD class="tr21 td24"><P class="p5 ft2">Alamat</P></TD>
							<TD class="tr21 td25"><P class="p20 ft2">:</P></TD>
							<TD colspan=6 class="tr21 td26"><P class="p18 ft2"><?php echo $fetch['alamat'] ?></P></TD>
						</TR>
						<TR>
							<TD colspan=4 class="tr11 td30"><P class="p5 ft10">&nbsp;</P></TD>
							<TD class="tr11 td31"><P class="p5 ft10">&nbsp;</P></TD>
							<TD class="tr11 td32"><P class="p5 ft10">&nbsp;</P></TD>
							<TD class="tr11 td33"><P class="p5 ft10">&nbsp;</P></TD>
							<TD class="tr11 td34"><P class="p5 ft10">&nbsp;</P></TD>
							<TD class="tr11 td35"><P class="p5 ft10">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD colspan=9 class=""><P class="p11 ft16">II. Diisi Oleh Pengusaha Restoran :</P></TD>
							
						</TR>
						<TR>
							<TD class="tr22 td15"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td38"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td39"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td32"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td31"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td32"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td33"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td34"><P class="p5 ft22">&nbsp;</P></TD>
							<TD class="tr22 td35"><P class="p5 ft22">&nbsp;</P></TD>
						</TR>
						<TR>
							<TD rowspan=2 class="tr23 td2"><P class="p16 ft2">a.</P></TD>
							<TD rowspan=2 class="tr23 td24"><P class="p5 ft2">Klasifikasi Usaha</P></TD>
							<TD rowspan=2 class="tr23 td25"><P class="p17 ft2">:</P></TD>
							<TD colspan=2 class="tr24 td40"><P class="p5 ft23">&nbsp;</P></TD>
							<TD colspan=2 class="tr24 td41"><P class="p5 ft23">&nbsp;</P></TD>
							<TD rowspan=2 class="tr23 td37"><P class="p21 ft2">Restoran.</P></TD>
							<TD rowspan=2 class="tr23 td28"><P class="p22 ft18">4. Cepat Saji/<SPAN class="ft18">Fast Food.</SPAN></P></TD>
						</TR>
						<TR>
							<TD class="tr14 td42"><P class="p5 ft4">&nbsp;</P></TD>
							
							<TD class="tr2 td44"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr14 td40"><P class="p23 ft2">1.</P></TD>
						</TR>
						<TR>
							<TD class="tr21 td2"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr21 td24"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr21 td25"><P class="p5 ft4">&nbsp;</P></TD>
							<TD colspan=4 class="tr21 td46"><P class="p22 ft2">2.</P></TD>
							<TD class="tr21 td37"><P class="p5 ft2">Kafe.</P></TD>
							<TD class="tr21 td28"><P class="p22 ft18">5. Jasa Boga/Katering</P></TD>
						</TR>
						<TR>
							<TD class="tr13 td15"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr13 td38"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr13 td39"><P class="p5 ft4">&nbsp;</P></TD>
							<TD colspan=4 class="tr13 td47"><P class="p22 ft2">3.</P></TD>
							<TD colspan=2 class="tr13 td48"><P class="p5 ft2">Kantin/Kafetaria/Warung Makan. 6. ..........................</P></TD>
						</TR>
						<TR>
							<TD colspan=8 class="tr16 td49"><P class="p16 ft13">b. Pendapatan dari Makanan Dan Minuman</P></TD>
							<TD class="tr16 td35"><P class="p24 ft13">Rp <?php echo number_format($fetch[0]['total_amount']) ?></P></TD>
						</TR>
						<TR>
							<TD class="tr21 td15"><P class="p16 ft2">c.</P></TD>
							<TD colspan=6 class="tr21 td50"><P class="p5 ft2">Pendapatan dari Service Charge</P></TD>
							<TD class="tr21 td51"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr21 td35"><P class="p24 ft2">Rp <?php echo number_format($fetch[0]['service_charge']) ?></P></TD>
						</TR>
						<TR>
							<TD class="tr16 td15"><P class="p16 ft13">d.</P></TD>
							<TD class="tr16 td38"><P class="p5 ft13">Pendapatan <NOBR>Lain-lain</NOBR></P></TD>
							<TD class="tr16 td39"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td32"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td31"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td32"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td33"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td51"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td35"><P class="p24 ft13">Rp</P></TD>
						</TR>
						<TR>
							<TD class="tr21 td15"><P class="p16 ft2">e.</P></TD>
							<TD colspan=6 class="tr21 td50"><P class="p5 ft2">Dasar Pengenaan Pajak ( DPP )</P></TD>
							<TD class="tr21 td51"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr21 td35"><P class="p24 ft2">Rp <?php echo number_format($fetch[0]['dpp']) ?></P></TD>
						</TR>
						<TR>
							<TD class="tr16 td15"><P class="p16 ft13">f.</P></TD>
							<TD class="tr16 td38"><P class="p5 ft13">Pajak Terutang</P></TD>
							<TD class="tr16 td39"><P class="p5 ft12">&nbsp;</P></TD>
							<TD colspan=5 class="tr16 td52"><P class="p25 ft13">( 10 % X DPP )</P></TD>
							<TD class="tr16 td35"><P class="p24 ft13">Rp <?php echo number_format($fetch[0]['tax']) ?></P></TD>
						</TR>
						<TR>
							<TD class="tr21 td15"><P class="p16 ft2">g.</P></TD>
							<TD colspan=6 class="tr21 td50"><P class="p5 ft2">Pajak Yang Telah Dibayar.</P></TD>
							<TD class="tr21 td51"><P class="p5 ft4">&nbsp;</P></TD>
							<TD class="tr21 td35"><P class="p24 ft2">Rp</P></TD>
						</TR>
						<TR>
							<TD class="tr16 td15"><P class="p16 ft13">h.</P></TD>
							<TD colspan=6 class="tr16 td50"><P class="p5 ft13">Pajak Kurang Atau Lebih Bayar.</P></TD>
							<TD class="tr16 td51"><P class="p5 ft12">&nbsp;</P></TD>
							<TD class="tr16 td35"><P class="p24 ft13">Rp</P></TD>
						</TR>
						</TABLE>
						<P class="p26 ft2">i. Pajak Restoran kurang dibayar dilunasi tanggal <NOBR>____-______-______</NOBR> <NOBR>(dd-mm-yy)</NOBR></P>
						<TABLE cellpadding=0 cellspacing=0 class="t2">
						<TR>
							<TD class="tr19 td53"><P class="p11 ft16">III. Data Pendukung :</P></TD>
							<TD class="tr19 td54"><P class="p27 ft2">Lampiran *)</P></TD>
						</TR>
						<TR>

						</TR>
						<TR>
							<TD class="tr16 td55"><P class="p28 ft13">a). Surat Setoran Pajak Daerah ( SSPD )</P></TD>
							<TD class="tr16 td28"><P class="p8 ft13">Ada/Tidak ada</P></TD>
						</TR>
						<TR>
							<TD class="tr21 td55"><P class="p28 ft2">b). Rekapitulasi Penjualan/Omzet.</P></TD>
							<TD class="tr21 td28"><P class="p8 ft2">Ada/Tidak ada</P></TD>
						</TR>
						<TR>
							<TD class="tr21 td55"><P class="p28 ft2">c). Rekapitulasi Penggunaan Bon/Bill</P></TD>
							<TD class="tr21 td28"><P class="p8 ft2">Ada/Tidak ada</P></TD>
						</TR>
						<TR>
							<TD class="tr21 td49"><P class="p28 ft2">d). …………………………………………</P></TD>
							<TD class="tr21 td35"><P class="p8 ft2">Ada/Tidak ada</P></TD>
						</TR>
						</TABLE>
						<P class="p29 ft13">Demikian formulir ini diisi dengan <NOBR>sebenar-benarnya</NOBR> dan apabila terdapat ketidak benaran dalam memenuhi kewajiban pengisian SPTPD ini, saya bersedia dikenakan sanksi sesuai dengan Peraturan Daerah yang berlaku.</P>
						<TABLE cellpadding=0 cellspacing=0 class="t3">
						<TR>

							<TD class="tr19 td57"><P class="p30 ft2">Jakarta, ………………………</P></TD>
						</TR>
						<TR>
							<TD class="tr14 td56"><P class="p31 ft2">Diterima oleh Petugas,</P></TD>
							<TD class="tr14 td57"><P class="p32 ft2">WP/Penanggung Pajak/Kuasa,</P></TD>
						</TR>
						<TR>
							<TD class="tr21 td56"><P class="p31 ft2">tanggal ……………..</P></TD>

						</TR>
						<TR>
							<TD class="tr25 td56"><P class="p31 ft2">………………………….</P></TD>
							<TD class="tr25 td57"><P class="p33 ft25">…………………………….</P></TD>
						</TR>
						<TR>
							<TD class="tr21 td56"><P class="p31 ft2">NIP ….…………………</P></TD>
							<TD class="tr21 td57"><P class="p34 ft2">Nama jelas/Cap/Stempel</P></TD>
						</TR>
						<TR>

						</TR>
					</TABLE>
				</div>
				
			</DIV>
		</DIV>
	</BODY>
</div>