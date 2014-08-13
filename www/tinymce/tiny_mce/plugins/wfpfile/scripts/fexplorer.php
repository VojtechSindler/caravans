<?


include "settings.php";
include "funkce.php";

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




<? 
// formular pro vlozeni souboru na server
if (isset($_GET['upload'])) {
	include "upload-form.php";
}

// -----------------------------------------
// prohlizeni souboru
else {
	echo "<div class=\"popis-okna\"><h2>".$ilng['explorer']." </h2>".$ilng['explorerdescription']."</div>
	<div id=\"menu\">
		<div class=\"float-left\" style=\"padding-left:10px;\">
			<form action=\"".$_SERVER['PHP_SELF']."\" method=\"GET\">";
				$slozka = dir($file_save_path);
				$default_slozka="";
				
				if ($def_dir != '' && $_GET['seldirectory']=='') $_GET['seldirectory'] = $def_dir;
				
				echo $ilng['selectdir']."<select name=\"seldirectory\" onchange=\"this.form.submit();\" style=\"width:150px;\">";
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
	echo "</form>
		</div>
		<div class=\"float-right\" style=\"padding-right:10px;\">
			<a href=\"fexplorer.php?upload=1\">".$ilng['uploadnewfile']."</a>
		</div>
		<div class=\"clearboth\"></div>
	</div>";
	
		if ($_GET['serad']=="") $_GET['serad']="nazev";
		if ($_GET['jak']=="") $_GET['jak']="vzes";
		if ($_GET['jak']=="vzes") $jak="ses";
		else $jak="vzes";
		
		$img_sipecka="<img src=\"img/".$_GET['jak'].".gif\" alt=\"\" />";
		$sipka_nazev=$sipka_velikost=$sipka_datum="";
		if ($_GET['serad']=="nazev") $sipka_nazev=$img_sipecka;
		if ($_GET['serad']=="velikost") $sipka_velikost=$img_sipecka;
		if ($_GET['serad']=="datum") $sipka_datum=$img_sipecka;
	
echo "<div class=\"hlavicka\">
		<table class=\"tabVypisSouboru\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
				<td class=\"tdIkony\"></td>
				<td><a class=\"aHlavicka\" href=\"?seldirectory=".$_GET['seldirectory']."&amp;serad=nazev&amp;jak=".$jak."\">".$ilng["name"]."</a></td>
				<td class=\"tdSize\"><a class=\"aHlavicka\" href=\"?seldirectory=".$_GET['seldirectory']."&amp;serad=velikost&amp;jak=".$jak."\">".$ilng["size"]."</a></td>
				<td class=\"tdDate\"><a class=\"aHlavicka\" href=\"?seldirectory=".$_GET['seldirectory']."&amp;serad=datum&amp;jak=".$jak."\">".$ilng["date"]."</a></td>
				<td class=\"tdAkce\">Akce</td>
			</tr>
		</table>
	</div>
	
	<div class=\"obsah\">";
		
		if (isset($_GET['seldirectory'])) $sel_adr=$_GET['seldirectory'];
		else $sel_adr=$default_slozka;
		
		if (substr($sel_adr,0,1)=='.' || substr($cilovy_adr,0,1)=='/') die('Hack?');
		
		$adr = $file_save_path.$sel_adr;
		$adr2 = $file_save_relativ_path.$adr;
		
		vypis_souboru($adr);
		
		if (sizeof($pole_adresaru)!=0) natsort($pole_adresaru);
		if (sizeof($pole_souboru)!=0) usort($pole_souboru, "serad_soubory");
		
		echo "<table class=\"tabVypisSouboru\" cellspacing=\"1\" cellpadding=\"0\">";
		for ($i=0;$i<sizeof($pole_adresaru);$i++) {
			echo "<tr>
					<td class=\"tdIkony\"><img src=\"img/adr.gif\" alt=\"\" /></td>
					<td class=\"tdFile\">[<a class=\"aAdr\" href=\"?serad=".$_GET['serad']."&amp;jak=".$_GET['jak']."&amp;adr=".$pole_adresaru[$i]["odkaz"]."\">".$pole_adresaru[$i]["nazev"]."</a>]</td>
					<td class=\"tdSize\"></td>
					<td class=\"tdDate\"></td>
					<td class=\"tdAkce\"></td>
				</tr>";
		}
		for ($i=0;$i<sizeof($pole_souboru);$i++) {
		//<a href=\"#null\" onclick=\"insertimg('".$adr2."/".$soubor."');\">
			echo "<tr>
					<td class=\"tdIkony\"><img src=\"".prirad_ikonu($pole_souboru[$i]["nazev"])."\" alt=\"\" /></td>
					<td class=\"tdName\"><a class=\"aSoubor\" href=\"#null\" onclick=\"insertfile('".$file_save_relativ_path.$cilovy_adr.$sel_adr."/".$pole_souboru[$i]["nazev"]."', '".velikost_souboru(filesize($file_save_path.$cilovy_adr.$sel_adr."/".$pole_souboru[$i]["nazev"]))."');\">".$pole_souboru[$i]["nazev"]."</a></td>
					<td class=\"tdSize\">".velikost_souboru($pole_souboru[$i]["velikost"])."</td>
					<td class=\"tdDate\">".date("d.m.Y H:i",$pole_souboru[$i]["datum"])."</td>
					<td class=\"tdAkce\">";
					
					if (!in_array(strtolower($sel_adr),$no_delete_dir)) 
					{
						echo "<a title=\"Smazat soubor\" href=\"delfile.php?path=".$sel_adr."&amp;file=".$pole_souboru[$i]["nazev"]."&amp;returnfolder=".$sel_adr."&amp;serad=".$_GET['serad']."&amp;jak=".$_GET['jak']."\" onclick=\"return potvrd('".$ilng['confirmdelete']."');\"><img src=\"../images/cancelicon.gif\" style=\"border: 0px;\" alt=\"Smazat\" /></a>";
					}	
					echo "</td>
				</tr>";
		}
		
		
		echo "</table>";
	echo "</div>";
}
?>
</body>
</html>
