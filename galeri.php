<?php
error_reporting(0);
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
$uid = $_SESSION['uid'];
$member_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Pertemanan</title>
    <link rel="stylesheet" href="css/dinding.css" type="text/css">
    <link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" media="screen">
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("a#galeri").fancybox({
            'overlayShow' : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'titlePosition' : 'inside'
        });
    });
    </script> 
</head>
<body>
<div class="top">
    <div class="main">
        <?php include ('atas.php'); ?>
        <div class="left">
            <div class="propic">
                <?php
                    if($uid==$member_id) {
                        //Ambil Gambar Profile
                        $query_profil   = mysql_query("SELECT * FROM user WHERE uid='$uid'");
                        $row = mysql_fetch_array($query_profil);
                        if ($row['gambar_profil'] != NULL) {
                            $image = "member/$uid/$row[gambar_profil]";
                        }else{
                            $image = "image/default.png";
                        }
                ?>
                <img src="<?php echo $image; ?>" class="big_profile" alt="">
                <?php
                    }
                    else{
                        $query_profil = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
                        $row = mysql_fetch_array($query_profil);
                        if($row['gambar_profil'] != NULL) {
                            $image = "member/$member_id/$row[gambar_profil]";
                        }else{
                            $image = "image/default.png";
                        }
                ?>
                <img src="<?php echo $image; ?>" class="big_profile" alt="">
                <?php } ?>
            </div>
            <div class="link style1">
                <?php include ('kiri.php'); ?>
            </div>
        </div>
        <div class="right">
            <div class="rightleft">
                <div class="list"></div>
                <?php
                    //Paging halaman galeri
                    $batas = 16;
                    $halaman = $_GET['halaman'];
                    if(empty($halaman)) {
                        $posisi=0;
                        $halaman=1;
                    }else{
                        $posisi=($halaman-1) * $batas;
                    }
                    //query jika membuka foto sendiri atau teman
                    if($uid==$member_id){
                        $query_judul = mysql_query("SELECT * FROM user WHERE uid='$uid'");
                        $row = mysql_fetch_array($query_judul);
                ?>
                <div class="thumbdiv_title">
                    <img src="image/galeri.png" alt="">Galeri Foto
                    <?php echo $row['nama']; ?>
                </div>
                <?php
                        $query = mysql_query("SELECT * FROM status WHERE uid='$uid' AND foto!='undefined'
                                            OR id_dinding='$uid' AND foto!='undefined'
                                            ORDER BY idstatus DESC LIMIT $posisi, $batas");
                    }else{
                        $query = mysql_query("SELECT * FROM user WHERE uid='$member_id'");
                        $row = mysql_fetch_array($query_judul);
                ?>
                <div class="thumbdiv_title">
                    <img src="image/galeri.png" alt="">Galeri Foto
                    <?php echo $row['nama']; ?>
                </div>
                <?php   
                        $query = mysql_query("SELECT * FROM status WHERE uid='$member_id' AND foto!='undefined'
                                            OR id_dinding='$member_id' AND foto!='undefined'
                                            ORDER BY idstatus DESC LIMIT $posisi, $batas");
                    }
                ?>
                <div class="thumbdiv">
                    <ul>
                        <?php 
                            //Looping data foto
                            while($row=mysql_fetch_array($query)){
                                $foto = $row['foto'];
                                $id_dinding = $row['id_dinding'];
                                if($row['$uid'] == $row['id_dinding']){
                                    $fotokecil = "member/$row[uid]/foto/".thumb."$foto";
                                    $fotobesar = "member/$row[uid]/foto/$foto";
                                }else{
                                    $fotokecil = "member/$id_dinding/foto/".thumb."$foto";
                                    $fotobesar = "member/$id_dinding/foto/$foto";
                                }
                                if ($row['foto']!="undefined") {
                        ?>
                        <li>
                            <a href="<?php echo $fotobesar; ?>" id="galeri" title="<?php echo $row['status']; ?>">
                                <img src="<?php echo $fotokecil; ?>" alt="">
                            </a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                    <div class="page">
                        <?php
                            //paging halaman galeri
                            if($uid==$member_id) {
                                $user = $uid;
                                $qry_tampil = mysql_query("SELECT * FROM status WHERE uid='$uid' AND foto!='undefined'
                                                        OR id_dinding='$uid' AND foto!='undefined'
                                                        ORDER BY idstatus DESC");
                            }else{
                                $user = $member_id;
                                $qry_tampil = mysql_query("SELECT * FROM status WHERE uid='$member_id' AND foto!='undefined'
                                                        OR id_dinding='$member_id' AND foto!='undefined'
                                                        ORDER BY idstatus DESC");
                            }
                            //Query untuk menampilkan link NEXT dan PREVIOUS
                            $jmldata = mysql_num_rows($qry_tampil);
                            $jmlhalaman = ceil($jmldata/$batas);
                            $file = "galeri.php";
                            if($halaman>1){
                                $previous = $halaman-1;
                                echo"<a href=$file?id=$user&halaman=1> <<First </a> |
                                <a href=$file?id=$user&halaman=$previous> <Previous </a> | ";
                            }else{
                                echo"<<First | <Privous | ";
                            }
                            //Tampilkan link halaman 1,2,3 .......
                            for($i=1;$i<=$jmlhalaman;$i++)
                                if($i!=$halaman) {
                                    echo "<a href=$file?id=$user&halaman=$i>$i</a> | ";
                                }else{
                                    echo "<b>$i</b> | ";
                                }
                            //Link ke halaman berikutnya
                            if($halaman < $jmlhalaman) {
                                $next=$halaman+1;
                                echo "<a href=$file?id=$user&halaman=$next> Next> </a> |
                                <a href=$file?id=$user&halaman=$jmlhalaman> Last>> </a> ";
                            }else{
                                echo " Next> | Last>>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>