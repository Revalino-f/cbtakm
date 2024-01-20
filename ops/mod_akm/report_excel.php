<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
require("../../config/dis.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
echo "<style> .str{ mso-number-format:\@; } </style>";
$id_ujian = $_GET['m'];
$pengawas = fetch($koneksi, 'pengawas', array('id_pengawas' => $id_pengawas));
$mapel = fetch($koneksi, 'mapel', array('id_mapel' => $id_ujian));
$id_mapel = $mapel['id_mapel'];
if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}
$file = "NILAI_" . $mapel['tgl_ujian'] . "_" . $mapel['nama'];
$file = str_replace(" ", "-", $file);
$file = str_replace(":", "", $file);
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls"); ?>

Kode Mapel: <?= $mapel['kode'] ?><br />
Tanggal Ujian: <?= buat_tanggal('D, d M Y - H:i', $mapel['tgl_ujian']) ?><br />
Jumlah Soal: <?= $mapel['jml_soal'] ?> PG / <?= $mapel['jml_multi'] ?> PG K Multi/ <?= $mapel['jml_bs'] ?> PG K BS / <?= $mapel['jml_urut'] ?> Jodoh / <?= $mapel['jml_esai'] ?> ESAI<br />

<table border='1'>
	<tr>
		<td rowspan='2'>No.</td>
		<td rowspan='2'>No. Peserta</td>
		<td rowspan='2'>Nama</td>
		<td rowspan='2'>Kelas</td>
		<td rowspan='2'>Lama Ujian</td>
		<td rowspan='2'>Nilai PG</td>
		<td rowspan='2'>Nilai PG K Multi</td>
		<td rowspan='2'>Nilai PG K BS</td>
		<td rowspan='2'>Nilai Jodoh</td>
		<td rowspan='2'>Nilai Essai</td>
		<td rowspan='2'>Nilai / Skor</td>
		
	</tr>
	<tr>
	
	</tr>

	<?php

	$siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa a join nilai b ON a.id_siswa=b.id_siswa where b.id_mapel='$id_ujian' ORDER BY id_kelas ASC");
	$betul = array();
	$salah = array();
	while ($siswa = mysqli_fetch_array($siswaQ)) {
		$no++;
		$benar = $salah = 0;
		$skor = $lama = '-';
		$selisih = 0;
		$nilai = fetch($koneksi, 'nilai', array('id_mapel' => $id_mapel, 'id_siswa' => $siswa['id_siswa']));
		if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
			$selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);
		}
	?>
		<tr>
			<td><?= $no ?></td>
			<td><?= $siswa['no_peserta'] ?></td>
			<td><?= $siswa['nama'] ?></td>
			<td><?= $siswa['id_kelas'] ?></td>
			<td><?= lamaujian($selisih) ?></td>
			<td class='str'><?= round($nilai['skor'], 2) ?></td>
			<td class='str'><?= round($nilai['skor_multi'], 2) ?></td>
			<td class='str'><?= round($nilai['skor_bs'], 2) ?></td>
			<td class='str'><?= round($nilai['skor_urut'], 2) ?></td>
			<td class='str'><?= round($nilai['skor_esai'], 2) ?></td>
			<td class='str'><?= round($nilai['total'], 2) ?></td>
		
	
	<?php } ?>

</table> 