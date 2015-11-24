<?php 
    include_once 'include/db.php';
//jika user mendaftar
$nama       = $_POST['nama'];
$gender     = $_POST['gender'];
$tgl        = $_POST['tgl'];
$bln        = $_POST['bulan'];
$thn        = $_POST['tahun'];
$tanggal    = "$thn-$bln-$tgl";
$email      = $_POST['email'];
$pass       = $_POST['pass'];
$password   = md5($pass);

//cek apakah semua fiel sudah terisi semua
if(empty($nama) || empty($email) || empty($pass)) {
    die(msg(0,"Semua field harus di isi..!"));
}

//apakah sudah memilih gender
if(!(int)$gender) {
    die(msg(0,"Pilih Jenis kelamin dulu"));
}

if($gender=="1"){$jenkel = "laki-laki";}
else{$jenkel = "perempuan";}

//apakah sudah memilih tgl lahir?
if(!(int)$tgl || !(int)$bln || !(int)$thn) {
    die(msg(0,"Pilih tanggal lahir"));
}

//apakah email valid
if(!(preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-])+[A-z]{1,4}$/", $email))) {
    die (msg(0,"Masukkan alamat email yang benar"));
}

//cek apakah email sudah pernah tedaftar atau belum
$sql = mysql_query("SELECT uid FROM user WHERE email='$email'");
$rows = mysql_num_rows($sql);

if($rows == 0) {
    $result = mysql_query("INSERT INTO user (password, nama, tgl_lahir, gender, email)
                            VALUES ('$password', '$nama', '$tanggal', '$jenkel', '$email')");
    $uid = mysql_insert_id();
    mkdir ("member/$uid", 0755);
    mkdir ("member/$uid/foto", 0755);
    
    //registrasi sukses
    die(msg(1,"Registrasi berhasil, Silakan Login"));
}
else {
    //registrasi gagal
    die(msg(0,"Registrasi gagal, Email sudah terdaftar"));
}

function msg($status, $txt) {
    return '{"status":'.$status.',"txt":"'.$txt.'"}';
}