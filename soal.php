
 <style>
 /* custom radio */
.radio {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
 
/* hide the browser's default radio button */
.radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}
 
/* create custom radio */
.radio .check {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 50%;
}
 
/* on mouse-over, add border color */
.radio:hover input ~ .check {
    border: 2px solid #2489C5;
}
 
/* add background color when the radio is checked */
.radio input:checked ~ .check {
    background-color: #2489C5;
    border:none;
}
 
/* create the radio and hide when not checked */
.radio .check:after {
    content: "";
    position: absolute;
    display: none;
}
 
/* show the radio when checked */
.radio input:checked ~ .check:after {
    display: block;
}
 
/* radio style */
.radio .check:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
}
/* custom checkbox */
.checkbox {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
 
/* hide the browser's default checkbox */
.checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}
 
/* create custom checkbox */
.check {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border: 1px solid #ccc;
}
 
/* on mouse-over, add border color */
.checkbox:hover input ~ .check {
    border: 2px solid #2489C5;
}
 
/* add background color when the checkbox is checked */
.checkbox input:checked ~ .check {
    background-color: #2489C5;
    border:none;
}
 
/* create the checkmark and hide when not checked */
.check:after {
    content: "";
    position: absolute;
    display: none;
}
 
/* show the checkmark when checked */
.checkbox input:checked ~ .check:after {
    display: block;
}
 
/* checkmark style */
.checkbox .check:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

</style>
 
 <?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");

$soalx = $_POST['soal'];
$soalx = dekripsi($soalx);
$decoded = json_decode($soalx, true);
$pengacak = $_POST['pengacak'];
$pengacak = explode(',', $pengacak);
$pengacakpil = $_POST['pengacakpil'];
$pengacakpil = explode(',', $pengacakpil);
$id_siswa = (isset($_SESSION['id_siswa'])) ? $_SESSION['id_siswa'] : 0;
$ujiannya = dekripsi($_POST['ujian']);
$mapel = json_decode($ujiannya, true);
$pg = @$_POST['pg'];
$ac = $mapel[0]['id_ujian'];
$id = @$_POST['id'];
$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
?>

