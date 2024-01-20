<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'selesaikan') {
    $idnilai = $_POST['id'];
    $nilai = fetch($koneksi, 'nilai', array('id_nilai' => $idnilai));
    $idm = $nilai['id_mapel'];
    $ids = $nilai['id_siswa'];
    $idu = $nilai['id_ujian'];
    $where = array(
        'id_mapel' => $idm,
        'id_siswa' => $ids,
        'id_ujian' => $idu
    );

    $benar = $salah = 0;
		$benarm = $salahm = 0;
		$benarb = $salahb = 0;
		$benaru = $salahu = 0;
		$benari = $salahi = 0;
        $mapel = fetch($koneksi, 'mapel', array('id_mapel' => $idm));
        $siswa = fetch($koneksi, 'siswa', array('id_siswa' => $ids));
		$ceksoal = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 1));
		$ceksoalesai = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 2));
		$cekmulti = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 3));
		$cekbs = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 4));
		$cekurut = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 5));

$arrayjawabesai = array();
foreach ($ceksoalesai as $getsoalesai) {
    $w2 = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getsoalesai['id_soal'],
        'jenis' => 2
    );
   
    $getjwb2 = fetch($koneksi, 'jawaban', $w2);
    if ($getjwb2) {
        $jawabxx = str_replace("'", "`", $getjwb2['esai']);
        $jawabxx = str_replace("#", ">>", $jawabxx);
        $jawabxx = preg_replace('/[^A-Za-z0-9\@\<\>\$\_\&\-\+\(\)\/\?\!\;\:\`\"\[\]\*\{\}\=\%\~\`\รท\ร— ]/', '', $jawabxx);
        $arrayjawabesai[$getsoalesai['id_soal']] = $jawabxx;
    } else {
        $arrayjawabesai[$getsoalesai['id_soal']] = 'Tidak Diisi';
    }
	 ($getjwb2['esai'] == $getsoalesai['jawaban']) ? $benari++ : $salahi++;
}
$arrayjawab = array();
foreach ($ceksoal as $getsoal) {
    $w = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getsoal['id_soal'],
        'jenis' => 1
    );
    $getjwb = fetch($koneksi, 'jawaban', $w);
    if ($getjwb) {
        $arrayjawab[$getsoal['id_soal']] = $getjwb['jawaban'];
    } else {
        $arrayjawab[$getsoal['id_soal']] = 'X';
    }
    ($getjwb['jawaban'] == $getsoal['jawaban']) ? $benar++ : $salah++;
}

$arraymulti = array();
foreach ($cekmulti as $getmulti) {
    $m = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getmulti['id_soal'],
        'jenis' => 3
    );
    $getmt = fetch($koneksi, 'jawaban', $m);
    if ($getmulti) {
        $arraymulti[$getmulti['id_soal']] = $getmt['jawabmulti'];
    } else {
        $arraymulti[$getmulti['id_soal']] = 'X';
    }
    ($getmt['jawabmulti'] == $getmulti['jawaban']) ? $benarm++ : $salahm++;
}

$arraybs = array();
foreach ($cekbs as $getbs) {
    $b = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getbs['id_soal'],
        'jenis' => 4
    );
    $getb = fetch($koneksi, 'jawaban', $b);
    if ($getbs) {
        $arraybs[$getbs['id_soal']] = $getb['jawabbs'];
    } else {
        $arraybs[$getbs['id_soal']] = 'X';
    }
    ($getb['jawabbs'] == $getbs['jawaban']) ? $benarb++ : $salahb++;
}
$arrayurut = array();
foreach ($cekurut as $geturut) {
    $u = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $geturut['id_soal'],
        'jenis' => 5
    );
    $getut = fetch($koneksi, 'jawaban', $u);
    if ($geturut) {
        $arrayurut[$geturut['id_soal']] = $getut['jawaburut'];
    } else {
        $arrayurut[$geturut['id_soal']] = 'X';
    }
    ($getut['jawaburut'] == $geturut['jawaban']) ? $benaru++ : $salahu++;
}

$bagi1 = $mapel['tampil_pg'] / 100;
$bagi2 = $mapel['tampil_esai'] / 100;
$bagi3 = $mapel['tampil_multi'] / 100;
$bagi4 = $mapel['tampil_bs'] / 100;
$bagi5 = $mapel['tampil_urut'] / 100;

$bobot1 = $mapel['bobot_pg'] / 100;
$bobot2 = $mapel['bobot_esai'] / 100;
$bobot3 = $mapel['bobot_multi'] / 100;
$bobot4 = $mapel['bobot_bs'] / 100;
$bobot5 = $mapel['bobot_urut'] / 100;

