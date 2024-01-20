<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";

$id_siswa = $_POST['id_siswa'];
$id_mapel = $_POST['id_mapel'];
$id_ujian = $_POST['id_ujian'];
$id_soal = $_POST['id_soal'];
$jenis = '4';
$bs1 = $_POST['bs1'];
$bs2 = $_POST['bs2'];
$bs3 = $_POST['bs3'];
$bs4 = $_POST['bs4'];
$bs5 = $_POST['bs5'];


 if($bs1<>'' AND $bs2==''){$jawab = $bs1;}
 if($bs1<>'' AND $bs2<>''){$jawab = $bs1.', '.$bs2;}
  if($bs1<>'' AND $bs2<>'' AND $bs3<>''){$jawab = $bs1.', '.$bs2.', '.$bs3;}
   if($bs1<>'' AND $bs2<>'' AND $bs3<>'' AND $bs4<>''){$jawab = $bs1.', '.$bs2.', '.$bs3.', '.$bs4;}
    if($bs1<>'' AND $bs2<>'' AND $bs3<>'' AND $bs4<>'' AND $bs5<>''){$jawab = $bs1.', '.$bs2.', '.$bs3.', '.$bs4.', '.$bs5;}
 
$cekdata = "SELECT * FROM jawaban WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'";
$jikaada = mysqli_query($koneksi,$cekdata);
if(mysqli_num_rows($jikaada)>0){
	
$exec = mysqli_query($koneksi, "UPDATE jawaban SET jawabbs='$jawab',bs1='$bs1',bs2='$bs2',bs3='$bs3',bs4='$bs4',bs5='$bs5' WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'");

	}else{
		
$exec = mysqli_query($koneksi, "INSERT INTO jawaban (id_siswa,id_mapel,id_soal,id_ujian,jawabbs,jenis,bs1,bs2,bs3,bs4,bs5) VALUES ('$id_siswa','$id_mapel','$id_soal','$id_ujian','$jawab','$jenis','$bs1','$bs2','$bs3','$bs4','$bs5')");
	
	
		}


?>