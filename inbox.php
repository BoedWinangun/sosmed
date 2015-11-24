<?php
error_reporting(0);
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

$uid = $_SESSION['uid'];
$member_id = $_GET['id'];
?>

<!DOCTYPE>
<html>
<head>
    <title>Website Pertemanan</title>
    <link href="css/dinding.css" type="text/css" rel="stylesheet">
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
        
    <script src="js/jquery.1.4.2.min.js" type="text/javascript"></script>
    <script src="js/suggest.js" type="text/javascript"></script>
    <script src="js/jquery.form.js" type="text/javascript"></script>
    <script src="js/jquery.livequery.js" type="text/javascript"></script>
    <script src="js/surat.js" type="text/javascript"></script>
</head>
<body>
<div class="top">
<div class="main">
    <?php include ('atas.php'); ?>
    <div class="left">
        <div class="propic">
        <?php
        //ambil gambar profil
        $sql_profil = mysql_query("SELECT * FROM user WHERE uid='$uid'");
        $row = mysql_fetch_array($sql_profil);
        if($row['gambar_profil'] != NULL) {
            $images = "member/$uid/$row[gambar_profil]";
        }else {
            $images = "image/default.png";
        }
        ?>
            <img src="<?php echo $images; ?>" class="big_profile">
        </div>
        <div class="link_style1">
            <?php include ('kiri.php'); ?>
        </div>
    </div>

    <div class="right">
        <div class="rightleft">
        <div class="list"></div>
            <div class="inbox_title">
                <img src="image/dibaca.png">
                <a href="inbox.php?id=<?php echo $uid; ?>" >Inbox</a>
            </div>
            
            <!--form inbox-->
            <form method="post" action="hapus_pesan.php">
                <div class="inbox_content">
                    <ul>
                        <li class="hd">
                            <span class="box1">#</span>
                            <span class="box2">Pengirim</span>
                            <span class="box3">Subject</span>
                            <span class="box4">Tanggal</span>
                        </li>
                        <?php
                        // paging halaman
                        $batas=5;
                        $halaman=$_GET['halaman'];
                        if(empty($halaman)) {
                            $posisi = 0;
                            $halaman = 1;
                        }
                        else {
                            $posisi = ($halaman-1) *$batas;
                        }
                        $sql = mysql_query("SELECT * FROM pesan, user
                                            WHERE pesan.id_pengirim=user.uid
                                            AND pesan.id_penerima='$uid'
                                            ORDER BY pesan.id desc LIMIT $posisi, $batas");
                        while($row=mysql_fetch_array($sql)) {
                            if($row['gambar_profil_kecil'] != NULL) {
                                $image = "member/$row[id_pengirim]/profile".$row['id_pengirim'].".jpg";
                            }else {
                                $image = "image/default.png";
                            }
                        ?>
                        <li>
                            <span class="box1" ><input type="checkbox" name="cek[]" value="<?php echo $row['id']; ?>"></span>
                            <span class="box2"><img src="<?php echo $image; ?>" ><br>
                                <a href="profile.php?id=<?php echo $row['id_pengirim']; ?>" ><?php echo $row['nama']; ?></a>
                            </span>
                            <?php 
                            if($row['dibuka'] == 1) { ?>                                
                            <span class="box3">
                                <b><a href="bukapesan.php?id=<?php echo $member_id; ?>&baca=<?php echo $row['id']; ?>" ><?php echo $row['subjek']; ?></a></b>
                            </span>
                            <?php } else { ?>                                
                            <span class="box3">
                                <a href="bukapesan.php?id=<?php echo $member_id; ?>&baca=<?php echo $row['id']; ?>" ><?php echo $row['subjek']; ?></a>
                            </span>
                            <?php 
                            }
                            $tgl=substr($row['tgl'],8,2)."-".substr($row['tgl'],5,2)."-".substr($row['tgl'],0,4); ?>
                            <span class="box4" ><?php echo $tgl; ?></span>
                        </li>
                        <?php } ?>
                    </ul>
                    <div align="center" >
                        <input type="submit" name="hapus_button" class="greenButton" value="Hapus Pesan" ><br><br>
                    </div>
                </div>
            </form>
            
            <div class="page">
            <?php
                //query untuk menampilkan link next dan previous
                $tampil = mysql_query("SELECT * FROM pesan, user
                                    WHERE pesan.id_pengirim=user.uid 
                                    AND pesan.id_penerima='$uid'");
                $jmldata = mysql_num_rows($tampil);
                $jmlhalaman= ceil($jmldata/$batas);
                $file = "inbox.php";
                //Link ke halaman sebelumnya
                if($halaman>1) {
                    $previous = $halaman-1;
                    echo "<a href=$file?id=$uid&halaman=1> << First </a> | <a href=$file?id=$uid&halaman=$previous> < Previous </a> | ";
                } else {
                    echo "<< First | < Previous | ";
                }
                // Tampilkan link halaman
                for($i=1;$i<=$jmlhalaman;$i++)
                    if($i != $halaman) {
                        echo "<a href=$file?id=$uid&halaman=$i>$i</a> | ";
                    } else {
                        echo "<b>$i</b> | "; }
                //Link ke halaman berikutnya
                if($halaman < $jmlhalaman) {
                    $next= $halaman+1;
                    echo "<a href=$file?id=$uid&halaman=$next> Next > </a> | <a href=$file?id=$uid&halaman=$jmlhalaman> Last >> </a>" ;
                } else {
                    echo "Next > | Last >>"; }
            ?>
            </div>
        </div>
    </div>
</div>    
</div>    
</body>
</html>