$skor1 = ($benar/$bagi1) * $bobot1;
$skor2 = ($benari/$bagi2) * $bobot2;
$skor3 = ($benarm/$bagi3) * $bobot3;
$skor4 = ($benarb/$bagi4) * $bobot4;
$skor5 = ($benaru/$bagi5) * $bobot5;
if($skor1==''){
{$p=0;}	
}elseif($skor1 >=1){
{$p=$skor1;}
}
if($skor2==''){
{$e=0;}	
}elseif($skor2 >=1){
{$e=$skor2;}
}
if($skor3==''){
{$m=0;}	
}elseif($skor3 >=1){
{$m=$skor3;}
}
if($skor4==''){
{$b=0;}	
}elseif($skor4 >=1){
{$b=$skor4;}
}
if($skor5==''){
{$u=0;}	
}elseif($skor5 >=1){
{$u=$skor5;}
}



        $data = array(
            'ujian_selesai' => $datetime,
            'jml_benar' => $benar,
			'benar_esai' => $benari,
	'benar_multi' => $benarm,
	'benar_bs' => $benarb,
	'benar_urut' => $benaru,
            'jml_salah' => $salah,
			 'salah_esai' => $mapel['tampil_esai']-$benari,
	 'salah_multi' => $mapel['tampil_multi']-$benarm,
	  'salah_bs' => $mapel['tampil_bs']-$benarb,
	   'salah_urut' => $mapel['tampil_urut']-$benaru,
             'skor' => $p,
	   'skor_esai' => $e,
	   'skor_multi' => $m,
	   'skor_bs' => $b,
	   'skor_urut' => $u,
            'total' => $p+$e+$m+$b+$u,
            'online' => 0,
            'jawaban' => serialize($arrayjawab),
            'jawaban_esai' => serialize($arrayjawabesai),
			'jawaban_multi' => serialize($arraymulti),
	'jawaban_bs' => serialize($arraybs),
	'jawaban_urut' => serialize($arrayurut)
        );
    $simpan = update($koneksi, 'nilai', $data, $where);
    if ($simpan) {
        echo "Berhasil diselesaikan";
    }
    echo mysqli_error($koneksi);
    mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$ids','login','Selesai Ujian','$tanggal $waktu')");
}
if ($pg == 'selesaisemua') {
    if (empty($_GET['id'])) {
        $query = mysqli_query($koneksi, "SELECT * FROM nilai where skor is null");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM nilai where skor is null and id_ujian='$_GET[id]'");
    }

    while ($nilai = mysqli_fetch_assoc($query)) {
        $idm = $nilai['id_mapel'];
        $ids = $nilai['id_siswa'];
        $idu = $nilai['id_ujian'];
        $where = array(
            'id_mapel' => $idm,
            'id_siswa' => $ids,
            'id_ujian' => $idu
        );

        $benar = $salah = 0;
		$benarm = $salahm = 0;
		$benarb = $salahb = 0;
		$benaru = $salahu = 0;
		$benari = $salahi = 0;
        $mapel = fetch($koneksi, 'mapel', array('id_mapel' => $idm));
        $siswa = fetch($koneksi, 'siswa', array('id_siswa' => $ids));
		$ceksoal = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 1));
		$ceksoalesai = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 2));
		$cekmulti = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 3));
		$cekbs = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 4));
		$cekurut = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 5));

$arrayjawabesai = array();
foreach ($ceksoalesai as $getsoalesai) {
    $w2 = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getsoalesai['id_soal'],
        'jenis' => 2
    );
   
    $getjwb2 = fetch($koneksi, 'jawaban', $w2);
    if ($getjwb2) {
        $jawabxx = str_replace("'", "`", $getjwb2['esai']);
        $jawabxx = str_replace("#", ">>", $jawabxx);
        $jawabxx = preg_replace('/[^A-Za-z0-9\@\<\>\$\_\&\-\+\(\)\/\?\!\;\:\`\"\[\]\*\{\}\=\%\~\`\รท\ร— ]/', '', $jawabxx);
        $arrayjawabesai[$getsoalesai['id_soal']] = $jawabxx;
    } else {
        $arrayjawabesai[$getsoalesai['id_soal']] = 'Tidak Diisi';
    }
	 ($getjwb2['esai'] == $getsoalesai['jawaban']) ? $benari++ : $salahi++;
}
$arrayjawab = array();
foreach ($ceksoal as $getsoal) {
    $w = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getsoal['id_soal'],
        'jenis' => 1
    );
    $getjwb = fetch($koneksi, 'jawaban', $w);
    if ($getjwb) {
        $arrayjawab[$getsoal['id_soal']] = $getjwb['jawaban'];
    } else {
        $arrayjawab[$getsoal['id_soal']] = 'X';
    }
    ($getjwb['jawaban'] == $getsoal['jawaban']) ? $benar++ : $salah++;
}

$arraymulti = array();
foreach ($cekmulti as $getmulti) {
    $m = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getmulti['id_soal'],
        'jenis' => 3
    );
    $getmt = fetch($koneksi, 'jawaban', $m);
    if ($getmulti) {
        $arraymulti[$getmulti['id_soal']] = $getmt['jawabmulti'];
    } else {
        $arraymulti[$getmulti['id_soal']] = 'X';
    }
    ($getmt['jawabmulti'] == $getmulti['jawaban']) ? $benarm++ : $salahm++;
}

