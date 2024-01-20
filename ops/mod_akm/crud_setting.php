<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_admin();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';

if ($pg == 'setting_ujian') {
 $data = [
       
		'soal' => $_POST['soal']
		
		  ];
		   $exec = update($koneksi, 'menu', $data, ['id_menu' => '1']);
		   $exec = mysqli_query($koneksi, "truncate mapel");
		   $exec = mysqli_query($koneksi, "truncate soal");
		   $exec = mysqli_query($koneksi, "truncate ujian");
		   $exec = mysqli_query($koneksi, "truncate nilai");
		   $exec = mysqli_query($koneksi, "truncate jawaban");
		   $exec = mysqli_query($koneksi, "truncate jawaban_pindah");
}

