<?

include "settings.php";

if (!in_array(strtolower($_GET['path']),$no_delete_dir))
{
	if (file_exists($img_save_path.$_GET['path']."/".$_GET['file'])) {
		unlink($img_save_path.$_GET['path']."/".$_GET['file']);
		
		$path_parts = pathinfo($_GET['file']);
		$small = 'm_'.trim($path_parts["basename"],$path_parts["extension"]).'jpg';
			
		if (file_exists($img_save_path.$_GET['path']."/".$small)) 
			unlink($img_save_path.$_GET['path']."/".$small);
	}
	header ("Location: imgexplorer.php?seldirectory=".$_GET['returnfolder']."");
}
else header ("Location: imgexplorer.php?seldirectory=".$_GET['returnfolder']."&error=no_delete");
?>