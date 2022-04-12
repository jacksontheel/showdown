multiplier = 1

var intervalId = window.setInterval(function(){
    if ( document.hidden ) { return; } 
    var percent = $("#fill").width() / $("#fill").parent().width() * 100;
    $("#fill").animate({
    width: (percent + (2 * multiplier)) + "%",
    }, 1500);
    multiplier *= -1;
}, 5000);