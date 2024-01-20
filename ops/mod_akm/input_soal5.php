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
					<input type='hidden' name='kodek' value='PGM'>
					
				
							
					
						<div class='col-md-12'>
						<h4 class='box-title'>SOAL PG MULTI 3 OPSI</h4>
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
						 </div> <br>
						 <table class='table'>
						 <tr>
						 <td rowspan="2" class="text-center"><h4>Pernyataan </h4></td>
						 <td class="text-center"><h4>Baris Kolom A</h4></td>
						 <td class="text-center"><h4>Baris Kolom B</h4></td>
						 <td class="text-center"><h4>Baris Kolom C</h4></td>
						 </tr>
						
						 <tr>
						 
						 <td>
						 <div class='panel box box-solid'>
						<div class='box-header with-border'>
							<h4 class='box-title'>
								<a data-toggle='collapse' data-parent='#accordion' href='#collapseAA' aria-expanded='false' class='collapsed'>
													Baris Kolom A
												</a>
											</h4>											
										</div>
										<div id='collapseAA' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>
													<textarea name='perA' class='editor1 pilihan form-control' required='true'><?= $soal[perA] ?></textarea>
												</div>
											</div>
										</div>
									</div>
						 </td>
						 <td>
						 <div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseBB' aria-expanded='false' class='collapsed'>
													Baris Kolom B
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseBB' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>

													<textarea name='perB' class='editor1 pilihan form-control' required='true'><?= $soal[perB] ?></textarea>
												</div>
											</div>
										</div>
									</div>
						 </td>
						 <td>
						 <div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseCC' aria-expanded='false' class='collapsed'>
													Baris Kolom C
												</a>
											</h4>
											<div class='box-tools pull-right'>
												
											</div>
										</div>
										<div id='collapseCC' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>

													<textarea name='perC' class='editor1 pilihan form-control' required='true'><?= $soal[perC] ?></textarea>
												</div>
											</div>
										</div>
									</div>
						 </td>
						 </tr>
						 
						 <tr>
						 <td colspan="3">
						 <div class='box-group' id='accordion'>
									<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseOne' aria-expanded='false' class='collapsed'>
													Pernyataan 1
												</a>
											</h4>
										</div>
										<div id='collapseOne' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>
													<textarea name='pilA' class='editor1 pilihan form-control'><?= $soal['pilA'] ?></textarea>
												</div>
												</div>
											</div>
											</div>
										</td>
										<td class="text-center">
										<label>Kunci Jawaban Pernyataan 1</label>
										<select name='jawaban[]' class='form-control' >
										<option value=''>  </option>
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										</select>
										</td></tr>																
										<tr><td colspan="3">
										<div class='box-group' id='accordion'>
									<div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseB' aria-expanded='false' class='collapsed'>
													Pernyataan 2
												</a>
											</h4>											
										</div>
										<div id='collapseB' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>
													<textarea name='pilB' class='editor1 pilihan form-control'><?= $soal[pilB] ?></textarea>
												</div>
												</div>
										      </div>
												</div>											  
											   </td>
											   <td class="text-center" >
											   <label>Kunci Jawaban Pernyataan 2</label>
										<select name='jawaban[]' class='form-control' >
										<option value=''>  </option>
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										</select>
										</td></tr>										
										<tr><td colspan="3">
											   <div class='box-group' id='accordion'>
											  <div class='panel box box-solid'>
										<div class='box-header with-border'>
											<h4 class='box-title'>
												<a data-toggle='collapse' data-parent='#accordion' href='#collapseC' aria-expanded='false' class='collapsed'>
													Pernyataan 3
												</a>
											</h4>
										</div>
										<div id='collapseC' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
											<div class='box-body'>
												<div class='form-group'>
													<textarea name='pilC' class='editor1 pilihan form-control'><?= $soal[pilC] ?></textarea>
												</div>
												</div>
										      </div>
												</div>	
											   </td>
											   <td class="text-center">
											   <label>Kunci Jawaban Pernyataan 3</label>
										<select name='jawaban[]' class='form-control' >
										<option value=''>  </option>
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										</select>
										</td></tr>	
                                       <?php if($mapel['opsi']<>3){ ?>										
										<tr><td colspan="3">	  
											<div class='box-group' id='accordion'>
						                 <div class='panel box box-solid'>
											<div class='box-header with-border'>
												<h4 class='box-title'>
													<a data-toggle='collapse' data-parent='#accordion' href='#collapseD' aria-expanded='false' class='collapsed'>
														Pernyataan 4
													</a>
												</h4>
											</div>
											<div id='collapseD' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
												<div class='box-body'>
													<div class='form-group'>

														<textarea name='pilD' class='editor1 pilihan form-control'><?= $soal[pilD] ?></textarea>
													</div>
												 </div>
										        </div>	
												</div>
											   </td>
											   <td class="text-center" >
											   <label>Kunci Jawaban Pernyataan 4</label>
										<select name='jawaban[]' class='form-control' >
										<option value=''>  </option>
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										</select>
										</td></tr>
										<?php } ?>
										<?php if($mapel['opsi']==5){ ?>
										<tr><td colspan="3">											  
												<div class='panel box box-solid'>
											<div class='box-header with-border'>
												<h4 class='box-title'>
													<a data-toggle='collapse' data-parent='#accordion' href='#collapseE' aria-expanded='false' class='collapsed'>
														Pernyataan 5
													</a>
												</h4>
											</div>
											<div id='collapseE' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
												<div class='box-body'>
													<div class='form-group'>
														<textarea name='pilE' class='editor1 pilihan form-control'><?= $soal[pilE] ?></textarea>
													</div>
												 </div>
										        </div>
											   </div>																										
						                    </td>
						                  <td class="text-center" >
										  <label>Kunci Jawaban Pernyataan 5</label>
										<select name='jawaban[]' class='form-control' >
										<option value=''>  </option>
										<option value='A'> A </option>
										<option value='B'> B </option>
										<option value='C'> C </option>
										</select>
										</td></tr>
										<?php } ?>
						 </table>
						 
						 
						 
						
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


