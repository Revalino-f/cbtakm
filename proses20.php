<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";

$id_siswa = $_POST['id_siswa'];
$id_mapel = $_POST['id_mapel'];
$id_ujian = $_POST['id_ujian'];
$id_soal = $_POST['id_soal'];
$jenis = '5';

	$exec = mysqli_query($koneksi, "UPDATE jawaban SET jawaburut='' WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'");
   $hapus = mysqli_query($koneksi, "DELETE FROM jodoh WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'");

	

?>