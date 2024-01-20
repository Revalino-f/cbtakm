<?php $info = ''; ?>

<div class='row'>
        <div class='col-md-12'>
            <div class="panel panel-default">
               <div class="panel-heading" style="height:45px">                 
                    <div class='box-tools pull-right btn-group'>
					 <button id='btnresetlogin2' class='btn  btn-flat btn-success'><i class='fa fa-check'></i> Reset</button>
                    </div>
					 <h4 class='box-title'> Reset Ujian</h4>
                </div>
				
			  <div class="box-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" >Reset</a></li>
                        
                    </ul>
					<div class="tab-content">
                        <div class="tab-pane active" id="tab_1" >
						<br>
						<div class="panel panel-default">
            <div class='box-body'>
                <?= $info ?>
                <div id='tablereset' class='table-responsive'>
                    <table id='example1' class='table  table-hover'>
                        <thead>
                            <tr>
                                <th width='5px'><input type='checkbox' id='ceksemua'></th>
                                <th width='5px'>#</th>
                                <th>No Peserta</th>
                                <th>Nama Peserta</th>
                                <th>Mulai Ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $loginQ = mysqli_query($koneksi, "SELECT * FROM nilai where online='1' and ujian_selesai is null ORDER BY ujian_mulai DESC"); ?>
                            <?php while ($login = mysqli_fetch_array($loginQ)) : ?>
                                <?php
                                $siswa = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where id_siswa='$login[id_siswa]'"));
                                $no++;
                                ?>
                                <tr>
                                    <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $login['id_nilai'] ?>"></td>
                                    <td><?= $no ?></td>
                                    <td><?= $siswa['no_peserta'] ?></td>
                                    <td><?= $siswa['nama'] ?></td>
                                    <td><?= $login['ujian_mulai'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#btnresetlogin2").click(function() {
            id_array = new Array();
            i = 0;
            $("input.cekpilih:checked").each(function() {
                id_array[i] = $(this).val();
                i++;
            });
            $.ajax({
                url: "status/ajax_status.php?pg=resetlogin",
                data: "kode=" + id_array,
                type: "POST",
                success: function(respon) {
                    if (respon == 1) {
                        $("input.cekpilih:checked").each(function() {
                            $(this).parent().parent().remove('.cekpilih').animate({
                                opacity: "hide"
                            }, "slow");
							iziToast.info(
            {
                title: 'Sukses!',
                message: 'Data berhasil direset',
				titleColor: '#FFFF00',
				messageColor: '#fff',
				backgroundColor: 'rgba(0, 0, 0, 0.5)',
				 progressBarColor: '#FFFF00',
                  position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                        })
                    }
                }
            });
            return false;
        })
    });
</script>