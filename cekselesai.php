<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";
cek_session_siswa();
$id_mapel = $_POST['id_mapel'];
$id_siswa = $_POST['id_siswa'];
$id_ujian = $_POST['id_ujian'];
$cekpg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='1'"));
                        $cekesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='2'"));
                       $cekmulti = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='3'"));
					  $cekbs = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='4'"));
					  $cekurut = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='5'"));
					  $quero = mysqli_fetch_array(mysqli_query($koneksi, "SELECT tampil_pg,tampil_esai,tampil_multi,tampil_bs,tampil_urut FROM mapel WHERE id_mapel='$id_mapel'"));

                        if ($cekpg >= $quero['tampil_pg']) {
                            $soalpg = $quero['tampil_pg'];
                        } else {
                            $soalpg = $cekpg;
                        }
                        if ($cekesai >= $quero['tampil_esai']) {
                            $soalesai = $quero['tampil_esai'];
                        } else {
                            $soalpg = $cekesai;
                        }
						if ($cekmulti >= $quero['tampil_multi']) {
                             $soalmulti = $quero['tampil_multi'];
                      } else {
                     $soalpg = $cekmulti;
                       }
					   if ($cekbs >= $quero['tampil_bs']) {
                             $soalbs = $quero['tampil_bs'];
                      } else {
                     $soalpg = $cekbs;
                       }
					   if ($cekurut >= $quero['tampil_urut']) {
                             $soalurut = $quero['tampil_urut'];
                      } else {
                     $soalpg = $cekurut;
                       }
					   
                      $jumsoal = $soalpg + $soalesai + $soalmulti  + $soalbs + $soalurut;

$jumjawab = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jawaban WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND id_ujian='$id_ujian'"));
$cekragu = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jawaban WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND id_ujian='$id_ujian' and ragu='1'"));
 
if ($jumsoal == $jumjawab) {
    if ($cekragu == 0) {
        echo "ok";
    } else {
        echo "ragu";
    }
} else {
    echo "belum";
}
