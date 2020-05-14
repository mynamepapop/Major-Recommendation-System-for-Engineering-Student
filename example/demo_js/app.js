$(document).ready(function(){
    $("input").keyup(function () { 
        var name = $("input").val();
        $.post("get.php");
    });
});