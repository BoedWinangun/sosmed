<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';

$uid = $_SESSION['uid'];
$path = "member/$uid/";//folder penyimpanan
?>

<!DOCTYPE>
<html>
<head>
    <title>Website Pertemanan</title>
    <link href="css/dinding.css" type="text/css" rel="stylesheet">
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css/imgareaselect-default.css" rel="stylesheet" type="text/css">
        
    <script src="js/jquery.1.4.2.min.js" type="text/javascript"></script>
    <script src="js/suggest.js" type="text/javascript"></script>
    <script src="js/jquery.form.js" type="text/javascript"></script>
    <script src="js/jquery.livequery.js" type="text/javascript"></script>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery.imgareaselect.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
    //fungsi untuk membagi objek gambar sama besar
    function getSizes(im,obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
            if(confirm("Apakah akan menyimpan thumbnail gambar ini?")) {
                $.ajax({
                    type:"GET",
                    //proses ajax request pada file "gambar_profil_ajax.php"
                    url:"gambar_profil_ajax.php?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis,
                    cache:false,
                    success:function(response){
                        $("#cropimage").hide();
                        $("#thumbs").html("");
                        $("#thumbs").html("<img src='member/"+$("#uid").val()+"/"+response+"'>");
                    }
                });
            }
        } else {
            alert("Pilih area pada gambar");
        }
    }
    //pemanggilan dan pengaktifan plugin jquery imgareaselect
    $(document).ready(function() {
        $("img#photo").imgAreaSelect({
            aspectRatio: '1:1',
            onSelectEnd: getSizes
        })
    });                        
    </script>
    <?php
        $valid_format = array("jpg","png","gif","bmp");
        if(isset($_POST['submit'])) {
            $name = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];

            if(strlen($name)) {
                list($txt,$ext) = explode(".",$name);
                if(in_array($ext, $valid_format)){
                    if($size<(1024*1024)) {
                    //penamaan gambar dengan penggabungan fungsi waktu
                    //dan pemanggilan karakter nama file gambar asli
                    $actual_image_name = time().substr($txt, 5).".".$ext;
                    $tmp = $_FILES['photoimg']['tmp_name'];
                    if(move_uploaded_file($tmp,$path.$actual_image_name)) {
                        $sql_img = mysql_query("SELECT gambar_profil FROM user WHERE uid='$uid'");
                        $rows = mysql_fetch_array($sql_img);
                        if ($rows['gambar_profil'] != NULL){
                            unlink("member/$uid/$rows[gambar_profil]");
                        }
                        mysql_query("UPDATE user SET gambar_profil='$actual_image_name' WHERE uid='$uid'");
                        $image = "<div style='visibility: visible'>
                        <h3>Pilih dan Drag pada area gambar</h3>
                        <img src='member/$uid/".$actual_image_name."' id=\"photo\" style='max-width:500px;'></div>";
                    }
                    else {
                        $error = "<div id='error' style='visibility: visible'>Gagal</div>";
                        }
                    }
                    else {
                        $error = "<div id='error' style='visibility: visible'>Ukuran file terlalu besar</div>";
                    }
                }
                else {
                    $error = "<div id='error' style='visibility: visible'>Kesalahan Format File...!</div>";
                }
            }
            else {
                $error = "<div id='error' style='visibility: visible'>Pilih dulu gambarnya</idv>";
            }
        }
    ?>
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
        <ul id="sddm1">
            <li>
                <a href="profile.php?id=<?php echo $row['uid']; ?>">
                    <img src="image/wal.png" width="17" height="17" border="0"> &nbsp; Wall 
                </a>
            </li>
        </ul>
        </div>
    </div>

    <div class="right">
        <div class="rightleft">
        <div class="list"></div>
            <div id="wall_container">
                <div id="content">
                <div style="margin:0 auto; width:600px;">
                    <div style="visibility: hidden" id="showthumb"><?php echo $image; ?></div>
                    <div id="thumbs" style="padding:5px; width:600px"></div>
                    <div style="width:600px">
                    <form id="cropimage" method="post" enctype="multipart/form-data">
                        <h4>Upload Foto Anda : </h4>
                        <input type="file" name="photoimg" id="photoimg">
                        <input type="hidden" name="image_name" id="image_name" value="<?php echo ($actual_image_name) ?>" >
                        <input type="hidden" id="uid" name="uid" value="<?php echo ($uid)?>" >
                        <input type="submit" name="submit" class="greenButton" value="Upload">
                    </form>
                    <div style="visibility: hidden"><?php echo $error; ?></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>    
</div>    
</body>
</html>