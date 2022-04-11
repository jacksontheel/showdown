multiplier = 1

var intervalId = window.setInterval(function(){
    var percent = $("#fill").width() / $("#fill").parent().width() * 100;
    $("#fill").animate({
    width: (percent + (5 * multiplier)) + "%",
    }, 1500);
    multiplier *= -1;
}, 5000);