$arraybs = array();
foreach ($cekbs as $getbs) {
    $b = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getbs['id_soal'],
        'jenis' => 4
    );
    $getb = fetch($koneksi, 'jawaban', $b);
    if ($getbs) {
        $arraybs[$getbs['id_soal']] = $getb['jawabbs'];
    } else {
        $arraybs[$getbs['id_soal']] = 'X';
    }
    ($getb['jawabbs'] == $getbs['jawaban']) ? $benarb++ : $salahb++;
}
$arrayurut = array();
foreach ($cekurut as $geturut) {
    $u = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $geturut['id_soal'],
        'jenis' => 5
    );
    $getut = fetch($koneksi, 'jawaban', $u);
    if ($geturut) {
        $arrayurut[$geturut['id_soal']] = $getut['jawaburut'];
    } else {
        $arrayurut[$geturut['id_soal']] = 'X';
    }
    ($getut['jawaburut'] == $geturut['jawaban']) ? $benaru++ : $salahu++;
}

$bagi1 = $mapel['tampil_pg'] / 100;
$bagi2 = $mapel['tampil_esai'] / 100;
$bagi3 = $mapel['tampil_multi'] / 100;
$bagi4 = $mapel['tampil_bs'] / 100;
$bagi5 = $mapel['tampil_urut'] / 100;

$bobot1 = $mapel['bobot_pg'] / 100;
$bobot2 = $mapel['bobot_esai'] / 100;
$bobot3 = $mapel['bobot_multi'] / 100;
$bobot4 = $mapel['bobot_bs'] / 100;
$bobot5 = $mapel['bobot_urut'] / 100;

$skor1 = ($benar/$bagi1) * $bobot1;
$skor2 = ($benari/$bagi2) * $bobot2;
$skor3 = ($benarm/$bagi3) * $bobot3;
$skor4 = ($benarb/$bagi4) * $bobot4;
$skor5 = ($benaru/$bagi5) * $bobot5;
if($skor1==''){
{$p=0;}	
}elseif($skor1 >=1){
{$p=$skor1;}
}
if($skor2==''){
{$e=0;}	
}elseif($skor2 >=1){
{$e=$skor2;}
}
if($skor3==''){
{$m=0;}	
}elseif($skor3 >=1){
{$m=$skor3;}
}
if($skor4==''){
{$b=0;}	
}elseif($skor4 >=1){
{$b=$skor4;}
}
if($skor5==''){
{$u=0;}	
}elseif($skor5 >=1){
{$u=$skor5;}
}



        $data = array(
            'ujian_selesai' => $datetime,
            'jml_benar' => $benar,
			'benar_esai' => $benari,
	'benar_multi' => $benarm,
	'benar_bs' => $benarb,
	'benar_urut' => $benaru,
            'jml_salah' => $salah,
			 'salah_esai' => $mapel['tampil_esai']-$benari,
	 'salah_multi' => $mapel['tampil_multi']-$benarm,
	  'salah_bs' => $mapel['tampil_bs']-$benarb,
	   'salah_urut' => $mapel['tampil_urut']-$benaru,
             'skor' => $p,
	   'skor_esai' => $e,
	   'skor_multi' => $m,
	   'skor_bs' => $b,
	   'skor_urut' => $u,
            'total' => $p+$e+$m+$b+$u,
            'online' => 0,
            'jawaban' => serialize($arrayjawab),
            'jawaban_esai' => serialize($arrayjawabesai),
			'jawaban_multi' => serialize($arraymulti),
	'jawaban_bs' => serialize($arraybs),
	'jawaban_urut' => serialize($arrayurut)
        );
        $simpan = update($koneksi, 'nilai', $data, $where);
		$exec = mysqli_query($koneksi, "DELETE FROM jawaban WHERE id_ujian='$idu' AND id_siswa='$ids'");
	$exec = mysqli_query($koneksi, "DELETE FROM jodoh WHERE id_ujian='$idu' AND id_siswa='$ids'");

        if ($simpan) {
            echo "Berhasil diselesaikan";
        }
        echo mysqli_error($koneksi);
        mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$ids','login','Selesai Ujian','$tanggal $waktu')");
   
   }
}
if ($pg == 'resetlogin') {
    $kode = $_POST['kode'];
    $query = mysqli_query($koneksi, "UPDATE nilai set online='0' where id_nilai in (" . $kode . ")");
    if ($query) {
        echo 1;
    } else {
        echo 0;
    }
}
if ($pg == 'ulangujian') {
	$menu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='1'"));
    $idnilai = $_POST['id'];
    $nilai = fetch($koneksi, 'nilai', array('id_nilai' => $idnilai));
    $idu = $nilai['id_ujian'];
    $idm = $nilai['id_mapel'];
    $ids = $nilai['id_siswa'];
    $where2 = array(
        'id_mapel' => $idm,
        'id_siswa' => $ids,
        'id_ujian' => $idu
    );
	if($menu['ulangi']==0){
    delete($koneksi, 'nilai', ['id_nilai' => $idnilai]);
    delete($koneksi, 'jawaban', $where2);
	}
	if($menu['ulangi']==1){
		 delete($koneksi, 'nilai', ['id_nilai' => $idnilai]);
	}
}
