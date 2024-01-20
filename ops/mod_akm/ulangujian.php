<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
$idnilai = $_POST['id'];
$nilai = fetch($koneksi, 'nilai', array('id_nilai' => $idnilai));
$idu = $nilai['id_ujian'];
$idm = $nilai['id_bank'];
$ids = $nilai['id_siswa'];
$menu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM menu  WHERE id_menu='1'"));
$where2 = array(
    'id_bank' => $idm,
    'id_siswa' => $ids,
    'id_ujian' => $idu
);
if($menu['ulangi']==0){
delete($koneksi, 'nilai', ['id_nilai' => $idnilai]);
delete($koneksi, 'pengacak', $where2);
//delete($koneksi, 'pengacakopsi', $where2);
delete($koneksi, 'jawaban', $where2);
delete($koneksi, 'jodoh', $where2);
//delete($koneksi, 'hasil_jawaban', $where2);
}else{
delete($koneksi, 'nilai', ['id_nilai' => $idnilai]);
delete($koneksi, 'pengacak', $where2);
delete($koneksi, 'jawaban', $where2);
delete($koneksi, 'jodoh', $where2);
}
