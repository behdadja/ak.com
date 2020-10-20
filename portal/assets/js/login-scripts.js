/////////////// timer //////////////
var min = 1;
var sec = 59;
var myTimer = document.getElementById('myTimer');
var myBtn = document.getElementById('myBtn');
window.onload = countDown;

function countDown() {
    if (sec < 10) {
        myTimer.innerHTML = "0" + sec + " : 0" + min;
    } else {
        myTimer.innerHTML = sec + " : 0" + min;
    }
    if (min <= 0 && sec <= 0) {
        $("#myBtn").removeAttr("disabled");
        $("#myTimer").fadeTo(2500, 0);
        return;
    }
    if (min !== 0 && sec <= 0) {
        min -= 1;
        sec = 59;
    }
    sec -= 1;

    window.setTimeout(countDown, 1000);
}

$('#myBtn').on('click', function () {
    $("#myBtn").addClass("disabled");
});

/////////////// timer //////////////

$(document).ready(function () {
    $('#er').modal('hide');
    $('#vc').modal('hide');
});

$('#radioBtn a').on('click', function () {
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#' + tog).prop('value', sel);

    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
});
