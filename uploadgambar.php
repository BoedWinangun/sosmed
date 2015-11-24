<?php
include_once 'include/cek_sesi.php';
include_once 'include/db.php';
$uid=$_SESSION['uid'];
$uid_pemilik = $_POST['id_dinding2'];

if($uid==$uid_pemilik){
  $path = "member/$uid/foto/";
}
if($uid!=$uid_pemilik){
  $path = "member/$uid_pemilik/foto/";
}
$valid_formats_img = array("jpg", "png", "gif");

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];
	if(strlen($name)){
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext, $valid_formats_img)){
			if($size<(1024*1024)){
				$nama_gambar = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['photoimg']['tmp_name'];
                if($ext=="jpg" || $ext=="jpeg"){
                    $src = imagecreatefromjpeg($tmp);
                }
				else if($ext=="png"){
					$src = imagecreatefrompng($tmp);
				}
				else if($ext=="gif"){
					$src = imagecreatefromgif($tmp);
				}

				list($width,$height)=getimagesize($tmp);
    
                if(move_uploaded_file($tmp, $path.$nama_gambar)){
                    echo "<input type='hidden' name='image_url' id='ajax_image_url' value='".$nama_gambar."'>";
                    echo "<img src='$path".$nama_gambar."'  class='showthumb' width='250'>";
                }
                else{echo "Silahkan coba lagi.";}			
			}
            else{
                echo "Maaf, maksimum file yang diupload harus 1 MB";}			
		}
        else{echo "Kesalahan format gambar, coba lagi";}
    }
    else{echo "Pilih gambar dulu";}	
	exit;
}
?>