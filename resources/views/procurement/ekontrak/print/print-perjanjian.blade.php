<html>

<head>
	<title></title>
</head>
<style type="text/css">
	.page-break {
		page-break-after: always;
	}
</style>
<body>
	<div style="word-break:break-all;word-wrap:break-word;">
		<div style=" position:absoulte;">
			<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
				<tbody>
					<br>
					<tr>
						<td style="text-align:center; font-size : 14px;">
							<table border="0" style="width:75%;" align="center">
								<tbody>
									<tr>
										<th rowspan="5"><img src="https://lh3.googleusercontent.com/wAGw4WDCvy7du-MD9JqUOrDUIVtH0L8yK-0WV88RWN5n6kfv1zUmKHbWqeRt64Xva1ywxa8xNQhUqXaSEXNfkGoUJac2YVOHqgVnz7xATvYc98tEe3jGpf-buw98UGzM6nL3Xto" style="width: 60px;height: 60px;"></th>
									</tr>
									<tr>
										<td style="text-align: center;"><strong style="font-size: 10.5pt;">KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</strong></td>
									</tr>
									<tr>
										<td style="text-align: center;"><strong style="font-size: 10.5pt;text-transform: uppercase;">UNIVERSITAS NEGERI SURABAYA</strong></td>
									</tr>
									<tr>
										<td style="text-align: center; font-size: 10.5pt;">alamat</td>
									</tr>
									<tr>
										<td style="text-align: center;"><span style="font-size: 9pt">email</span></td>
									</tr>
									<div></div><div></div>
								</tbody>
							</table>
							<hr style="border: 1px solid;">
						</td>
					</tr>
				</table>
				<p style="text-align: center;"><strong>SURAT PERINTAH PENGIRIMAN (SPP)</strong></p>
				<p>&nbsp;</p>
				<p>Nomor : {{ $paket->no_sppbj }}</p>
				<p>Lamp : -</p>
				<p>Kepada</p>
				<p>Yth. Direktur {{$paket->namacv}}</p>
				<p>d/a {{$paket->alamat}}</p>
				<p>Perihal : Penunjukan Penyedia Barang/Jasa untuk ({{$paket->namapaket}})</p>
				<p>&nbsp;</p>
				<p>Dengan ini kami beritahukan bahwa penawaran Saudara, Nomor : {{ $paket->no_sppbj }}, tentang Penawaran Biaya Rp.{{number_format($paket->harga,0,',','.')}} ({{$paket->namapaket}}), dengan nilai penawaran setelah dilakukan klarifikasi/negoisasi teknis dan biaya sebesar Rp.{{number_format($paket->harga,0,',','.')}} ,- {{$harga}} termasuk PPN, dan telah ditetapkan sebagai penyedia jasa oleh Pejabat Pengadaan Pascasarjana Unesa.</p>
				<p>Selanjutnya kamu menunjuk Saudara untuk melaksankan ({{$paket->namapaket}}), dan meminta Saudara untuk membuat surat pernyaaan kesanggupan dan menandatangani surat perjanjian setelah dikeluarkannya SPPBJ ini.</p>
				<p>Kegagalan Saudara untuk menerima penunjukan ini, yang disusun berdasarkan evaluasi terhadap penawaran Saudara, akan dikenakan sanksi sesuai dengan ketentuan yang tercantum dalam Dokumen Pengadaan.</p>
				<br>
				<p style="text-align: right;">Surabaya, {{date('j F Y',strtotime($paket->tanggal))}}</p>
				<p style="text-align: right;">Pascasarjana Universitas Negeri Surabaya</p>
				<p style="text-align: right;">Pejabat Pembuat Komitmen,</p>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>