<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
$value = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id'"));
$tgl_ujian = explode(' ', $value['tgl_ujian']);
if ($ac == '') :
?>
    <div class='row'>
        <div class='col-md-12'><?= $pesan ?>
            <div class='box box-solid '>
                <div class='box-header with-border '>
                    <h3 class='box-title'><i class='fa fa-briefcase'></i> Data Bank Soal</h3>
                    <div class='box-tools pull-right '>
					<?php if ($setting['server'] == 'pusat') { ?>
						 <button id='btnhapusbank' class='btn btn-sm btn-danger' data-placement="top" data-toggle="tooltip" data-original-title="Hapus Bank Soal"><i class='fa fa-trash'></i> <span class='hidden-xs'></span></button>                            
							<button class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-target='#tambahbanksoal'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah</span></button>
					<?php } ?>
                    </div>
					 </div>
                <div class='box-body'>
                    <div id='tablereset' class='table-responsive'>
                        <table id='example1' class='table table-bordered table-hover'>
                            <thead>
                                <tr>
                                    <th width='5px'><input type='checkbox' id='ceksemua'></th>
                                    <th width='5px'>No</th>
									<th width='10%'>Kode</th>
									<th width='10%'>Level</th>
                                    <th>Mata Pelajaran</th>
								<th width='10%'>Group Soal</th>
                                        <th width='10%'>Status</th>								
                                      <th>Pengampu</th>	
                                     <th class="text-center">Action</th>									  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pengawas['level'] == 'admin') :
                                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY date ASC");
                                elseif ($pengawas['level'] == 'guru') :
                                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel WHERE idguru='$pengawas[id_pengawas]'  ORDER BY date ASC");
                                endif;
                                ?>
                                <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                                    <?php
                                    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$mapel[id_mapel]'"));
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $mapel['id_mapel'] ?>"></td>
                                        <td><small class='label label-primary'><?= $no ?></small></td>
                                           <td><?= $mapel['kode'] ?></td>
										   <td><?= $mapel['level'] ?></td>
                                           <td><?= $mapel['nama'] ?></td>
                                           <td><?= $mapel['groupsoal'] ?></td>
                                                
												<td>
                                            <?php

                                            if ($cek <> 0) {
                                                if ($mapel['status'] == '0') :
                                                    $status = 'non aktif';
                                                else :
                                                    $status = 'aktif';
                                                endif;
                                            } else {
                                                $status = 'Soal Kosong';
                                            }
                                            $guruku = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas = '$mapel[idguru]'"));
                                            ?>
											 <?= $status ?>
                                                  </td>
												  <td><?= $guruku['nama'] ?></td>
												<td class="text-center">  
                                                        
                                               <a href='?pg=<?= $pg ?>&ac=lihat&id=<?= $mapel['id_mapel'] ?>' class='btn  btn-sm btn-warning' data-placement="top" data-toggle="tooltip" data-original-title="Buat Soal"><i class='fa fa-search'></i></button></a>
											   <?php if ($setting['server'] == 'pusat') { ?> 
											  <a href='?pg=<?= $pg ?>&ac=upload11&id=<?= $mapel['id_mapel'] ?>' class='btn  btn-sm btn-success' data-placement="top" data-toggle="tooltip" data-original-title="Import Soal"><i class='fa fa-upload'></i></button></a>              
                                                                                          
											  <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#editbanksoal<?= $mapel['id_mapel'] ?>'><i class='fa fa-edit'></i> Edit</button>                             
												<?php } ?>
									   </td>
                                    </tr>

                                    <div class='modal fade' id='editbanksoal<?= $mapel['id_mapel'] ?>' style='display: none;'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                              <div class='modal-header bg-blue'>
                                                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                                    <h3 class='modal-title'>Edit Bank Soal</h3>
                                                </div>												
                                                <form id="formeditbank<?= $mapel['id_mapel'] ?>">
				                                <div class="panel-body">
                                                    <div class='modal-body'>
											<input type='hidden' name='idm' value='<?= $mapel['id_mapel'] ?>' />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    <label for="">Kode Bank Soal</label>
                                    <input type="text" class="form-control" name="kode" value='<?= $mapel['kode'] ?>' required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class='form-group-sm'>
                                    <label>Mata Pelajaran</label>
                                    <select name='nama' class='form-control' required='true'>
                                         <option value=''></option>
                                                                        <?php
                                                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
                                                                        while ($pk = mysqli_fetch_array($pkQ)) : ($pk['kode_mapel'] == $mapel['nama']) ? $s = 'selected' : $s = '';
                                                                            echo "<option value='$pk[kode_mapel]' $s>$pk[nama_mapel]</option>";
                                                                        endwhile;
                                                                        ?>
                                                                    </select>
																</div>
															</div>
														</div>

                        <?php if ($setting['jenjang']=='SMA' OR $setting['jenjang']=='SMK') : ?>
                            <div class='form-group-sm'>
                                <label>Program Keahlian</label>
                                <select name='id_pk[]' class='form-control select2' multiple="multiple" style='width:100%' required='true'>
                                   <option value='semua'>Semua</option>
                                                                    <?php
                                                                    $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                                                    while ($pk = mysqli_fetch_array($pkQ)) :
                                                                        if (in_array($pk['id_pk'], unserialize($mapel['idpk']))) : ?>
                                                                            <option value="<?= $pk['id_pk'] ?>" selected><?= $pk['id_pk'] ?></option>"
                                                                        <?php else : ?>
                                                                            <option value="<?= $pk['id_pk'] ?>"><?= $pk['id_pk'] ?></option>"
                                                                        <?php endif; ?>
                                                                    <?php endwhile;
                                                                    ?>
                                                                </select>
                                                            </div>
															
                                                        <?php endif; ?>
														
                        <div class='form-group-sm'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>Level Soal</label>
                                    <select name='level' id='level' class='form-control' required='true'>
                                        <option value='semua'>Semua Level</option>
                                                                        <?php
                                                                        $lev = mysqli_query($koneksi, "SELECT * FROM level");
                                                                        while ($level = mysqli_fetch_array($lev)) : ($level['kode_level'] == $mapel['level']) ? $s = 'selected' : $s = '';
                                                                            echo "<option value='$level[kode_level]' $s>$level[kode_level]</option>";
                                                                        endwhile;
                                                                        ?>
                                                                    </select>
                                </div>
                                <div class='col-md-6'>
                                    <label>Pilih Kelas</label><br>
                                    <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                                                                        <option value='semua'>Semua Kelas</option>
                                                                        <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                                        <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                                            <?php if (in_array($kelas['id_kelas'], unserialize($mapel['kelas']))) : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endwhile ?>
                                                                    </select>
                                </div>
                          </div>
						  </div>
                       <div class='form-group-sm'>
                               
                                    <label>Group Soal</label>
                                    <select name='groupsoal' class='form-control' required>
									<option value='<?= $mapel[groupsoal] ?>'><?= $mapel['groupsoal'] ?></option>
                                        <option value='Literasi'>Literasi</option>
                                        <option value='Numerasi'>Numerasi</option>
                                       
                                    </select>
                                </div>
                           
                         <div class='form-group-sm'>
								 <div class='row'>
								 <div class='col-md-12'>
                                   <label>Opsi Soal PG | MULTI | BS | MENJODOHKAN</label>
                                     <select name='opsi' class='form-control' required>
                                        <option value='<?= $mapel[opsi] ?>'><?= $mapel[opsi] ?></option>
										 <option value=''></option>
										 <option value='3'>3</option>
                                        <option value='4'>4</option>
                                        <option value='5'>5</option>
                                    </select>
                                </div>
                            </div>
							</div>		
						 
                        <div class='form-group-sm'>
                            <div class='row'>
                                    <div class='col-md-6'>
                                        <label>Guru Pengampu</label>
                                        <select name='guru' class='form-control' required='true'>
                                            <?php
											if($pengawas['level']=='admin'){
                                            $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
                                            }else{
											$guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where id_pengawas='$_SESSION[id_pengawas]'");
											}
											while ($guru = mysqli_fetch_array($guruku)) {
                                                echo "<option value='$guru[id_pengawas]'>$guru[nama]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                               
                           
                                <div class='col-md-6'>
                                    <label>Status Soal</label>
                                    <select name='status' class='form-control' required='true'>
                                        <option value='1'>Aktif</option>
                                        <option value='0'>Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class='modal-footer'>
                                                        <button type='submit' name='editbanksoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                                    </div> 
                </form>
            </div>
        </div>
    </div>
   
                                    <script>
                                        $('#formeditbank<?= $mapel['id_mapel'] ?>').submit(function(e) {
                                            e.preventDefault();
                                            $.ajax({
                                                type: 'POST',
                                                url: 'mod_akm/crud_banksoal.php?pg=ubah',
                                                data: $(this).serialize(),
                                                success: function(data) {

                                                    if (data == "OK") {
                                                     iziToast.info(
													{
													title: 'Sukses!',
													message: 'Data berhasil disimpan',
													titleColor: '#000000',
													messageColor: '',
													backgroundColor: '#91ebbe',
													 progressBarColor: '#000000',
													  position: 'topRight'
													});
													setTimeout(function() {
														window.location.reload();
													}, 2000);
                                                    } else {
                                                        toastr.error(data);
                                                    }
                                                    $('#editbanksoal<?= $mapel['id_mapel'] ?>').modal('hide');
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 2000);

                                                }
                                            });
                                            return false;
                                        });
                                    </script>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='tambahbanksoal' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                 <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Bank Soal</h3>
                </div> 
				 <form id="formtambahbank">				
                    <div class='modal-body'>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    <label for="">Kode Bank Soal</label>
                                    <input type="text" class="form-control" name="kode" placeholder="Masukan Kode Bank Soal" required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class='form-group-sm'>
                                    <label>Mata Pelajaran</label>
                                    <select name='nama' class='form-control' required='true'>
                                        <option value=''></option>
                                        <?php
                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                            echo "<option value='$pk[kode_mapel]'>$pk[nama_mapel]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <?php if ($setting['jenjang']=='SMA' OR $setting['jenjang']=='SMK') : ?>
                            <div class='form-group-sm'>
                                <label>Program Keahlian</label>
                                <select name='id_pk[]' class='form-control select2' multiple="multiple" style='width:100%' required='true'>
                                    <option value='semua'>Semua</option>
                                    <?php
                                    $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                    while ($pk = mysqli_fetch_array($pkQ)) :
                                        echo "<option value='$pk[id_pk]'>$pk[program_keahlian]</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class='form-group-sm'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>Level Soal</label>
                                    <select name='level' id='soallevel' class='form-control' required='true'>
                                        <option value=''></option>
                                        <option value='semua'>Semua</option>
                                        <?php
                                        $lev = mysqli_query($koneksi, "SELECT * FROM level");
                                        while ($level = mysqli_fetch_array($lev)) {
                                            echo "<option value='$level[kode_level]'>$level[kode_level]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-md-6'>
                                    <label>Pilih Kelas</label><br>
                                      <select name='kelas[]' id='soalkelas' class='form-control select2' multiple='multiple' style='width:100%' required='true'>
                                   
								           </select>
																</div>
														   </div>                     
													</div>
													<div class="row">
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                     <label>Topik</label>
                                   <select name='groupsoal' class='form-control' required>
									<option value=''></option>
                                        <option value='Literasi'>Literasi</option>
                                        <option value='Numerasi'>Numerasi</option>                                     
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='form-group-sm'>
                                   <label>Sub Topik</label>
                                     <input type="text" name="subtopik" class='form-control' required>
                                </div>
                            </div>
							 <div class="col-md-4">
                                <div class='form-group-sm'>
                                   <label>Level Kognitif</label>
                                     <input type="text" name="kognitif" class='form-control' value="HOTS" required>
                                </div>
                            </div>
                        </div>
								<br>
								<h5 class="siskolah box-title text-center"><b style="color:red">Isikan Bobot pada soal yang dipilih dengan Total 100 %</b></h5>
								
                            <div class="row">
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                  
									<input type="checkbox" name="pg" value="pg" id="pg">  <label>Soal PG</label>
                                    <input type="number" name="bobot_pg" id="bobot_pg" class='form-control' value="0" style="display:none;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='form-group-sm'>
                                   <input type="checkbox" name="multi" value="multi" id="multi"> <label>PG Multi Choice</label>
                                     <input type="number" name="bobot_multi" id="bobot_multi" class='form-control' value="0" style="display:none;">
                                </div>
                            </div>
							 <div class="col-md-4">
                                <div class='form-group-sm'>
                                   <input type="checkbox" name="bs" value="bs" id="bs"> <label>PG False True</label>
                                     <input type="number" name="bobot_bs" id="bobot_bs" class='form-control' value="0" style="display:none;">
                                </div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                     <input type="checkbox" name="esai" value="esai" id="esai"> <label>Isian Singkat</label>
                                    <input type="number" name="bobot_esai" id="bobot_esai" class='form-control' value="0" style="display:none;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='form-group-sm'>
                                    <input type="checkbox" name="urut" value="urut" id="urut"> <label>Mengurutkan</label>
                                     <input type="number" name="bobot_urut" id="bobot_urut" class='form-control' value="0" style="display:none;">
                                </div>
                            </div>
							 </div>
							  <br>
							   <div class='form-group-sm'>
								 <div class='row'>
								 <div class='col-md-12'>
                                   <label>Opsi Soal PG | MULTI | BS | MENJODOHKAN</label>
                                     <select name='opsi' class='form-control' required>
                                        <option value=''>Pilih Opsi</option>
										 <option value='3'>3</option>
                                        <option value='4'>4</option>
                                        <option value='5'>5</option>
                                    </select>
                                </div>
                            </div>
							</div>		
                                <div class='form-group-sm'>
								 <div class='row'>
								 <div class='col-md-12'>
                                   <label>Pembahasan Soal</label>
                                     <select name='pembahasan' class='form-control' required>
                                        <option value='0'>Tidak</option>
                                        <option value='1'>Ya</option>
                                       
                                    </select>
                                </div>
                            </div>
							</div>		
							
                               
                        <div class='form-group-sm'>
                            <div class='row'>
                               
                                    <div class='col-md-6'>
                                        <label>Guru Pengampu</label>
                                        <select name='guru' class='form-control' required='true'>
                                           <?php
											if($pengawas['level']=='admin'){
                                            $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
                                            }else{
											$guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where id_pengawas='$_SESSION[id_pengawas]'");
											}
											while ($guru = mysqli_fetch_array($guruku)) {
                                                echo "<option value='$guru[id_pengawas]'>$guru[nama]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                
                           
                                <div class='col-md-6'>
                                    <label>Status Soal</label>
                                    <select name='status' class='form-control' required='true'>
                                        <option value='1'>Aktif</option>
                                        <option value='0'>Non Aktif</option>
                                    </select>
                                </div>
								</div>
                        </div>
								<div class='form-group-sm'>
                                      <label>Soal Agama</label>
                                          <select name='agama' class='form-control'>
                                            <option value=''>Bukan Soal Agama</option>
                                              <?php
                                                $agam = mysqli_query($koneksi, "SELECT * FROM siswa group by agama");
                                                   while ($agama = mysqli_fetch_array($agam)) : ($agama['agama'] == $mapel['soal_agama']) ? $s = 'selected' : $s = '';
                                                       echo "<option value='" . $agama['agama'] . "' $s>$agama[agama]</option>";
                                                           endwhile;
                                                                 ?>
                                                                    </select>
                                                               
                            
                    </div>
                     <div class='modal-footer'>
					 <button type='submit' name='tambahsoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'> Simpan</i> </button>
                </div>
				</form>
				<div class="main-footer"></div>
            </div>
        </div>
    </div>
  
   
   
<?php elseif ($ac == 'pg') : ?>
    <?php include 'mod_akm/input_soal.php'; ?>
	
	<?php elseif ($ac == 'multi') : ?>
    <?php include 'mod_akm/input_soal2.php'; ?>
	
	<?php elseif ($ac == 'bs') : ?>
    <?php include 'mod_akm/input_soal3.php'; ?>
	
	<?php elseif ($ac == 'urut') : ?>
    <?php include 'mod_akm/input_soal4.php'; ?>
	
	<?php elseif ($ac == 'multipgm') : ?>
    <?php include 'mod_akm/input_soal5.php'; ?>
	
	<?php elseif ($ac == 'fo') : ?>
    <?php include 'mod_akm/input_soal6.php'; ?>
<?php elseif ($ac == 'lihat') : ?>

    <?php
    $id_mapel = $_GET['id'];
   
    ?>
<style>
.menu {
 display: block;
 background-color:#1dbb90;
 height:30px;
}


#navigasi {
 position:relative;
 line-height:20px;
 margin:0;
 padding:0;
 list-style-type:none;
 list-style-position:outside;
}

#navigasi a {
 display:block;
 padding:8px 16px;
 background-color:#1dbb90;
 color:#fff;
 text-decoration:none;
}

