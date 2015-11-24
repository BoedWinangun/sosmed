<div class="lefttop1">
    <div class="lefttopleft">
        <img src="image/logo.png" width="94" height="21">
    </div>
    <?php
        $permintaan_teman= mysql_query("SELECT * FROM permintaan_teman WHERE mem2='$uid'");
        $jum_permintaan=mysql_num_rows($permintaan_teman);
    ?>
    
    <div class="lefttoright">
        <a href="permintaan_teman.php?id=<?php echo $uid; ?>">
            <img src="image/Untitled-1.png" width="15" height="15" border="0">
        </a>
        <?php
            if($jum_permintaan!=0){
                echo"
                <font size='2' color='yellow'>
                    <b>$jum_permintaan</b>
                </font>";
            }
            $pesan_baru = mysql_query("SELECT * FROM pesan WHERE id_penerima='$uid' AND dibuka='1'");
            $jum_pesan = mysql_num_rows($pesan_baru);
        ?>
        <a href="inbox.php?id=<?php echo $uid; ?>">
            <img src="image/message.png" width="15" height="15" border="0">
        </a>
        <?php
            if($jum_pesan!=0){
                echo"
                <font size='2' color='yellow'>
                    <b>$jum_pesan</b>
                </font>";
            }
        ?>
    </div>
</div>

<div class="righttop1">
    <div class="search">
        <form>
            <input type="text" maxlength="30" id="inputString" onkeyup="lookup(this.value);" class="textfield">
        </form>
    </div>
    <div id="suggestions"></div>
    <div class="nav">
        <ul id="sddm">
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php?id=<?php echo $_SESSION['uid']; ?>">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <div style="clear:both"></div>
        <div style="clear:both"></div>
    </div>
</div>