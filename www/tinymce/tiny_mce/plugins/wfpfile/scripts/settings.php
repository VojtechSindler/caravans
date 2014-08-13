<?
//wfpfile

// please set thif variables to your values.
$aplication_language = "cs"; //set language (must exist in language folder)
$file_save_path = $_SERVER["DOCUMENT_ROOT"]."/gallery/articles/"; //path to directory where are pictures ///// $_SERVER["DOCUMENT_ROOT"]
$file_save_relativ_path = "../../gallery/articles";
$no_delete_dir = array('pouze_cteni');
$def_dir = "1";

//this is for set permissions to 777 if you want to create new folder for pictures
$FTPsetpermission = 0; // 0 = no connect to ftp, 1 = connect to ftp ancd change permissions
$FTPServer = "ftp.server.ltd";
$FTPUser = "login";
$FTPPassword = "password";


//// please set thif variables to your values.
//$aplication_language = "cs"; //set language (must exist in language folder)
//$file_save_path = "../../../files_upload/"; //path to directory where are pictures ///// $_SERVER["DOCUMENT_ROOT"]
//$file_save_relativ_path = "files_upload/";
//$no_delete_dir = array('pouze_cteni');
//$def_dir = 'soubory';
//
////this is for set permissions to 777 if you want to create new folder for pictures
//$FTPsetpermission = 0; // 0 = no connect to ftp, 1 = connect to ftp ancd change permissions
//$FTPServer = "ftp.server.ltd";
//$FTPUser = "login";
//$FTPPassword = "password";
?>