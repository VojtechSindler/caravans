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
function change(id) {
    var src = document.getElementById("" + id).getAttribute("src");
    if (src == 'img/more.png') {
        src = 'img/less.png';
    } else {
        src = 'img/more.png';
    }
    document.getElementById("" + id).setAttribute("src",src);
}