<?php if ($pg == 'soal') { ?>
    <?php
    $no_soal = $_POST['no_soal'];
    $no_prev = $no_soal - 1;
    $no_next = $no_soal + 1;
    $id_mapel = $_POST['id_mapel'];
    $id_siswa = $_POST['id_siswa'];
    $where2 = array(
        'id_siswa' => $id_siswa,
        'id_mapel' => $id_mapel,
        'id_ujian' => $ac
    );
   
    update($koneksi, 'nilai', array('ujian_berlangsung' => $datetime), $where2);
    $nilai = fetch($koneksi, 'nilai', $where2);
    if ($nilai['ujian_selesai'] <> null) {
        jump("$homeurl");
    }
	
    $nomor = $_POST['no_soal'];
    $nosoal = $nomor;
    foreach ($decoded as $soal) {
		

        if ($soal['id_soal'] == $pengacak[$nosoal]) {
            $jawab = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $soal['id_soal'], 'id_ujian' => $ac));
    ?>
            <div class='box-body'>
                <div class='row'>
                    <div class='col-md-12'>
					
					   
                        <div class='callout soal'>
						 
                            <div class='soaltanya animated fadeIn' style="text-align:justify"><?= $soal['soal'] ?></div>
                        </div>
					
                        <div class='col-md-12'>
                            <?php
                            if ($soal['file'] <> '') {
                                $ext = explode(".", $soal['file']);
                                $ext = end($ext);
                                if (in_array($ext, $image)) {
                                    echo "<span  id='zoom' style='display:inline-block'> <img  src='$homeurl/files/$soal[file]' class='img-responsive'/></span>";
                                } elseif (in_array($ext, $audio)) {
                                    echo "<audio controls='controls' ><source src='$homeurl/files/$soal[file]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                } else {
                                    echo "File tidak didukung!";
                                }
                            }
                            if ($soal['file1'] <> '') {
                                $ext = explode(".", $soal['file1']);
                                $ext = end($ext);
                                if (in_array($ext, $image)) {
                                    echo "<span  id='zoom1' style='display:inline-block'> <img  src='$homeurl/files/$soal[file1]' class='img-responsive'/></span>";
                                } elseif (in_array($ext, $audio)) {
                                    echo "<audio controls='controls' ><source src='$homeurl/files/$soal[file1]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                } else {
                                    echo "File tidak didukung!";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php if ($soal['jenis'] == 1) { ?>
                        <div class='col-md-12'>
                            <?php if ($mapel[0]['ulang'] == '1') : ?>
                                <?php
                                if ($mapel[0]['opsi'] == 3) {
                                    $kali = 3;
                                } elseif ($mapel[0]['opsi'] == 4) {
                                    $kali = 4;
                                    $nop4 = $no_soal * $kali + 3;
                                    $pil4 = $pengacakpil[$nop4];
                                    $pilDD = "pil" . $pil4;
                                    $fileDD = "file" . $pil4;
                                } elseif ($mapel[0]['opsi'] == 5) {
                                    $kali = 5;
                                    $nop4 = $no_soal * $kali + 3;
                                    $pil4 = $pengacakpil[$nop4];
                                    $pilDD = "pil" . $pil4;
                                    $fileDD = "file" . $pil4;
                                    $nop5 = $no_soal * $kali + 4;
                                    $pil5 = $pengacakpil[$nop5];
                                    $pilEE = "pil" . $pil5;
                                    $fileEE = "file" . $pil5;
                                }

                                $nop1 = $no_soal * $kali;
                                $nop2 = $no_soal * $kali + 1;
                                $nop3 = $no_soal * $kali + 2;
                                $pil1 = $pengacakpil[$nop1];
                                $pilAA = "pil" . $pil1;
                                $fileAA = "file" . $pil1;
                                $pil2 = $pengacakpil[$nop2];
                                $pilBB = "pil" . $pil2;
                                $fileBB = "file" . $pil2;
                                $pil3 = $pengacakpil[$nop3];
                                $pilCC = "pil" . $pil3;
                                $fileCC = "file" . $pil3;


                                $a = ($jawab['jawabx'] == 'A') ? 'checked' : '';
                                $b = ($jawab['jawabx'] == 'B') ? 'checked' : '';
                                $c = ($jawab['jawabx'] == 'C') ? 'checked' : '';

                                if ($mapel[0]['opsi'] == 4) :
                                    $d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
                                elseif ($mapel[0]['opsi'] == 5) :
                                    $d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
                                    $e = ($jawab['jawabx'] == 'E') ? 'checked' : '';
                                endif;


                                ?>
                                <?php if ($soal['pilA'] == '' and $soal['fileA'] == '' and $soal['pilB'] == '' and $soal['fileB'] == '' and $soal['pilC'] == '' and $soal['fileC'] == '' and $soal['pilD'] == '' and $soal['fileD'] == '') { ?>
                                    <?php
                                    $ax = ($jawab['jawabx'] == 'A') ? 'checked' : '';
                                    $bx = ($jawab['jawabx'] == 'B') ? 'checked' : '';
                                    $cx = ($jawab['jawabx'] == 'C') ? 'checked' : '';
                                    $dx = ($jawab['jawabx'] == 'D') ? 'checked' : '';
                                    if ($mapel[0]['opsi'] == 5) :
                                        $ex = ($jawab['jawabx'] == 'E') ? 'checked' : '';
                                    endif;
                                    ?>
                                    <table class='table'>
                                        <tr>
                                            <td>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='A' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'A','A',1,<?= $ac ?>)" <?= $ax ?> />
                                                <label class='button-label' for='A'>
                                                    <h1>A</h1>
                                                </label>
                                            </td>

                                            <td>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='C' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'C','C',1,<?= $ac ?>)" <?= $cx ?> />
                                                <label class='button-label' for='C'>
                                                    <h1>C</h1>
                                                </label>
                                            </td>
                                            <?php if ($mapel[0]['opsi'] == 5) { ?>
                                                <td>
                                                    <input class='hidden radio-label' type='radio' name='jawab' id='E' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'E','E',1,<?= $ac ?>)" <?= $ex ?> />
                                                    <label class='button-label' for='E'>
                                                        <h1>E</h1>
                                                    </label>

                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='B' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'B','B',1,<?= $ac ?>)" <?= $bx ?> />
                                                <label class='button-label' for='B'>
                                                    <h1>B</h1>
                                                </label>
                                            </td>
                                            <?php if ($mapel[0]['opsi'] <> 3) { ?>
                                                <td>
                                                    <input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'D','D',1,<?= $ac ?>)" <?= $dx ?> />
                                                    <label class='button-label' for='D'>
                                                        <h1>D</h1>
                                                    </label>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                <?php } else { ?>
                                    <table width='100%' class='table'>
                                        <tr>
                                            <!-- Opsi A -->
                                            <td width='60'>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='A' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil1 ?>','A',1,<?= $ac ?>)" <?= $a ?> />
                                                <label class='button-label' for='A'>
                                                    <h1>A</h1>
                                                </label>
                                            </td>
                                            <td style='vertical-align:middle;'>
                                                <span class='soal'><?= $soal[$pilAA] ?></span>
                                                <?php if ($soal[$fileAA] <> '') : ?>
                                                    <?php
                                                    $ext = explode(".", $soal[$fileAA]);
                                                    $ext = end($ext);
                                                    if (in_array($ext, $image)) :
                                                        echo "<span  class='lup' style='display:inline-block'><img src='$homeurl/files/$soal[$fileAA]' class='img-responsive' style='width:250px;'/></span>";
                                                    elseif (in_array($ext, $audio)) :
                                                        echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileAA]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                    else :
                                                        echo "File tidak didukung!";
                                                    endif;
                                                    ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Opsi B -->
                                            <td width='60'>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='B' onclick="jawabsoal(<?= $id_mapel ?>, <?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil2 ?>','B',1, <?= $ac ?>)" <?= $b ?> />
                                                <label class='button-label' for='B'>
                                                    <h1>B</h1>
                                                </label>
                                            </td>
                                            <td style='vertical-align:middle;'>
                                                <span class='soal'><?= $soal[$pilBB] ?></span>
                                                <?php
                                                if ($soal[$fileBB] <> '') {
                                                    $ext = explode(".", $soal[$fileBB]);
                                                    $ext = end($ext);
                                                    if (in_array($ext, $image)) :
                                                        echo "<span  class='lup' style='display:inline-block'><img src='$homeurl/files/$soal[$fileBB]' class='img-responsive' style='width:250px;'/></span>";
                                                    elseif (in_array($ext, $audio)) :
                                                        echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileBB]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                    else :
                                                        echo "File tidak didukung!";
                                                    endif;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Opsi C -->
                                            <td>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='C' onclick="jawabsoal(<?= $id_mapel ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>,'<?= $pil3 ?>','C',1,<?= $ac ?>)" <?= $c ?> />
                                                <label class='button-label' for='C'>
                                                    <h1>C</h1>
                                                </label>
                                            </td>
                                            <td style='vertical-align:middle;'>
                                                <span class='soal'><?= $soal[$pilCC] ?></span>
                                                <?php
                                                if ($soal[$fileCC] <> '') {
                                                    $ext = explode(".", $soal[$fileCC]);
                                                    $ext = end($ext);
                                                    if (in_array($ext, $image)) {
                                                        echo "<span  class='lup' style='display:inline-block'><img src='$homeurl/files/$soal[$fileCC]' class='img-responsive' style='width:250px;'/></span>";
                                                    } elseif (in_array($ext, $audio)) {
                                                        echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileCC]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                    } else {
                                                        echo "File tidak didukung!";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php if ($mapel[0]['opsi'] <> 3) : ?>
                                            <tr>
                                                <td>
                                                    <input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_mapel ?>, <?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil4 ?>','D',1,<?= $ac ?>)" <?= $d ?> />
                                                    <label class='button-label' for='D'>
                                                        <h1>D</h1>
                                                    </label>
                                                </td>
                                                <td style='vertical-align:middle;'>
                                                    <span class='soal'><?= $soal[$pilDD] ?></span>
                                                    <?php
                                                    if ($soal[$fileDD] <> '') {
                                                        $ext = explode(".", $soal[$fileDD]);
                                                        $ext = end($ext);
                                                        if (in_array($ext, $image)) {
                                                            echo "<span  class='lup' style='display:inline-block'><img src='$homeurl/files/$soal[$fileDD]' class='img-responsive' style='width:250px;'/></span>";
                                                        } elseif (in_array($ext, $audio)) {
                                                            echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileDD]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                        } else {
                                                            echo "File tidak didukung!";
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($mapel[0]['opsi'] == 5) : ?>
                                            <tr>
                                                <td>
                                                    <input class='hidden radio-label' type='radio' name='jawab' id='E' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil5 ?>','E',1,<?= $ac ?>)" <?= $e ?> />
                                                    <label class='button-label' for='E'>
                                                        <h1>E</h1>
                                                    </label>
                                                </td>
                                                <td style='vertical-align:middle;'>
                                                    <span class='soal'><?= $soal[$pilEE] ?></span>
                                                    <?php
                                                    if ($soal[$fileEE] <> '') {
                                                        $ext = explode(".", $soal[$fileEE]);
                                                        $ext = end($ext);
                                                        if (in_array($ext, $image)) {
                                                            echo "<span  class='lup' style='display:inline-block'><img src='$homeurl/files/$soal[$fileEE]' class='img-responsive' style='width:250px;'/></span>";
                                                        } elseif (in_array($ext, $audio)) {
                                                            echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileEE]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                        } else {
                                                            echo "File tidak didukung!";
                                                        }
                                                    } ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                <?php } ?>
                            <?php else : ?>
                                <?php

                                $a = ($jawab['jawabx'] == 'A') ? 'checked' : '';
                                $b = ($jawab['jawabx'] == 'B') ? 'checked' : '';
                                $c = ($jawab['jawabx'] == 'C') ? 'checked' : '';
                                if ($mapel[0]['opsi'] == 4) {
                                    $d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
                                }
                                if ($mapel[0]['opsi'] == 5) {
                                    $d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
                                    $e = ($jawab['jawabx'] == 'E') ? 'checked' : '';
                                }
                                ?>
                                <table width='100%' class='table'>
                                    <tr>
                                        <td width='60'>
                                            <input class='hidden radio-label' type='radio' name='jawab' id='A' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'A','A',1,<?= $ac ?>)" <?= $a ?> />
                                            <label class='button-label' for='A'>
                                                <h1>A</h1>
                                            </label>
                                        </td>
                                        <td style='vertical-align:middle;'>
                                            <span class='soal'><?= $soal['pilA'] ?></span>
                                            <?php
                                            if ($soal['fileA'] <> '') {
                                                $ext = explode(".", $soal['fileA']);
                                                $ext = end($ext);
                                                if (in_array($ext, $image)) {
                                                    echo "<img src='$homeurl/files/$soal[fileA]' class='img-responsive' style='max-width:300px;'/>";
                                                } elseif (in_array($ext, $audio)) {
                                                    echo "<audio controls='controls'><source src='$homeurl/files/$soal[fileA]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                } else {
                                                    echo "File tidak didukung!";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class='hidden radio-label' type='radio' name='jawab' id='B' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'B','B',1,<?= $ac ?>)" <?= $b ?> />
                                            <label class='button-label' for='B'>
                                                <h1>B</h1>
                                            </label>
                                        </td>
                                        <td style='vertical-align:middle;'>
                                            <span class='soal'><?= $soal['pilB'] ?></span>
                                            <?php
                                            if ($soal['fileB'] <> '') {
                                                $ext = explode(".", $soal['fileB']);
                                                $ext = end($ext);
                                                if (in_array($ext, $image)) {
                                                    echo "<img src='$homeurl/files/$soal[fileB]' class='img-responsive' style='max-width:300px;'/>";
                                                } elseif (in_array($ext, $audio)) {
                                                    echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileB]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                } else {
                                                    echo "File tidak didukung!";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class='hidden radio-label' type='radio' name='jawab' id='C' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'C','C',1,<?= $ac ?>)" <?= $c ?> />
                                            <label class='button-label' for='C'>
                                                <h1>C</h1>
                                            </label>

                                        </td>
                                        <td style='vertical-align:middle;'>
                                            <span class='soal'><?= $soal['pilC'] ?></span>
                                            <?php
                                            if ($soal['fileC'] <> '') {
                                                $ext = explode(".", $soal['fileC']);
                                                $ext = end($ext);
                                                if (in_array($ext, $image)) {
                                                    echo "<img src='$homeurl/files/$soal[fileC]' class='img-responsive' style='max-width:300px;'/>";
                                                } elseif (in_array($ext, $audio)) {
                                                    echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileC]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                } else {
                                                    echo "File tidak didukung!";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php if ($mapel[0]['opsi'] <> 3) { ?>
                                        <tr>
                                            <td>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'D','D',1,<?= $ac ?>)" <?= $d ?> />
                                                <label class='button-label' for='D'>
                                                    <h1>D</h1>
                                                </label>
                                            </td>
                                            <td style='vertical-align:middle;'>
                                                <span class='soal'><?= $soal['pilD'] ?></span>
                                                <?php
                                                if ($soal['fileD'] <> '') {
                                                    $ext = explode(".", $soal['fileD']);
                                                    $ext = end($ext);
                                                    if (in_array($ext, $image)) {
                                                        echo "<img src='$homeurl/files/$soal[fileD]' class='img-responsive' style='max-width:300px;'/>";
                                                    } elseif (in_array($ext, $audio)) {
                                                        echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileD]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                    } else {
                                                        echo "File tidak didukung!";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($mapel[0]['opsi'] == 5) { ?>
                                        <tr>
                                            <td>
                                                <input class='hidden radio-label' type='radio' name='jawab' id='E' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'E','E',1,<?= $ac ?>)" <?= $e ?> />
                                                <label class='button-label' for='E'>
                                                    <h1>E</h1>
                                                </label>
                                            </td>
                                            <td style='vertical-align:middle;'>
                                                <span class='soal'><?= $soal['pilE'] ?></span>
                                                <?php
                                                if ($soal['fileE'] <> '') {

                                                    $ext = explode(".", $soal['fileE']);
                                                    $ext = end($ext);
                                                    if (in_array($ext, $image)) {
                                                        echo "<img src='$homeurl/files/$soal[fileE]' class='img-responsive' style='max-width:300px;'/>";
                                                    } elseif (in_array($ext, $audio)) {
                                                        echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileE]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                    } else {
                                                        echo "File tidak didukung!";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
					
                    <?php if ($soal['jenis'] == 2) { ?>
                        <div class='col-md-12'>
						<p> Isi Jawaban </p>
                            <textarea id='jawabesai' name='textjawab' style='height:50px' class='form-control' onchange="jawabesai(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,2)"><?= $jawab['esai'] ?></textarea>
                           
						   <br><br>
							
                        </div>
                    <?php } ?>
                </div>
				
			  <?php if ($soal['jenis'] == '3' AND $soal['kode']=='') { ?>
			   <form id='myForm'  method='POST' action='<?= $homeurl ?>/proses.php'>
                      <?php $checked = explode(', ',$jawab['jawabmulti']); ?>
                       
                           
                                <table width='100%' class='table'>
								 
                                    <tr>
                                        <td width='60'>
                                            <label class="checkbox"><input type='checkbox' name='jawab[]' id='subA' value='A' <?php in_array ('A', $checked) ? print 'checked' : ''; ?> onclick="jawa(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'A','A',3,<?= $ac ?>)" <?= $a ?> />
                                             <span class="check"></span>
                                               </label>
                                        </td>
                                        <td style='vertical-align:middle;'>
                                            <span class='soal'><br><?= $soal['pilA'] ?></span>
                                            <?php
                                            if ($soal['fileA'] <> '') {
                                                $ext = explode(".", $soal['fileA']);
                                                $ext = end($ext);
                                                if (in_array($ext, $image)) {
                                                    echo "<img src='$homeurl/files/$soal[fileA]' class='img-responsive' style='max-width:300px;'/>";
                                                } elseif (in_array($ext, $audio)) {
                                                    echo "<audio controls='controls'><source src='$homeurl/files/$soal[fileA]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                } else {
                                                    echo "File tidak didukung!";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                           <label class="checkbox">  <input type='checkbox' name='jawab[]' id='subB' value='B' <?php in_array ('B', $checked) ? print 'checked' : ''; ?> onclick="jawa(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'B','B',3,<?= $ac ?>)" <?= $b ?> />
                                             <span class="check"></span>
                                               </label>
                                        </td>
                                        <td style='vertical-align:middle;'>
                                            <span class='soal'><br><?= $soal['pilB'] ?></span>
                                            <?php
                                            if ($soal['fileB'] <> '') {
                                                $ext = explode(".", $soal['fileB']);
                                                $ext = end($ext);
                                                if (in_array($ext, $image)) {
                                                    echo "<img src='$homeurl/files/$soal[fileB]' class='img-responsive' style='max-width:300px;'/>";
                                                } elseif (in_array($ext, $audio)) {
                                                    echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileB]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                } else {
                                                    echo "File tidak didukung!";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                             <label class="checkbox"><input class='hidden radio-label' type='checkbox' name='jawab[]' id='subC' value='C' <?php in_array ('C', $checked) ? print 'checked' : ''; ?> onclick="jawa(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'C','C',3,<?= $ac ?>)" <?= $c ?> />
                                            <span class="check"></span>
                                               </label>
                                        </td>
                                        <td style='vertical-align:middle;'>
                                            <span class='soal'><br><?= $soal['pilC'] ?></span>
                                            <?php
                                            if ($soal['fileC'] <> '') {
                                                $ext = explode(".", $soal['fileC']);
                                                $ext = end($ext);
                                                if (in_array($ext, $image)) {
                                                    echo "<img src='$homeurl/files/$soal[fileC]' class='img-responsive' style='max-width:300px;'/>";
                                                } elseif (in_array($ext, $audio)) {
                                                    echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileC]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                } else {
                                                    echo "File tidak didukung!";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php if ($mapel[0]['opsi'] <> 3) { ?>
                                        <tr>
                                            <td>
                                               <label class="checkbox">  <input class='hidden radio-label' type='checkbox' name='jawab[]' id='subD' value='D' <?php in_array ('D', $checked) ? print 'checked' : ''; ?> onclick="jawa(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'D','D',3,<?= $ac ?>)" <?= $d ?> />
                                            <span class="check"></span>
                                               </label>
                                            </td>
                                            <td style='vertical-align:middle;'>
                                                <span class='soal'><br><?= $soal['pilD'] ?></span>
                                                <?php
                                                if ($soal['fileD'] <> '') {
                                                    $ext = explode(".", $soal['fileD']);
                                                    $ext = end($ext);
                                                    if (in_array($ext, $image)) {
                                                        echo "<img src='$homeurl/files/$soal[fileD]' class='img-responsive' style='max-width:300px;'/>";
                                                    } elseif (in_array($ext, $audio)) {
                                                        echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileD]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                    } else {
                                                        echo "File tidak didukung!";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($mapel[0]['opsi'] == 5) { ?>
                                        <tr>
                                            <td>
                                              <label class="checkbox">  <input class='hidden radio-label' type='checkbox' name='jawab[]' id='subE' value='E' <?php in_array ('E', $checked) ? print 'checked' : ''; ?> onclick="jawa(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'E','E',3,<?= $ac ?>)" <?= $e ?> />
                                             <span class="check"></span>
                                               </label>
                                            </td>
                                            <td style='vertical-align:middle;'>
                                                <span class='soal'><br><?= $soal['pilE'] ?></span>
                                                <?php
                                                if ($soal['fileE'] <> '') {

                                                    $ext = explode(".", $soal['fileE']);
                                                    $ext = end($ext);
                                                    if (in_array($ext, $image)) {
                                                        echo "<img src='$homeurl/files/$soal[fileE]' class='img-responsive' style='max-width:300px;'/>";
                                                    } elseif (in_array($ext, $audio)) {
                                                        echo "<audio controls='controls' ><source src='$homeurl/files/$soal[fileE]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                                                    } else {
                                                        echo "File tidak didukung!";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
									 
                                </table>
								<input type='hidden' name='id_mapel' value='<?= $id_mapel ?>' >
								<input type='hidden' name='id_siswa' value='<?= $id_siswa ?>' >
								<input type='hidden' name='id_soal' value='<?= $soal['id_soal'] ?>' >
								<input type='hidden' name='id_ujian' value='<?= $ac ?>' >
							
											   </form>
											   <br><br>
                          
                        </div>
                         <?php } ?>
						 
						 
						  <?php if ($soal['jenis'] == 3 AND $soal['kode']=='PGM') { ?>
			   <form id='myForm8'  method='POST' action='<?= $homeurl ?>/proses4.php'>
                      <div class='col-md-12'>
                       <input type='hidden' name='id_mapel' value='<?= $id_mapel ?>' >
								<input type='hidden' name='id_siswa' value='<?= $id_siswa ?>' >
								<input type='hidden' name='id_soal' value='<?= $soal['id_soal'] ?>' >
								<input type='hidden' name='id_ujian' value='<?= $ac ?>' >
                           
										<?php $checked3 = explode(', ',$jawab['jawabmulti']); ?>
										<?php $checked4 = explode(', ',$jawab['jawabmulti']); ?>
										<?php $checked5 = explode(', ',$jawab['jawabmulti']); ?>
						                   
						                    <table width='100%' class='table'>
										  
                                             <tr>
											<td style='vertical-align:middle;background-color: #1dbb90; color:#fff'><span class='soal'>Pernyataan</span></td>
											<td width='70px' style='vertical-align:middle;background-color: #1dbb90; color:#fff'><span class='soal'><?= $soal['perA'] ?></span></td>
											<td width='70px' style='vertical-align:middle;background-color: #1dbb90; color:#fff'><span class='soal'><?= $soal['perB'] ?></td>
											<td width='70px' style='vertical-align:middle;background-color: #1dbb90; color:#fff'><span class='soal'><?= $soal['perC'] ?></td>
											</tr>

						                      <?php $checked1 = explode(', ',$jawab['bs1']); ?>
											<tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilA'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="pgm1" value="A"  id="pgm11"  <?php in_array ('A', $checked1) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm1" value="B" id="pgm12"  <?php in_array ('B', $checked1) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm1" value="C" id="pgm13"  <?php in_array ('C', $checked1) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											<?php $checked2 = explode(', ',$jawab['bs2']); ?>
						                    <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilB'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="pgm2" value="A"  id="pgm21"  <?php in_array ('A', $checked2) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm2" value="B" id="pgm22"  <?php in_array ('B', $checked2) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm2" value="C" id="pgm23"  <?php in_array ('C', $checked2) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											<?php $checked3 = explode(', ',$jawab['bs3']); ?>
						                      <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilC'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="pgm3" value="A"  id="pgm31"  <?php in_array ('A', $checked3) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm3" value="B" id="pgm32"  <?php in_array ('B', $checked3) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm3" value="C" id="pgm33"  <?php in_array ('C', $checked3) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php if ($mapel[0]['opsi']<>3) { ?>
											<?php $checked4 = explode(', ',$jawab['bs4']); ?>
						                     <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilD'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="pgm4" value="A"  id="pgm41"  <?php in_array ('A', $checked4) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm4" value="B" id="pgm42"  <?php in_array ('B', $checked4) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm4" value="C" id="pgm43"  <?php in_array ('C', $checked4) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php } ?>
						                    <?php if ($mapel[0]['opsi'] == 5) { ?>
											<?php $checked5 = explode(', ',$jawab['bs5']); ?>
						                    <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilE'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="pgm5" value="A"  id="pgm51"  <?php in_array ('A', $checked5) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm5" value="B" id="pgm52"  <?php in_array ('B', $checked5) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="pgm5" value="C" id="pgm53"  <?php in_array ('C', $checked5) ? print 'checked' : ''; ?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											<?php } ?>
						        
                                </table>
								  </form>
								<br><br>   
                            
                        </div>
                         <?php } ?>
						 
						 
		                 <?php if ($soal['jenis'] == '4' AND $soal['kode']=='') { ?>
						   <form id='myForm3'  method='POST' action='<?= $homeurl ?>/proses3.php'>
						   
								   <div class='col-md-12'>
									<table width='100%' class='table'>
												
											<td style='vertical-align:middle;background-color: #1dbb90; color:#fff'><span class='soal'>Pernyataan</span></td>
											<td style='vertical-align:middle;background-color: #1dbb90; color:#fff;width:60px'><span class='soal'>Benar</span></td>
											<td style='vertical-align:middle;background-color: #1dbb90; color:#fff;width:60px'><span class='soal'>Salah</span></td>
											</tr>
											<?php $checked = explode(', ',$jawab['bs1']); ?>
											<tr>
										<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilA'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs1" value="B"  id="bs1"  <?php if($jawab['bs1']=='B') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs1" value="S" id="bs11"  <?php if($jawab['bs1']=='S') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											<?php $checked = explode(', ',$jawab['bs2']); ?>
								           <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilB'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs2" value="B"  id="bs2"  <?php if($jawab['bs2']=='B') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs2" value="S" id="bs22"  <?php if($jawab['bs2']=='S') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
								            <?php $checked = explode(', ',$jawab['bs3']); ?>
											<tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilC'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs3" value="B"  id="bs3"  <?php if($jawab['bs3']=='B') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs3" value="S" id="bs33"  <?php if($jawab['bs3']=='S') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php if ($mapel[0]['opsi']<>3) { ?>
											<?php $checked = explode(', ',$jawab['bs4']); ?>
								           <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilD'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs4" value="B"  id="bs4"  <?php if($jawab['bs4']=='B') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs4" value="S" id="bs44"  <?php if($jawab['bs4']=='S') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php } ?>
											 <?php if ($mapel[0]['opsi'] == 5) { ?>
											<?php $checked = explode(', ',$jawab['bs5']); ?>
								           <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilE'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs5" value="B"  id="bs5"  <?php if($jawab['bs5']=='B') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs5" value="S" id="bs55"  <?php if($jawab['bs5']=='S') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php } ?>
											
								           </table>
								
				
											 <br><br> <br><br>
								<input type='hidden' name='id_mapel' value='<?= $id_mapel ?>' >
								<input type='hidden' name='id_siswa' value='<?= $id_siswa ?>' >
								<input type='hidden' name='id_soal' value='<?= $soal['id_soal'] ?>' >
								<input type='hidden' name='id_ujian' value='<?= $ac ?>' >
								
								</form>
                           
                        </div>
                    <?php } ?>

					  <?php if ($soal['jenis'] == '4' AND $soal['kode']=='FO') { ?>
						   <form id='myForm3'  method='POST' action='<?= $homeurl ?>/proses3.php'>
						 <div class='col-md-12'>
									<table width='100%' class='table'>
												
											<td style='vertical-align:middle;background-color: #1dbb90; color:#fff'><span class='soal'>Pernyataan</span></td>
											<td style='vertical-align:middle;background-color: #1dbb90; color:#fff;width:60px'><span class='soal'>Fakta</span></td>
											<td style='vertical-align:middle;background-color: #1dbb90; color:#fff;width:60px'><span class='soal'>Opini</span></td>
											</tr>
											<?php $checked = explode(', ',$jawab['bs1']); ?>
											<tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilA'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs1" value="F"  id="bs1"  <?php if($jawab['bs1']=='F') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs1" value="O" id="bs11"  <?php if($jawab['bs1']=='O') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											<?php $checked = explode(', ',$jawab['bs2']); ?>
								           <tr>
										<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilB'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs2" value="F"  id="bs2"  <?php if($jawab['bs2']=='F') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs2" value="O" id="bs22"  <?php if($jawab['bs2']=='O') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
								            <?php $checked = explode(', ',$jawab['bs3']); ?>
											<tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilC'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs3" value="F"  id="bs3"  <?php if($jawab['bs3']=='F') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs3" value="O" id="bs33"  <?php if($jawab['bs3']=='O') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php if ($mapel[0]['opsi']<>3) { ?>
											<?php $checked = explode(', ',$jawab['bs4']); ?>
								           <tr>
										<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilD'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs4" value="F"  id="bs4"  <?php if($jawab['bs4']=='F') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs4" value="O" id="bs44"  <?php if($jawab['bs4']=='O') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php } ?>
											 <?php if ($mapel[0]['opsi'] == 5) { ?>
											<?php $checked = explode(', ',$jawab['bs5']); ?>
								           <tr>
											<td style='vertical-align:middle;'><span class='soal'><?= $soal['pilE'] ?></span></td>
											<td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                            <label class="radio"><input type="radio" name="bs5" value="F"  id="bs5"  <?php if($jawab['bs5']=='F') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            <td class="text-center" style="padding:2px">
											<div class="checkbox icheck-primary">
                                           <label class="radio"><input type="radio" name="bs5" value="O" id="bs55"  <?php if($jawab['bs5']=='O') echo 'checked'?>>
											<span class="check"></span></label>
											</div>
											</td>
								            </tr>
											 <?php } ?>
								           </table>
								
								
											 <br><br> <br><br>
								<input type='hidden' name='id_mapel' value='<?= $id_mapel ?>' >
								<input type='hidden' name='id_siswa' value='<?= $id_siswa ?>' >
								<input type='hidden' name='id_soal' value='<?= $soal['id_soal'] ?>' >
								<input type='hidden' name='id_ujian' value='<?= $ac ?>' >
								
								</form>
                           
                        </div>
                    <?php } ?>
					
					
		                <?php if ($soal['jenis'] == 5) { ?>
		              <form id='myForm2'  method='POST' action='<?= $homeurl ?>/proses2.php'>
					  
					
                        <div class='col-md-12'>
                           
							 <?php $checked = explode(', ',$jawab['jawaburut']); ?>
							 <b class="sandik" style="color:red"><span class='soal'>Jika Gunakan HP Silahkan Geser Pernyataam Kekiri atau Kanan</span></b>
							 <div class='table-responsive'>
                            <table width='100%' class='table'>
												<tr>
												<td style="width:50%">
													<table class="table table-hover table-bordered" id="tabel-soal-1">
														<thead style="background-color: #1dbb90; color:#fff">
														<tr>
														<td><span class='soal'>Pernyataan</span></td>
															<td width="10px"></td>
														</thead>
														
														            <tr id="row1-5-1" class="tr-left-5">
																			<td onClick="pilih1('5','1','#00BCD4','1')" style='vertical-align:middle;'><span class='soal'><?= $soal['perA'] ?></span></td>
																			<td class="text-center" style="width:10px"  onClick="pilih1('5','1','#00BCD4','1')"><div id= "d_left_5_1" >
																			<div class="checkbox icheck-primary" id="radio_left_5_1">
																			<label class="radio"><input type="radio" name="left[5][1]" value="A" class="m-left-5" id= "r_left_5_1" onClick="pilih1('5','1','#00BCD4','1')" <?php in_array ('A', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td></tr>
																		<tr id="row1-5-2" class="tr-left-5">
																			<td onClick="pilih1('5','2','#F44336','2')" style='vertical-align:middle;'><span class='soal'><?= $soal['perB'] ?></span></td>
																			<td class="text-center" style="width:10px"  onClick="pilih1('5','2','#F44336','2')"><div id= "d_left_5_2">
																			<div class="checkbox icheck-primary" id="radio_left_5_2">
																			<label class="radio"><input type="radio" name="left[5][2]" value="B" class="m-left-5" id= "r_left_5_2" onClick="pilih1('5','2','#F44336','2')" <?php in_array ('B', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td></tr>
																			<tr id="row1-5-3" class="tr-left-5">
																			<td onClick="pilih1('5','3','#4CAF50','3')" style='vertical-align:middle;'><span class='soal'><?= $soal['perC'] ?></span></td>
																			<td class="text-center" style="width:10px"  onClick="pilih1('5','3','#4CAF50','3')"><div id= "d_left_5_3">
																			<div class="checkbox icheck-primary" id="radio_left_5_3">
																			<label class="radio"><input type="radio" name="left[5][3]" value="C" class="m-left-5" id= "r_left_5_3" onClick="pilih1('5','3','#4CAF50','3')" <?php in_array ('C', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td></tr>
																			<?php if ($mapel[0]['opsi']<>3) { ?>
																			<tr id="row1-5-4" class="tr-left-5">
																			<td onClick="pilih1('5','4','#FF9800','4')" style='vertical-align:middle;'><span class='soal'><?= $soal['perD'] ?></span></td>
																			<td class="text-center" style="width:10px"  onClick="pilih1('5','4','#FF9800','4')"><div id= "d_left_5_4">
																			<div class="checkbox icheck-primary" id="radio_left_5_4">
																			<label class="radio"><input type="radio" name="left[5][4]" value="D" class="m-left-5" id= "r_left_5_4" onClick="pilih1('5','4','#FF9800','4')" <?php in_array ('D', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td></tr>
						                                                   <?php } ?>
																			<?php if ($mapel[0]['opsi'] == 5) { ?>
																			<tr id="row1-5-5" class="tr-left-5">
																			<td onClick="pilih1('5','5','#FF9800','5')" style='vertical-align:middle;'><span class='soal'><?= $soal['perE'] ?></span></td>
																			<td class="text-center" style="width:10px"  onClick="pilih1('5','5','#0277BD','5')"><div id= "d_left_5_5">
																			<div class="checkbox icheck-primary" id="radio_left_5_5">
																			<label class="radio"><input type="radio" name="left[5][5]" value="E" class="m-left-5" id= "r_left_5_5" onClick="pilih1('5','5','#0277BD','5')" <?php in_array ('E', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td></tr>
                                                                               <?php } ?>																			
																		
																	</table>
																</td>
																
																<td style="width:50%">
																	<table class="table table-hover table-bordered" id="tabel-soal-2">
																		<thead style="background-color: #1dbb90; color:#fff">
																		<tr>
																			<td width="10px"></td>
																			<td><span class='soal'>Pilihan Jawaban</span></td>
																		</thead>
														              <tr id="row2-5-1" class="tr-right-5">
																			<td class="text-center" style="width:10px" onCLick="pilih2('5','1',2,'1','18','2')">
																			<div class="checkbox icheck-primary" id="radio_right_5_1">
																			 <label class="checkbox"> <input type="checkbox" name="urut[]" value="A" id="urut1"  class="m-right-5" <?php in_array ('A', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td>
																			<td onCLick="pilih2('5','1',2,'1','18','2')" style='vertical-align:middle;'><span class='soal'><?= $soal['pilA'] ?></span></td></tr>
																			
																			<tr id="row2-5-2" class="tr-right-5">
																			<td class="text-center" style="width:10px" onCLick="pilih2('5','2',2,'2','18','2')">
																			<div class="checkbox icheck-primary" id="radio_right_5_2">
																			 <label class="checkbox"> <input type="checkbox" name="urut[]" value="B" id="urut2"  class="m-right-5" <?php in_array ('B', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td>
																			<td onCLick="pilih2('5','2',2,'2','18','2')" style='vertical-align:middle;'><span class='soal'><?= $soal['pilB'] ?></span></td></tr>
																			
																			<tr id="row2-5-3" class="tr-right-5">
																			<td class="text-center" style="width:10px" onCLick="pilih2('5','3',2,'3','18','2')">
																			<div class="checkbox icheck-primary" id="radio_right_5_3">
																			 <label class="checkbox"> <input type="checkbox" name="urut[]" value="C" id="urut3"  class="m-right-5" <?php in_array ('C', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td>
																			<td onCLick="pilih2('5','3',2,'3','18','2')" style='vertical-align:middle;'><span class='soal'><?= $soal['pilC'] ?></span></td></tr>
																			 <?php if ($mapel[0]['opsi']<>3) { ?>
																			<tr id="row2-5-4" class="tr-right-5">
																			
																			<td class="text-center" style="width:10px" onCLick="pilih2('5','4',2,'4','18','2')">
																			<div class="checkbox icheck-primary" id="radio_right_5_4">
																			 <label class="checkbox"> <input type="checkbox" name="urut[]" value="D" id="urut4"  class="m-right-5" <?php in_array ('D', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td>
																			<td onCLick="pilih2('5','4',2,'4','18','2')" style='vertical-align:middle;'><span class='soal'><?= $soal['pilD'] ?></span></td></tr>	
						                                                     <?php } ?>
																		   <?php if ($mapel[0]['opsi'] == 5) { ?>
																			<td class="text-center" style="width:10px" onCLick="pilih2('5','5',2,'5','18','2')">
																			<div class="checkbox icheck-primary" id="radio_right_5_4">
																			 <label class="checkbox"> <input type="checkbox" name="urut[]" value="E" id="urut5"  class="m-right-5" <?php in_array ('D', $checked) ? print 'checked' : ''; ?>>
																			<span class="check"></span></label>
																			</div>
																			</td>
																			<td onCLick="pilih2('5','5',2,'5','18','2')" style='vertical-align:middle;'><span class='soal'><?= $soal['pilE'] ?></span></td></tr>	
																			  <?php } ?>
														
													                        </table>
																				<br><br>
																			</td>
																			</tr>
																		</table>
																		
																<div>
															
											 <input type='hidden' name='id_mapel' value='<?= $id_mapel ?>' >
								<input type='hidden' name='id_siswa' value='<?= $id_siswa ?>' >
								<input type='hidden' name='id_soal' value='<?= $soal['id_soal'] ?>' >
								<input type='hidden' name='id_ujian' value='<?= $ac ?>' >
                                   
										
										 </form>
										 <form id='myForm20'  method='POST' action='<?= $homeurl ?>/proses20.php'>
										 <input type='hidden' name='id_siswa' value='<?= $id_siswa ?>' >
								<input type='hidden' name='id_soal' value='<?= $soal['id_soal'] ?>' >
								<input type='hidden' name='id_ujian' value='<?= $ac ?>' >
					                     <center>
										 <p>Setelah klik ganti jawaban pindahkan dulu ke soal sebelumnya atau selanjutnya agar jawaban soal ini kosong lagi</p>
										 <button  id="ganti" class="btn btn-primary btn-sm"> Ganti Jawaban</button>
										 </center>
										 </form>
										 <hr>
                                   </div>
                   
		  <?php } ?>
		
            <div class='box-footer navbar-fixed-bottom'>
                <table width='100%'>
                    <tr>
                        <td style="text-align:center">
                            <button id='move-prev' class='btn  btn-primary' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_prev ?>)"><i class='fas fa-chevron-circle-left'></i> <span class='hidden-xs'>Prev</span></button>
                           
                        </td>
                        <?php if ($soal['jenis'] == 1) { ?>
                            <td style="text-align:center">
                                     
                                <div id='load-ragu'>
                                    <a href='#' class='btn btn-warning'><input type='checkbox' onclick="radaragu(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, <?= $ac ?>)" <?= $ragu = ($jawab['ragu'] == 1) ? 'checked' : ''; ?> /> Ragu <span class='hidden-xs'>- Ragu</span></a>
                                </div>
                                   
                            </td>
                        <?php } ?>
                        <td style="text-align:center">
                            <?php
                            $jumsoalpg = $mapel[0]['tampil_pg'] + $mapel[0]['tampil_esai'] + $mapel[0]['tampil_multi'] + $mapel[0]['tampil_bs'] + $mapel[0]['tampil_urut'];

                            $cekno_soal = $no_soal + 1;
                            ?>
                            <?php if (($no_soal >= 0) && ($cekno_soal < $jumsoalpg)) { ?>

                               
                                <button id='move-next' class='btn  btn-success' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_next ?>)"><span class='hidden-xs'>Next </span><i class='fas fa-chevron-circle-right'></i></button>

                            <?php } elseif (($no_soal >= 0) && ($cekno_soal = $jumsoalpg) && ($jumsoalesai == 0)) { ?>
                                <input type='submit' name='done' id='selesai-submit' style='display:none;' />
                                <button class='done-btn btn btn-danger'><i class="fas fa-flag-checkered    "></i> <span class='hidden-xs'>TEST </span>SELESAI</button>
                               
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
    <?php
        }
    }
    ?>
	

    <script>
        $(document).ready(function() {
            $('#zoom').zoom();
            $('#zoom1').zoom();
            $('.lup').zoom();
            $('.soal img')
                .wrap('<span style="display:inline-block"></span>')
                .css('display', 'block')
                .parent()
                .zoom();
        });
    </script>
    <script>
        $(document).ready(function() {
            Mousetrap.bind('enter', function() {
                loadsoal(<?= $id_mapel . "," . $id_siswa . "," . $no_next ?>);
            });

            Mousetrap.bind('right', function() {
                loadsoal(<?= $id_mapel . "," . $id_siswa . "," . $no_next ?>);
            });

            Mousetrap.bind('left', function() {
                loadsoal(<?= $id_mapel . "," . $id_siswa . "," . $no_prev  ?>);
            });

            Mousetrap.bind('a', function() {
                $('#A').click()
            });

            Mousetrap.bind('b', function() {
                $('#B').click()
            });

            Mousetrap.bind('c', function() {
                $('#C').click()
            });

            Mousetrap.bind('d', function() {
                $('#D').click()
            });

            Mousetrap.bind('e', function() {
                $('#E').click()
            });

            Mousetrap.bind('space', function() {
                $('input[type=checkbox]').click()
                radaragu(<?= $id_mapel . "," . $id_siswa . "," . $soal['id_soal'] ?>, <?= $ac ?>)
            });

        });
    </script>
    <script>
        MathJax.Hub.Typeset()
    </script>
<?php } ?>
<?php
if ($pg == 'jawab') {
    $jenis = $_POST['jenis'];
    $dataesai = array(
        'id_ujian' => $_POST['idu'],
        'id_mapel' => $_POST['id_mapel'],
        'id_siswa' => $_POST['id_siswa'],
        'id_soal' => $_POST['id_soal'],
        'jenis' => $_POST['jenis'],
        'esai' => strtolower($_POST['jawaban'])
    );
    $data = array(
        'id_ujian' => $_POST['idu'],
        'id_mapel' => $_POST['id_mapel'],
        'id_siswa' => $_POST['id_siswa'],
        'id_soal' => $_POST['id_soal'],
        'jenis' => $_POST['jenis'],
        'jawaban' => $_POST['jawaban'],
        'jawabx' => $_POST['jawabx']
    );
	 
    $where = array(
        'id_ujian' => $_POST['idu'],
        'id_mapel' => $_POST['id_mapel'],
        'id_siswa' => $_POST['id_siswa'],
        'id_soal' => $_POST['id_soal'],
        'jenis' => $jenis
    );
    $cekjawaban = rowcount($koneksi, 'jawaban', $where);

    if ($jenis == 1) {
        if ($cekjawaban == 0) {
            $exec = insert($koneksi, 'jawaban', $data);
        } else {
            $exec = update($koneksi, 'jawaban', $data, $where);
        }
    } else {
        if ($cekjawaban == 0) {
            $exec = insert($koneksi, 'jawaban', $dataesai);
        } else {
            $exec = update($koneksi, 'jawaban', $dataesai, $where);
        }
    }
    echo $exec;
} elseif ($pg == 'ragu') {
    $where = array(
        'id_mapel' => $_POST['id_mapel'],
        'id_siswa' => $_POST['id_siswa'],
        'id_soal' => $_POST['id_soal'],
        'id_ujian' => $_POST['id_ujian'],
        'jenis' => 1
    );
    $cekragu = fetch($koneksi, 'jawaban', $where);
    if ($cekragu['ragu'] == 0) {
        $exec = update($koneksi, 'jawaban', array('ragu' => 1), $where);
    } else {
        $exec = update($koneksi, 'jawaban', array('ragu' => 0), $where);
    }
    echo $exec;
}

?>
<script>
$("#subA").click(function() {
	$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm").submit(function(){
	return false;
});
$("#subB").click(function() {
	$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm").submit(function(){
	return false;
});
$("#subC").click(function() {
	$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm").submit(function(){
	return false;
});
$("#subD").click(function() {
	$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm").submit(function(){
	return false;
});

$("#subE").click(function() {
	$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm").submit(function(){
	return false;
});
 

</script>


<script>
$("#urut1").click(function() {
	$.post($("#myForm2").attr("action"), $("#myForm2 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm2").submit(function(){
	return false;
});
 $("#urut2").click(function() {
	$.post($("#myForm2").attr("action"), $("#myForm2 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm2").submit(function(){
	return false;
});
$("#urut3").click(function() {
	$.post($("#myForm2").attr("action"), $("#myForm2 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm2").submit(function(){
	return false;
});
$("#urut4").click(function() {
	$.post($("#myForm2").attr("action"), $("#myForm2 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm2").submit(function(){
	return false;
});
$("#urut5").click(function() {
	$.post($("#myForm2").attr("action"), $("#myForm2 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm2").submit(function(){
	return false;
});
</script>




<script>
$("#bs1").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});


$("#bs11").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});
$("#bs2").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});


$("#bs22").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});
$("#bs3").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});


$("#bs33").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});
$("#bs4").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});


$("#bs44").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});
$("#bs5").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});


$("#bs55").click(function() {
	$.post($("#myForm3").attr("action"), $("#myForm3 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm3").submit(function(){
	return false;
});


</script>

	<script>
$("#pgm11").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
 $("#pgm12").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
$("#pgm13").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 $("#pgm21").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
 $("#pgm22").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
$("#pgm23").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});

$("#pgm31").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
 $("#pgm32").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
$("#pgm33").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
$("#pgm41").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
 $("#pgm42").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
$("#pgm43").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
$("#pgm51").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
 $("#pgm52").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm8").submit(function(){
	return false;
});
$("#pgm53").click(function() {
	$.post($("#myForm8").attr("action"), $("#myForm8 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
$("#myForm8").submit(function(){
	return false;
});

</script>
<script>
$("#ganti").click(function() {
	$.post($("#myForm20").attr("action"), $("#myForm20 :input").serializeArray(), function(info) { $("#result").html(info); });
	clearInput();
});
 
$("#myForm20").submit(function(){
	return false;
});
	</script>			

	
<script>
	
	
					var left = '';
			
			eval('var right_5' + '= "";');
			
			eval('var warna1_5' + '= "";');
			
			eval('var id1_5' + '= "";');
			
			eval('var pos1_5' + '= "";');
			
			eval('var pos11_5' + '= "";');
			
			eval('var dipilih1_5' + '= [];');
			
			eval('var dipilih2_5' + '= [];');
			
			eval('var order1_5' + '= "";');
		
			eval('var free1_5' + '= true;');
			
			eval('var free_5' + '= true;');
			
			eval('var jawab_5' + '= "";');
			
			eval('var jawaban_5' + '= "";');
			
		
					
		
	function pilih1(no, id, warna, order) {
			
			// if (window['right_'+no] == '') {
				// $('.m-left-'+no).prop('checked', false);
				// $('.tr-left-'+no).css('background','');
			// }
			//if (window['dipilih1_'+no].indexOf(id) >=0) window['free1_'+no]=false;
			if (window['free1_'+no]) {
				window['free1_'+no] = false;
				$('#r_left_'+no+'_'+id).prop('checked', true);
				$('#row1-'+no+'-'+id).css('background',warna);
				window['pos1_'+no] = $('#r_left_'+no+'_'+id).offset();
				window['pos11_'+no] = $('#r_left_'+no+'_'+id).position();
				window['warna1_'+no] = warna;
				window['id1_'+no] = id;
				window['order1_'+no] = order;
				window['dipilih1_'+no].push(id);
				window['jawab_'+no] = id;
			}
			
	}
	
	function removeA(arr) {
		var what, a = arguments, L = a.length, ax;
		while (L > 1 && arr.length) {
			what = a[--L];
			while ((ax= arr.indexOf(what)) !== -1) {
				arr.splice(ax, 1);
			}
		}
		return arr;
	}
	
	function rgb2hex(rgb) {
		rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
		function hex(x) {
			return ("0" + parseInt(x).toString(16)).slice(-2);
		}
		return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
	}
	
	
	
	function pilih2(no, id,tipe,order,s, ps) {
		var _c_pilih = $('#urut'+no+'_'+id).prop('checked');
		if (_c_pilih==true) {
			//alert('1');
			
			var id1 =  window['pasangan_'+no+'_'+id];
			window['free1_'+no] = false;
			//$('#r_left_'+no+'_'+id).prop('checked', true);
			var warna11 = rgb2hex($('#row2-'+no+'-'+id).css('background-color'));
			window['warna1_'+no] = warna11;
			window['pos1_'+no] = $('#r_left_'+no+'_'+id1).offset();
			window['pos11_'+no] = $('#r_left_'+no+'_'+id1).position();
			var cc = id1+";"+id+'|';
			var ddd = window['jawaban_'+no];
			dd = ddd.replace(cc,"");
			window['jawaban_'+no] = dd;
			
			window['id1_'+no] = id1;
			window['free1_'+no] = false;
			window['right_'+no] = '';
			window['free_'+no] = true;
			//delete window['dipilih2_'+no][id];
			//window['dipilih2_'+no].remove(id);
			removeA(window['dipilih2_'+no], id);
			//$('#r_right_'+no+'_'+id).prop('checked', false);
			//$('.line-'+no).css('display','none');
			var xx = '#line_'+no+'_'+window['id1_'+no];
			//alert(xx);
			$(xx).css('display','none');
			$('#r_right_'+no+'_'+id).prop('checked', false);
			$('#row2-'+no+'-'+id).css('background','#ffffff');
		}
		else 
		{
			//alert('2');
			window['free_'+no] = true;
			if (window['dipilih2_'+no].indexOf(id) >=0) window['free_'+no]=false;
			//alert(2);
			
			if ((window['id1_'+no] != '') && window['free_'+no] && (window['right_'+no] == '')) {
				//alert(3);
				window['free1_'+no] = true;
				window['right_'+no] = '';
				eval('var pasangan_'+no+'_'+id + '= "";');
				window['pasangan_'+no+'_'+id] = window['id1_'+no];
				window['jawaban_'+no] = window['jawaban_'+no]+ window['id1_'+no] +';'+ id +'|';
				window['dipilih2_'+no].push(id);
				$('#r_right_'+no+'_'+id).prop('checked', true);
				$('#row2-'+no+'-'+id).css('background',window['warna1_'+no]);
				$('#r_right_'+no+'_'+id).val(window['id1_'+no]+';'+id);
				
				pos2 = $('#r_right_'+no+'_'+id).offset();
				pos22 = $('#r_right_'+no+'_'+id).position();
				$('#svg_'+no+'_'+window['id1_'+no]).css('left',window['pos1_'+no].left);
				$('#line_'+no+'_'+window['id1_'+no]).fadeIn();
				if (window['pos1_'+no].top > pos2.top) {
					$('#line_'+no+'_'+window['id1_'+no])
						.attr('x1',0)
						.attr('y1',window['pos1_'+no].top-pos2.top)
						.attr('x2',Math.abs(window['pos1_'+no].left-pos2.left))
						.attr('y2',0)
						.attr('stroke',window['warna1_'+no])
						;
					$('#svg_'+no+'_'+window['id1_'+no]).css('top',pos2.top);
					$('#svg_'+no+'_'+window['id1_'+no]).css('left',window['pos1_'+no].left);
					$('#svg_'+no+'_'+window['id1_'+no]).css('height',Math.abs(window['pos1_'+no].top-pos2.top));
					$('#svg_'+no+'_'+window['id1_'+no]).css('width',Math.abs(window['pos1_'+no].left-pos2.left));
				} else {
					$('#line_'+no+'_'+window['id1_'+no])
						.attr('x1',0)
						.attr('y1',0)
						.attr('x2',Math.abs(window['pos1_'+no].left-pos2.left)-0)
						.attr('y2',Math.abs(window['pos1_'+no].top-pos2.top))
						.attr('stroke',window['warna1_'+no])
						;
					$('#svg_'+no+'_'+window['id1_'+no]).css('top',window['pos1_'+no].top);
					$('#svg_'+no+'_'+window['id1_'+no]).css('left',window['pos1_'+no].left+10);
					$('#svg_'+no+'_'+window['id1_'+no]).css('height',Math.abs(window['pos1_'+no].top-pos2.top));
					$('#svg_'+no+'_'+window['id1_'+no]).css('width',Math.abs(window['pos1_'+no].left-pos2.left)-10);
				}
				
				window['id1_'+no] = '';
				jawaban = window['jawaban_'+no];
				n = no;
				
				if (jawaban == '')
					$("#answer"+n).html('');
				else {
					$("#answer"+n).html('<i class="fa fa-check"></i>');
					$("#answer"+n).removeClass('d-none');
				}
			
				
					$("#tmp_answer_"+n).html(jawaban);
					if (ps == '2')	   {
						save_answer(n,jawaban);
						//pushPromise(s,jawaban);
					}
				
				
				
				trigger_ragu(selected);

			} else {
				if (tipe==2)
				$('#r_right_'+no+'_'+id).prop('checked', false);
			}
		
		}
		
	}
	
			eval('var tipesoal_pencocokan_1 = "1"');
			eval('var tipesoal_pencocokan_2 = "2"');
			eval('var tipesoal_pencocokan_3 = "3"');
			eval('var tipesoal_pencocokan_4 = "4"');
			eval('var tipesoal_pencocokan_5 = "5"');
			
		eval('var soal_pencocokan_5 = "18"');
		eval('var jawaban_pencocokan_5 = ""');
		eval('var warna_pencocokan_5 = ["#1E88E5","#00BCD4","#F44336","#4CAF50","#FF5722","#E91E63","#9C27B0","#673AB7","#5C6BC0","#03A9F4","#FF9800","#0277BD"]');
								
			
		
	function redrawline(no) {
		var tmp_tipesoal = window['5_'+no];
		if (tmp_tipesoal == 5) {
			resetKunci(no,'');
			var tmp = $('#tmp_answer_'+no).html();//window['jawaban_pencocokan_'+no];
			var tmp_warna = window['warna_pencocokan_'+no];
			var tmp_soal = window['soal_pencocokan_'+no];
			var arr_tmp = tmp.split('|');
			for (i=0;i<arr_tmp.length;i++) {
				if (arr_tmp[i].trim() != '') {
					var arr_tmp2 = arr_tmp[i].split(';');
					pilih1(no,arr_tmp2[0], tmp_warna[i], i);
					pilih2(no,arr_tmp2[1], '2', arr_tmp2[1],tmp_soal,'1');
				}
			}
			
			$('#c-svg-'+no).fadeIn();
		}
	}
	
	
</script>

<script>
function kelapKelip() {
$('.sandik').fadeOut(); 
$('.sandik').fadeIn(); 
}
setInterval(kelapKelip, 1000); 
</script>
