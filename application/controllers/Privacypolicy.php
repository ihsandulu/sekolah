<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Privacypolicy extends CI_Controller
{


	public function index()
	{
?>
		<!DOCTYPE html>
		<html lang="id">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Kebijakan Privasi - Qithy School</title>
			<style>
				body {
					font-family: Arial, sans-serif;
					max-width: 900px;
					margin: 40px auto;
					padding: 20px;
					line-height: 1.8;
					color: #333;
				}

				h1 {
					text-align: center;
					color: #1565c0;
				}

				h2 {
					color: #1565c0;
					margin-top: 30px;
				}

				.footer {
					margin-top: 40px;
					padding-top: 20px;
					border-top: 1px solid #ddd;
					font-size: 14px;
					color: #666;
				}
			</style>
		</head>

		<body>

			<h1>Kebijakan Privasi Qithy School</h1>

			<p><strong>Tanggal Berlaku:</strong> 04 Juni 2026</p>

			<p>
				Qithy School adalah sistem informasi sekolah yang digunakan untuk membantu pengelolaan kegiatan akademik dan administrasi sekolah, termasuk absensi siswa dan guru, pengelolaan nilai, pencatatan tabungan siswa, pencetakan raport, serta penyampaian informasi kepada wali murid melalui aplikasi Android.
			</p>

			<p>
				Dengan menggunakan Qithy School, pengguna menyetujui pengumpulan dan penggunaan informasi sesuai dengan Kebijakan Privasi ini.
			</p>

			<h2>1. Informasi yang Dikumpulkan</h2>

			<ul>
				<li>Nama siswa, guru, wali murid, dan staf sekolah.</li>
				<li>Data kelas dan informasi akademik.</li>
				<li>Data kehadiran siswa dan guru.</li>
				<li>Data nilai tugas, ujian, dan hasil belajar.</li>
				<li>Data tabungan siswa yang dicatat oleh sekolah.</li>
				<li>Data raport dan riwayat pendidikan.</li>
				<li>Nomor telepon dan alamat email yang diberikan oleh sekolah atau pengguna.</li>
				<li>Token notifikasi perangkat Android.</li>
				<li>Informasi teknis perangkat yang diperlukan untuk operasional aplikasi.</li>
			</ul>

			<h2>2. Penggunaan Informasi</h2>

			<ul>
				<li>Mengelola kegiatan akademik dan administrasi sekolah.</li>
				<li>Mencatat absensi siswa dan guru.</li>
				<li>Mengelola nilai ujian dan raport.</li>
				<li>Mengelola tabungan siswa.</li>
				<li>Mengirim notifikasi kepada wali murid.</li>
				<li>Meningkatkan keamanan dan kualitas layanan.</li>
			</ul>

			<h2>3. Notifikasi</h2>

			<p>
				Qithy School dapat mengirimkan notifikasi kepada pengguna melalui aplikasi Android, termasuk informasi kehadiran, nilai, pengumuman sekolah, informasi tabungan siswa, dan informasi penting lainnya.
			</p>

			<h2>4. Penyimpanan dan Keamanan Data</h2>

			<p>
				Kami berupaya melindungi data pengguna dengan menerapkan langkah-langkah keamanan yang wajar, termasuk pengelolaan hak akses, autentikasi pengguna, dan perlindungan sistem server.
			</p>

			<h2>5. Pembagian Data</h2>

			<p>
				Qithy School tidak menjual atau memperdagangkan data pribadi pengguna kepada pihak lain. Data hanya digunakan untuk kepentingan operasional sekolah dan dapat diakses oleh pihak yang berwenang.
			</p>

			<h2>6. Hak Pengguna</h2>

			<ul>
				<li>Meminta perbaikan data yang tidak akurat.</li>
				<li>Memperbarui informasi akun.</li>
				<li>Menghubungi pihak sekolah terkait pengelolaan data pribadi.</li>
			</ul>

			<h2>7. Layanan Pihak Ketiga</h2>

			<p>
				Qithy School dapat menggunakan layanan pihak ketiga yang mendukung operasional aplikasi, seperti layanan hosting, penyimpanan data, dan pengiriman notifikasi.
			</p>

			<h2>8. Perubahan Kebijakan Privasi</h2>

			<p>
				Kebijakan Privasi ini dapat diperbarui sewaktu-waktu. Perubahan akan berlaku setelah dipublikasikan pada halaman ini.
			</p>

			<h2>9. Kontak</h2>

			<p>
				Apabila terdapat pertanyaan mengenai Kebijakan Privasi ini, pengguna dapat menghubungi administrator sekolah atau pengelola sistem Qithy School.
			</p>

			<div class="footer">
				<strong>Qithy School</strong><br>
				Sistem Informasi Akademik dan Administrasi Sekolah
			</div>

		</body>

		</html>
<?php

	}
}
