<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
$uid = $_SESSION['uid'];
?>

<!DOCTYPE>
<html>
<head>
    <title>Website Pertemanan</title>
    <link href="css/dinding.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.1.4.2.min.js" type="text/javascript"></script>
    <script src="js/wall.js" type="text/javascript"></script>
    <script src="js/suggest.js" type="text/javascript"></script>
    <script src="js/jquery.form.js" type="text/javascript"></script>
    <script src="js/bootstrap-filestyle.js" type="text/javascript"></script>
    <script src="js/jquery.livequery.js" type="text/javascript"></script>
    <script src="js/jquery.oembed.js" type="text/javascript"></script>
</head>
    
<body>
<div class="top">
<div class="main">
    <?php include ('atas.php'); ?>
    
    <div class="left">
        <div class="propic">
        <?php
            //ambil gambar profil
            $sql=mysql_query("SELECT gambar_profil FROM user WHERE uid='$uid'");
            $rows=mysql_fetch_array($sql);
                if ($rows['gambar_profil'] != NULL) {
                    $images = "member/$uid/$rows[gambar_profil]";
                }
                else {
                    $images = "image/default.png";
                }
        ?>
            <img src="<?php echo $images; ?>" class="big_profile">
        </div>
        <div class="link style1">
            <p align="right">
                <a href="profile_photo.php" style="text_decoration:none; color:#2ba314;">Edit Profile Pic</a>
            </p>
        </div>
    </div>
    
    <div class="right">
        <div class="list"></div>
        <div id="wall_container">
            <div id="updateboxarea">
                <h6><b>Tulis Statusmu...! </b>&nbsp; 
                    <a href="#" id="klikfoto">
                        <img src="image/foto.png">
                    </a>
                </h6>
                <form method="post" action="uploadgambar.php" id="frmUpload" enctype="multipart/form-data">
                    <div class="bukafoto" style="display:none;" id="bukafoto">
                        <b>Silakan Upload foto anda dengan Max ukuran foto 1 MB</b><br>
                        <input type="file" name="photoimg" id="photoimg" class="photoimg">
                        <input type="hidden" name="id_dinding2" value="<?php echo $uid; ?>">
                    </div>
                </form>
                <textarea cols="30" rows="4" name="update" id="update"></textarea>
                <input type="hidden" name="id_dinding" id="id_dinding" value="<?php echo $uid; ?>">
                <div id="showthumb"></div>
                <input type="submit" value="Update" id="update_button" class="update_button">                
            </div>
            
            <div id="flashmessage">
                <div id="flash" align="left"></div>    
            </div>
            <div id="content">
                <?php include('buka_status.php'); ?>    
            </div>
        </div>
    </div>
</div>
</div>
    <script type="text/javascript">
		$('#photoimg').filestyle()
	</script>
</body>
</html>