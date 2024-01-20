<?php
	require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");

	
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:login.php'):null;
	$id_mapel = $_GET['id'];
	
	$pengawas = fetch($koneksi, 'pengawas',array('id_pengawas'=>$id_pengawas));
	$mapel=mysqli_fetch_array(mysqli_query($koneksi, "select * from mapel where id_mapel='$id_mapel'"));
	if($mapel['idpk']=='0'){
		$jurusan='Semua Jurusan';
	}else{
		$jurusan=$mapel['idpk'];
	}
	$guru = fetch($koneksi, 'pengawas',array('id_pengawas'=>$mapel['idguru']));
	$jenis = fetch($koneksi, 'jenis', array('status' => 'aktif'));
	$namasekolah=fetch($koneksi, 'setting');
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}
	elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}
	?>
	
		<!DOCTYPE html>
		<html>
			<head>
				<title>	Print Soal</title>
				<style>
		* {
			margin: auto;
			padding: 0;
			line-height: 100%;
		}

		td {
			padding: 1px 3px 1px 3px;
		}

		.garis {
			border: 1px solid #000;
			border-left: 0px;
			border-right: 0px;
			padding: 1px;
			margin-top: 5px;
			margin-bottom: 5px;
		}
	</style>
			</head>
			<body>
				
			<table style="width:100%">
                                <tr>
                                    <td rowspan='4' width='120' align='center'>
                                        <img src='<?php echo $homeurl . '/dist/img/diknas.png' . '?date=' . time(); ?>' width='80'>
                                    </td>
                                    <td colspan='2' align='center'>
                                        <font size='+1'>
                                            <b>LEMBAR SOAL <?php echo strtoupper ($jenis['nama']) ?></b>
                                        </font>
                                    </td>
                                    <td rowspan='7' width='120' align='center'><img src='../../<?= $setting['logo'] ?>' width='80'></td>
                                </tr>
                                <tr>
                                    <td colspan='2' align='center'>
                                        <font size='+1'><b><?= $setting['sekolah'] ?></b></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='2' align='center'>
                                        <font size='+1'><b>TAHUN PELAJARAN <?= $ajaran ?></b></font>
                                    </td>
                                </tr>
								<tr>
                                    <td colspan='2' align='center'>
                                        <font size='+1'><b>KABUPATEN <?php echo strtoupper($setting['kota']) ?> PROVNSI <?php echo strtoupper ($setting['provinsi'])?></b></font>
                                    </td>
                                </tr>
                            </table>
