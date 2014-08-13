<?

// please set thif variables to your values.
$aplication_language = "cs"; //set language (must exist in language folder)
$img_save_path = $_SERVER["DOCUMENT_ROOT"]."/gallery/articles/"; //path to directory where are pictures ///// $_SERVER["DOCUMENT_ROOT"]/mywebname/fotos
$img_save_relativ_path = "./../../gallery/articles/";
$do_thumbnails = 1;
$thumbnail_max_width = 150;
$thumbnail_max_height = 120;
$no_delete_dir = array('fotogalerie','reference','auta');
$def_dir = "1";

//this is for set permissions to 777 if you want to create new folder for pictures
$FTPsetpermission = 0; // 0 = no connect to ftp, 1 = connect to ftp ancd change permissions
$FTPServer = "ftp.server.ltd";
$FTPUser = "login";
$FTPPassword = "password";

//// please set thif variables to your values.
//$aplication_language = "cs"; //set language (must exist in language folder)
//$img_save_path = "../../../../upimages/"; //path to directory where are pictures ///// $_SERVER["DOCUMENT_ROOT"]/mywebname/fotos
//$img_save_relativ_path = "../CEHL_EDITOR/upimages/";
//$do_thumbnails = 1;
//$thumbnail_max_width = 150;
//$thumbnail_max_height = 120;
//$no_delete_dir = array('fotogalerie','reference','auta');
//$def_dir = 'obrazky_hlavni_strana';
//
////this is for set permissions to 777 if you want to create new folder for pictures
//$FTPsetpermission = 0; // 0 = no connect to ftp, 1 = connect to ftp ancd change permissions
//$FTPServer = "ftp.server.ltd";
//$FTPUser = "login";
//$FTPPassword = "password";
?>