#navigasi a:hover {
 background-color:#000;
 color:#fff;
}

#navigasi li {
 position:relative;
 float:left;
}

#navigasi ul {
 position:absolute;
 display:none;
 margin:0;
 padding:0;
 list-style-type:none;
 list-style-position:outside;
}

#navigasi li ul a{
 width:19em;
 height:auto;
 float:left;
}

#navigasi li:hover ul{
 display:block;
}

#navigasi li:hover ul ul{
 display:none;
}
					</style>
    <div class='row'>
        <div class='col-md-12'>
       <div class="panel panel-default">
                <div class="panel-heading" > 
            <?php $bobot = fetch($koneksi, 'mapel', ['id_mapel' => $id_mapel]); 
			$totalbobot=$bobot['bobot_pg']+$bobot['bobot_esai']+$bobot['bobot_multi']+$bobot['bobot_bs']+$bobot['bobot_urut'];
			?>
			  <?php if ($setting['server'] == 'pusat') { ?>
            <div class="box-header with-border">
                <h3 class="box-title"> Soal <?= $namamapel['groupsoal'] ?>  |  <b><font color="#FF0000">Total Bobot : <?= $totalbobot ?>%</font></b></h3>
            <?php if ($totalbobot <> 100) : ?>
			<div class='box-tools pull-right '>
			<marquee> <h5><b><font color="#FF0000">Total Bobot : <?= $totalbobot ?>%, Silahkan Perbaiki Bobot Sampai Menjadi 100%</font></b></h5></marquee>
			</div>
			 
			<?php endif ?>
			 <?php } ?>
			</div>
			</div>
			<div class="panel panel-default">
              <div class='box-body'>
				<div class='box-tools pull-right '>
				 <?php if ($setting['server'] == 'pusat') { ?>
			<button class='btn btn-sm btn-flat btn-warning' data-toggle='modal' data-target='#tambahbobotpg'><i class='fa fa-edit'></i> <span class='hidden-xs'>Bobot</span></button></a></li>
				 <?php } ?>
						<a class='btn btn-sm btn-flat btn-info' href='?pg=bankakm' data-placement="top" data-toggle="tooltip" data-original-title="Bank Soal"><i class='fa fa-reply'></i><span class='hidden-xs'></span></a>
								 
                        <button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print' data-placement="top" data-toggle="tooltip" data-original-title="Cetak"></i><span class='hidden-xs'> </span></button>
                        <?php if ($setting['server'] == 'pusat') { ?>
					   <button id="btnkosongsoal" data-id="<?= $id_mapel ?>" class='btn btn-sm btn-danger' data-placement="top" data-toggle="tooltip" data-original-title="Reset"><i class='fa fa-trash'></i><span class='hidden-xs'> </span></button>
						<?php } ?>
					   <iframe name='frameresult' src='mod_akm/cetaksoal.php?id=<?= $id_mapel ?>' style='border:none;width:1px;height:1px;'></iframe>
                    </div>
				</div></div>
             <div class="panel-heading" >
			             <?php if($bobot['bobot_pg']<>0){ ?>
                        <a href="?pg=bankakm&ac=pg&id=<?= $bobot['id_mapel'] ?>&jenis=1" class="btn btn-sm btn-success" ><i class='fa fa-plus'></i> PG</a>
					     <?php } ?>
						  <?php if($bobot['bobot_esai']<>0){ ?>
                        <a href="?pg=bankakm&ac=pg&id=<?= $bobot['id_mapel'] ?>&jenis=2" class="btn btn-sm btn-primary" ><i class='fa fa-plus'></i> Esay</a>
					     <?php } ?>
						  <?php if($bobot['bobot_multi']<>0){ ?>
                        <a href="?pg=bankakm&ac=multi&id=<?= $bobot['id_mapel'] ?>&jenis=3" class="btn btn-sm btn-warning" ><i class='fa fa-plus'></i> PG Multi</a>
					     <a href="?pg=bankakm&ac=multipgm&id=<?= $bobot['id_mapel'] ?>&jenis=3" class="btn btn-sm btn-warning" ><i class='fa fa-plus'></i> PG Multi 3 Kolom</a>
						<?php } ?>
						  <?php if($bobot['bobot_bs']<>0){ ?>
                        <a href="?pg=bankakm&ac=bs&id=<?= $bobot['id_mapel'] ?>&jenis=4" class="btn btn-sm btn-info" ><i class='fa fa-plus'></i> Benar Salah</a>
					       <a href="?pg=bankakm&ac=fo&id=<?= $bobot['id_mapel'] ?>&jenis=4" class="btn btn-sm btn-info" ><i class='fa fa-plus'></i> Fakta Opini</a>
						<?php } ?>
						  <?php if($bobot['bobot_urut']<>0){ ?>
                        <a href="?pg=bankakm&ac=urut&id=<?= $bobot['id_mapel'] ?>&jenis=5" class="btn btn-sm btn-danger" ><i class='fa fa-plus'></i> Jodohkan</a>
					     <?php } ?>
					</div>	
                
                       <div class='tab-content'>
						<div class="tab-pane active" id="tab_1">
					<div class="panel panel-default">
              <div class='box-body'>
					<h4 class='box-title'><i class='fa fa-th-list'></i> Soal AKM - <?= $bobot['nama'] ?></h4>
									</div><br>
									<div class='table-responsive'>
                                    <table id="tabelsoal" class='table table-bordered'>
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
                                                                <?php if ($bobot['opsi'] == 5) : ?>
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
                                                                <?php if ($bobot['opsi'] <> 3) : ?>
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
													 <table width="100%" class='table table-bordered'>
													 <tr>
															<td rowspan="2" class="text-center" style="background-color: #1dbb90; color:#fff"><br><b>Pernyataan</b></td>
															<td class="text-center" width="15%" style="background-color: #1dbb90; color:#fff"><b>Jawaban A</b></td>
															<td class="text-center" width="15%" style="background-color: #1dbb90; color:#fff"><b>Jawaban B</b></td>
															<td class="text-center" width="15%" style="background-color: #1dbb90; color:#fff"><b>Jawaban C</b></td>
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
															 <?php if ($bobot['opsi']<>3){ ?>
															<tr>
															<td><?= $soal['pilD'] ?></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															</tr>
															<?php } ?>
															 <?php if ($bobot['opsi'] ==5){ ?>
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
															 <?php if ($bobot['opsi']<>3){ ?>
															<td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
															 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
															 <td style="padding: 3px;width: 31%; vertical-align: text-top;"> <?= $soal['pilD'] ?></td>
															<?php } ?>
															</tr>
															
															 <?php if ($bobot['opsi'] ==5){ ?>
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
													 <table width="100%" class='table table-bordered'>
													 <tr>
															<td class="text-center" style="background-color: #1dbb90; color:#fff"><b>Pernyataan</b></td>
															<td class="text-center" width="5%" style="background-color: #1dbb90; color:#fff"><b>Fakta</b></td>
															<td class="text-center" width="5%" style="background-color: #1dbb90; color:#fff"><b>Opini</b></td>
															
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
															 <?php if ($bobot['opsi'] <>3){ ?>
															<tr>
															<td><?= $soal['pilD'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															
															</tr>
															 <?php } ?>
															 <?php if ($bobot['opsi'] ==5){ ?>
															<tr>
															<td><?= $soal['pilE'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													
													<?php if ($soal['jenis'] == '4' AND $soal['kode'] == '') : ?>
													 <table width="100%" class='table table-bordered'>
													 <tr>
															<td class="text-center" style="background-color: #1dbb90; color:#fff"><b>Pernyataan</b></td>
															<td class="text-center" width="5%" style="background-color: #1dbb90; color:#fff"><b>Benar</b></td>
															<td class="text-center" width="5%" style="background-color: #1dbb90; color:#fff"><b>Salah</b></td>
															
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
															 <?php if ($bobot['opsi'] <>3){ ?>
															<tr>
															<td><?= $soal['pilD'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
															
															</tr>
															 <?php } ?>
															 <?php if ($bobot['opsi'] ==5){ ?>
															<tr>
															<td><?= $soal['pilE'] ?></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
															
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													<?php if ($soal['jenis'] == '5') : ?>
													 <table width="100%" class='table table-bordered'>
													       <tr>
														  
															<td class="text-center" style="background-color: #1dbb90; color:#fff"><b>Pernyataan</b></td>	
															<td class="text-center" width="5%" style="background-color: #1dbb90; color:#fff"><b></b></td>	
															<td class="text-center" width="5%" style="background-color: #1dbb90; color:#fff"><b></b></td>	
                                                            <td class="text-center" style="background-color: #1dbb90; color:#fff"><b>Jawaban</b></td>	
																													
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
															 <?php if ($bobot['opsi'] <>3){ ?>
															<tr>															
															<td><?= $soal['perD'] ?></td>															
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><?= $soal['pilD'] ?></td>															
															</tr>
															<?php } ?>
															 <?php if ($bobot['opsi'] ==5){ ?>
															<tr>															
															<td><?= $soal['perE'] ?></td>															
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
															<td><?= $soal['pilE'] ?></td>															
															</tr>
															<?php } ?>
															</table>
                                                    <?php endif; ?>
													
                                                        <b> Kunci : <?= $soal['jawaban'] ?> </b>
                                                    </td>
													
													 <?php if ($setting['server'] == 'pusat') { ?>
                                                    <td width='10%'>
													  <a><button class='btn bg-maroon btn-sm' data-toggle='modal' data-target="#hapus<?= $soal['id_soal'] ?>"><i class='fa fa-trash'></i></button></a>
                                                     
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
													 <?php } ?>
                                                </tr>
												 <?php
                                                $info = info("Anda yakin akan menghapus soal ini ?");
                                                if (isset($_POST['hapus'])) {
                                                    $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_soal = '$_REQUEST[idu]'");
                                                    (!$exec) ? info("Gagal menyimpan", "NO") : jump("?pg=$pg&ac=$ac&id=$id_mapel");
                                                }
                                                ?>
                                                <div class='modal fade' id="hapus<?= $soal['id_soal'] ?>" style='display: none;'>
                                                    <div class='modal-dialog'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header bg-blue'>
                                                                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                                                <h3 class='modal-title'>Hapus Soal</h3>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form action='' method='post'>
                                                                    <input type='hidden' id='idu' name='idu' value="<?= $soal['id_soal'] ?>" />
                                                                    <div class='callout '>
                                                                        <h4><?= $info ?></h4>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <div class='box-tools pull-right '>
                                                                            <button type='button' class='btn btn-success btn-sm pull-left' data-dismiss='modal'>Close</button>
																			<button type='submit' name='hapus' class='btn btn-danger btn-sm bg-red'><i class='fa fa-trash-o'></i> Hapus</button> 
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>   
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                        </div>
                    </div>
						 </div>
						<div class='modal fade' id='tambahbobotpg' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-maroon'>
                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                <h4 class='modal-title'><i class="fas fa-edit"></i> Edit Bobot Soal</h4>
            </div>
				                  <?php 
									$siswa = fetch($koneksi, 'mapel', ['id_mapel' => $id_mapel]);
									?>
                <form id="formtambahbobotpg">
				<input type="hidden" class="form-control" name="id_mapel" value='<?= $siswa['id_mapel'] ?>' required>
                    <div class='modal-body'>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Bobot PG (%)</label>
                                    <input type="text" class="form-control" name="bobot_pg" value='<?= $siswa['bobot_pg'] ?>' required>
                                </div>
                             </div>
							 <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Bobot Isian Singkat (%)</label>
                                    <input type="text" class="form-control" name="bobot_esai" value='<?= $siswa['bobot_esai'] ?>' required>
                                </div>
                             </div>
							 <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">PG Kompleks  Multi (%)</label>
                                    <input type="text" class="form-control" name="bobot_multi" value='<?= $siswa['bobot_multi'] ?>' required>
                                </div>
                             </div>
							 <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">PG Komplek BS | FO (%)</label>
                                    <input type="text" class="form-control" name="bobot_bs" value='<?= $siswa['bobot_bs'] ?>' required>
                                </div>
                             </div>
							 <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Bobot Menjodohkan (%)</label>
                                    <input type="text" class="form-control" name="bobot_urut" value='<?= $siswa['bobot_urut'] ?>' required>
                                </div>
                             </div>
							 </div>
                 <div class='modal-footer'>
                        <button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                    </div>
                </form>
            </div>
               </div>
                </div>
            </div>
        </div>
    </div>
  

	<?php elseif ($ac == 'upload11') : ?>
	<div class='row'>
<div class='col-md-12'>
            <div class='panel panel-default'>
               <div class="panel-heading" style="height:45px">
                  <h4 class='box-title'><i class="fas fa-upload"></i> Impor Soal</h4></div>    
              <div class="box-body">
					<div class="tab-content">
                        <div class="tab-pane active" id="tab_1" >
						<br>
<?php
$idmapel=$_GET['id'];

$nom = mysqli_fetch_array(mysqli_query($koneksi, "SELECT max(nomor) AS nomer FROM soal WHERE id_mapel='$idmapel' "));
?>
    <div class='col-md-3'></div>
    <div class='col-md-6'>
        <div class="panel panel-default">
              				
            <div class='box-body'>
			<form id="form-import" action='' method="POST" enctype="multipart/form-data">
                <div class='form-group'>
                    <label>Impor Soal</label>
                    <input type="file" class="form-control" name="file"  placeholder="" aria-describedby="helpfile" required>
                     <small id="helpfile" class="form-text text-muted">File harus .xls</small>
                       </div>
							<input type="hidden" name="idmapel" value="<?= $idmapel ?>" >
                           
                            <input type="hidden" name="nomer" value="<?= $nom['nomer'] ?>" >							
                       
                               <div class="modal-footer">  
							   <a href="?pg=bankakm&ac=lihat&id=<?= $idmapel ?>" class="btn btn-sm btn-danger"><i class='fa fa-times' ></i> Kembali</a>		
                                  <a href="template/formatsoal.xls" class="btn btn-sm btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="Format soal tidak bergambar"><i class='fa fa-download' ></i> Format</a>
								<button type="submit" id="edis" class="btn btn-sm btn-success" onclick="fungsiSaya()"><i class='fa fa-upload'></i> Upload</button>
                                   </div>
								   </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
       <script>
    //IMPORT FILE PENDUKUNG 
    $('#form-import').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'mod_akm/crud_imporsoal11.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('form button').on("click", function(e) {
                    e.preventDefault();
                });
            },
            success: function(data) {

                $('#importdata').modal('hide');
                 iziToast.info(
            {
                title: 'Sukses!',
                message: 'Data berhasil disimpan',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#91ebbe',
				 progressBarColor: '#000000',
                  position: 'topRight'
                    });
                setTimeout(function() {
                    window.location.replace('?pg=bankakm&ac=lihat&id=<?= $idmapel ?>');
                }, 2000);


            }
        });
    });
   
