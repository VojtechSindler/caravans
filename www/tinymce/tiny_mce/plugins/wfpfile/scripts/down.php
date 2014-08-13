<?



//*************************************** HLAVNI PROGRAM *********************************************



if ($_GET['serad']=="") $_GET['serad']="nazev";
if ($_GET['jak']=="") $_GET['jak']="vzes";
if ($_GET['jak']=="vzes") $jak="ses";
else $jak="vzes";

$img_sipecka="<img src=\"img/".$_GET['jak'].".gif\" alt=\"\" />";
$sipka_nazev=$sipka_velikost=$sipka_datum="";
if ($_GET['serad']=="nazev") $sipka_nazev=$img_sipecka;
if ($_GET['serad']=="velikost") $sipka_velikost=$img_sipecka;
if ($_GET['serad']=="datum") $sipka_datum=$img_sipecka;

echo "<table>
		<tr class=\"trHlavicka\">
			<td colspan=\"2\">&nbsp;".$sipka_nazev."&nbsp;<a class=\"aHlavicka\" href=\"?adr=".$_GET['adr']."&amp;serad=nazev&amp;jak=".$jak."\">File</a></td>
			<td class=\"tdSize\">&nbsp;".$sipka_velikost."&nbsp;<a class=\"aHlavicka\" href=\"?adr=".$_GET['adr']."&amp;serad=velikost&amp;jak=".$jak."\">Size</a></td>
			<td class=\"tdDate\">&nbsp;".$sipka_datum."&nbsp;<a class=\"aHlavicka\" href=\"?adr=".$_GET['adr']."&amp;serad=datum&amp;jak=".$jak."\">Date</a></td>
		</tr>
		<tr>
			<td class=\"tdLinka\" colspan=\"4\"></td>
		</tr>";
$zpet="adr=".substr($_GET['adr'],0,strrpos($_GET['adr'],"/"));
if ($_GET['adr']!="") {
	echo "<tr>
			<td class=\"tdIkony\"><img src=\"img/up.gif\" alt=\"\" /></td>
			<td class=\"tdFile\">[<a class=\"aAdr\" href=\"?serad=".$_GET['serad']."&amp;jak=".$_GET['jak']."&amp;".$zpet."\">. .</a>]</td>
			<td class=\"tdSize\"></td>
			<td class=\"tdDate\"></td>
		</tr>";
}



vypis_souboru($file_save_path.$default_slozka);


if (sizeof($pole_adresaru)!=0) natsort($pole_adresaru);
if (sizeof($pole_souboru)!=0) usort($pole_souboru, "serad_soubory");

for ($i=0;$i<sizeof($pole_adresaru);$i++) {
	echo "<tr>
			<td class=\"tdIkony\"><img src=\"img/adr.gif\" alt=\"\" /></td>
			<td class=\"tdFile\">[<a class=\"aAdr\" href=\"?serad=".$_GET['serad']."&amp;jak=".$_GET['jak']."&amp;adr=".$pole_adresaru[$i]["odkaz"]."\">".$pole_adresaru[$i]["nazev"]."</a>]</td>
			<td class=\"tdSize\"></td>
			<td class=\"tdDate\"></td>
		</tr>";
}
for ($i=0;$i<sizeof($pole_souboru);$i++) {

	echo "<tr>
			<td class=\"tdIkony\"><img src=\"".prirad_ikonu($pole_souboru[$i]["nazev"])."\" alt=\"\" /></td>
			<td class=\"tdFile\"><a class=\"aSoubor\" href=\"".$adresar."/".$pole_souboru[$i]["nazev"]."\">".$pole_souboru[$i]["nazev"]."</a></td>
			<td class=\"tdSize\"><span> [ ".velikost_souboru($pole_souboru[$i]["velikost"])." ]</span></td>
			<td class=\"tdDate\"><span>".date("d.m.Y H:i",$pole_souboru[$i]["datum"])."</span></td>
		</tr>";
}


echo "</table>";
?>