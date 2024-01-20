<?php
if (!isset($_GET['id']) && !isset($_GET['no']) && !isset($_GET['jenis'])) :
	die("Anda tidak dizinkan mengakses langsung script ini!");
endif;
$nomor = $_GET['no'];
$jenis = $_GET['jenis'];
$id_mapel = $_GET['id'];

$nom = mysqli_fetch_array(mysqli_query($koneksi, "SELECT max(nomor) AS nomer FROM soal WHERE id_mapel='$id_mapel'"));
if($nom['nomer']==''){
$nomor = 1;
}else{
$nomor =$nom['nomer'] + 1;
}
$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
$idmap=$mapel['kode'];

$jumsoal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='$jenis'"));
$soalQ = mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='$jenis'");
$soal = mysqli_fetch_array($soalQ);
($soal['jawaban'] == 'A') ? $jwbA = 'checked' : $jwbA = '';
($soal['jawaban'] == 'B') ? $jwbB = 'checked' : $jwbB = '';
($soal['jawaban'] == 'C') ? $jwbC = 'checked' : $jwbC = '';
($soal['jawaban'] == 'D') ? $jwbD = 'checked' : $jwbD = '';
if ($mapel['opsi'] == 5) {
	($soal['jawaban'] == 'E') ? $jwbE = 'checked' : $jwbE = '';
}
?>
<div class='row'>
	<div class='col-md-12'>
	<div class='panel panel-default'>
               <div class="panel-heading" style="height:45px">
                    <div class='box-tools pull-right '>
					 
                    </div>
					<h4 class='box-title'><i class="fas fa-desktop"></i> Soal AKM</h4>
                </div>
				
				 <div class='box-body'>
		<form id='formsoal' action='' method='post' enctype='multipart/form-data'>
			<div class='box box-solid'>
				<div class='box-header with-border'>

					<div class='btn-group' style='margin-top:-5px'>
						<a class='btn btn-sm btn-warning'>Mapel </a>
						<a class='btn btn-sm btn-success'><?= $mapel['nama'] ?> </a>
						<a class='btn btn-sm btn-danger'>No Soal : <?= $nomor ?></a>
					</div>
					<div class='box-tools pull-right btn-group'>

						<button type='submit' name='simpansoal' onclick="tinyMCE.triggerSave(true,true);" class='btn btn-sm btn-primary'><i class='fa fa-check'></i> Simpan</button>
						<a href='?pg=<?= $pg ?>&ac=lihat&id=<?= $id_mapel ?>' class='btn btn-sm btn-danger'><i class='fa fa-times'></i></a>

					</div>
				</div><!-- /.box-header -->

				<div class='box-body'>
					<input type='hidden' name='mapel' value='<?= $id_mapel ?>'>
					<input type='hidden' name='jenis' value='<?= $jenis ?>'>
					<input type='hidden' name='nomor' value='<?= $nomor ?>'>
					
				
							
					
						<div class='col-md-12'>
						<h4 class='box-title'>SOAL MENJODOHKAN</h4>
								<div class='box-body pad'>
								
									<form>
										<textarea id='editor2' name='isi_soal' class='editor1' rows='10' cols='80' style='width:100%;'><?= $soal['soal'] ?></textarea>
									</form>
								</div>
							
							<?php if($mapel['pembahasan']==1){ ?>
							
							<h4 class='box-title'>PEMBAHASAN</h4>
								<div class='box-body pad'>
									
										<textarea id='bahasan' name='bahasan' class='editor1' rows='10' cols='80' style='width:100%;'><?= $soal['pembahasan'] ?></textarea>
									
								</div>
							
							<?php } ?>
						 </div> 
						<?php
						if ($jenis == '5') {
						?>
						  <div class='row'>
							<div class='col-md-6'>
								<div class='box-group' id='accordion'>
									<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseOne' aria-expanded='false' class='collapsed'>
													PERNYATAAN A
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseOne' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>
													<textarea name='perA' class='editor1 pilihan form-control'><?= $soal['perA'] ?></textarea>
												</div>
												<div class='form-group'>
												<?php
												if ($soal['fileA'] <> '') {
													$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
													$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
													$ext = explode(".", $soal['fileA']);
													$ext = end($ext);
													if (in_array($ext, $image)) {
														echo "
														<label>Gambar A</label><br />
														<img src='$homeurl/files/$soal[fileA]' style='max-width:80px;' />
														";
													} elseif (in_array($ext, $audio)) {
														echo "
														<label>Audio</label><br />
														<audio controls>
															<source src='$homeurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
														";
													} else {
														echo "File tidak didukung!";
													}
													echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileA&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
												}
						                       }
						                         ?>
												</div>
											</div>
										</div>
									</div>
									<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseB' aria-expanded='false' class='collapsed'>
													PERNYATAAN B
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseB' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>

													<textarea name='perB' class='editor1 pilihan form-control'><?= $soal['perB'] ?></textarea>
												</div>
												<div class='form-group'>
												<?php
												if ($soal['fileB'] <> '') {
													$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
													$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
													$ext = explode(".", $soal['fileB']);
													$ext = end($ext);
													if (in_array($ext, $image)) {
														echo "
														<label>Gambar B</label><br />
														<img src='$homeurl/files/$soal[fileB]' style='max-width:80px;' />
														";
													} elseif (in_array($ext, $audio)) {
														echo "
														<label>Audio</label><br />
														<audio controls>
															<source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
														";
													} else {
														echo "File tidak didukung!";
													}
													echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileB&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
												} else {
													echo "
														
														";
												}
												?>
												</div>
											</div>
										</div>
									</div>
									<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseC' aria-expanded='false' class='collapsed'>
													PERNYATAAN C
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseC' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>

													<textarea name='perC' class='editor1 pilihan form-control'><?= $soal['perC'] ?></textarea>
												</div>
												<div class='form-group'>
												<?php
												if ($soal['fileC'] <> '') {
													$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
													$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
													$ext = explode(".", $soal['fileC']);
													$ext = end($ext);
													if (in_array($ext, $image)) {
														echo "
														<label>Gambar C</label><br />
														<img src='$homeurl/files/$soal[fileC]' style='max-width:80px;' />
														";
													} elseif (in_array($ext, $audio)) {
														echo "
														<label>Audio</label><br />
														<audio controls>
															<source src='$homeurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
														";
													} else {
														echo "File tidak didukung!";
													}
													echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileC&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
												} else {
													echo "
														
														";
												}
												?>
												</div>
											</div>
										</div>
									</div>
									           
												<?php if ($mapel['opsi'] <>3) { ?>	
													
										<div class='panel box box-solid'>
											<div class='box-header with-border'>
												<h4 class='box-title'>
													<a data-toggle='collapse' data-parent='#accordion' href='#collapseD' aria-expanded='false' class='collapsed'>
														PERNYATAAN D
													</a>
												</h4>
												<div class='box-tools pull-right'>
												
												</div>
											</div>
											<div id='collapseD' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
												<div class='box-body'>
													<div class='form-group'>

														<textarea name='perD' class='editor1 pilihan form-control'><?= $soal['perD'] ?></textarea>
													</div>
													<div class='form-group'>
													<?php
													if ($soal['fileD'] <> '') {
														$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
														$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
														$ext = explode(".", $soal['fileD']);
														$ext = end($ext);
														if (in_array($ext, $image)) {
															echo "
															<label>Gambar D</label><br />
															<img src='$homeurl/files/$soal[fileD]' style='max-width:80px;' />
															";
														} elseif (in_array($ext, $audio)) {
															echo "
															<label>Audio</label><br />
															<audio controls>
																<source src='$homeurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
															";
														} else {
															echo "File tidak didukung!";
														}
														echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileD&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
													} else {
														echo "
															
															";
													}
													?>
													</div>
												</div>
											</div>
										</div>

										<?php } ?>
												<?php if ($mapel['opsi'] == 5) { ?>
													
										<div class='panel box box-solid'>
											<div class='box-header with-border'>
												<h4 class='box-title'>
													<a data-toggle='collapse' data-parent='#accordion' href='#collapseE' aria-expanded='false' class='collapsed'>
														PERNYATAAN E
													</a>
												</h4>
												<div class='box-tools pull-right'>
												
												</div>
											</div>
											<div id='collapseE' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
												<div class='box-body'>
													<div class='form-group'>

														<textarea name='perE' class='editor1 pilihan form-control'><?= $soal['perE'] ?></textarea>
													</div>
													<div class='form-group'>
													<?php
													if ($soal['fileE'] <> '') {
														$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
														$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
														$ext = explode(".", $soal['fileE']);
														$ext = end($ext);
														if (in_array($ext, $image)) {
															echo "
															<label>Gambar E</label><br />
															<img src='$homeurl/files/$soal[fileE]' style='max-width:80px;' />
															";
														} elseif (in_array($ext, $audio)) {
															echo "
															<label>Audio</label><br />
															<audio controls>
																<source src='$homeurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
															";
														} else {
															echo "File tidak didukung!";
														}
														echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileE&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
													} else {
														echo "
															
															";
													} ?>
													
													
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										</div>
										</div>	
												
												
												<div class='col-md-6'>
												<div class='box-group' id='accordion'>
									<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseAA' aria-expanded='false' class='collapsed'>
													PILIHAN JAWABAN A
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseAA' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>

													<textarea name='pilA' class='editor1 pilihan form-control'><?= $soal['pilA'] ?></textarea>
												</div>
												<div class='form-group'>
												<?php
												if ($soal['fileB'] <> '') {
													$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
													$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
													$ext = explode(".", $soal['fileB']);
													$ext = end($ext);
													if (in_array($ext, $image)) {
														echo "
														<label>Gambar B</label><br />
														<img src='$homeurl/files/$soal[fileB]' style='max-width:80px;' />
														";
													} elseif (in_array($ext, $audio)) {
														echo "
														<label>Audio</label><br />
														<audio controls>
															<source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
														";
													} else {
														echo "File tidak didukung!";
													}
													echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileB&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
												} else {
													echo "
														
														";
												}
												?>
												</div>
											</div>
										</div>
									</div>
												<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseBB' aria-expanded='false' class='collapsed'>
													PILIHAN JAWABAN B
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseBB' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>

													<textarea name='pilB' class='editor1 pilihan form-control'><?= $soal['pilB'] ?></textarea>
												</div>
												<div class='form-group'>
												<?php
												if ($soal['fileB'] <> '') {
													$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
													$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
													$ext = explode(".", $soal['fileB']);
													$ext = end($ext);
													if (in_array($ext, $image)) {
														echo "
														<label>Gambar B</label><br />
														<img src='$homeurl/files/$soal[fileB]' style='max-width:80px;' />
														";
													} elseif (in_array($ext, $audio)) {
														echo "
														<label>Audio</label><br />
														<audio controls>
															<source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
														";
													} else {
														echo "File tidak didukung!";
													}
													echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileB&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
												} else {
													echo "
														
														";
												}
												?>
												</div>
											</div>
										</div>
									</div>
									<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseCC' aria-expanded='false' class='collapsed'>
													PILIHAN JAWABAN C
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseCC' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>

													<textarea name='pilC' class='editor1 pilihan form-control'><?= $soal['pilC'] ?></textarea>
												</div>
												<div class='form-group'>
												<?php
												if ($soal['fileB'] <> '') {
													$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
													$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
													$ext = explode(".", $soal['fileB']);
													$ext = end($ext);
													if (in_array($ext, $image)) {
														echo "
														<label>Gambar B</label><br />
														<img src='$homeurl/files/$soal[fileB]' style='max-width:80px;' />
														";
													} elseif (in_array($ext, $audio)) {
														echo "
														<label>Audio</label><br />
														<audio controls>
															<source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
														";
													} else {
														echo "File tidak didukung!";
													}
													echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileB&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
												} else {
													echo "
														
														";
												}
												?>
												</div>
											</div>
										</div>
									</div>
												<?php if ($mapel['opsi'] <>3) { ?>	
										<div class='panel box box-solid'>
											<div class='box-header with-border'>
												<h4 class='box-title'>
													<a data-toggle='collapse' data-parent='#accordion' href='#collapseDD' aria-expanded='false' class='collapsed'>
														PILIHAN JAWABAN D
													</a>
												</h4>
												<div class='box-tools pull-right'>
												
												</div>
											</div>
											<div id='collapseDD' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
												<div class='box-body'>
													<div class='form-group'>

														<textarea name='pilD' class='editor1 pilihan form-control'><?= $soal['pilD'] ?></textarea>
													</div>
													<div class='form-group'>
													<?php
													if ($soal['fileD'] <> '') {
														$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
														$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
														$ext = explode(".", $soal['fileD']);
														$ext = end($ext);
														if (in_array($ext, $image)) {
															echo "
															<label>Gambar D</label><br />
															<img src='$homeurl/files/$soal[fileD]' style='max-width:80px;' />
															";
														} elseif (in_array($ext, $audio)) {
															echo "
															<label>Audio</label><br />
															<audio controls>
																<source src='$homeurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
															";
														} else {
															echo "File tidak didukung!";
														}
														echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileD&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
													} else {
														echo "
															
															";
													}
													?>
													</div>
												</div>
											</div>
										</div>

										
												<?php } ?>
												<?php if ($mapel['opsi'] == 5) { ?>
													
										<div class='panel box box-solid'>
											<div class='box-header with-border'>
												<h4 class='box-title'>
													<a data-toggle='collapse' data-parent='#accordion' href='#collapseEE' aria-expanded='false' class='collapsed'>
														PILIHAN JAWABAN E
													</a>
												</h4>
												<div class='box-tools pull-right'>
												
												</div>
											</div>
											<div id='collapseEE' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
												<div class='box-body'>
													<div class='form-group'>

														<textarea name='pilE' class='editor1 pilihan form-control'><?= $soal['pilE'] ?></textarea>
													</div>
													<div class='form-group'>
													<?php
													if ($soal['fileE'] <> '') {
														$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
														$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
														$ext = explode(".", $soal['fileE']);
														$ext = end($ext);
														if (in_array($ext, $image)) {
															echo "
															<label>Gambar E</label><br />
															<img src='$homeurl/files/$soal[fileE]' style='max-width:80px;' />
															";
														} elseif (in_array($ext, $audio)) {
															echo "
															<label>Audio</label><br />
															<audio controls>
																<source src='$homeurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
															";
														} else {
															echo "File tidak didukung!";
														}
														echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileE&jenis=$jenis' class='text-red'><i class='fa fa-times'></i> Hapus</a>";
													} else {
														echo "
															
															";
													}
													?>
													
													</div>
												</div>
											</div>
										</div>
										
												<?php } ?>
                                       </div>
										
												
												<br>
												<div class='col-md-14'>
								<div class='box-group' id='accordion'>
									<div class='panel box box-solid'>
									
										<div class='box-header with-border'>
											<div class='form-group'>
                                           
                                                <div class='col-md-6'>
                                                    <label style='color:red'>KUNCI 1</label>
                                                   <select name='jwb[]' class='form-control' >
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										<?php if ($mapel['opsi'] <>3) { ?>	
										<option value='D'> D </option>
										<?php } ?>
									   <?php if ($mapel['opsi'] == 5) { ?>
										<option value='E'> E </option>
										<?php } ?>
										</select>
                                                </div>
										
										<div class='form-group'>
                                                <div class='col-md-6'>
                                                    <label style='color:red'>KUNCI 2</label>
                                                    <select name='jwb[]' class='form-control' >
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										<?php if ($mapel['opsi'] <>3) { ?>	
										<option value='D'> D </option>
										<?php } ?>
										<?php if ($mapel['opsi'] == 5) { ?>
										<option value='E'> E </option>
										<?php } ?>
										</select>
                                                </div>
												<div class='form-group'>
                                                <div class='col-md-6'>
                                                    <label style='color:red'>KUNCI 3</label>
                                                     <select name='jwb[]' class='form-control' >
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										<?php if ($mapel['opsi'] <>3) { ?>	
										<option value='D'> D </option>
										<?php } ?>
										<?php if ($mapel['opsi'] == 5) { ?>
										<option value='E'> E </option>
										<?php } ?>
										</select>
                                                </div>
												<?php if ($mapel['opsi'] <>3) { ?>	
												<div class='form-group'>
                                                <div class='col-md-6'>
                                                    <label style='color:red'>KUNCI 4</label>
                                                     <select name='jwb[]' class='form-control' >
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										<option value='D'> D </option>
										<?php if ($mapel['opsi'] == 5) { ?>
										<option value='E'> E </option>
										<?php } ?>
										</select>
                                                </div>
												<?php } ?>
											<?php if ($mapel['opsi'] == 5) { ?>
					                         
													<div class='form-group'>
                                                <div class='col-md-6'>
                                                    <label style='color:red'>KUNCI 5</label>
                                                    <select name='jwb[]' class='form-control' >
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										<option value='D'> D </option>
										
										<option value='E'> E </option>
									
										</select>
                                                </div>
										</div>
								</div>
							</div>
						<?php	}
							?>
					</div>
				</div>
			</div>
			
		</form>
	</div>
</div>

<script>
	tinymce.init({
		selector: '.editor1',
		
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
		],

		toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
		fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
		paste_data_images: true,

		images_upload_handler: function(blobInfo, success, failure) {
			success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
		},
		image_class_list: [{
			title: 'Responsive',
			value: 'img-responsive'
		}],
	});
</script>