<div class='garis'></div>
<table style="width:100%">
<td width=2000>Mata Pelajaran </td>
			<td width=2000>: <?= $mapel['nama'] ?> </td>
			<td rowspan='5' width=900></td>
		</tr>
		<tr>
			<td>Tingkat | Jurusan </td>
			<td>: <?= $mapel['level'] ?> | <?php

											foreach (unserialize($mapel['idpk']) as $pk) {
												echo $pk . " ";
											} ?> </td>
		</tr>
		<tr>
			<td>Pembuat Soal</td>
			<td>: <?= $guru['nama'] ?></td>
		</tr>
		</table>
		<div class='garis'></div>
			
				<br/>
				
			 <table  class='table'>
                                        <tbody>
                                            <?php $soalq = mysqli_query($koneksi, "SELECT * FROM soal where id_mapel='$id_mapel'  order by nomor "); ?>
                                            <?php while ($soal = mysqli_fetch_array($soalq)) : ?>

                                                <tr>
                                                    <td style='width:30px'>
                                                        <?= $soal['nomor'] ?>
                                                    </td>
                                                    <td style="text-align:justify">
                                                        <?php
                                                        if ($soal['file'] <> '') :
                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                            $ext = explode(".", $soal['file']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $image)) {
                                                                echo "<p style='margin-bottom: 5px'><img src='$homeurl/files/$soal[file]' style='max-width:100px;'/></p>";
                                                            } elseif (in_array($ext, $audio)) {
                                                                echo "<p style='margin-bottom: 5px'><audio controls><source src='$homeurl/files/$soal[file]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        endif;
                                                        ?>
                                                        <?= $soal['soal']; ?>
                                                        <?php
                                                        if ($soal['file1'] <> '') :
                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                            $ext = explode(".", $soal['file1']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $image)) {
                                                                echo "<p style='margin-top: 5px'><img src='$homeurl/files/$soal[file1]' style='max-width:200px;' /></p>";
                                                            } elseif (in_array($ext, $audio)) {
                                                                echo "<p style='margin-top: 5px'><audio controls><source src='$homeurl/files/$soal[file1]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        endif;
                                                        ?>
														<?php if ($soal['jenis'] == '1') : ?>
                                                        <table width="100%">
                                                            <tr>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
                                                                <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                    <?php
                                                                    if ($soal['pilA'] <> '') {
                                                                        echo "$soal[pilA] ";
                                                                    }

                                                                    if ($soal['fileA'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soal['fileA']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo "<img src='$homeurl/files/$soal[fileA]' style='max-width:100px;'/>";
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo "<audio controls><source src='$homeurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                        } else {
                                                                            echo "File tidak didukung!";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
                                                                <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                    <?php
                                                                    if (!$soal['pilC'] == "") {
                                                                        echo "$soal[pilC] ";
                                                                    }

                                                                    if ($soal['fileC'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soal['fileC']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo "<img src='$homeurl/files/$soal[fileC]' style='max-width:100px;' />";
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo "<audio controls><source src='$homeurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                        } else {
                                                                            echo "File tidak didukung!";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php if ($namamapel['opsi'] == 5) : ?>
                                                                    <td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
                                                                    <td style="padding: 3px; vertical-align: text-top;">
                                                                        <?php
                                                                        if (!$soal['pilE'] == "") {
                                                                            echo "$soal[pilE] ";
                                                                        }

                                                                        if ($soal['fileE'] <> '') {
                                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                            $ext = explode(".", $soal['fileE']);
                                                                            $ext = end($ext);
                                                                            if (in_array($ext, $image)) {
                                                                                echo "<img src='$homeurl/files/$soal[fileE]' style='max-width:100px;' />";
                                                                            } elseif (in_array($ext, $audio)) {
                                                                                echo "<audio controls><source src='$homeurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                            } else {
                                                                                echo "File tidak didukung!";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endif; ?>

                                                            </tr>

                                                            <tr>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
                                                                <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                    <?php
                                                                    if (!$soal['pilB'] == "") {
                                                                        echo "$soal[pilB] ";
                                                                    }

                                                                    if ($soal['fileB'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soal['fileB']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo "<img src='$homeurl/files/$soal[fileB]' style='max-width:100px;' />";
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo "<audio controls><source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                        } else {
                                                                            echo "File tidak didukung!";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php if ($namamapel['opsi'] <> 3) : ?>
                                                                    <td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
                                                                    <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                        <?php
                                                                        if (!$soal['pilD'] == "") {
                                                                            echo "$soal[pilD] ";
                                                                        }

                                                                        if ($soal['fileD'] <> '') {
                                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                            $ext = explode(".", $soal['fileD']);
                                                                            $ext = end($ext);
                                                                            if (in_array($ext, $image)) {
                                                                                echo "<img src='$homeurl/files/$soal[fileD]' style='max-width:100px;' />";
                                                                            } elseif (in_array($ext, $audio)) {
                                                                                echo "<audio controls><source src='$homeurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                            } else {
                                                                                echo "File tidak didukung!";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                <?php endif; ?>

                                                            </tr>

                                                        </table>														
														<?php endif; ?>
															<?php if ($soal['jenis'] == '3' AND $soal['kode'] == 'PGM') : ?>
													 <table width="100%" class='table'>
													 <tr>
															<td rowspan="2" class="text-center" ><br><b>Pernyataan</b></td>
															<td class="text-center" width="15%" ><b>Jawaban A</b></td>
															<td class="text-center" width="15%" ><b>Jawaban B</b></td>
															<td class="text-center" width="15%" ><b>Jawaban C</b></td>
															</tr>
                                                            <tr>
															
															<td><?= $soal['perA'] ?></td>
															<td><?= $soal['perB'] ?></td>
															<td><?= $soal['perC'] ?></td>
															</tr>
															<tr>
															<td><?= $soal['pilA'] ?></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
															</tr>
															<tr>
															<td><?= $soal['pilB'] ?></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
															</tr>
															<tr>
															<td><?= $soal['pilC'] ?></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
															</tr>
															<tr>
															<td><?= $soal['pilD'] ?></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															</tr>
															<?php if($setting['jenjang']=='SMK' OR $setting['jenjang']=='SMA'){ ?>
															<tr>
															<td><?= $soal['pilE'] ?></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													
													<?php if ($soal['jenis'] == '3' AND $soal['kode'] == '') : ?>
													 <table width="100%">
													 <tr>
														      <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
															 <td style="padding: 3px;width: 31%; vertical-align: text-top;"><?= $soal['pilA'] ?></td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
															 <td style="padding: 3px;width: 31%; vertical-align: text-top;"> <?= $soal['pilB'] ?></td>
															
															</tr>
															 <tr>
														      <td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
															 <td style="padding: 3px;width: 31%; vertical-align: text-top;"><?= $soal['pilC'] ?></td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
															 <td style="padding: 3px;width: 31%; vertical-align: text-top;"> <?= $soal['pilD'] ?></td>
															
															</tr>
															<?php if($setting['jenjang']=='SMK' OR $setting['jenjang']=='SMA'){ ?>
															<tr>
														      <td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
															 <td style="padding: 3px;width: 31%; vertical-align: text-top;"><?= $soal['pilE'] ?></td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"></td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"></td>
															 <td style="padding: 3px;width: 31%; vertical-align: text-top;"> </td>
															
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													
													<?php if ($soal['jenis'] == '4' AND $soal['kode'] == 'FO') : ?>
													 <table width="100%" class='table'>
													 <tr>
															<td class="text-center" ><b>Pernyataan</b></td>
															<td class="text-center" width="5%" ><b>Fakta</b></td>
															<td class="text-center" width="5%" ><b>Opini</b></td>
															
															</tr>
                                                           
															<tr>
															<td><?= $soal['pilA'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
															
															</tr>
															<tr>
															<td><?= $soal['pilB'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
															
															</tr>
															<tr>
															<td><?= $soal['pilC'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
															
															</tr>
															<tr>
															<td><?= $soal['pilD'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															
															</tr>
															<?php if($setting['jenjang']=='SMK' OR $setting['jenjang']=='SMA'){ ?>
															<tr>
															<td><?= $soal['pilE'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													
													<?php if ($soal['jenis'] == '4' AND $soal['kode'] == '') : ?>
													 <table width="100%" class='table'>
													 <tr>
															<td class="text-center" ><b>Pernyataan</b></td>
															<td class="text-center" width="5%" ><b>Benar</b></td>
															<td class="text-center" width="5%" ><b>Salah</b></td>
															
															</tr>
                                                           
															<tr>
															<td><?= $soal['pilA'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
															
															</tr>
															<tr>
															<td><?= $soal['pilB'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
															
															</tr>
															<tr>
															<td><?= $soal['pilC'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
															
															</tr>
															<tr>
															<td><?= $soal['pilD'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															
															</tr>
															<?php if($setting['jenjang']=='SMK' OR $setting['jenjang']=='SMA'){ ?>
															<tr>
															<td><?= $soal['pilE'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													<?php if ($soal['jenis'] == '5') : ?>
													 <table width="100%" class='table'>
													       <tr>
														  
															<td class="text-center" ><b>Pernyataan</b></td>	
															<td class="text-center" width="5%" ><b></b></td>	
															<td class="text-center" width="5%" ><b></b></td>	
                                                            <td class="text-center" ><b>Jawaban</b></td>	
																													
															</tr>
                                                           
															<tr>															
															<td><?= $soal['perA'] ?></td>															
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><?= $soal['pilA'] ?></td>															
															</tr>
															<tr>															
															<td><?= $soal['perB'] ?></td>															
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><?= $soal['pilB'] ?></td>															
															</tr>
															<tr>															
															<td><?= $soal['perC'] ?></td>															
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><?= $soal['pilC'] ?></td>															
															</tr>
															<tr>															
															<td><?= $soal['perD'] ?></td>															
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><?= $soal['pilD'] ?></td>															
															</tr>
															<?php if($setting['jenjang']=='SMK' OR $setting['jenjang']=='SMA'){ ?>
															<tr>															
															<td><?= $soal['perE'] ?></td>															
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><?= $soal['pilE'] ?></td>															
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													
                                                       
                                                    </td>
													
													
                                                    <td width='10%'>
													  <button data-id="<?= $soal['id_soal'] ?>" class="hapus btn-sm btn btn-danger"><i class="fas fa-times"></i></button>
                                                     
                                                   <?php if($soal['jenis']==3 AND $soal['kode']==''){ ?>
												   <a href="?pg=editsoal3&id_soal=<?php echo $soal['id_soal'] ?>" class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></button></a>
												   <?php } ?>
												    <?php if($soal['jenis']==3 AND $soal['kode']=='PGM'){ ?>
												   <a href="?pg=editsoal7&id_soal=<?php echo $soal['id_soal'] ?>" class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></button></a>
												   <?php } ?>
												    <?php if($soal['jenis']==1){ ?>
												   <a href="?pg=editsoal1&id_soal=<?php echo $soal['id_soal'] ?>" class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></button></a>
												   <?php } ?>
												   <?php if($soal['jenis']==2){ ?>
												   <a href="?pg=editsoal2&id_soal=<?php echo $soal['id_soal'] ?>" class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></button></a>
												   <?php } ?>
												    <?php if($soal['jenis']=='4' AND $soal['kode']==''){ ?>
												   <a href="?pg=editsoal4&id_soal=<?php echo $soal['id_soal'] ?>" class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></button></a>
												   <?php } ?>
												   <?php if($soal['jenis']=='4' AND $soal['kode']=='FO'){ ?>
												   <a href="?pg=editsoal6&id_soal=<?php echo $soal['id_soal'] ?>" class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></button></a>
												   <?php } ?>
												   <?php if($soal['jenis']==5){ ?>
												   <a href="?pg=editsoal5&id_soal=<?php echo $soal['id_soal'] ?>" class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></button></a>
												   <?php } ?>
												  
												  </td>
													
                                                </tr>
                                                
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
			