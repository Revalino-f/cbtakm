<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";

$id_siswa = $_POST['id_siswa'];
$id_mapel = $_POST['id_mapel'];
$id_ujian = $_POST['id_ujian'];
$id_soal = $_POST['id_soal'];
$jenis = '3';
$jawab = implode($_POST['jawab'], ', ');
$cekdata = "SELECT * FROM jawaban WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'";
$jikaada = mysqli_query($koneksi,$cekdata);
if(mysqli_num_rows($jikaada)>0){
	$exec = mysqli_query($koneksi, "UPDATE jawaban SET jawabmulti='$jawab' WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'");

	
	}else{
$exec = mysqli_query($koneksi, "INSERT INTO jawaban (id_siswa,id_mapel,id_soal,id_ujian,jawabmulti,jenis) VALUES ('$id_siswa','$id_mapel','$id_soal','$id_ujian','$jawab','$jenis')");

	}
?>