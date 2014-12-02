function menu() {
    var id = document.title
    id = id.substring(10, 13);
    $(".menu").removeClass("active");
    $("#" + id).addClass("active");
}
function menuWeb() {
    var id = document.title
    id = id.substring(1, 3);
    $(".menu").removeClass("menuActive");
    $("#" + id).addClass("menuActive");
}
function submenu(id) {
    $("#" + id).show();
}

function hidesubmenu(id) {
    $("#" + id).hide();
}
function change(id, cesta, lang) {
    if(lang == "de_DE"){
       var more = "more_de.png";
       var less = "less_de.png";
    }else{
       var more = "more.png";
       var less = "less.png";
   }
    var src = document.getElementById("" + id).getAttribute("src");
    if (src == (cesta + more)) {
        src = (cesta + less);
        $("." + id).show(400);
    } else {
        src = (cesta + more);
        $("." + id).hide(400);
    }
    document.getElementById("" + id).setAttribute("src", src);
}


function slideshow(kam) {
    var active = parseInt($('.active').attr("id"));
    if (kam == 'left') {
        var next=active-1;
        if ($('#'+active).prev().hasClass('noactive')) {
            $('#'+active).animate({left:"+1000"}).removeClass("active").addClass("noactive");
            $('#'+next).addClass("active").removeClass("noactive").animate({left:"0"});
        }
    } else {
        var next=active+1;
        if ($('#'+active).next().hasClass('noactive')) {
            $('#'+active).animate({left:"-1000"}).removeClass("active").addClass("noactive");
            $('#'+next).addClass("active").removeClass("noactive").animate({left:"0"});
        }
    }
}


(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&appId=1441883569432021&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));




