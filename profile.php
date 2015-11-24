<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
error_reporting(0);

$uid = $_SESSION['uid'];

//Ambil profile id
$member_id = $_GET['id'];
?>

<html>
<head>
    <title>Website Pertemanan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/dinding.css" rel="stylesheet" type="text/css">
    <link href="css/surat.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.1.4.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.form.js" type="text/javascript"></script>
    <script src="js/jquery.livequery.js" type="text/javascript"></script>
    <script src="js/jquery.oembed.js" type="text/javascript"></script>
    <script src="js/suggest.js" type="text/javascript"></script>
    <script src="js/wall.js" type="text/javascript"></script>
    <script src="js/surat.js" type="text/javascript"></script>
</head>
<body>
<div class="top">
<div class="main">
<?php include ('atas.php');
/*Jika membuka profil sendiri*/
if($uid == $member_id) {
?>
    <div class="left">
        <div class="propic">
        <?php
            $query = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
            $row = mysql_fetch_array($query);
            if($row['gambar_profil'] != NULL ) {
                $image = "member/$member_id/$row[gambar_profil]";
            }
            else {
                $image = "image/default.png";
            }
        ?>
            <a href="profile_photo.php">
               <img src="<?php echo $image; ?>" class="big_profile">
            </a>
        </div>
        <div class="link_style1">
            <?php include ('kiri.php'); ?>    
        </div>
    </div>
    
    <div class="right">
        <div class="list"></div>
        <div id="wall_container">
            <h3><?php echo $row['nama']; ?>&nbsp;&nbsp;&nbsp;
                <a href="#" id="klikfoto">
                    <img src="image/foto.png">
                </a>
            </h3>
            <div id="updateboxarea">
                <textarea cols="30" rows="4" name="update" id="update" maxlength="200" ></textarea>
                <input type="hidden" name="id_dinding" id="id_dinding" value="<?php echo $member_id; ?>">
                <div id="showthumb"></div>
                <input type="submit" value="Update" id="update_button" class="update_button">
                <form method="post" action="uploadgambar.php" id="frmUpload" enctype="multipart/form-data">
                    <div style="display:none" id="bukafoto" class="bukafoto">
                        <b>Silahkan upload foto anda dengan max ukuran 1MB</b><br>
                        <input type="file" name="photoimg" id="photoimg">
                        <input type="hidden" name="id_dinding2" value="<?php echo $member_id;?>">
                    </div>
                </form>
            </div>
            <div id="flashmessage">
                <div id="flash" align="left"></div>
            </div>
            <div id="content">
                <?php include ('buka_status_profil.php'); ?>
            </div>
        </div>
    </div>

<!--Jika membuka bukan profil sendiri-->
<?php 
} 
else { 
            $sql_teman = mysql_query("SELECT array_teman FROM user WHERE uid='$uid' LIMIT 1");
            while($row=mysql_fetch_array($sql_teman)) {
                $arrayteman = $row['array_teman'];
            }
            $teman = explode(",",$arrayteman);
    
            //Jika member ini sudah menjadi teman, tampilkan profilnya
            if(in_array($member_id, $teman)) {
                $sql_profil = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
                $row=mysql_fetch_array($sql_profil);
                if($row['gambar_profil'] != NULL) {
                    $image= "member/$member_id/$row[gambar_profil]";
                } else {
                    $image = "image/default.png";
                }
?>
    <div class="left">
        <div class="propic">
            <img src="<?php echo $image;?>" class="big_profile">
        </div>
        <div class="link style1">
            <?php include ('kiri.php'); ?>
        </div>
    </div>
    
    <div class="right">
        <div class="list"></div>
        <div id="wall_container">
            <h3><?php echo $row['nama'];?> &nbsp;&nbsp;&nbsp;
                <a href="#" class="muncul">
                    <img src="image/message.png" alt="Kirim Pesan">&nbsp;
                </a>
                <a href="#" id="klikfoto">
                    <img src="image/foto.png" >
                </a>
            </h3>
            
            <!--Form kirim pesan-->
            <div id="contact" >
                <div id="close">Close</div>
                <div id="contact_header">Kirim Pesan</div>
                <p class="success">Pesan Sudah Terkirim.</p>
                <form action="kirim_pesan.php" method="post" name="formPesan" id="formPesan">
                    <p><input name="id_pengirim" id="id_pengirim" type="hidden" size="30" value="<?php echo $uid; ?>"></p>
                    <p><input name="id_penerima" id="id_penerima" type="hidden" size="30" value="<?php echo $member_id; ?>"></p>
                    <p>
                        <input name="penerima" id="penerima" type="text" size="50" value="Kepada : <?php echo $row['nama']; ?>" disabled>
                        &nbsp;&nbsp; <img src="<?php echo "member/$member_id/$row[gambar_profil_kecil]" ; ?>" >
                        <input name="subject" id="subject" type="text" size="50" placeholder="Subject" >
                    </p>
                    <p>
                        <textarea name="pesan" id="pesan" rows="5" cols="80"></textarea>
                    </p>
                    <p><input type="submit" id="simpan_pesan" name="simpan_pesan" value="Kirim"></p>
                </form>
            </div>
            <div id="mask"></div>
            <!--End contact-->
            
            <div id="updateboxarea">
                <textarea cols="30" rows="4" name="update" id="update" maxlength="200" ></textarea>
                <input type="hidden" name="id_dinding" id="id_dinding" value="<?php echo $member_id; ?>">
                <div id="showthumb"></div>
                <input type="submit" value="Update" id="update_button" class="update_button">
                <form method="post" action="uploadgambar.php" id="frmUpload" enctype="multipart/form-data">
                    <div style="display:none" id="bukafoto" class="bukafoto">
                        <b>Silahkan upload foto anda dengan max ukuran 1MB</b><br>
                        <input type="file" name="photoimg" id="photoimg">
                        <input type="hidden" name="id_dinding2" value="<?php echo $member_id;?>">
                    </div>
                </form>
            </div>
            <div id="flashmessage">
                <div id="flash" align="left"></div>
            </div>
            <div id="content">
                <?php include ('buka_status_profil.php'); ?>
            </div>
        </div>
    </div>
    
        <?php }
            //Jika member ini BELUM menjadi teman
            if(!in_array($member_id, $teman)) {
                $sql_profil = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
                $row=mysql_fetch_array($sql_profil);
                if($row['gambar_profil'] != NULL) {
                    $image= "member/$member_id/$row[gambar_profil]";
                } else {
                    $image = "image/default.png";
                }
        ?>
    <div class="left">
        <div class="propic">
            <img src="<?php echo $image;?>" class="big_profile">
        <?php
        /*Cek Apakah permintaan teman sudah pernah dilakukan*/
        $cek_minta = mysql_query("SELECT * FROM permintaan_teman 
                                WHERE mem2='$uid' AND mem1='$member_id'
                                OR mem2='$member_id' AND mem1='$uid'");
        $user_ada = mysql_num_rows($cek_minta);
            if($user_ada==1) {
        ?>
            <script language="javascript">
                alert("Maaf, Anda sudah memiliki permintaan teman dari user ini!");
                document.location="home.php";
            </script>
        <?php } ?>
        </div>
    </div>
    
    <div class="right">
        <div class="list"></div>
        <div id="wall_container">
            <div id="updateboxarea">
            <div>
                Jadikan <b><?php echo $row['nama']; ?></b> Teman Kamu    
            </div>
            <form method="post" action="tambah_teman.php" name="proses_tambah">
                <input type="submit" class="greenButton" value="Add Friend" name="tambah_teman">
                <input type="hidden" name="mem2" value="<?php echo $member_id; ?>">
            </form>
            </div>
            <div id="flashmessage">
                <div id="flash" align="left"></div>
            </div>
            <div id="content">
            </div>
        </div>
    </div>
    
    <?php }
    }

    /*Cek Apakah user id terdaftar? jika belum munculkan pesan*/
    $sql_cek = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
    $user_ada = mysql_num_rows($sql_cek);
    if($user_ada==0) {
    ?>
    <script language="javascript">
        alert("Maaf, User ini tidak terdaftar!!");
        document.location="home.php";
    </script>
    <?php
        }
?>
    
</div>    
</div>    
</body>
</html>