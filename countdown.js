var midnight = new Date();
midnight.setUTCHours(24,0,0,0);
midnight.setHours(midnight.getHours()+7);

var x = setInterval(function() {

  var now = new Date().getTime();

  var distance = midnight - now;

  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  $("#matchTime").html(hours + ":" + minutes + ":" + seconds + " until next match");
}, 1000);