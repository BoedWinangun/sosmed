$(document).ready(function() {
    //tampil popup window
    $('a.muncul').click(function() {
        //scroll keatas
        $('html, body').animate({scrollTop:0}, 'fast');
        
        //sebelum menampikan pop-up windows, reset form
        $('.success, .error').hide();
        $('form#formPesan').show();
        $('input#subject').val();
        $('textarea#pesan').val();
        
        //tampilkan div mask dan contact
        $('#mask').show().fadeTo('', 0.7);
        $('div#contact').fadeIn();
        return false;
    });
    
    //tutup pop-up windows ketika div close atau div mask diklik
    $('div#close, div#mask').click(function(){
        $('div#contact, div#mask').stop().fadeOut('slow');
    });
    
    //ketika tombol kirim di klik
    $('input#simpan_pesan').click(function() {
    $('.error').hide().remove();
        //inisialisasi string
        var id_pengirim = $("#id_pengirim").val();
        var id_penerima = $("#id_penerima").val();
        var subject = $("#subject").val();
        var pesan = $("#pesan").val();
        var dataString = "id_pengirim="+ id_pengirim +"&id_penerima="+ id_penerima +"&subject="+ subject +"&pesan="+ pesan;
        //hitung error
        var error_count=0;
        
        if(subject == "") {
            $("$contact_header").after("<p class=error>Silakan isi dulu subject!</p>");
            error_count += 1;
        }
        if(pesan == "") {
            $("#contact_header").after("<p class=error>Silahkan isi dulu Pesan!</p>");
            error_count += 1;
        }
        
        //kalau tidak ada error
        if(error_count === 0) {
            $.ajax({
                type: "POST",
                url: "kirim_pesan.php",
                data: dataString,
                success: function() {
                    $('.error').hide();
                    $(".success").slideDown("slow");
                    $("form#formPesan").fadeOut("slow");
                },
                error: function() {
                    $(".error").hide();
                    $("#sendError").slideDown("slow");
                }
            });
        }
        else {
            $(".error").show();
        }
        return false;
    });
    
    //toggle replay
    $("#reply").click(function() {
        $("#balas").slideToggle();
        return false;
    });
    
    //simpan pesan balasan kerika tombol di klik...
    $(".balas_button").click(function() {
        var subject = $("#subject").val();
        var textbalas = $("#textbalas").val();
        var id_penerima = $("#id_penerima").val();
        var dataString = "subject="+ subject +"&textbalas="+ textbalas + "&id_penerima="+ id_penerima;
        
        if(subject == "") {
            alert("Isi dulu subject");
        }
        else if(textbalas == "" ) {
            alert("Isi dulu pesan balasannya");
        }
        else {
            $.ajax({
                type: "POST",
                url: "balas_pesan.php",
                data: dataString,
                cache: false,
                success: function() {
                    $(".replypesan").fadeOut("slow");
                    $(".success").slideDown("slow");
                    $(".success").fadeOut("slow");
                }
            });
        }
        return false;
    })
        
});