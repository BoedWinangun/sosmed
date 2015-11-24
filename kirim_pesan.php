<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

if($_POST) {
    $id_pengirim = $_POST['id_pengirim'];
    $id_penerima = $_POST['id_penerima'];
    $subject = $_POST['subject'];
    $pesan = $_POST['pesan'];
    $tgl = date('Y-m-d');
    
    if(!empty($subject) && !empty($pesan)) {
        $sql = mysql_query("INSERT INTO pesan (id_pengirim,
                                                id_penerima,
                                                tgl,
                                                subjek,
                                                pesan,
                                                dibuka)
                                        VALUES ('$id_pengirim',
                                                '$id_penerima',
                                                '$tgl',
                                                '$subject',
                                                '$pesan',
                                                '1')");
    }
}
?>