<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

$uid = $_SESSION['uid'];

if(isset($_POST['idstatus'])) {
    $idstatus = $_POST['idstatus'];
    $oquery = mysql_query("SELECT * FROM status 
                        WHERE idstatus='$idstatus' AND uid='$uid'");
    $row = mysql_fetch_array($oquery);
    $foto = $row['foto'];
    $query = mysql_query("DELETE FROM komentar 
                        WHERE idstatus='$idsatatus'");
    $query = mysql_query("DELETE FROM status
                        WHERE idstatus='$idstatus' AND uid='$uid'");
    unlink("member/$uid/foto/$foto");    
}
?>