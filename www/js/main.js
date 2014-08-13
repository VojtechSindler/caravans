function menu() {
    var id = document.title
    id = id.substring(10, 13);
    $(".menu").removeClass("active");
    $("#" + id).addClass("active");
}
