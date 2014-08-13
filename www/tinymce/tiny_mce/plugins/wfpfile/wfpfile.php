<?


include "scripts/settings.php";
include "scripts/funkce.php";

if (file_exists("langs/".$aplication_language.".php")) include "langs/".$aplication_language.".php";
else include "langs/en.php";

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
	<title><? echo $ilng['title']; ?></title>
	<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="jscripts/functions.js"></script>
	<link href="../../themes/advanced/css/editor_popup.css" rel="stylesheet" type="text/css" />
	<link href="css/wfpstyle.css" rel="stylesheet" type="text/css" />
	<base target="_self" />
</head>
<body>
<? 

echo "
	<div class=\"popis-okna\">
		<h2>".$ilng['title']."</h2>".$ilng['undertitle']."
	</div>

	<div id=\"obsah\">
		<form id=\"formik\" name=\"formik\" onSubmit=\"insertFile();return false;\" action=\#\">
		<table cellspacing=\"10\">
			<tr>
				<td>".$ilng['filepath']."</td>
				<td><input type=\"text\" onchange=\"updateinvisible(this.value);\" name=\"filepath\" style=\"width:300px; height:15px;\" id=\"filepath\" /></td>
				<td><a href=\"#null\" onclick=\"file_explore();\">".$ilng['explore']."</a></td>
			</tr>
			<tr>
				<td>".$ilng['filename']."</td>
				<td colspan=\"2\">
					<input type=\"text\" id=\"filename\" name=\"filename\" style=\"width:300px; height:15px;\" id=\"imgtitle\" />
				</td>
			</tr>
			<tr>
				<td>".$ilng['filetitle']."</td>
				<td colspan=\"2\">
					<input type=\"text\" name=\"filetitle\" style=\"width:300px; height:15px;\" id=\"filetitle\" />
				</td>
			</tr>
			<tr>
				<td colspan=\"2\"><input type=\"checkbox\" name=\"insertsize\" id=\"insertsize\" /> <label for=\"insertsize\">".$ilng['insertsize']."</label></td>
			</tr>
			<tr>
				<td colspan=\"2\"><input type=\"checkbox\" name=\"inserttype\" id=\"inserttype\" /> <label for=\"inserttype\">".$ilng['inserttype']."</label><input type=\"hidden\" name=\"fsize\" id=\"fsize\" /></td>
			</tr>
			
		</table>"; 

?>
<div class="mceActionPanel">

			<div style="float:left; padding-left:10px;">
				<input id="insert" name="insert" value="<? echo $ilng['insert'];?>" type="submit">
			</div>

			<div style="float: right; padding-right:10px;">
				<input id="cancel" name="cancel" value="<? echo $ilng['cancel'];?>" onClick="tinyMCEPopup.close();" type="button">
			</div>
		</div>
		</form>
	</div>

</body>
</html>
