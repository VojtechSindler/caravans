<?
function serad_soubory ($a, $b) {
	switch ($_GET['serad']) {
		case "nazev":	if ($_GET['jak']=="vzes") 
							return strcmp(strtolower($a[$_GET['serad']]),strtolower($b[$_GET['serad']]));
						if ($_GET['jak']=="ses")
    						return strcmp(strtolower($b[$_GET['serad']]),strtolower($a[$_GET['serad']]));
						break;
	
		case "velikost":
		case "datum":	if ($_GET['jak']=="vzes") {
							if ($a[$_GET['serad']]==$b[$_GET['serad']]) return 0;
							return ($a[$_GET['serad']] > $b[$_GET['serad']]) ? 1 : -1;
						}
						if ($_GET['jak']=="ses") {
							if ($b[$_GET['serad']]==$a[$_GET['serad']]) return 0;
							return ($b[$_GET['serad']] > $a[$_GET['serad']]) ? 1 : -1;
						}
						break;
	}
}

function velikost_souboru($cislo) {
	$KB=1024;
	$MB=1048576;
	$GB=1073741824;
	
	if ($cislo<$KB) $velikost=$cislo." B";
	else if ($cislo>$KB && $cislo<$MB) $velikost=round($cislo/$KB,2)." kB";
	else $velikost=round($cislo/$MB,2)." MB";
	return $velikost;
}

function prirad_ikonu($soubor) {
	$ico_path = "../images";
	switch (strtolower(substr($soubor,strrpos($soubor,".")))) {
		case ".doc": $ikona=$ico_path."/ico_doc.gif";
					 break;
		case ".xls": $ikona=$ico_path."/ico_xls.gif";
					 break;
		case ".ppt": $ikona=$ico_path."/ico_ppt.gif";
					 break;
		case ".txt": 
		case ".dat":
		case ".conf":$ikona=$ico_path."/ico_txt.gif";
					 break;
		case ".pdf": $ikona=$ico_path."/ico_pdf.gif";
					 break;
		case ".rar":
		case ".zip": $ikona=$ico_path."/ico_zip.gif";
					 break;
		case ".exe": $ikona=$ico_path."/ico_exe.gif";
					 break;
		case ".jpg": $ikona=$ico_path."/ico_jpg.gif";
					 break;
		case ".gif": $ikona=$ico_path."/ico_gif.gif";
					 break;
		case ".wav":
		case ".mp3": $ikona=$ico_path."/ico_mp3.gif";
					 break;
		default: $ikona=$ico_path."/ico_default.gif";
	} 
	return $ikona;
}

function vypis_souboru($jmenoAdr) {
	global $pole_adresaru, $pole_souboru;
	$a=0;
	$b=0;
	$slozka = dir($jmenoAdr);
	while($soubor=$slozka->read()) {
		if ($soubor=="." || $soubor=="..") continue;
		
		if ($_GET['adr']!="") $adr2=$_GET['adr']."/";
		else $adr2="";
		
		if (is_dir($jmenoAdr."/".$soubor)) {
			$pole_adresaru[$a]["nazev"]=$soubor;
			$pole_adresaru[$a]["odkaz"]=$adr2.$soubor;
			$a++;
		}
		else {
			$pole_souboru[$b]["nazev"]=$soubor;
			$pole_souboru[$b]["velikost"]=filesize($jmenoAdr."/".$soubor);
			$pole_souboru[$b]["datum"]=filemtime($jmenoAdr."/".$soubor);
			$b++;
		}
	}
	$slozka->close();
}

function removediakritika($text)

	{
		$return = StrToLower($text); //velká písmena nahradí malými.
		$return = Str_Replace(

						Array("á","è","ï","é","ì","í","¾","ò","ó","ø","š","","ú","ù","ý","ž","Á","È","Ï","É","Ì","Í","¼","Ò","Ó","Ø","Š","","Ú","Ù","Ý","Ž"," ","_","(",")","!",",","\"","'","?",":","+","/","\\","´","¡","=",":","$","@","*","&","^") ,

						Array("a","c","d","e","e","i","l","n","o","r","s","t","u","u","y","z","A","C","D","E","E","I","L","N","O","R","S","T","U","U","Y","Z","-","-","","","","","","","","-","-","-","-","-","-","-","-","-","-","-","-","-") ,

						$return);

		return $return;

	}


?>
