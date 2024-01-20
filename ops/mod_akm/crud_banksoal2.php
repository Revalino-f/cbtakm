<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));
$id_pengawas = $pengawas['id_pengawas'];

if ($pg == 'simpan_soal') {
	
      $idsoal = $_POST['idsoal'];
    $nomor = $_POST['nomor'];
    $jenis = $_POST['jenis'];
    $id_mapel = $_POST['mapel'];
	$kode = $_POST['kode'];
	 $kodek = $_POST['kodek'];
	 $pembahasan = addslashes($_POST['bahasan']);
    $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
    $jumsoal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='$jenis'"));
    $soalQ = mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='$jenis'");
    $soal = mysqli_fetch_array($soalQ);
    $isi_soal = addslashes($_POST['isi_soal']);
    $ektensi = ['jpg', 'png', 'mp3', 'jpeg'];
    if ($jenis == '1') {
        $pilA = addslashes($_POST['pilA']);
        $pilB = addslashes($_POST['pilB']);
        $pilC = addslashes($_POST['pilC']);
        $pilD = addslashes($_POST['pilD']);

        $pilE = addslashes($_POST['pilE']);
       
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] <> '') {
            $file = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $size = $_FILES['file']['size'];
            $ext = explode('.', $file);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $url = 'files/' . $id_mapel . '_' . $nomor . '_1.' . $ext;
                $urlx = $id_mapel . '_' . $nomor . '_1.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $url);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$urlx','$id_mapel')");
                (!$upload) ? $url = $soal['file'] : null;
            }
        } else {
            $urlx = $soal['file'];
        }
        if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] <> '') {
            $file1 = $_FILES['file1']['name'];
            $temp = $_FILES['file1']['tmp_name'];
            $size = $_FILES['file1']['size'];
            $ext = explode('.', $file1);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $file1 = 'files/' . $id_mapel . '_' . $nomor . '_2.' . $ext;
                $filex1 = $id_mapel . '_' . $nomor . '_2.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $file1);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filex1','$id_mapel')");
                (!$upload) ? $file1 = $soal['file1'] : null;
            }
        } else {
            $filex1 = $soal['file1'];
        }
        if (isset($_FILES['fileA']['name']) && $_FILES['fileA']['name'] <> '') {
            $fileA = $_FILES['fileA']['name'];
            $temp = $_FILES['fileA']['tmp_name'];
            $size = $_FILES['fileA']['size'];
            $ext = explode('.', $fileA);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileA = 'files/' . $id_mapel . '_' . $nomor . '_A.' . $ext;
                $filexA = $id_mapel . '_' . $nomor . '_A.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileA);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexA','$id_mapel')");
                (!$upload) ? $fileA = $soal['fileA'] : null;
            }
        } else {
            $filexA = $soal['fileA'];
        }
        if (isset($_FILES['fileB']['name']) && $_FILES['fileB']['name'] <> '') {
            $fileB = $_FILES['fileB']['name'];
            $temp = $_FILES['fileB']['tmp_name'];
            $size = $_FILES['fileB']['size'];
            $ext = explode('.', $fileB);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileB = 'files/' . $id_mapel . '_' . $nomor . '_B.' . $ext;
                $filexB = $id_mapel . '_' . $nomor . '_B.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileB);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexB','$id_mapel')");
                (!$upload) ? $fileB = $soal['fileB'] : null;
            }
        } else {
            $filexB = $soal['fileB'];
        }
        if (isset($_FILES['fileC']['name']) && $_FILES['fileC']['name'] <> '') {
            $fileC = $_FILES['fileC']['name'];
            $temp = $_FILES['fileC']['tmp_name'];
            $size = $_FILES['fileC']['size'];
            $ext = explode('.', $fileC);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileC = 'files/' . $id_mapel . '_' . $nomor . '_C.' . $ext;
                $filexC = $id_mapel . '_' . $nomor . '_C.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileC);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexC','$id_mapel')");
                (!$upload) ? $fileC = $soal['fileC'] : null;
            }
        } else {
            $filexC = $soal['fileC'];
        }
        if (isset($_FILES['fileD']['name']) && $_FILES['fileD']['name'] <> '') {
            $fileD = $_FILES['fileD']['name'];
            $temp = $_FILES['fileD']['tmp_name'];
            $size = $_FILES['fileD']['size'];
            $ext = explode('.', $fileD);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileD = 'files/' . $id_mapel . '_' . $nomor . '_D.' . $ext;
                $filexD = $id_mapel . '_' . $nomor . '_D.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileD);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexD','$id_mapel')");
                (!$upload) ? $fileD = $soal['fileD'] : null;
            }
        } else {
            $filexD = $soal['fileD'];
        }

        if (isset($_FILES['fileE']['name']) && $_FILES['fileE']['name'] <> '') {
            $fileE = $_FILES['fileE']['name'];
            $temp = $_FILES['fileE']['tmp_name'];
            $size = $_FILES['fileE']['size'];
            $ext = explode('.', $fileE);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileE = 'files/' . $id_mapel . '_' . $nomor . '_E.' . $ext;
                $filexE = $id_mapel . '_' . $nomor . '_E.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileE);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexE','$id_mapel')");
                (!$upload) ? $fileE = $soal['fileE'] : null;
            }
        } else {
            $filexE = $soal['fileE'];
        }

        $jawaban = $_POST['jawaban'];
      
            $exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal',pilA='$pilA',pilB='$pilB',pilC='$pilC',pilD='$pilD',pilE='$pilE',jawaban='$jawaban',pembahasan='$pembahasan',file='$urlx' WHERE id_soal='$idsoal' AND jenis='1'");
        
	   
    }
    if ($jenis == '2') {
		 $pilA = strtolower($_POST['pilA']);
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] <> '') {
            $file = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $size = $_FILES['file']['size'];
            $ext = explode('.', $file);
            $ext = end($ext);
            $url = 'files/' . $id_mapel . '_' . $nomor . '_E1.' . $ext;
            $urlx = $id_mapel . '_' . $nomor . '_E1.' . $ext;
            $upload = move_uploaded_file($temp, '../../' . $url);
            $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$urlx','$id_mapel')");
            (!$upload) ? $url = $soal['file'] : null;
        } else {
            $urlx = $soal['file'];
        }
        if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] <> '') {
            $file1 = $_FILES['file1']['name'];
            $temp = $_FILES['file1']['tmp_name'];
            $size = $_FILES['file1']['size'];
            $ext = explode('.', $file1);
            $ext = end($ext);
            $file1 = 'files/' . $id_mapel . '_' . $nomor . '_E2.' . $ext;
            $filex1 = $id_mapel . '_' . $nomor . '_E2.' . $ext;
            $upload = move_uploaded_file($temp, '../../' . $file1);
            $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filex1','$id_mapel')");
            (!$upload) ? $file1 = $soal['file1'] : null;
        } else {
            $filex1 = $soal['file1'];
        }
        if ($jumsoal == 0) {
           
        } else {
            $exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal', jawaban='$pilA',pembahasan='$pembahasan',file='$urlx' WHERE id_soal='$idsoal' AND jenis='2'");
        
		}
    }
    (!$exec) ? $info = info('Gagal menyimpan soal!', 'NO') : $info = info('Berhasil menyimpan soal!', 'OK');
}

  if ($jenis == '3') {
	
	  $pilA = addslashes($_POST['pilA']);
     $pilB = addslashes($_POST['pilB']);
     $pilC = addslashes($_POST['pilC']);
      $pilD = addslashes($_POST['pilD']);

        $pilE = addslashes($_POST['pilE']);
           
		$perA = addslashes($_POST['perA']);
        $perB = addslashes($_POST['perB']);
        $perC = addslashes($_POST['perC']);
        $perD = addslashes($_POST['perD']);
        $perE = addslashes($_POST['perE']);	   
		  
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] <> '') {
            $file = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $size = $_FILES['file']['size'];
            $ext = explode('.', $file);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $url = 'files/' . $id_mapel . '_' . $nomor . '_1.' . $ext;
                $urlx = $id_mapel . '_' . $nomor . '_1.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $url);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$urlx','$id_mapel')");
                (!$upload) ? $url = $soal['file'] : null;
            }
        } else {
            $urlx = $soal['file'];
        }

      
        
       $jawabane = implode($_POST['jawaban'], ', ');
	   
       if ($kodek=='PGM') {
            $exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal',pilA='$pilA',pilB='$pilB',pilC='$pilC',pilD='$pilD',pilE='$pilE',perA='$perA',perB='$perB',perC='$perC',perD='$perD',perE='$perE',jawaban='$jawabane',pembahasan='$pembahasan',file='$urlx' WHERE id_soal='$idsoal'");
       }else{
		     $exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal',pilA='$pilA',pilB='$pilB',pilC='$pilC',pilD='$pilD',pilE='$pilE',jawaban='$jawabane',pembahasan='$pembahasan',file='$urlx' WHERE id_soal='$idsoal'");
	   }
  }
    

  if ($jenis == '4') {
	
	    $pilA = addslashes($_POST['pilA']);
        $pilB = addslashes($_POST['pilB']);
        $pilC = addslashes($_POST['pilC']);
        $pilD = addslashes($_POST['pilD']);

        $pilE = addslashes($_POST['pilE']);

        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] <> '') {
            $file = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $size = $_FILES['file']['size'];
            $ext = explode('.', $file);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $url = 'files/' . $id_mapel . '_' . $nomor . '_1.' . $ext;
                $urlx = $id_mapel . '_' . $nomor . '_1.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $url);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$urlx','$id_mapel')");
                (!$upload) ? $url = $soal['file'] : null;
            }
        } else {
            $urlx = $soal['file'];
        }
        if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] <> '') {
            $file1 = $_FILES['file1']['name'];
            $temp = $_FILES['file1']['tmp_name'];
            $size = $_FILES['file1']['size'];
            $ext = explode('.', $file1);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $file1 = 'files/' . $id_mapel . '_' . $nomor . '_2.' . $ext;
                $filex1 = $id_mapel . '_' . $nomor . '_2.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $file1);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filex1','$id_mapel')");
                (!$upload) ? $file1 = $soal['file1'] : null;
            }
        } else {
            $filex1 = $soal['file1'];
        }
        if (isset($_FILES['fileA']['name']) && $_FILES['fileA']['name'] <> '') {
            $fileA = $_FILES['fileA']['name'];
            $temp = $_FILES['fileA']['tmp_name'];
            $size = $_FILES['fileA']['size'];
            $ext = explode('.', $fileA);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileA = 'files/' . $id_mapel . '_' . $nomor . '_A.' . $ext;
                $filexA = $id_mapel . '_' . $nomor . '_A.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileA);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexA','$id_mapel')");
                (!$upload) ? $fileA = $soal['fileA'] : null;
            }
        } else {
            $filexA = $soal['fileA'];
        }
        if (isset($_FILES['fileB']['name']) && $_FILES['fileB']['name'] <> '') {
            $fileB = $_FILES['fileB']['name'];
            $temp = $_FILES['fileB']['tmp_name'];
            $size = $_FILES['fileB']['size'];
            $ext = explode('.', $fileB);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileB = 'files/' . $id_mapel . '_' . $nomor . '_B.' . $ext;
                $filexB = $id_mapel . '_' . $nomor . '_B.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileB);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexB','$id_mapel')");
                (!$upload) ? $fileB = $soal['fileB'] : null;
            }
        } else {
            $filexB = $soal['fileB'];
        }
        if (isset($_FILES['fileC']['name']) && $_FILES['fileC']['name'] <> '') {
            $fileC = $_FILES['fileC']['name'];
            $temp = $_FILES['fileC']['tmp_name'];
            $size = $_FILES['fileC']['size'];
            $ext = explode('.', $fileC);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileC = 'files/' . $id_mapel . '_' . $nomor . '_C.' . $ext;
                $filexC = $id_mapel . '_' . $nomor . '_C.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileC);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexC','$id_mapel')");
                (!$upload) ? $fileC = $soal['fileC'] : null;
            }
        } else {
            $filexC = $soal['fileC'];
        }
        if (isset($_FILES['fileD']['name']) && $_FILES['fileD']['name'] <> '') {
            $fileD = $_FILES['fileD']['name'];
            $temp = $_FILES['fileD']['tmp_name'];
            $size = $_FILES['fileD']['size'];
            $ext = explode('.', $fileD);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileD = 'files/' . $id_mapel . '_' . $nomor . '_D.' . $ext;
                $filexD = $id_mapel . '_' . $nomor . '_D.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileD);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexD','$id_mapel')");
                (!$upload) ? $fileD = $soal['fileD'] : null;
            }
        } else {
            $filexD = $soal['fileD'];
        }

        if (isset($_FILES['fileE']['name']) && $_FILES['fileE']['name'] <> '') {
            $fileE = $_FILES['fileE']['name'];
            $temp = $_FILES['fileE']['tmp_name'];
            $size = $_FILES['fileE']['size'];
            $ext = explode('.', $fileE);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileE = 'files/' . $id_mapel . '_' . $nomor . '_E.' . $ext;
                $filexE = $id_mapel . '_' . $nomor . '_E.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileE);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexE','$id_mapel')");
                (!$upload) ? $fileE = $soal['fileE'] : null;
            }
        } else {
            $filexE = $soal['fileE'];
        }
            if($mapel['opsi']==3){
        $jawabanb = $_POST['jawabana'].', '.$_POST['jawabanb'].', '.$_POST['jawabanc'];
		}elseif($mapel['opsi']==4){
		$jawabanb = $_POST['jawabana'].', '.$_POST['jawabanb'].', '.$_POST['jawabanc'].', '.$_POST['jawaband'];
		}else{
		$jawabanb = $_POST['jawabana'].', '.$_POST['jawabanb'].', '.$_POST['jawabanc'].', '.$_POST['jawaband'].', '.$_POST['jawabane'];
		}
			$exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal',pilA='$pilA',pilB='$pilB',pilC='$pilC',pilD='$pilD',pilE='$pilE',jawaban='$jawabanb',pembahasan='$pembahasan',file='$urlx' WHERE id_soal='$idsoal' AND jenis='4'");
     
    }

 if ($jenis == '5') {
	
	  $pilA = addslashes($_POST['pilA']);
     $pilB = addslashes($_POST['pilB']);
     $pilC = addslashes($_POST['pilC']);
      $pilD = addslashes($_POST['pilD']);

        $pilE = addslashes($_POST['pilE']);
		$perA = addslashes($_POST['perA']);
        $perB = addslashes($_POST['perB']);
        $perC = addslashes($_POST['perC']);
        $perD = addslashes($_POST['perD']);
        $perE = addslashes($_POST['perE']);
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] <> '') {
            $file = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $size = $_FILES['file']['size'];
            $ext = explode('.', $file);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $url = 'files/' . $id_mapel . '_' . $nomor . '_1.' . $ext;
                $urlx = $id_mapel . '_' . $nomor . '_1.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $url);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$urlx','$id_mapel')");
                (!$upload) ? $url = $soal['file'] : null;
            }
        } else {
            $urlx = $soal['file'];
        }
        if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] <> '') {
            $file1 = $_FILES['file1']['name'];
            $temp = $_FILES['file1']['tmp_name'];
            $size = $_FILES['file1']['size'];
            $ext = explode('.', $file1);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $file1 = 'files/' . $id_mapel . '_' . $nomor . '_2.' . $ext;
                $filex1 = $id_mapel . '_' . $nomor . '_2.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $file1);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filex1','$id_mapel')");
                (!$upload) ? $file1 = $soal['file1'] : null;
            }
        } else {
            $filex1 = $soal['file1'];
        }
        if (isset($_FILES['fileA']['name']) && $_FILES['fileA']['name'] <> '') {
            $fileA = $_FILES['fileA']['name'];
            $temp = $_FILES['fileA']['tmp_name'];
            $size = $_FILES['fileA']['size'];
            $ext = explode('.', $fileA);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileA = 'files/' . $id_mapel . '_' . $nomor . '_A.' . $ext;
                $filexA = $id_mapel . '_' . $nomor . '_A.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileA);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexA','$id_mapel')");
                (!$upload) ? $fileA = $soal['fileA'] : null;
            }
        } else {
            $filexA = $soal['fileA'];
        }
        if (isset($_FILES['fileB']['name']) && $_FILES['fileB']['name'] <> '') {
            $fileB = $_FILES['fileB']['name'];
            $temp = $_FILES['fileB']['tmp_name'];
            $size = $_FILES['fileB']['size'];
            $ext = explode('.', $fileB);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileB = 'files/' . $id_mapel . '_' . $nomor . '_B.' . $ext;
                $filexB = $id_mapel . '_' . $nomor . '_B.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileB);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexB','$id_mapel')");
                (!$upload) ? $fileB = $soal['fileB'] : null;
            }
        } else {
            $filexB = $soal['fileB'];
        }
        if (isset($_FILES['fileC']['name']) && $_FILES['fileC']['name'] <> '') {
            $fileC = $_FILES['fileC']['name'];
            $temp = $_FILES['fileC']['tmp_name'];
            $size = $_FILES['fileC']['size'];
            $ext = explode('.', $fileC);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileC = 'files/' . $id_mapel . '_' . $nomor . '_C.' . $ext;
                $filexC = $id_mapel . '_' . $nomor . '_C.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileC);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexC','$id_mapel')");
                (!$upload) ? $fileC = $soal['fileC'] : null;
            }
        } else {
            $filexC = $soal['fileC'];
        }
        if (isset($_FILES['fileD']['name']) && $_FILES['fileD']['name'] <> '') {
            $fileD = $_FILES['fileD']['name'];
            $temp = $_FILES['fileD']['tmp_name'];
            $size = $_FILES['fileD']['size'];
            $ext = explode('.', $fileD);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileD = 'files/' . $id_mapel . '_' . $nomor . '_D.' . $ext;
                $filexD = $id_mapel . '_' . $nomor . '_D.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileD);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexD','$id_mapel')");
                (!$upload) ? $fileD = $soal['fileD'] : null;
            }
        } else {
            $filexD = $soal['fileD'];
        }

        if (isset($_FILES['fileE']['name']) && $_FILES['fileE']['name'] <> '') {
            $fileE = $_FILES['fileE']['name'];
            $temp = $_FILES['fileE']['tmp_name'];
            $size = $_FILES['fileE']['size'];
            $ext = explode('.', $fileE);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $fileE = 'files/' . $id_mapel . '_' . $nomor . '_E.' . $ext;
                $filexE = $id_mapel . '_' . $nomor . '_E.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $fileE);
                $que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexE','$id_mapel')");
                (!$upload) ? $fileE = $soal['fileE'] : null;
            }
        } else {
            $filexE = $soal['fileE'];
        }

       $jawabani = implode($_POST['jwb'], ', ');
        
            $exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal',pilA='$pilA',pilB='$pilB',pilC='$pilC',pilD='$pilD',pilE='$pilE',perA='$perA',perB='$perB',perC='$perC',perD='$perD',perE='$perE',jawaban='$jawabani',pembahasan='$pembahasan',file='$urlx' WHERE id_soal='$idsoal' AND jenis='5'");
    
    }
