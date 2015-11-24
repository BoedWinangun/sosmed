<?php
error_reporting(0);
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

if($_POST['hapus_button']) {
    $cek = $_POST['cek'];
    //Hitung jumlah yang dicentang (dihapus)
    $jumlah = count($cek);
    if($jumlah==0) {
?>
    <script language="javascript">
        alert("Centang dulu pesan yang mau dihapus");
        document.location="inbox.php";
    </script>
<?php
    }
    //looping delete sebanyak jumlah yang di centang
    for($i=0;$i<$jumlah;$i++) {
        mysql_query("DELETE FROM pesan WHERE id='$cek[$i]'");
?>
    <script languge="javascript">
        document.location="inbox.php";
    </script>
<?php
    }
}
?>