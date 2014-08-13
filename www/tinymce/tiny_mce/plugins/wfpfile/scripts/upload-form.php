<?

//upload souboru
echo "
	<div class=\"popis-okna\">
		<h2>".$ilng['uploadertoserver']." </h2>".$ilng['uploadertoserverdesc']."
	</div>
	
	<div id=\"menu\">
		<div class=\"float-right\" style=\"padding-right:10px;\"><a href=\"fexplorer.php\">".$ilng['backtoexplore']."</a></div>
		<div class=\"clearboth\"></div>
	</div>
	
	<div id=\"obsah\">
		<form action=\"uploader.php\" method=\"post\" enctype=\"multipart/form-data\">
		<table cellspacing=\"10\">
			<tr>
				<td style=\"width:160px;\">".$ilng['file']." 1:</td>
				<td style=\"width:400px;\"><input type=\"file\" name=\"upicture1\" id=\"upicture1\" size=\"50\" /></td>
			</tr>
			<tr>
				<td>".$ilng['file']." 2:</td>
				<td><input type=\"file\" name=\"upicture2\" id=\"upicture2\" size=\"50\" /></td>
			</tr>
			<tr>
				<td>".$ilng['file']." 3:</td>
				<td><input type=\"file\" name=\"upicture3\" id=\"upicture3\" size=\"50\" /></td>
			</tr>
			<tr>
				<td>".$ilng['uploadtodir']."</td>
				<td>
					<select name=\"selfolder\" style=\"width:150px;\">";
						$slozka = dir($file_save_path);
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
			</tr>
			<tr>
				<td>".$ilng['newfolder']."</td>
				<td><input type=\"text\" name=\"newfolder\" style=\"width:150px; height:15px;\" id=\"newfolder\" /></td>
			</tr>
			<tr>
				<td></td>
				<td>".$ilng['newfolderrecommendation']."</td>
			</tr>
			<tr>
			<td colspan=\"2\">";
				if (isset($_GET['ereport'])) { 
					echo "<strong>";
					switch ($_GET['ereport']) {
						case "001": echo $ilng['file']." 3 ".$ilng['uploaderror'];
								break;
						case "010": echo $ilng['file']." 2 ".$ilng['uploaderror'];
								break;
						case "100": echo $ilng['file']." 1 ".$ilng['uploaderror'];
								break;
						case "011": echo $ilng['file']." 2 ".$ilng['and']." 3 ".$ilng['uploaderror'];
								break;
						case "101": echo $ilng['file']." 1 ".$ilng['and']." 3 ".$ilng['uploaderror'];
								break;
						case "110": echo $ilng['file']." 1 ".$ilng['and']." 2 ".$ilng['uploaderror'];
								break;
						case "111": echo $ilng['nofileuploaded'];
								break;
						default: if ($_GET['misto']==0) echo $ilng['allfileuploaded']; 
								break;	
						
					}
					echo "</strong>";
				}
if ($_GET['misto']==1)
{
echo "<strong>".$ilng['nospace']."</strong>";
}
	
		echo "</td>
			</tr>
			<tr>
				<td colspan=\"2\"><input type=\"submit\" value=\"".$ilng['send']."\" id=\"insert\" /></td>
			</tr>
		</table>
	</form>
	</div>";

?>
