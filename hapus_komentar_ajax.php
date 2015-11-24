<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

$uid = $_SESSION['uid'];
if(isset($_POST['idkom'])) {
    $idkom = $_POST['idkom'];
    $query = mysql_query("DELETE FROM komentar
                        WHERE uid='$uid' 
                        AND idkomentar='$idkom'");
}
?>