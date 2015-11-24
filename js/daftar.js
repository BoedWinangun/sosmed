$(document).ready(function() {
    $('#regForm').submit(function(e) {
        register();
        e.preventDefault();
    });
});

function register() {
    hideshow('loading',1);
    error(0);
    sukses(0);
    $.ajax({
        type: "POST",
        url: "proses_daftar.php",
        data: $('#regForm').serialize(),
        dataType: "json",
        success:function(msg) {
            if(parseInt(msg.status)==1) {
                sukses(1,msg.txt);
                $('#error').removeClass('error').addClass('sukses');
                $("#nama").val('');
                $("#email").val('');
                $("#pass").val('');
                $("#gender").val('Pilih Gender:');
                $("#tgl").val('Tanggal:');
                $("#bulan").val('Bulan:');
                $("#tahun").val('Tahun:');
            }
            else if (parseInt(msg.status)==0) {
                error(1,msg.txt);
                $('#error').removeClass('sukses').addClass('error');
            }
            hideshow('loading',0);
        }
    });
}

function hideshow(el, act) {
    if(act) $('#'+el).css('visibility','visible');
    else $('#'+el).css('visibility','hidden');
}

function error(act, txt) {
    hideshow('error',act);
    if(txt) $('#error').html(txt);
}

function sukses(act, txt) {
    hideshow('error',act);
    if(txt) $('#error').html(txt);
}
