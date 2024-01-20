<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<?php

if($menu['pindah']=='0'){{$pindah="Manual";}}elseif($menu['pindah']=='1'){{$pindah="Otomatis";}}
if($menu['soal']=='0'){{$soal="CBT";}}elseif($menu['soal']=='1'){{$soal="AKM";}}
if($menu['ulangi']=='0'){{$ulangi="Hapus Jawaban dan Nilai";}}elseif($menu['ulangi']=='1'){{$ulangi="Hapus Nilai Saja";}}
?>
<?php if ($ac == '') { ?>
<div class='row'>
        <div class='col-md-12'>
            <div class='panel panel-default'>
               <div class="panel-heading" style="height:45px">
                  <h4 class='box-title'><i class="fas fa-tools"></i> Pengaturan Soal</h4></div>    
			  <div class='box-header with-border'>
			  <h4 class='box-title'></h4>
			  </div>
			  <div class="box-body">
                   <div class='modal-header bg-red'>
				   <center><i class="fas fa-exclamation-triangle fa-2x"> Perhatian !!!</i></center>
				   <br>
				   <center><b><h6>Merubah Model Soal Akan Menghapus Data Bank Soal,Hasil Nilai Siswa,Jadwal Ujian Sebelumnya</h6></b></center>
				   <br>
				   <br>
				   <center><b>MODEL SOAL SAAT INI <?= $soal; ?></b></center>
				   </div>
				   <br>
				   <br>
                    
                       
						<div class="panel panel-default">	
						
                    <form id='menu'   class="form-horizontal" >
									<div class="box-body box-pane">
					        
							<label class="col-sm-12 control-label"></label>
					      <div class="form-group-sm">
							<label class="col-sm-3 control-label">Model Soal</label>
							<div class="col-sm-6">
							<div class="input-group">
						   <select name="soal" id="soal"  class="form-control" style="width: 100%;" required>				    
                                <option value="<?= $menu['soal']  ?>">Pilh Model Soal</option>  								
								<option value="1">AKM</option>
								<option value="0">CBT</option>
                                 </select>
								 <span class="input-group-btn">
						   <button type='submit' name='submit' class='btn btn-sm  btn-success' style="margin-right:18px"><i class='fa fa-check' ></i><span> Simpan</span></button>
                          </span>
							</div>
		                    </div>
							</div>
							   
                         						
					 </div>
					  </form>
                        </div>
					 </div>
                        </div>
						  <script>
				  $('#menu').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
      
        $.ajax({
            type: 'POST',
            url: 'mod_akm/crud_setting.php?pg=setting_ujian',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
               iziToast.info({
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


<?php } ?>