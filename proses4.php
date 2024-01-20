<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";
$id_siswa = $_POST['id_siswa'];
$id_mapel = $_POST['id_mapel'];
$id_ujian = $_POST['id_ujian'];
$id_soal = $_POST['id_soal'];
$jenis = '3';
$pgm1 = $_POST['pgm1'];
$pgm2 = $_POST['pgm2'];
$pgm3 = $_POST['pgm3'];
$pgm4 = $_POST['pgm4'];
$pgm5 = $_POST['pgm5'];


 if($pgm1<>'' AND $pgm2==''){$jawab = $pgm1;}
 if($pgm1<>'' AND $pgm2<>''){$jawab = $pgm1.', '.$pgm2;}
  if($pgm1<>'' AND $pgm2<>'' AND $pgm3<>''){$jawab = $pgm1.', '.$pgm2.', '.$pgm3;}
   if($pgm1<>'' AND $pgm2<>'' AND $pgm3<>'' AND $pgm4<>''){$jawab = $pgm1.', '.$pgm2.', '.$pgm3.', '.$pgm4;}
    if($pgm1<>'' AND $pgm2<>'' AND $pgm3<>'' AND $pgm4<>'' AND $pgm5<>''){$jawab = $pgm1.', '.$pgm2.', '.$pgm3.', '.$pgm4.', '.$pgm5;}
 
$cekdata = "SELECT * FROM jawaban WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'";
$jikaada = mysqli_query($koneksi,$cekdata);
if(mysqli_num_rows($jikaada)>0){
	
$exec = mysqli_query($koneksi, "UPDATE jawaban SET jawabmulti='$jawab',bs1='$pgm1',bs2='$pgm2',bs3='$pgm3',bs4='$pgm4',bs5='$pgm5' WHERE id_siswa='$id_siswa' AND id_ujian='$id_ujian' AND id_soal='$id_soal' AND jenis='$jenis'");
		
		
	}else{
		
$exec = mysqli_query($koneksi, "INSERT INTO jawaban (id_siswa,id_mapel,id_soal,id_ujian,jawabmulti,jenis,bs1,bs2,bs3,bs4,bs5) VALUES ('$id_siswa','$id_mapel','$id_soal','$id_ujian','$jawab','$jenis','$pgm1','$pgm2','$pgm3','$pgm4','$pgm5')");
	
		
	
		}


?>