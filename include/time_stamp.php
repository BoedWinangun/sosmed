<?php
function time_stamp($waktu_sesi) {
    $selisih_waktu = time() - $waktu_sesi;
    $detik = $selisih_waktu;
    $menit = round($selisih_waktu / 60);
    $jam = round($selisih_waktu / 3600);
    $hari = round($selisih_waktu / 86400);
    $minggu = round($selisih_waktu / 604800);
    $bulan = round($selisih_waktu / 2419200);
    $tahun = round($selisih_waktu / 29030400);
    
    if ($detik <= 60) {
        echo "$detik detik lalu";
    }
    
    elseif ($menit <=60) {
        if($menit==1){
            echo "Satu menit lalu";
        }else{
            echo "$menit menit lalu";
        }
    }
    elseif ($jam <=24) {
        if($jam==1){
            echo "Satu jam lalu";
        }else{
            echo "$jam jam lalu";
        }
    }
    elseif ($hari <=7) {
        if($hari==1){
            echo "Satu hari lalu";
        }else{
            echo "$hari hari lalu";
        }
    }
    elseif ($minggu <=4) {
        if($minggu==1){
            echo "Satu minggu lalu";
        }else{
            echo "$minggu minggu lalu";
        }
    }
    elseif ($bulan <=12) {
        if($bulan==1){
            echo "Satu bulan lalu";
        }else{
            echo "$bulan bulan lalu";
        }
    }
    else{
        if($tahun==1) {
            echo "satu tahun lalu";
        }else{
            echo "$tahun tahun lalu";
        }
    }
}
?>