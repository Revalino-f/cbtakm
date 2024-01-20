<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
require("../../config/excel_reader2.php");
 require_once '../../PHPExcel/PHPExcel/Reader/Excel5.php';
$idmapel=$_POST['idmapel'];
  
 $nomer = $_POST['nomer'];
if($nomer==''){
$nomer=0;
}	
 
if (isset($_FILES['file']['name'])) {
    
        $file = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $ext = explode('.', $file);
        $ext = end($ext);
		
        if ($ext <> 'xls') {
            echo "harap pilih file excel .xls";
        } else {
            $data = new Spreadsheet_Excel_Reader($temp);
            $hasildata = $data->rowcount($sheet_index = 0);
            $sukses = $gagal = 0;
         

            for ($i = 5; $i <= $hasildata; $i++) :
                $no = $data->val($i, 1);
				
                $soal = addslashes($data->val($i, 2));
                $gambar = addslashes($data->val($i, 3));
                $num = addslashes($data->val($i, 4));
                $pil = addslashes($data->val($i, 5));
                $opsi = addslashes($data->val($i, 6));
                $per = addslashes($data->val($i, 7));
				$jenis = addslashes($data->val($i, 8));
                $kode = addslashes($data->val($i, 9));
                $jawab = addslashes($data->val($i, 10));
               
                $nomor = $nomer+$no; 
				
            
 
			 if ($soal <> '') {
                    $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,jenis,kode,jawaban) VALUES ('$idmapel','$no','$soal','$jenis','$kode','$jawab')");
			 } 
			  if ($gambar <> '') {
                    $exec = mysqli_query($koneksi, "INSERT INTO temp_pil (idmapel,nomor) VALUES ('$idmapel','$no')");
			 } 
			 if ($pil == 'A'):
				  $exec = mysqli_query($koneksi, "UPDATE soal SET pilA='$opsi',perA='$per' WHERE id_mapel='$idmapel' AND nomor='$num'");
				
				elseif ($pil == 'B'):
				 $exec = mysqli_query($koneksi, "UPDATE soal SET pilB='$opsi',perB='$per' WHERE id_mapel='$idmapel' AND nomor='$num'");
				
                elseif ($pil == 'C'):
				 $exec = mysqli_query($koneksi, "UPDATE soal SET pilC='$opsi',perC='$per' WHERE id_mapel='$idmapel' AND nomor='$num'");
				
               elseif ($pil == 'D'):
				 $exec = mysqli_query($koneksi, "UPDATE soal SET pilD='$opsi',perD='$per' WHERE id_mapel='$idmapel' AND nomor='$num'");
				
                 elseif ($pil == 'E'):
				 $exec = mysqli_query($koneksi, "UPDATE soal SET pilE='$opsi',perE='$per' WHERE id_mapel='$idmapel' AND nomor='$num'");
			
			endif; 
            endfor;
		}
		

		$objReader = new PHPExcel_Reader_Excel5($temp);
  $dataQ = $objReader->load($_FILES['file']['tmp_name']);
  $objData = $dataQ->getActiveSheet();
  $dataArray = $objData->toArray();
    for ($a=1; $a < $dataArray ; $a++) {
		 $objData = $dataQ->getActiveSheet();
		 
        foreach ($objData->getDrawingCollection() as $gbr) {
			   
          $string = $gbr->getCoordinates();
          $coord = PHPExcel_Cell::coordinateFromString($string);
		if ($gbr instanceof PHPExcel_Worksheet_MemoryDrawing) {
          $image = $gbr->getImageResource();
          $img = $gbr->getIndexedFilename();
		   $ext = explode('.', $img);
            $ext = end($ext);
			$gb = rand(1, 10000) . '.' . $ext;
          imagejpeg($image, '../../files/'. $gb);
	
		
		}
		
       $exec = mysqli_query($koneksi, "INSERT INTO temp_file (id_mapel,nama_file) VALUES ('$idmapel','$gb')");
	   $exec = mysqli_query($koneksi, "INSERT INTO file_pendukung (id_mapel,nama_file) VALUES ('$idmapel','$gb')");
	
		}
	 break;
	 
	}
		
			
		}

	
?>		   
<?php	
   
	$queryxs = mysqli_query($koneksi, "select * from temp_pil JOIN temp_file ON temp_file.id_file=temp_pil.id 
	WHERE idmapel='$idmapel'");
     while ($nom = mysqli_fetch_array($queryxs)):
     $nomer = $nom['nomor'] ;
	 
	
	 $exec = mysqli_query($koneksi, "INSERT INTO temp_soal (id_mapel,nomor,idfile,file) VALUES ('$nom[idmapel]','$nomer','$nom[id]','$nom[nama_file]')");	
	 
	 endwhile;
?>

<?php

	 $query = mysqli_query($koneksi, "select * from temp_soal WHERE id_mapel='$idmapel'");
         while ($filex = mysqli_fetch_array($query)){
	    
	 $exec = mysqli_query($koneksi, "UPDATE soal SET file='$filex[file]' WHERE id_mapel='$filex[id_mapel]' AND nomor='$filex[nomor]'");
	
	if($exec){
	mysqli_query($koneksi, "truncate temp_file");
    mysqli_query($koneksi, "truncate temp_pil");
	mysqli_query($koneksi, "truncate temp_soal");
	}
		 }	
?>		
		
	
			