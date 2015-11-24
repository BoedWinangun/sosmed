$(document).ready(function() {
    //update status
    $("#update_button").click(function() {
      var updateval = $("#update").val();
      var id_dinding = $("#id_dinding").val();
      var image_url = $('#ajax_image_url').val();
      var dataString = 'update='+ updateval + '&id_dinding='+ id_dinding + '&image_url='+ image_url;
      if(updateval=='') {
        alert("Status Harus Di isi");
      }
      else {
        $("#flash").show();
        $("#flash").fadeIn(400).html('Loading Update...');
        $.ajax({
          type: "POST",
          url: "status_ajax.php",
          data: dataString,
          cache: false,
          success: function(html) {
            $("#showthumb").html("");
            $("#flash").fadeOut('slow');
            $("#content").prepend(html);
            $("#update").val('');	
            $('#bukafoto').fadeOut('slow');
            $("#update").focus();
            $("#stexpand").oembed(updateval);
          }
        });
      }
      return false;
    });
    
    //update foto
    $("#photoimg").livequery("change", function() {
        $("#showthumb").html('');
        $("#showthumb").html('<img src="image/loader.gif" alt="Uploading....">');
        $('#bukafoto').fadeOut('slow');
        $("#frmUpload").ajaxForm({target: '#showthumb'}).submit();
    });
    
    //tampilkan 10 postingan berikutnya
    //ketika mengklik link "show older post" pada halaman home
    $('.load_more_home').livequery("click", function(e) {
        var statusakhir = $(this).attr("id");
        if(statusakhir!='end') {
            $.ajax ({
                type:"POST",
                url: "buka_status.php",
                data: "statusakhir="+ statusakhir,
                beforeSend: function() {
                    $('a.load_more').append('<img src="image/facebook_style_loader.gif">');
                },
                success: function(html) {
                    $('#paging').remove();
                    $('#content').append($(html).fadeIn('slow'));
                }
            });
        }
        return false;
    });
    
    //tampilkan 10 postingan berikutnya
    //ketika mengklik link "show older post" pada halaman profile
    $('.load_more').livequery("click", function(e) {
        var statusakhir = $(this).attr("id");
        var id_dinding = $("#id_dinding").val();
        if(statusakhir!='end') {
            $.ajax({
                type: "POST",
                url: "buka_status_profil.php",
                data: "statusakhir="+ statusakhir + "&id_dinding="+ id_dinding,
                beforeSend: function() {
                    $('a.lead_more').append('<img src="image/facebook_style_loader.gif">');
                },
                success: function() {
                    $('#paging').remove();
                    $('#content').append($(html).fadeIn('slow'));
                }
            });
        }
        return false;
    });
    
    //toggle upload foto
    $('#klikfoto').click(function() {
        $("#photoimg").attr({ value: '' });
        $("#bukafoto").slideToggle();
        return false;
    });
    
    //update komentar
    $('.comment_button').live("click", function() {
        var ID = $(this).attr("id");
        var komentar = $("#ctextarea"+ID).val();
        var dataString = 'komentar='+ komentar + '&idstatus='+ ID;
        if(komentar=='') {
            alert("Silahkan isi dulu komentarnya");
        }
        else{
            $.ajax({
                type: "POST",
                url: "komentar_ajax.php",
                data: dataString,
                cache: false,
                success: function(html){
                    $("#commentload"+ID).append(html);
                    $("#ctextarea"+ID).val('');
                    $("#ctextarea"+ID).focus();
                }
            });
        }
        return false;
    });
    
    //buka komentar
    $('.commentopen').live("click", function() {
        var ID = $(this).attr("id");
        $("#commentbox"+ID).slideToggle('fast');
        $("#ctextarea"+ID).focus();
        return false;
    });    
    
    //Komentar Collapse
    $('.commentcoll').live("click", function() {
        var ID = $(this).attr("id");
        $("#commentboxfirst"+ID).remove();
        $("#collap"+ID).remove();
        $("#commentboxall"+ID).slideDown('slow');
        return false;
    });
    
    //hapus komentar
    $('.stcommentdelete').live("click", function() {
        var ID = $(this).attr("id");
        var dataString = 'idkom='+ID;
        if (confirm("Apakah anda yakin akan menghapus komentar?")) {
            $.ajax({
                type: "POST",
                url: "hapus_komentar_ajax.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#stcommentbody"+ID).slideUp();
                }
            });
        }
        return false;
    });
    
    //hapus status
    $('.stdelete').live("click", function() {
        var ID = $(this).attr("id");
        var dataString = 'idstatus='+ID;
        if(confirm("Apakah anda yakin akan menghapus status ini?")) {
            $.ajax({
                type: "POST",
                url: "hapus_status_ajax.php",
                data: dataString,
                cache: false,
                success: function(html){
                    $("#stbody"+ID).slideUp();
                }
            });
        }
        return false;
    });
    
    //Hapus Teman
    $('#hapus_button').live("click", function() {
        var mem2 = $("#id_mem").val();
        var dataString = 'mem2='+mem2;
            $.ajax({
                type: "POST",
                url: "hapus_teman.php",
                data: dataString,
                cache: false,
                success: function(html){
                    $("#list"+mem2).slideUp();
                    $("#member").prepend(html);
                }
            });
        return false;
    });
           
            
});

    