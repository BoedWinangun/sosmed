<?php 
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
include_once 'include/time_stamp.php';
include_once 'include/tolink.php';

$uid = $_SESSION['uid'];

//Ambil gambar komentar
$query_gbr_komen = mysql_query("SELECT gambar_profil_kecil FROM user WHERE uid='$uid'");
$rows_gbr = mysql_fetch_array($query_gbr_komen);
if($rows_gbr['gambar_profil_kecil'] != NULL) {
    $image_komentar = "member/$uid/profile".$uid.".jpg";
}
else {
    $image_komentar = "image/default.png";
}

//Tampilkan data komentar
if(isset($_POST['statusakhir']) && is_numeric($_POST['statusakhir'])) {
    $statusakhir = $_POST['statusakhir'];
    $query = mysql_query("SELECT * FROM status,user 
                        WHERE status.uid=user.uid
                        AND status.uid=status.id_dinding
                        AND status.idstatus<'$statusakhir'
                        ORDER BY status.idstatus DESC LIMIT 10");
}
else{
    $query = mysql_query("SELECT * FROM status,user
                        WHERE status.uid=user.uid
                        AND status.uid=status.id_dinding
                        ORDER BY status.idstatus DESC LIMIT 0,10");
}
while($row = mysql_fetch_array($query)) {
    //Ambil gambar profile kecil untuk gambar status
    if($row['gambar_profil_kecil'] != NULL) {
        $image= "member/$row[uid]/profile".$row['uid'].".jpg";
    }else{
        $image = "image/default.png";
    }

    $idstatus   = $row['idstatus'];
    $userid     = $row['uid'];
    $oristatus  = $row['status'];
    $status     = tolink(htmlentities($oristatus));
    $time       = $row['dibuat'];
    $nama       = $row['nama'];
    $foto       = $row['foto'];
    $fotostatus = "member/$row[uid]/foto/$foto";
    $face       = $image;
    $face_komen = $image_komentar;
?>

<script type="text/javascript">
$(document).ready(function() {
    $("#stexpand<?php echo $idstatus; ?>").oembed("<?php echo $oristatus; ?>", {
        maxWidth: 400,
        maxHeight: 300});
});
</script>

<div class="stbody" id="stbody<?php echo $idstatus; ?>">
    <div class="stimg">
        <img src="<?php echo $face; ?>" class="big_face">
    </div>
    <div class="sttext">
        <a class="stdelete" href="#" id="<?php echo $idstatus;?>" title="Delete" >x</a>
        <b><a href="profile.php?id=<?php echo $userid; ?>"> <?php echo $nama; ?></a> </b><br>
        <?php echo $status; ?>
        <div class="sttime">
            <?php time_stamp($time); ?> | <a href="#" class="commentopen" id="<?php echo $idstatus; ?>" title="Comment">Comment</a>
        </div>
        
        <?php
            if ($foto != "undefined") { ?>
                <img src="<?php echo $fotostatus; ?>" width="250" >
        <?php } ?>
        
        <div id="stexpandbox">
            <div id="stexpand<?php echo $idstatus; ?>" ></div>
        </div>
        
        <div class="commentcontainer" id="commentload<?php echo $idstatus; ?>" >
            <?php include ('buka_komentar.php'); ?>
        </div>
        
        <div class="commentupdate" style="display:none" id="commentbox<?php echo $idstatus; ?>" >
            <div class="stcommentimg">
                <img src="<?php echo $face_komen; ?>" class="small_face" >
            </div>
            <div class="stcommenttext">
                <form method="post" action="">
                    <textarea name="komentar" class="comment" maxlength="200" id="ctextarea<?php echo $idstatus; ?>" ></textarea><br>
                    <input type="submit" value="Comment" id="<?php echo $idstatus; ?>" class="comment_button">
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
} 
if (mysql_num_rows($query)==10) { ?>
<div id="paging">
    <a href="#" id="<?php echo $idstatus; ?>" class="load_more_home">
        Show Older Posts <img src="image/arrow1.png" >
    </a>
</div>
<?php } else { ?>
<div id="paging">
    <a id="end" href="#" class="load_more_home" >No More Posts</a>
</div>
<?php } ?>