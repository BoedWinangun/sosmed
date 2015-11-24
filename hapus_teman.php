<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

$uid = $_SESSION['uid'];

//Hapus Pertemanan
$id_mem=$_POST['mem2'];
    // query untuk user yang ingin menghapus pertemanan
    $sql_array_teman1 = mysql_query("SELECT array_teman FROM user WHERE uid='$uid' LIMIT 1");  
    while($row=mysql_fetch_array($sql_array_teman1)) { 
        $array_teman1 = $row["array_teman"]; 
    }
    // query untuk user yang ingin dihapus pertemanan
    $sql_array_teman2 = mysql_query("SELECT array_teman FROM user WHERE uid='$id_mem' LIMIT 1");
    while($row=mysql_fetch_array($sql_array_teman2)) { 
      $array_teman2 = $row["array_teman"]; 
    }
    // Pecah array masing-masing user
    $arrayTeman1 = explode(",", $array_teman1);
    $arrayTeman2 = explode(",", $array_teman2);

    // inilah perintah untuk menghapus user dalam sebuah array dengan fungsi "unset"
    // hapus nilai key user yang ingin menghapus pada array_teman di hapus
    foreach ($arrayTeman1 as $key => $value) {
        if ($value == $id_mem) {
            unset($arrayTeman1[$key]);
        } 
    }
    //hapus nilai key user yang ingin dihapus pada array_teman yang menghapus
    foreach ($arrayTeman2 as $key => $value) {
        if ($value == $uid) {
            unset($arrayTeman2[$key]);
        } 
    } 
    // sekarang gunakan fungsi implode untuk mengembalikan lagi ke dalam string setelah array tadi sebelumnya di unset
    $stringArrayBaru1 = implode(",", $arrayTeman1);
    $stringArrayBaru2 = implode(",", $arrayTeman2);

    // Dan setelah kembali menjadi string, update array ke masing2 user yang menghapus dan dihapus
    $sql = mysql_query("UPDATE user SET array_teman='$stringArrayBaru1' WHERE uid='$uid'");
    $sql = mysql_query("UPDATE user SET array_teman='$stringArrayBaru2' WHERE uid='$id_mem'");
?>