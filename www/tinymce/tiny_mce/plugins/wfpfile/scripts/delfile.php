<?

include "settings.php";

if (!in_array(strtolower($_GET['path']),$no_delete_dir))
{
	if (file_exists($file_save_path.$_GET['path']."/".$_GET['file'])) {
		unlink($file_save_path.$_GET['path']."/".$_GET['file']);
	}
	header ("Location: fexplorer.php?seldirectory=".$_GET['returnfolder']."&serad=".$_GET['serad']."&jak=".$_GET['jak']."");
}
else header ("Location: fexplorer.php?seldirectory=".$_GET['returnfolder']."&serad=".$_GET['serad']."&jak=".$_GET['jak']."&error=no_delete");
?>