</script>
<script>
function fungsiSaya() {
  var x = document.getElementById("edis");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
	

<?php endif; ?>
<script>
    $(function() {
        $("#btnhapusbank").click(function() {
            i = 0;
            id_array = new Array();
            $("input.cekpilih:checked").each(function() {
                id_array[i] = $(this).val();
                i++;
            });
            swal({
                title: 'Bank Soal Terpilih ' + i,
                text: 'Apakah kamu yakin akan menghapus data bank soal yang sudah dipilih  ini ??',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'mod_akm/crud_banksoal.php?pg=hapus',
                        data: "kode=" + id_array,
                        type: "POST",
                        success: function(respon) {
                            console.log(respon);
                            if (respon == 1) {
                                $("input.cekpilih:checked").each(function() {
                                    $(this).parent().parent().remove('.cekpilih').animate({
                                        opacity: "hide"
                                    }, "slow");
                                })
                            }
                        }
                    })
                }
            });
            return false;
        })
    });
    $("#btnkosongsoal").click(function() {
        var id = $(this).data('id');
        swal({
            title: 'Konfirmasi ',
            text: 'Apakah kamu yakin akan menghapus semua soal ??',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'mod_akm/crud_banksoal.php?pg=kosongsoal',
                    data: "id=" + id,
                    type: "POST",
                    success: function(respon) {
                        iziToast.info(
            {
                title: 'Sukses!',
                message: 'Data berhasil dihapus',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#f7abab',
				 progressBarColor: '#000000',
                  position: 'topRight'		  
                });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                });
            }
            return false;
        })

    });
    $('#formsoal').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'mod_akm/crud_banksoal.php?pg=simpan_soal',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {},
            success: function(data) {
                iziToast.info(
            {
                title: 'Sukses!',
                message: 'Data berhasil disimpan',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#91ebbe',
				 progressBarColor: '#000000',
                  position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
            }
        })
        return false;
    });
	 
    $('#formtambahbank').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'mod_akm/crud_banksoal.php?pg=tambah',
            data: $(this).serialize(),
            success: function(data) {
                console.log(data);
                if (data == "OK") {
                    iziToast.info(
            {
                title: 'Sukses!',
                message: 'Bank Soal berhasil disimpan',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#91ebbe',
				 progressBarColor: '#000000',
                  position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                      iziToast.info(
            {
                title: 'Gagal!',
                message: 'Kode Bank Sudah Ada',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#f7abab',
				 progressBarColor: '#000000',
                  position: 'topRight'
                    });
					setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }

            }
        });
        return false;
    });
	
    $("#soallevel").change(function() {
        var level = $(this).val();
        console.log(level);
        $.ajax({
            type: "POST",
            url: "mod_akm/crud_banksoal.php?pg=ambil_kelas", 
            data: "level=" + level, 
            success: function(response) { 
                $("#soalkelas").html(response);
            }
        });
    });
