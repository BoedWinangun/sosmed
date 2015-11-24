<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

if($_POST) {
    $id_pengirim = $_SESSION['uid'];
    $id_penerima = $_POST['id_penerima'];
    $subject     = $_POST['subject'];
    $pesan       = $_POST['textbalas'];
    $tgl         = date('Y-m-d');
    
    if(!empty($subject) && !empty($pesan)) {
        $query = mysql_query("INSERT INTO pesan(id_pengirim,
                                                id_penerima,
                                                tgl,
                                                subjek,
                                                pesan,
                                                dibuka)
                                        VALUES('$id_pengirim',
                                            '$id_penerima',
                                            '$tgl',
                                            '$subject',
                                            '$pesan',
                                            '1')");
    }
}
?>