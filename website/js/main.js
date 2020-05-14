/*
    massage_green("");
    massage_yellow("");
    massage_red("");
*/
var massage_delay = 4*1000;
function massage_red(str){
    document.getElementById("mss2").innerHTML = str
    $("#mss2").fadeIn(1000);
    setTimeout(function(){
        $("#mss2").fadeOut(1000);
    }, massage_delay);
}
function massage_green(str){
    document.getElementById("mss1").innerHTML = str
    $("#mss1").fadeIn(1000);
    setTimeout(function(){
        $("#mss1").fadeOut(1000);
    }, massage_delay);
}
function massage_yellow(str){
    document.getElementById("mss3").innerHTML = str
    $("#mss3").fadeIn(1000);
    setTimeout(function(){
        $("#mss3").fadeOut(1000);
    }, massage_delay);
}

$(document).ready(function(){
    // sidebar
    console.log("ff");
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
});