</script>
<script>
 $('#formtambahbobotpg').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'mod_akm/crud_banksoal.php?pg=tambahpg',
            data: $(this).serialize(),
            success: function(data) {
                console.log(data);
                if (data == 'OK') {
                   iziToast.info(
            {
                title: 'Sukses!',
                message: 'Bobot berhasil disimpan',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#91ebbe',
				 progressBarColor: '#000000',
                  position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                  iziToast.info(
            {
                title: 'Gagal!',
                message: 'Bobot Sudah ada',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#f7abab',
				 progressBarColor: '#000000',
                  position: 'topRight'
                    });
					setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }

            }
        });
        return false;
    });
	
$('#formtambahboboturaian').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'mod_akm/crud_banksoal.php?pg=tambahuraian',
            data: $(this).serialize(),
            success: function(data) {
                console.log(data);
                if (data == "OK") {
                    toastr.success("bobot nilai berhasil dibuat");
                } else {
                    toastr.error(data);
                }
                $('#tambahboboturaian').modal('hide');
                setTimeout(function() {
                    location.reload();
                }, 2000);

            }
        });
        return false;
    });
</script>

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
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
</script>
<script>
$('#pg').click(function() {
   if($(this).is(":checked")){
      $("#bobot_pg").show();
   }
   else{
      $("#bobot_pg").hide();
   }
});
</script>
<script>
$('#multi').click(function() {
   if($(this).is(":checked")){
      $("#bobot_multi").show();
   }
   else{
      $("#bobot_multi").hide();
   }
});
</script>
<script>
$('#bs').click(function() {
   if($(this).is(":checked")){
      $("#bobot_bs").show();
   }
   else{
      $("#bobot_bs").hide();
   }
});
</script>
<script>
$('#esai').click(function() {
   if($(this).is(":checked")){
      $("#bobot_esai").show();
   }
   else{
      $("#bobot_esai").hide();
   }
});
</script>
<script>
$('#urut').click(function() {
   if($(this).is(":checked")){
      $("#bobot_urut").show();
   }
   else{
      $("#bobot_urut").hide();
   }
});
</script>

<script>
 $('#tabelsoal').on('click', '.hapussoal', function() {
        var id = $(this).data('id');
        Swal.fire({
				  title: 'Are you sure?',
				  text: "You won't be able to revert this!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, delete it!'	
        }).then((result) => {
            if (result.value) {
                $.ajax({
                     url: 'mod_akm/crud_banksoal.php?pg=hapussoal',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                  iziToast.info(
            {
                title: 'Sukses!',
                message: 'Data berhasil dihapus',
				titleColor: '#000000',
				messageColor: '',
				backgroundColor: '#f7abab',
				 progressBarColor: '#000000',
                  position: 'topRight'				  
                });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                });
            }
            return false;
        })

    });
	
	
</script>