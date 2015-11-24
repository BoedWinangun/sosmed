$(document).ready(function() {
    $("input").blur(function() {
        $("#suggestions").fadeOut();
    });
});

function lookup(inputString) {
    if(inputString.length==0) {
        $("#suggestions").fadeOut();
    }
    else{
        $.post("pencarian.php", {queryString: ""+inputString+""},function(data) {
            $("#suggestions").fadeIn();
            $("#suggestions").html(data);
        });
    }
}
