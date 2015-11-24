<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
error_reporting(0);

$uid = $_SESSION['uid'];
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
<?php include ('atas.php'); ?>

    <div class="left">
        <div class="propic">
        <?php
        if($uid==$member_id) {
            $query = mysql_query("SELECT * FROM user WHERE uid='$uid'");
            $row = mysql_fetch_array($query);
            if($row['gambar_profil'] != NULL ) {
                $image = "member/$uid/$row[gambar_profil]";
            }
            else {
                $image = "image/default.png";
            }
        ?>
            <img src="<?php echo $image; ?>" class="big_profile">
        <?php }
        else {
            $query = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
            $row = mysql_fetch_array($query);
            if($row['gambar_profil'] != NULL ) {
                $image = "member/$member_id/$row[gambar_profil]";
            }
            else {
                $image = "image/default.png";
            }
        ?>
            <img src="<?php echo $image; ?>" class="big_profile">
        <?php } ?>
        </div>
        <div class="link_style1">
            <?php include ('kiri.php'); ?>    
        </div>
    </div>
    
    <div class="right">
        <div class="list"></div>
        <div id="wall_container">            
            <?php
            // Menampilkan daftar teman pada profil sendiri
            if($uid==$member_id){
                $query_judul = mysql_query("SELECT * FROM user where uid='$uid'");
                $row=mysql_fetch_array($query_judul);
                $array_teman = $row['array_teman'];
                if ($array_teman != NULL) {
                ?>
                <div class="member_title">
                  <img src="image/connect.png" /> Daftar Teman <?php echo $row['nama']; ?>
                </div>
                <?php
                }else { ?>
                <div class="member_title1">
                  Anda Belum Memiliki Teman
                </div>     
                <?php }
                $query = mysql_query("SELECT * FROM user WHERE uid='$uid'");
            }
            //jika yang dibuka profil teman
            else{
                $query_judul = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
                $row=mysql_fetch_array($query_judul);
                $array_teman = $row['array_teman'];
                if ($array_teman != NULL) {
                ?>
                <div class="member_title">
                  <img src="image/connect.png" /> Daftar Teman <?php echo $row['nama']; ?>
                </div>
                <?php
                }else { ?>
                <div class="member_title1">
                  Anda Belum Memiliki Teman
                </div>     
                <?php }
                $query = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
            }
            ?>
            <ul id="member">
            <?php
            //lakukan looping
            while($row=mysql_fetch_array($query)){
              $arrayTeman = $row["array_teman"];
                /*cek apakah field array kosong atau tidak
                Jika tidak kosong*/
              if ($arrayTeman != "") { 
                  // Pecah Array Teman
                  $array_teman = explode(",", $arrayTeman);
                  $temanCount = count($array_teman);//hitung jumlah teman pada array
                  // paging daftar teman dibatasi 10 user perhalaman
                  $batas=10;//batasi hingga 10 user
                  $halaman=$_GET['halaman'];
                  if(empty($halaman)){
                     $posisi=0;
                     $halaman=1;
                  }
                  else {
                     $posisi=($halaman-1) * $batas; 
                  }
                 // memecah array berdasarkan limit dan posisi paging
                 $array_fix=array_slice($array_teman, $posisi, $batas);

                 // Tampilkan daftar array teman
                 foreach ($array_fix as $key => $value) { 
                    $sql_teman = mysql_query("SELECT uid, nama, gambar_profil_kecil FROM user WHERE uid='$value' LIMIT 1");
                    while($row=mysql_fetch_array($sql_teman)){	
                        if ($row['gambar_profil_kecil'] != NULL){
                         $image = "member/$row[uid]/profile".$row[uid].".jpg";
                        }
                        else{
                             $image="image/default.png";
                        }
                        //Tampilkan List Teman
                        ?>	
                        <li id="list<?php echo $row['uid']; ?>"> <img src="<?php echo $image; ?> " />
                            <a href="profile.php?id=<?php echo $row['uid']; ?>" class="user-title"><?php echo $row['nama'];?> </a>
                            <span class="add">
                                <input type="submit" class="greenButton" id="hapus_button" value="Hapus Teman" name="hapus_teman" />
                                <input type="hidden" name="id_mem" id="id_mem" value="<?php echo $row['uid']; ?>">
                            </span>
                        </li>
                        <br>
                  <?php
                  }
                }
              }
            }
            ?>
            </ul> 
            <div class="page">
                <?php
                // tampilkan paging halaman
                if($uid==$member_id){
                    $user = $uid;
                }
                else{
                    $user = $member_id;
                }
                // Query untuk menampilkan link Next dan Previous
                $jmlhalaman = ceil($temanCount/$batas);
                $file= "daftar_teman.php";
                //Link ke halaman sebelumnya
              if($halaman>1) {
                   $previous=$halaman-1;
                   echo "<a href=$file?id=$user&halaman=1> << First </a> | <a href=$file?id=$user&halaman=$previous> < Previous</a> | ";
              }
              else {
                   echo "<< First | < Previous | ";
              }

              // tampilkan Link Halaman 1,2,3 .....
              for($i=1;$i<=$jmlhalaman;$i++)
                if ($i !=$halaman) {
                  echo "<a href=$file?id=$user&halaman=$i>$i</a> | " ;
              }
              else {
                  echo "<b>$i</b> | ";
              }
              // Link ke halaman Berikutnya
              if($halaman < $jmlhalaman) {
                   $next=$halaman+1;
                   echo "<a href=$file?id=$user&halaman=$next> Next > </a> | <a href=$file?id=$user&halaman=$jmlhalaman> Last >> </a> ";
              }
              else {
                   echo " Next > | Last >>"; 
              }
              ?>
            </div>
        </div>
    </div>    
</div>    
</div>    
</body>
</html>