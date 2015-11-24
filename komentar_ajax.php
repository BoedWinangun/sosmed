<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
include_once 'include/tolink.php';
include_once 'include/time_stamp.php';

$uid = $_SESSION['uid'];

//Ambil gambar profile
$query = mysql_query ("SELECT gambar_profil_kecil FROM user WHERE uid='$uid'");
$row = mysql_fetch_array ($query);
if ($row['gambar_profil_kecil'] != NULL) {
    $image = "member/$uid/profile".$uid.".jpg";
}else{
    $image = "image/default.png";
}
    
//Tampil komentar ter_update
    if (isset($_POST['komentar'])) {
        $komentar = $_POST['komentar'];
        $idstatus = $_POST['idstatus'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $komentar = htmlentities($komentar);
        $time = time();
        
        $query = mysql_query("SELECT idkomentar,komentar FROM komentar 
                            WHERE uid=$uid AND idstatus='$idstatus'
                            ORDER BY idkomentar DESC LIMIT 1");
        $result = mysql_fetch_array($query);
        
        if($komentar!=$result['komentar'] ) {
            $query = mysql_query("INSERT INTO komentar (komentar,
                                                        uid,
                                                        idstatus,
                                                        ip,
                                                        dibuat)
                                                VALUES ('$komentar',
                                                        '$uid',
                                                        '$idstatus',
                                                        '$ip',
                                                        '$time')");
            $oquery = mysql_query("SELECT * FROM komentar,user
                                WHERE komentar.uid=user.uid
                                AND komentar.uid='$uid'
                                AND komentar.idstatus='$idstatus'
                                ORDER BY komentar.idkomentar DESC LIMIT 1");
            $result = mysql_fetch_array($oquery);
            
            $idkom = $result['idkomentar'];
            $kom = tolink(htmlentities($result['komentar']));
            $time = $result['dibuat'];
            $nama = $result['nama'];
            $uid = $result['uid'];
            $face = $image;
?>

<div class="stcommentbody" id="stcommentbody<?php echo $idkom; ?>">
    <div class="stcommentimg">
        <img src="<?php echo $face; ?>" class="small_face">
    </div>
    <div class="stcommenttext">
        <a class="stcommentdelete" href="#" id="<?php echo $idkom; ?>" title="Hapus Komentar">x</a>
        <b><?php echo $nama; ?></b> <?php echo $kom; ?><br>
        <div class="stcommenttime"><?php time_stamp($time); ?></div>        
    </div>
</div>
<?php 
        }
    }
?>
            