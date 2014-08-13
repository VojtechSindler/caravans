<?


include "settings.php";
include "funkce.php";

$new_folder = str_replace(" ", "_", $_POST['newfolder']);
$new_folder = str_replace("/", "_", $new_folder);
$new_folder = str_replace("\\", "_", $new_folder);
$new_folder=removediakritika($new_folder);

if (in_array(strtolower($new_folder),$no_delete_dir)) $new_folder .= '-1';


if (isset($_POST['newfolder']) && !file_exists($file_save_path.$new_folder)) {
	if ($FTPsetpermission == 0) {
		//no connect to ftp, create folder
		mkdir($file_save_path.$new_folder, 0700);
		$foldertoupload = $file_save_path.$new_folder;
	}
	else {
		//connect to FTP and create folder
		$FTPCon = ftp_connect($FTPServer) or die("Unable to connect to ".$FTPServer);
		$Login = ftp_login($FTPCon, $FTPUser, $FTPPassword); //prihlaseni
		if (!ftp_mkdir($FTPCon, $file_save_relativ_path.$new_folder)) 
		die("Unable to create new folder");
		if (!ftp_site($FTPCon, "CHMOD 0777 ".$file_save_relativ_path.$new_folder)) 
		die("Unable to change new folder permissions");
		ftp_close($FTPCon); //ukonci spojeni
		$foldertoupload = $file_save_path.$new_folder;
	}
}

if (!isset($foldertoupload)) $foldertoupload = $file_save_path.$_POST['selfolder']; 

//upload 1st picture
if ($_FILES['upicture1']['name']!="") {
		$jmenoSouboru=str_replace(" ", "_", strtolower($_FILES['upicture1']['name']));
		$jmenoSouboru=str_replace("%", "_", $jmenoSouboru);
		$jmenoSouboru=str_replace("/", "_", $jmenoSouboru);
		$jmenoSouboru=removediakritika($jmenoSouboru);
		while (file_exists($foldertoupload."/".$jmenoSouboru)) {
			$jmenoSouboru=rand(1,500).$jmenoSouboru;
		}
		if (!move_uploaded_file($_FILES['upicture1']['tmp_name'], $foldertoupload."/".$jmenoSouboru)) $allerror = "1";
		else if (filesize($foldertoupload."/".$jmenoSouboru)==0) {
			 	$allerror = "1";
				unlink($foldertoupload."/".$jmenoSouboru);
			 }
		     else {
			 	$allerror = "0";	
			 }
}
//upload 2nd picture
if ($_FILES['upicture2']['name']!="") {
		$jmenoSouboru=str_replace(" ", "_", strtolower($_FILES['upicture2']['name']));
		$jmenoSouboru=str_replace("%", "_", $jmenoSouboru);
		$jmenoSouboru=str_replace("/", "_", $jmenoSouboru);
		$jmenoSouboru=removediakritika($jmenoSouboru);
		while (file_exists($foldertoupload."/".$jmenoSouboru)) {
			$jmenoSouboru=rand(1,500).$jmenoSouboru;
		}
		if (!move_uploaded_file($_FILES['upicture2']['tmp_name'], $foldertoupload."/".$jmenoSouboru)) $allerror .= "1";
		else if (filesize($foldertoupload."/".$jmenoSouboru)==0) {
			 	$allerror .= "1";
				unlink($foldertoupload."/".$jmenoSouboru);
			 }
		     else {
			 	$allerror .= "0";	
			 }

}
//upload 3rd picture
if ($_FILES['upicture3']['name']!="") {
		$jmenoSouboru=str_replace(" ", "_", strtolower($_FILES['upicture3']['name']));
		$jmenoSouboru=str_replace("%", "_", $jmenoSouboru);
		$jmenoSouboru=str_replace("/", "_", $jmenoSouboru);
		$jmenoSouboru=removediakritika($jmenoSouboru);
		while (file_exists($foldertoupload."/".$jmenoSouboru)) {
			$jmenoSouboru=rand(1,500).$jmenoSouboru;
		}
		if (!move_uploaded_file($_FILES['upicture3']['tmp_name'], $foldertoupload."/".$jmenoSouboru)) $allerror .= "1";
		else if (filesize($foldertoupload."/".$jmenoSouboru)==0) {
			 	$allerror .= "1";
				unlink($foldertoupload."/".$jmenoSouboru);
			 }
		     else {
			 	$allerror .= "0";	
			 }
}

header ("Location: fexplorer.php?upload=1&ereport=".$allerror);
?>
