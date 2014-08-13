<?


include "settings.php";

if (file_exists("../langs/".$aplication_language.".php")) include "../langs/".$aplication_language.".php";
else include "../langs/en.php";

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
	<title><? echo $ilng['explorer']; ?></title>
	<script type="text/javascript" src="../../../tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="../jscripts/functions.js"></script>
	<link href="../../../themes/advanced/css/editor_popup.css" rel="stylesheet" type="text/css" />
	<link href="../css/wfpstyle.css" rel="stylesheet" type="text/css" />
	<base target="_self" />
</head>
<body>
<div class="borderbottom1"><div id="vrchni"><div class="padding5">
<h2>
<? 
if (isset($_GET['upload'])) {
	//upload souboru
	echo $ilng['uploadertoserver']." </h2>".$ilng['uploadertoserverdesc']."</div></div></div>
<div class=\"borderbottom1\"><div id=\"menu\"><div class=\"padding-menu\">
	<div class=\"float-right\"><a href=\"imgexplorer.php\">".$ilng['backtoexplore']."</a></div></div></div></div>
	
	<div id=\"hlavni\"><form action=\"uploader.php\" method=\"post\" enctype=\"multipart/form-data\">
	<div class=\"padding5-15\">
	<table cellspacing=\"10\">
<tr>
<td style=\"width:160px;\">
".$ilng['picture']." 1:
</td>
<td  style=\"width:400px;\">
<input type=\"file\" name=\"upicture1\" id=\"upicture1\" size=\"50\" />
</td>
</tr><tr>
<td>
".$ilng['picture']." 2:
</td>
<td>
<input type=\"file\" name=\"upicture2\" id=\"upicture2\" size=\"50\" />
</td>
</tr><tr>
<td>
".$ilng['picture']." 3:
</td>
<td>
<input type=\"file\" name=\"upicture3\" id=\"upicture3\" size=\"50\" />
</td>
</tr><tr>
<td>
".$ilng['uploadtodir']."
</td>
<td>
<select name=\"selfolder\" style=\"width:150px;\">";
	$slozka = dir($img_save_path);
	while($soubor=$slozka->read()) {
	//echo $soubor." - ".fileperms($soubor);
		if ($soubor=="." || $soubor==".." || $soubor==".htaccess") continue; // || !is_dir($soubor)
		if (!in_array(strtolower($soubor),$no_delete_dir)) 
		{
			echo "<option value=\"".$soubor."\">".$soubor."</option>";
			if ($default_slozka=="") $default_slozka=$soubor;
		}
	}
	$slozka->close();
	echo "</select>
</td>
</tr><tr>
<td>
".$ilng['newfolder']."
</td>
<td>
<input type=\"text\" name=\"newfolder\" style=\"width:150px; height:15px;\" id=\"newfolder\" />
</td>
</tr><tr>
<td>
</td>
<td>
".$ilng['newfolderrecommendation']."
</td>
</tr><tr>
<td colspan=\"2\">";
if (isset($_GET['ereport'])) { 
	echo "<strong>";
	switch ($_GET['ereport']) {
		case "001": echo $ilng['picture']." 3 ".$ilng['uploaderror'];
				break;
		case "010": echo $ilng['picture']." 2 ".$ilng['uploaderror'];
				break;
		case "100": echo $ilng['picture']." 1 ".$ilng['uploaderror'];
				break;
		case "011": echo $ilng['picture']." 2 ".$ilng['and']." 3 ".$ilng['uploaderror'];
				break;
		case "101": echo $ilng['picture']." 1 ".$ilng['and']." 3 ".$ilng['uploaderror'];
				break;
		case "110": echo $ilng['picture']." 1 ".$ilng['and']." 2 ".$ilng['uploaderror'];
				break;
		case "111": echo $ilng['nopictuploaded'];
				break;
		default: if ($_GET['misto']==0) echo $ilng['allpictuploaded'];
				break;	
		
	}
	echo "</strong>";
}

echo "</td>
</tr><tr>
<td colspan=\"2\"><input type=\"submit\" value=\"".$ilng['send']."\" id=\"insert\" /></td>
</tr>
	</table></div></form>
	</div>";
}
else {
	//prohlizeni souboru
	echo $ilng['explorer']." </h2>".$ilng['explorerdescription']."</div></div></div>
	<div class=\"borderbottom1\"><div id=\"menu\"><div class=\"padding-menu\"><form action=\"".$_SERVER['PHP_SELF']."\" method=\"GET\"><div class=\"float-left\">".$ilng['selectdir']." ";
	$slozka = dir($img_save_path);
	$default_slozka="";
	
	if ($def_dir != '' && $_GET['seldirectory']=='') $_GET['seldirectory'] = $def_dir; 
	
	echo "<select name=\"seldirectory\" onchange=\"this.form.submit();\" style=\"width:150px;\">";
	while($soubor=$slozka->read()) {
	//echo $soubor." - ".fileperms($soubor);
		if ($_GET['seldirectory']==$soubor) $selectedis = "selected=\"selected\"";
		else $selectedis = "";
		if ($soubor=="." || $soubor==".." || $soubor==".htaccess") continue; // || !is_dir($soubor)
		echo "<option value=\"".$soubor."\" ".$selectedis.">".$soubor."</option>";
		if ($default_slozka=="") $default_slozka=$soubor;
	}
	$slozka->close();
	echo "</select>";
	echo "</div></form>
	
	<div class=\"float-right\"><a href=\"imgexplorer.php?upload=1\">".$ilng['uploadnewimg']."</a></div>
	
	
	</div></div></div>
	
	<div id=\"hlavni-dalsi\">
	<div class=\"padding5-15\"> 
	<div class=\"align-center\"><div class=\"align-center\">";
	$pocet_obrazku=1;
	
	if (isset($_GET['seldirectory'])) $cilovy_adr=$_GET['seldirectory'];
	else $cilovy_adr=$default_slozka;
	
	if (substr($cilovy_adr,0,1)=='.' || substr($cilovy_adr,0,1)=='/') die('Hack?');
	
	$slozka = dir($img_save_path.$cilovy_adr);
	while($soubor=$slozka->read()) {
		if ($soubor=="." || $soubor==".." || $soubor==".htaccess") continue;
		if (preg_match("'^(..)(?<!m_)(.*)\.(gif|jpe?g|png)$'i",$soubor))
		{
			echo "<div class=\"nahled\"><div class=\"border1\"><div class=\"height135\">
					<a href=\"#null\" onclick=\"insertimg('".$img_save_relativ_path.$cilovy_adr."/".$soubor."');\"><img src=\"smallimg.php?imgpath=".$img_save_path.$cilovy_adr."/".$soubor."\" alt=\"\" title=\"".$soubor."\" /></a>
				  </div>".$max_y.substr(substr($soubor,0,-4),0,10)."<br />
<img src=\"../images/infoicon.gif\" onmouseover=\"showInfoDIV('".$img_save_relativ_path.$cilovy_adr."/".$soubor."',".filesize($img_save_path.$cilovy_adr."/".$soubor).");\" onmouseout=\"hideInfoDIV();\" style=\"cursor: pointer; border: 0px;\" alt=\"\" />&nbsp;";
if (!in_array(strtolower($cilovy_adr),$no_delete_dir)) echo "<a href=\"delimg.php?path=".$cilovy_adr."&amp;file=".$soubor."&amp;returnfolder=".$cilovy_adr."\" onclick=\"return potvrd('".$ilng['confirmdelete']."');\"><img src=\"../images/cancelicon.gif\" style=\"border: 0px;\" alt=\"\" /></a>";
echo "</div></div> ";

// <img src=\"../images/resizeicon.gif\" style=\"cursor: pointer; border: 0px;\" alt=\"\" />&nbsp;
		if ($pocet_obrazku%4==0) echo "<p><br class=\"clearboth\" /></p>"; 
		$pocet_obrazku++;
		}
	}
	$slozka->close();
	echo "</div></div></div>
	</div>";
}

echo "<div id=\"infoDiv\" class=\"infoDiv\"
style=\"display:none\" >
<div class=\"InfoTitle\">".$ilng['aboutpic']."</div>
<div id=\"infoTexts\">
<div  style=\"float:left\">";
echo $ilng['width'].": <br />";
echo $ilng['height'].": <br />";
echo $ilng['size'].": <br />";
echo $ilng['typeofimg'].": ";

 echo "
 </div>
 <div><span id=\"divWidthText\"></span><br />
 <span id=\"divHeightText\"></span><br />
  <span id=\"divSizeText\"></span><br />
  <span id=\"divTypeText\"></span>
 </div>
</div>
<div id=\"infoWaitText\">
".$ilng['waitplz']."
</div>
</div>";
?>

<img class="neviditelny" src="images/wfpimage.gif" id="tajnyobrazek2" />

</body>
</html>
