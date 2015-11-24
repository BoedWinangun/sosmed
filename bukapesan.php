<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
error_reporting(0);
$uid = $_SESSION['uid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Pertemanan</title>
    <link rel="stylesheet" href="css/dinding.css" type="text/css">
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="css/surat.css" type="text/css">
    <script src="js/jquery.1.4.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.livequery.js" type="text/javascript"></script>
    <script src="js/jquery.oembed.js" type="text/javascript"></script>
    <script src="js/wall.js" type="text/javascript"></script>
    <script src="js/surat.js" type="text/javascript"></script>
</head>
<body>
<div class="top">
   <div class="main">
       <?php include('atas.php'); ?>
       <div class="left">
           <div class="propic">
               <?php
                /*Ambil gambar profile*/
                $query_profil = mysql_query("SELECT * FROM user WHERE uid='$uid'");
                $row = mysql_fetch_array($query_profil);
                if($row['gambar_profil'] != NULL || $row['gambar_profil_kecil'] != NULL) {
                    $image = "member/$uid/$row[gambar_profil]";
                    $image_kecil = "member/$uid/$row[gambar_profil_kecil]";
                }else{
                    $image = "image/default.png";
                    $image_kecil = "image/default.png";
                }
                ?>
                <img src="<?php echo $image; ?>" class="big_profile" alt="">
           </div>
           <div class="link style1">
               <?php include('kiri.php'); ?>
           </div>
       </div>
       
       <div class="right">
           <div class="list"></div>
           <div class="inbox_title">
               <img src="image/dibaca.png">
               <a href="inbox.php?id=<?php echo $uid; ?>"> Inbox </a>
           </div>
           <div class="inbox_content">
               <ul>
                   <?php
                    $id_pesan=$_GET['baca'];
                    $query = mysql_query("SELECT * FROM user, pesan
                                        WHERE id='$id_pesan' 
                                        AND pesan.id_pengirim=user.uid");
                    $row = mysql_fetch_array($query);
                    if($row['gambar_profil_kecil'] != NULL ) {
                        $image = "member/$row[id_pengirim]/profile".$row[id_pengirim].".jpg";
                    }else{
                        $image = "image/default.png";
                    }
                    $tgl = substr($row[tgl],8,2)."-".substr($row[tgl],5,2)."-".substr($row[tgl],0,4);
                    ?>
                    <li class="hd">
                        <span class="box0">
                            Subject : <?php echo $row['subjek']; ?>
                        </span>
                    </li>
                    <li>
                        <span class="box5">
                            <img src="<?php echo $image; ?>" alt="">&nbsp; &nbsp;
                        </span>
                        <span class="box6">
                            <b>From :</b> <a href="profile.php?id=<?php echo $row['id_pengirim']; ?>"><?php echo $row['nama']; ?></a> , 
                            <b>Tanggal :</b>&nbsp; <?php echo $tgl;?> <br>
                            <?php echo $row['pesan']; ?>
                        </span>
                    </li>
                    <!--Update pesan kalaw pesan udah di buka-->
                    <?php
                        $qry_dibuka = mysql_query("UPDATE pesan SET dibuka='0' WHERE id='$id_pesan'");
                    ?>
               </ul>
               <div class="inbox_title">
                   <a href="#" id="reply"><img src="image/reply.png" alt=""> Balas</a>
               </div>
               <p class="success">Pesan Sudah Terbalas.</p>
               <div class="replypesan" style="display:none" id="balas">
                   <div class="replyimg">
                       <img src="<?php echo $image_kecil; ?>" alt="">
                   </div>
                   <div class="sttext">
                       <form method="post" action="">
                           <input type="text" value="Re: <?php echo $row['subjek']; ?>" id="subject" size="50">
                           <textarea name="textbalas" id="textbalas" class="textbalas" cols="45" rows="5"></textarea>
                           <input type="hidden" value="<?php echo $row['id_pengirim']; ?>" id="id_penerima"><br>
                           <input type="submit" value="Kirim" id="balas_button" class="balas_button">
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
</body>
</html>