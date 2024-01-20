<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<div class='modal fade' id='tambahjadwal' style='display: none;'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header bg-maroon'>
                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                <h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Tambah Jadwal Ujian</h4>
            </div>
            <div class='modal-body'>
                <form id="formtambahujian" method='post'>
                    <div class='form-group-sm'>
                        <label>Nama Bank Soal</label>
                        <select name='idmapel' class='form-control' required='true'>
                            <?php
                            if ($pengawas['level'] == 'admin') {
                                $namamapelx = mysqli_query($koneksi, "SELECT * FROM mapel where status='1' order by nama ASC");
                            } else {
                                $namamapelx = mysqli_query($koneksi, "SELECT * FROM mapel where status='1' and idguru='$id_pengawas' order by nama ASC");
                            }
                            while ($namamapel = mysqli_fetch_array($namamapelx)) {
                                $dataArray = unserialize($namamapel['kelas']);
                                echo "<option value='$namamapel[id_mapel]'>$namamapel[kode] [$namamapel[nama] [$namamapel[groupsoal]] -";
                                foreach ($dataArray as $key => $value) {
                                    echo "$value ";
                                }
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
					<div class='form-group-sm'>
                        <label>Guru Pengampu</label>
                        <select name='idguru' class='form-control' required='true'>
						<?php if($pengawas['level']=='admin'){ ?>
                            <option value=''>Pilih Guru </option>
                            <?php
                            $nama = mysqli_query($koneksi, "SELECT * FROM pengawas WHERE level='guru'");
                            while ($namaQ = mysqli_fetch_array($nama)) {
                                echo "<option value='$namaQ[id_pengawas]'>$namaQ[nama] </option>";
                            }
                            ?>
                        </select>
						<?php }else{ ?>
						<?php
                            $nama = mysqli_query($koneksi, "SELECT * FROM pengawas WHERE  id_pengawas='$_SESSION[id_pengawas]'");
                            while ($namaQ = mysqli_fetch_array($nama)) {
                                echo "<option value='$namaQ[id_pengawas]'>$namaQ[nama] </option>";
                            }
                            ?>
                        </select>
						<?php } ?>
                    </div>
                    <div class='form-group-sm'>
                        <label>Nama Jenis Ujian</label>
                        <select name='kode_ujian' class='form-control' required='true'>
                            <option value=''>Pilih Jenis Ujian </option>
                            <?php
                            $namaujianx = mysqli_query($koneksi, "SELECT * FROM jenis where status='aktif' order by nama ASC");
                            while ($ujian = mysqli_fetch_array($namaujianx)) {
                                echo "<option value='$ujian[id_jenis]'>$ujian[id_jenis] - $ujian[nama] </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class='form-group-sm'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label>Tanggal Mulai Ujian</label>
                                <input type='text' name='tgl_ujian' class='tgl form-control' autocomplete='off' required='true' />
                            </div>
                            <div class='col-md-6'>
                                <label>Tanggal Waktu Expired</label>
                                <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-3'>
                            <div class='form-group-sm'>
                                <label>Sesi</label>
                                <select name='sesi' class='form-control' required='true'>
                                    <?php
                                    $sesix = mysqli_query($koneksi, "SELECT * from sesi");
                                    while ($sesi = mysqli_fetch_array($sesix)) {
                                        echo "<option value='$sesi[kode_sesi]'>$sesi[kode_sesi]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>Lama ujian (menit)</label>
                                <input type='number' name='lama_ujian' class='form-control' required='true' />
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <label>Selesai (Menit)</label>
                            <input type='number' name='btn_selesai' class='form-control' required='true' />
                        </div>
                        <div class='col-md-3'>
                            <label>Pelanggaran (detik)</label>
                            <input type='number' name='pelanggaran' class='form-control' required='true' />
                        </div>
                    </div>
                   
					
                    <div class='form-group-sm'>
                        <label></label><br>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='acak' value='1'  /> Acak Soal
                        </label>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='peringkat' value='1' /> Peringkat
                        </label>
						<label>
                            <input type='checkbox' class='icheckbox_square-green' name='acakopsi' value='1' disabled /> Acak Opsi
                        </label>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='token' value='1'  /> Token Soal
                        </label>

                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='hasil' value='1' /> Hasil Tampil
                        </label>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='reset' value='1'  disabled /> Reset Login
                        </label>
                    </div>
                    <div class='modal-footer'>
                        <center><i class="fas fa-exclamation-triangle fa-2x"> Perhatian !!!</i></center>
									<center><b><h5>Untuk Model Soal AKM Reset Login Dinonaktifkan !!!</h5></b></Center>
                                        <br>
						<center><button name='tambahjadwal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan Semua</button></center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border '>
                <h3 class='box-title'><i class="fas fa-envelope-open-text    "></i> Aktifasi Ujian</h3>
                <div class='box-tools pull-right '>
                    <?php if ($setting['server'] == 'pusat') : ?>

                        <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-backdrop='static' data-target='#tambahjadwal'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah Jadwal</span></button>
                    <?php endif ?>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class="col-md-1">
                </div>
				 <div class="col-md-6">
                    <form id='formaktivasi' action="">
                        <div class="form-group-sm">
                            <label for="">Pilih Jadwal Ujian</label>
                            <select class="form-control select2" name="ujian[]" style="width:100%" multiple='true' required>
                                 <?php if ($pengawas['level'] == 'admin') {
                                    $jadwal = mysqli_query($koneksi, "SELECT * FROM ujian WHERE groupsoal<>'CBT' ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                                } else {
                                    $jadwal = mysqli_query($koneksi, "SELECT * FROM ujian where id_guru='$id_pengawas' and groupsoal<>'CBT' ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                                } ?>
                                <?php while ($ujian = mysqli_fetch_array($jadwal)) : ?>

                                    <option value="<?= $ujian['id_ujian'] ?>"><?= $ujian['kode_nama'] . " - " . $ujian['nama'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group-sm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Pilih Kelompok Test / Sesi</label>
                                    <select class="form-control select2" name="sesi" id="">
                                        <?php $sesi = mysqli_query($koneksi, "select * from siswa group by sesi"); ?>
                                        <?php while ($ses = mysqli_fetch_array($sesi)) : ?>
                                            <option value="<?= $ses['sesi'] ?>"><?= $ses['sesi'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Pilih Aksi</label>
                                    <select class="form-control select2" name="aksi" required>

                                        <option value=""></option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                        <option value="hapus">Hapus</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						<br>
                        <button name="simpan" class="btn btn-success">Simpan Semua</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="box-body">
                        <div class='small-box bg-aqua'>
                            <div class='inner'>
                                <?php $token = mysqli_fetch_array(mysqli_query($koneksi, "select token from token")) ?>
                                <h3><span name='token' id='isi_token'><?= $token['token'] ?></span></h3>
                                <p>Token Tes</p>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-barcode'></i>
                            </div>
                        </div>
                        <a id="btntoken" href="#"><i class='fa fa-spin fa-refresh'></i> Refreh Sekarang</a>
                        <p>Token akan refresh setiap 15 menit
                    </div>
                </div>
            </div><!-- /.box -->
        </div>

    </div>

</div>


<div class=''>
    <div id='tablereset' class='table-responsive'>
        <table class='table table-bordered table-hover ' id="example1">
            <thead>
                <tr>

                    <th width='5px'>#</th>
                    <th>Bank Soal</th>
                    <th>Level/Jur/Kelas</th>
                    <th>Durasi</th>
                    <th>Tgl Waktu Ujian</th>
                    <th>Acak/Opsi/Token/Hasil/Reset</th>
                    <th>Status Ujian</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($pengawas['level'] == 'admin') {
                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian where groupsoal<>'CBT' ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                } else {
                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian where id_guru='$id_pengawas' and groupsoal<>'CBT' ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                }
                ?>
                <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                    <?php if ($mapel['tgl_ujian'] > date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) {
                        $color = "bg-gray";
                        $status = "BELUM MULAI";
                    } elseif ($mapel['tgl_ujian'] < date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) {
                        $color = "bg-blue";
                        $status = "<i class='fa fa-spinner fa-spin'></i> MULAI UJIAN";
                    } else {
                        $color = "bg-red";
                        $status = "<i class='fa fa-times'></i> WAKTU HABIS";
                    } ?>
                    <?php
                    $tgl = explode(" ", $mapel['tgl_ujian']);
                    $tgl = $tgl[0];
                    $no++;
                    ?>

                    <tr>
                        <td><?= $no ?></td>
                        <td>
                            <?php
                            if ($mapel['id_pk'] == '0') {
                                $jur = 'Semua';
                            } else {
                                $jur = $mapel['id_pk'];
                            }
                            ?>

                            <?= $mapel['kode_nama'] ?>
                        </td>
                        <td>
                            <i class="fa fa-tag"></i> <?= $mapel['kode_ujian'] ?> &nbsp;
                            <i class="fa fa-user"></i> <?= $mapel['level'] ?> &nbsp;
                            <i class="fa fa-wrench"></i>
                            <?php
                            $dataArray = unserialize($mapel['id_pk']);
                            foreach ($dataArray as $key => $value) :
                                echo $value . " ";
                            endforeach;
                            ?>
                            <br>
                            <?php
                            $dataArray = unserialize($mapel['kelas']);
                            foreach ($dataArray as $key => $value) :
                                echo $value . " ";
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <small class='label label-warning'>
                                <?= ($mapel['tampil_pg']+$mapel['tampil_esai']+$mapel['tampil_multi']+$mapel['tampil_bs']+$mapel['tampil_urut']) ?> Soal / <?= $mapel['lama_ujian'] ?> m </small>
                        </td>
                        <td>
                            <small> <?= $mapel['tgl_ujian'] ?></small><br>
                            <small><?= $mapel['tgl_selesai'] ?></small>
                        </td>

                        <td>
                            <?php
                            if ($mapel['acak'] == 1) {
                                echo "<label class='label label-success'>Y</label> ";
                            } elseif ($mapel['acak'] == 0) {
                                echo "<label class='label label-danger'>N</label> ";
                            }
							if ($mapel['peringkat'] == 1) {
                                echo "<label class='label label-success'>Y</label> ";
                            } elseif ($mapel['peringkat'] == 0) {
                                echo "<label class='label label-danger'>N</label> ";
                            }
                            if ($mapel['ulang'] == 1) {
                                echo "<label class='label label-success'>Y</label> ";
                            } elseif ($mapel['ulang'] == 0) {
                                echo "<label class='label label-danger'>N</label> ";
                            }
                            if ($mapel['token'] == 1) {
                                echo "<label class='label label-success'>Y</label> ";
                            } elseif ($mapel['token'] == 0) {
                                echo "<label class='label label-danger'>N</label> ";
                            }
                            if ($mapel['hasil'] == 1) {
                                echo "<label class='label label-success'>Y</label> ";
                            } elseif ($mapel['hasil'] == 0) {
                                echo "<label class='label label-danger'>N</label> ";
                            }

                            if ($mapel['reset'] == 1) {
                                echo "<label class='label label-success'>Y</label> ";
                            } elseif ($mapel['reset'] == 0) {
                                echo "<label class='label label-danger'>N</label> ";
                            }

                            ?>
                        </td>
                        <td style="text-align:center">
                            <?php
                            if ($mapel['status'] == 1) {
                                echo " <label class='badge bg-green'>Aktif</label> <label class='badge bg-red'>Sesi $mapel[sesi]</label>";
                            } elseif ($mapel['status'] == 0) {
                                echo "<label class='badge bg-red'>Tidak Aktif</label>";
                            }
                            ?>
                        </td>
                        <td style="text-align:center">
                            <?=
                                $status
                            ?> <br>
                            <i class="fa fa-circle text-green"></i>
                            <?=
                                $useronline = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai is null"));
                            ?>
                            <i class="fa fa-circle text-danger"></i>
                            <?=
                                $userend = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai <> ''"));
                            ?>
                        </td>
                        <td style="text-align:center">
                            <div class='btn'>
                                <?php if ($setting['server'] == 'pusat') { ?>
							   <a class='btn btn-warning' data-id="<?= $mapel['id_ujian'] ?>" data-toggle='modal' data-target="#edit<?= $mapel['id_ujian'] ?>"><i class='fa fa-edit'></i></a>
								<?php } ?>
						   <a href="?pg=statusakm&id=<?= $mapel['id_ujian'] ?>" class='btn btn-danger ' data-toggle='tooltip' data-placement='top' title='Lihat Status Peserta'><i class='fa fa-users'></i></a>
                            </div>
                        </td>
                    </tr>
                 
                    <div class='modal fade' id='edit<?= $mapel['id_ujian'] ?>' style='display: none;'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header bg-blue'>
                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                <h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Edit Waktu Ujian</h4>
            </div>
                                <form id="formedit<?= $mapel['id_ujian'] ?>">
                                    <div class='modal-body'>
                                        <input type='hidden' name='idm' value="<?= $mapel['id_ujian'] ?>" />
                                        <div class="form-group-sm">
                                            <label for="mulaiujian">Waktu Mulai Ujian</label>
                                            <input type="text" class="tgl form-control" name="tgl_ujian" value="<?= $mapel['tgl_ujian'] ?>" aria-describedby="helpId" placeholder="">
                                            <small id="helpId" class="form-text text-muted">Tanggal dan waktu ujian dibuka</small>
                                        </div>
                                        <div class="form-group-sm">
                                            <label for="selesaiujian">Waktu Ujian Ditutup</label>
                                            <input type="text" class="tgl form-control" name="tgl_selesai" value="<?= $mapel['tgl_selesai'] ?>" aria-describedby="helpId" placeholder="">
                                            <small id="helpId" class="form-text text-muted">Tanggal dan waktu ujian ditutup</small>
                                        </div>
                                        <div class='form-group-sm'>
                                            <div class='row'>
                                                <div class='col-md-3'>
                                                    <label>Lama Ujian</label>
                                                    <input type='number' name='lama_ujian' value="<?= $mapel['lama_ujian'] ?>" class='form-control' required='true' />
                                                </div>
                                                <div class='col-md-3'>
                                                    <label>Sesi</label>
                                                    <input type='number' name='sesi' value="<?= $mapel['sesi'] ?>" class='form-control' required='true' />
                                                </div>
    
                                                <div class='col-md-3'>
                                                    <label>Selesai (menit)</label>
                                                    <input type='number' name='btn_selesai' value="<?= $mapel['btn_selesai'] ?>" class='form-control' required='true' />
                                                </div>
                                                <div class='col-md-3'>
                                                    <label>Pelanggaran (detik)</label>
                                                    <input type='number' name='pelanggaran' value="<?= $mapel['pelanggaran'] ?>" class='form-control' required='true' />
                                                </div>
                                            </div>
                                        </div>
										<br>
                                        <div class='form-group-sm'>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='acak' value='1' <?php if ($mapel['acak'] == 1) {
                                                                                                                                echo "checked='true'";
                                                                                                                            } ?>  /> Acak Soal
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='peringkat' value='1' <?php if ($mapel['peringkat'] == 1) {
                                                                                                                                echo "checked='true'";
                                                                                                                            } ?> /> Peringkat
                                            </label>
											<label>
                                                <input type='checkbox' class='icheckbox_square-green' name='acakopsi' value='1' <?php if ($mapel['ulang'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> disabled /> Acak Opsi
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='token' value='1' <?php if ($mapel['token'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?>  /> Token Soal
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='hasil' value='1' <?php if ($mapel['hasil'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> /> Hasil Tampil
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='reset' value='1' <?php if ($mapel['reset'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> disabled /> Reset Login
                                            </label>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                <center><i class="fas fa-exclamation-triangle fa-2x"> Perhatian !!!</i></center>
									<center><b><h5>Untuk Model Soal AKM Reset Login Dinonaktifkan !!!</h5></b></Center>
                                        <br>
										<center>
                                            <button type="submit" class='btn btn-primary' name='simpan'><i class='fa fa-save'></i> Ganti Waktu Ujian</button>
                                        </center>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        $("#formedit<?= $mapel['id_ujian'] ?>").submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                type: 'POST',
                                url: 'mod_akm/crud_jadwal.php?pg=ubah',
                                data: $(this).serialize(),
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
                            });
                            return false;
                        });
                    </script>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>

    <script>
        $(document).ready(function() {
            $("#btntoken").click(function() {
                $.ajax({
                    url: "mod_akm/crud_jadwal.php?pg=token",
                    type: "POST",
                    success: function(respon) {
                        $('#isi_token').html(respon);
                        iziToast.success({
                            title: 'Sukses',
                            message: 'Token diperbarui',
                            position: 'topRight'
                        });
                    }
                });
                return false;
            })
            $('#formaktivasi').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'mod_akm/crud_jadwal.php?pg=aktivasi',
                    data: $(this).serialize(),
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
                });
                return false;
            });

        });
    </script>
    <script>
         $('#formtambahujian').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'mod_akm/crud_jadwal.php?pg=tambah',
                data: $(this).serialize(),

                success: function(data) {
                    console.log(data);
                    if (data == 'OK') {
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
                        Swal.fire({	
				title: '<a href="#" class="sandik" style="color:red">Gagal !! Bank Soal Sudah ada</a>',				
				showConfirmButton: false,
				 animation: false,
				  customClass: 'animated tada',				  
				  imageUrl: '../dist/img/sandik_kecil.gif',
                 footer: '<a href="#"><b style="color:red">Sistem Administrasi Pendidik (SANDIK)</b></a>'
                    });
					setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }

            }
        });
        return false;
    });
    </script>