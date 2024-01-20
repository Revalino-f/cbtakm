<?php

require("../../config/koneksi.php");
require("../../config/function.php");
require("../../config/crud.php");
require_once '../../PHPExcel/PHPExcel/Reader/Excel5.php';
$idmapel=$_POST['idmapel'];

$nomer = $_POST['nomer'];
if($nomer==''){
$nomer=0;
}
 $fileUpl = $_FILES['xls']['name'];
 
  $objReader = new PHPExcel_Reader_Excel5($fileUpl);
  $data = $objReader->load($_FILES['xls']['tmp_name']);
  $objData = $data->getActiveSheet();
  $dataArray = $objData->toArray();
    for ($i=1; $i < count($dataArray) ; $i++) {
		 $objData = $data->getActiveSheet();
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
		
	    
		$nomor = ($nomer + $i);
		
		 $soal = $dataArray[$i]['1'];
		 $soalg = $dataArray[$i]['2'];
		 $pilA = $dataArray[$i]['3'];
		 $pilB = $dataArray[$i]['4'];
		 $pilC = $dataArray[$i]['5'];
		 $pilD = $dataArray[$i]['6'];
		 $pilE = $dataArray[$i]['7'];
		 $perA = $dataArray[$i]['8'];
		 $perB = $dataArray[$i]['9'];
		 $perC = $dataArray[$i]['10'];
		 $perD = $dataArray[$i]['11'];
		 $perE = $dataArray[$i]['12'];
		 $jenis = $dataArray[$i]['13'];
		 $kode = $dataArray[$i]['14'];
		 $kunci = $dataArray[$i]['15'];
		
       $i++;
		}
	$data=[
	   'nomor'=>$nomor,
	   'id_bank'=>$idmapel,
	   'soal'=>$soal,
	   'pilA'=>$pilA,
	   'pilB'=>$pilB,
	   'pilC'=>$pilC,
	   'pilD'=>$pilD,
	   'pilE'=>$pilE,
	   'perA'=>$perA,
	   'perB'=>$perB,
	   'perC'=>$perC,
	   'perD'=>$perD,
	   'perE'=>$perE,
	   'jenis'=>$jenis,
	   'kode'=>$kode,
	   'jawaban'=>$kunci,
	   'file'=>$gb
	];
	
      $exec = insert($koneksi,'soal',$data);
	
		$fil=$koneksi->query("INSERT INTO file_pendukung(id_bank,nama_file) VALUES('$idmapel','$gb')");
		   
	}
	
	
	 break;
	 
	}
	