<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
cek_session_siswa();
$id_mapel = $_POST['id_mapel'];
$id_siswa = $_POST['id_siswa'];
$id_ujian = $_POST['idu'];
$pengacak = $_POST['pengacak'];
$pengacak = explode(',', $pengacak);
$pengacakpil = $_POST['pengacakpil'];
$pengacakpil = explode(',', $pengacakpil);
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
?>
<div class='row' id='nomorsoal'>

    <?php for ($n = 0; $n < $jumsoal; $n++) : ?>
        <?php
        $id_soal = $pengacak[$n];
        $cekjwb = rowcount($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_soal,  'id_ujian' => $id_ujian));
        $ragu = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_soal,  'id_ujian' => $id_ujian));

        $color1 = ($cekjwb <> 0) ? 'green' : 'gray';
        $color = ($ragu['ragu'] == 1) ? 'yellow' : $color1;
        $nomor = $n + 1;
        $nomor = ($nomor < 10) ? "0" . $nomor : $nomor;

         if($ragu['jenis']=='1' ){
		   $jawabannya=$ragu['jawaban'];
		   
	   }
	   if($ragu['jenis']=='2' ){
		   $jawabannya='Esai';
	   }
	   if($ragu['jenis']=='3' ){
		   $jawabannya=$ragu['jawabmulti'];
	   }
       if($ragu['jenis']=='4' ){
		   $jawabannya=$ragu['jawabbs'];
	   }
	   if($ragu['jenis']=='5' ){
		   $jawabannya=$ragu['jawaburut'];
	   }
	   if($ragu['id_mapel']<>$id_mapel ){
		    $jawabannya='Blm Jwb';
	   }
	   

        ?>
		<?php if($ragu['jenis']=='1' ){ ?>
        <a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-red' style="font-size:medium"><?= $jawabannya ?></span></a>
        <?php } ?>
	   <?php if($ragu['jenis']=='2' ){ ?>
        <a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-red' style="font-size:medium"><?= $jawabannya ?></span></a>
        <?php } ?>
	<?php if($ragu['jenis']=='3' ){ ?>
        <a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-red' style="font-size:small"><?= $jawabannya ?></span></a>
        <?php } ?>
		<?php if($ragu['jenis']=='4' ){ ?>
        <a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-red' style="font-size:small"><?= $jawabannya ?></span></a>
        <?php } ?>
		<?php if($ragu['jenis']=='5' ){ ?>
        <a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-red' style="font-size:small"><?= $jawabannya ?></span></a>
       	   <?php } ?>
		   <?php if($ragu['id_mapel']<>$id_mapel ){ ?>
		    <a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-black' style="font-size:small"><?= $jawabannya ?></span></a>
       	   <?php } ?>
	<?php endfor; ?>
</div>