<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

$mem1 = $_SESSION['uid'];
$mem2 = $_POST['mem2'];

mysql_query("INSERT INTO permintaan_teman (mem1, mem2, timedate) 
            VALUES ('$mem1', '$mem2', now())");
?>

<script language="javascript">
    alert("Permintaan Teman Berhasil");
    document.location="home.php";
</script>
?>