<?php
error_reporting(0);
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

$uid = $_SESSION['uid'];

//Ambil profile id
$member_id = $_GET['id'];
?>

<html>
<head>
    <title>Website Pertemanan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/dinding.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.1.4.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.form.js" type="text/javascript"></script>
    <script src="js/jquery.livequery.js" type="text/javascript"></script>
    <script src="js/jquery.oembed.js" type="text/javascript"></script>
    <script src="js/suggest.js" type="text/javascript"></script>
    <script src="js/wall.js" type="text/javascript"></script>
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
        <div class="member_title">
            <img src="image/friends_request.png" >&nbsp; Permintaan Teman
        </div>
        <ul id="member">
        <?php
            $sql = mysql_query("SELECT * FROM permintaan_teman, user
                            WHERE permintaan_teman.mem1=user.uid 
                            AND permintaan_teman.mem2='$uid'");
            while($row=mysql_fetch_array($sql)) {
                if($row['gambar_profil_kecil'] != NULL) {
                    $image = "member/$row[mem1]/profile".$row['mem1'].".jpg";
                } else {
                    $image = "image/default.png";
                }
        ?>
            <li>
                <img src="<?php echo $image; ?>">
                <a href="#" class="user-title"><?php echo $row['nama']; ?></a>
                <span class="add">
                    <form name="terimateman" method="post">
                        <input type="submit" class="greenButton" value="Terima Teman" name="app_teman">
                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                        <input type="hidden" name="id_mem" value="<?php echo $row['uid']; ?>">
                    </form>
                </span>
                <span class="reject">
                    <form method="post" name="rejectteman">
                        <input type="submit" class="greenButton" value="Tolak Teman" name="reject_teman">
                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                        <input type="hidden" name="id_mem" value="<?php echo $row['uid']; ?>">
                    </form>
                </span>
            </li><br>
        <?php } ?>
        </ul>
        
        <?php
            $id = $_POST['id'];
            $id_mem = $_POST['id_mem'];
            if(!empty($_POST['app_teman'])) {
                //Simpan permintaan ke table array_teman
                //Query untuk user yang meminta pertemanan
                $sql_array_teman1 = mysql_query("SELECT array_teman FROM user WHERE uid='$uid' LIMIT 1");
                while($row=mysql_fetch_array($sql_array_teman1)) {
                    $array_teman1 = $row["array_teman"];
                }
                
                //Query untuk user yang dimintai pertemanan
                $sql_array_teman2 = mysql_query("SELECT array_teman FROM user WHERE uid='$id_mem' LIMIT 1");
                while($row=mysql_fetch_array($sql_array_teman2)) {
                    $array_teman2 = $row["array_teman"];
                }
                
                //Pecah array masing-masing user
                $arrayTeman1 = explode(",", $array_teman1);
                $arrayTeman2 = explode(",", $array_teman2);
                
                //Cek apakah user yang diminta sudah ada pada array
                if(in_array($id_mem, $arrayTeman1)) {
                    $error="<div id='error' style='visibility: visible'>Member ini telah menjadi teman Anda</div>";
                }
                //Cek apakah user yang meminta sudah ada pada array
                if (in_array($uid, $arrayTeman2)) {
                    $error="<div id='error' style='visibility: visible'>Member ini telah menjadi teman anda</div>";
                }
                
                //Jika user yang meminta pertemanan masih kosong arraynya
                if($array_teman1 != "") {
                    $array_Teman1 = "$array_teman1, $id_mem";
                } else {
                    $array_Teman1 = "$id_mem";
                }
                
                //Jika user yang diminta pertemanan masih kosong arraynya
                if($array_teman2 != "") {
                    $array_Teman2 = "$array_teman2, $uid";
                } else {
                    $array_Teman2 = "$uid";
                }
                
                //Update data array bagi user yang meminta pertemanan
                $UpdateArrayTeman1 = mysql_query("UPDATE user SET array_teman='$array_Teman1' WHERE uid='$uid'");
                
                //Update data array bagi user yang diminta pertemanan
                $UpdateArrayTeman2 = mysql_query("UPDATE user SET array_teman='$array_Teman2' WHERE uid='$id_mem'");
                
                //Hapus permintaan Teman dari table permintaan
                $delete = mysql_query("DELETE FROM permintaan_teman WHERE id='$id'");
        ?>
        <script language="javascript">
            alert("Approval Teman Barhasil");
            document.location="home.php";
        </script>
        <?php
            }
            if(!empty($_POST['reject_teman'])) {
                //Hapus permintaan Teman
                $delete = mysql_query("DELETE FROM permintaan_teman WHERE id='$id'");
        ?>
        <script language="javascript">
            alert("Permintaan Teman Sudah Ditolak");
            document.location="home.php";
        </script>
        <?php } ?>      
<?php } ?>
                
    </div>

    </div>
    </div>
    </body>
</html>