<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
$kode = $_POST['id'];
$nilai = mysqli_fetch_array(mysqli_query($koneksi, "select * from nilai a join mapel b on a.id_mapel=b.id_mapel where a.id_nilai='$kode'"));
$aresay = $_POST['nesai' . $kode];
$nesai = serialize($aresay);
$sum = 0;
foreach ($aresay as $id => $value) {
	$sum = $sum + $value;
}
$skor = intval($sum) * intval($nilai['bobot_esai']) / 100;
$total = floatval($nilai['skor']) + $skor + floatval($nilai['skor_multi']) + floatval($nilai['skor_bs']) + floatval($nilai['skor_urut']);
$query = mysqli_query($koneksi, "UPDATE nilai set skor_esai='$skor',nilai_esai='$skor', nilai_esai2='$nesai',total='$total' where id_nilai = '$kode'");
echo $sum;
