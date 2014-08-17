function menu() {
    var id = document.title
    id = id.substring(10, 13);
    $(".menu").removeClass("active");
    $("#" + id).addClass("active");
}
function submenu(id) {
    $("#" + id).show();
}

function hidesubmenu(id) {
    $("#" + id).hide();
}
<<<<<<< HEAD
function change(id, cesta) {
    var src = document.getElementById("" + id).getAttribute("src");
    if (src == (cesta + 'more.png')) {
        src = (cesta + 'less.png');
        $("." + id).show(400);
    } else {
        src = (cesta + 'more.png');
        $("." + id).hide(400);
    }
    document.getElementById("" + id).setAttribute("src", src);
}

function slideshow(kam) {
    if (kam == 'left') {
        if ($('#1').prev().hasClass('noactive')) {
            $('#3').removeAttr('id').removeClass('active').addClass('noactive').prev().attr('id', 3).prev().attr('id', 2).prev().attr('id', 1).addClass('active').removeClass('noactive');
        }
    } else {
        if ($('#3').next().hasClass('noactive')) {
            $('#1').removeAttr('id').removeClass('active').addClass('noactive').next().attr('id', 1).next().attr('id', 2).next().attr('id', 3).addClass('active').removeClass('noactive');
        }
    }
=======
function change(id) {
    var src = document.getElementById("" + id).getAttribute("src");
    if (src == 'img/more.png') {
        src = 'img/less.png';
    } else {
        src = 'img/more.png';
    }
    document.getElementById("" + id).setAttribute("src",src);
>>>>>>> origin/master
}