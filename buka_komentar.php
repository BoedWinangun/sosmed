<?php
//Query ketika komentar status lebih dari dua
$query_jum = mysql_query("SELECT * FROM komentar,user
                    WHERE komentar.uid=user.uid 
                    AND komentar.idstatus='$idstatus'
                    ORDER BY komentar.idkomentar asc");
$kom_count = mysql_num_rows($query_jum);
if($kom_count>2) {
    $komen_all = $kom_count-2;
?>

<div class="commentboxfirst" id="commentboxfirst<?php echo $idstatus; ?>" >
    <a href="#" class="commentcoll" id="<?php echo $idstatus; ?>" title="Comment">
        <img src="image/komentar.png"> View All <?php echo $kom_count; ?> Comment
    </a> 
</div>

<?php }
else {
    $komen_all = 0;
}
?>

<div class="collap" id='collap<?php echo $idstatus; ?>'>
<?php
// Query menampilkan keseluruhan komentar pada status
$querykoment=mysql_query("SELECT * FROM komentar,user
             WHERE komentar.uid=user.uid 
             AND komentar.idstatus='$idstatus' 
             ORDER BY komentar.idkomentar LIMIT $komen_all,2");
while($rowkoment=mysql_fetch_array($querykoment)){
  $idkom=$rowkoment['idkomentar'];
  $komentar=tolink(htmlentities($rowkoment['komentar']));
  $time=$rowkoment['dibuat'];
  $nama=$rowkoment['nama'];
  $uid=$rowkoment['uid'];
  
  if ($rowkoment['gambar_profil_kecil'] != NULL){
	    $image_koment= "member/$uid/profile".$uid.".jpg";
	}
	else{
		 $image_koment="image/default.png";
	}
  $cface= $image_koment;
?>

<div class="stcommentbody2" id="stcommentbody<?php echo $idkom; ?>">
<div class="stcommentimg">
<img src="<?php echo $cface; ?>" class='small_face' />
</div> 
<div class="stcommenttext">
<a class="stcommentdelete" href="#" id='<?php echo $idkom; ?>' title='Delete Comment'>x</a>
<b><a href="profile.php?id=<?php echo $uid; ?>"><?php echo $nama; ?></b></a> <?php echo $komentar; ?>
<div class="stcommenttime"><?php time_stamp($time); ?></div> 
</div>
</div>
<?php } ?>
    
</div>


<div style='display:none' id='commentboxall<?php echo $idstatus; ?>'>
<?php
// Query menampilkan keseluruhan komentar pada status
$querykoment=mysql_query("SELECT * FROM komentar,user
             WHERE komentar.uid=user.uid 
             AND komentar.idstatus='$idstatus' 
             ORDER BY komentar.idkomentar DESC");
while($rowkoment=mysql_fetch_array($querykoment)){
  $idkom=$rowkoment['idkomentar'];
  $komentar=tolink(htmlentities($rowkoment['komentar']));
  $time=$rowkoment['dibuat'];
  $nama=$rowkoment['nama'];
  $uid=$rowkoment['uid'];
  
  if ($rowkoment['gambar_profil_kecil'] != NULL){
	    $image_koment= "member/$uid/profile".$uid.".jpg";
	}
	else{
		 $image_koment="image/default.png";
	}
  $cface= $image_koment;
?>

<div class="stcommentbody" id="stcommentbody<?php echo $idkom; ?>">
<div class="stcommentimg">
<img src="<?php echo $cface; ?>" class='small_face' />
</div> 
<div class="stcommenttext">
<a class="stcommentdelete" href="#" id='<?php echo $idkom; ?>' title='Delete Comment'>x</a>
<b><a href="profile.php?id=<?php echo $uid; ?>"><?php echo $nama; ?></b></a> <?php echo $komentar; ?>
<div class="stcommenttime"><?php time_stamp($time); ?></div> 
</div>
</div>
<?php } ?>
</div>
