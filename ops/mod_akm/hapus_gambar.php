<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
$id = $_POST['id'];
 $soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$id'"));
   $soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$id'"));
    (file_exists("../files/" . $soal[$file])) ? unlink("../files/" . $soal[$file]) : null;
    mysqli_query($koneksi, "UPDATE soal SET file='' WHERE id_soal='$id'");