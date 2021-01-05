<html>
<head>
	<title>
	</title>

</head>
<style>
	.page-break {
		page-break-after: always;
	}
</style>
<body>
	<div style="word-break:break-all;word-wrap:break-word;">
		<div style=" position:absoulte;">
			<table border="1" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td>
							<p>
								<span>FT &ndash; </span>
								<strong>UNIVERSITAS NEGERI SURABAYA</strong>
							</p>
						</td>
						<td>
							<p>
								<strong>BERITA ACARA PEMERIKSAAN PEKERJAAN&nbsp;</strong>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p>
								<span>Pekerjaan</span> <span>:</span> <span>{{ $paket->nama}}</span>
							</p>
							<p>
								<span>Lokasi</span> <span>:</span> <span>{{ $paket->alamat}}</span>
							</p>
							<p>
								<span>TahunAnggaran </span> <span>:</span> <span>{{ date('Y') }}</span>
							</p>
						</td>
						<td>
							<p>
								<span>Nomor &nbsp; </span> <span>: &nbsp; </span>
								<span>{{ $paket->kode_rup }}</span>
							</p>
							<p>
								<span>Tanggal&nbsp; </span> <span>:</span> <span>{{ \tglindo($paket->created_at) }}</span>
							</p>
							<p>
								<span>Lampiran &nbsp; &nbsp; : &nbsp; Daftar Checklis Barang</span>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<span>Pada hari ini </span>
					<strong>{{ \hari_ini(date('D')) }}</strong>
				<span>, tanggal <strong>{{ (date('d')) }}</strong> bulan </span>
				<strong>{{ \bulan_ini(date('M')) }}</strong>
				<span>, tahun </span>
				<strong>{{ date('Y') }}</strong>
				<span>, kami yang bertanda tangan dibawah ini telah mengadakan Pemeriksaan Pekerjaan </span>
				<span>{{ $paket->nama}}</span>
				<span> di unit {{ $paket->satuankerja }}.</span>
			</p>
			<ol style="list-style-type: lower-alpha;">
				<li>
						<span>Nama </span> <span>:</span> <span>&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; (Tim Pengendali Kualitas / Tim Teknis)<br />
						</span>
					<span>
						<br/>NIP</span> <span>:</span><span>&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span>
					</li>
					<li>
						<span>Nama </span> <span>:</span> <span>&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; (Tim Pengendali Kualitas / Tim Teknis)<br />
							</span>
						<br/>NIP <span><span>:</span>&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&nbsp;</span>
					</li>
				</ol>
				<p>
					<span>Dengan ini menyatakan bahwa :</span>
				</p>
				<ol>
					<li>
						<span>
							<span>Telah mengadakan pemeriksaan dan penilaian pekerjaan Pengadaan Barang berupa&nbsp; :</span>
						</span>
						<table >
							<tbody>
								<tr>
									<td>
										<span>Pekerjaan&nbsp;</span>
									</td>
									<td >: &nbsp; {{ $paket->nama}}</td>
								</tr>
								<tr>
									<td>Lokasi</td>
									<td >: &nbsp; {{ $paket->alamat }}</td>
								</tr>
								<tr >
									<td>
										<span>Penyedia Jasa</span>
									</td>
									<td>:&nbsp;<strong>{{ $paket->pt }}</strong>
									</td>
								</tr>
								<tr>
									<td>
										<span>Surat Perintah Kerja (SPK)</span>
									</td>
									<td >:&nbsp;<strong>{{ $paket->spk_no }}</strong></td>
								</tr>
								<tr>
									<td>
										<span>Tanggal </span>
									</td>
									<td >:&nbsp;<strong>{{ $paket->spk_tanggal }}</strong></td>
								</tr>
								<tr>
									<td>
										<span>Nilai Kontrak</span>
									</td>
									<td >:&nbsp;<strong>{{ $paket->spk_nilai_kotrak }}</strong></td>
									
								</tr>
								<tr>
									<td>
										<span>Jangka Waktu Pelaksanaan</span>
									</td>
									<td >:&nbsp;<strong>{{ $paket->spk_wkt_penyelesaian }}</strong></td>
								</tr>
								<tr>
									<td>
										<span>Tanggal mulai</span>
									</td>
									<td >:&nbsp;<strong>{{ $paket->spk_tanggal_mulai_kerja }}</strong></td>
								</tr>
								<tr>
									<td>
										<span>Tanggal selesai</span>
									</td>
									<td >:&nbsp;<strong>{{ $paket->spk_wkt_penyelesaian }}</strong></td>
								</tr>
							</tbody>
						</table>
					</li>
					<li>
						<span>Berdasarkan pemeriksaan, menunjukkan bahwa prestasi pekerjaan&nbsp; yang telah dilakukan&nbsp; oleh {{ $paket->pt }}. untuk pekerjaan {{ $paket->nama}} telah mencapai 100%, sesuai dengan ceklist terlampir.</span>
					</li>
					<li>Berita acara ini dibuat sebagai persyaratan untuk mendapatkan pembayaran sebagaimana telah ditentukan dalam surat perjanjian pelaksanaan pekerjaan</li>
				</ol>
				<p>
					<span>Demikian berita acara pemeriksaan pekerjaan ini dibuat dalam rangkap secukupnya untuk digunakan sebagaimana mestinya.</span>
				</p>
				<p style="text-align: right;">
					<span>Tim Pengendali&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Kualitas <span>Penyedia Jasa,</span>
				</span>
			</p>
			<p style="text-align: right;">
				<span>
					<span>
						<br />
						<span>{{ $paket->satuankerja }}</span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>{{ $paket->pt }}</span>
					</span>
				</span>
			</p>
			<p style="text-align: center;">
				<span>
					<span>
						<span>Nama 1: ......&nbsp; &nbsp; &nbsp; <strong>(ttd)</strong>
						</span>
					</span>
				</span>
			</p>
			<p style="text-align: center;">&nbsp;</p>
			<p style="text-align: center;">
				<span>
					<span>
						<span>Nama 2: .......&nbsp; &nbsp; &nbsp;<strong>(ttd)</strong>
						</span>
					</span>
				</span>
			</p>
			<p style="text-align: center;">&nbsp;</p>
			<p style="text-align: center;">
				<span>
					<span>
						<span>
							<strong>.................. Direktur</strong>
						</span>
					</span>
				</span>
			</p>
			<div class="page-break"></div>
			<p style="text-align: center;">
				<span>LAMPIRAN BERITA ACARA PEMERIKSAAN</span>
			</p>
			<p style="text-align: center;">
				<span>DAFTAR CHECKLIST BARANG</span>
			</p>
			<p style="text-align: center;">
				<span>Nomor&nbsp; : {{ $paket->kode_rup }}</span>
			</p>
			<p style="text-align: center;">
				<span>Tanggal : {{ \tglindo($paket->created_at) }}</span>
			</p>
			<table align="center" border="1" style="width: 85%;" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>No</td>
						<td style="text-align: center;">
							<strong>Uraian Pekerjaan</strong>
						</td>
						<td style="text-align: center;">
							<strong>Volume</strong>
						</td>
						<td style="text-align: center;">Satuan</td>
						<td style="text-align: center;">checklist</td>
					</tr>
				</thead>
				<tbody>
					@foreach ($dt as $key => $rows)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $rows->pekerjaan }}</td>
							<td>{{ $rows->qty }}</td>
							<td>{{ $rows->satuan }}</td>
							@if ($rows->is_check == 1)
								<td>Ya</td>
							@else
								<td>Tidak</td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>