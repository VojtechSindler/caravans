<?

include "scripts/settings.php";

if (file_exists("langs/".$aplication_language.".php")) include "langs/".$aplication_language.".php";
else include "langs/en.php";

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
	<title><? echo $ilng['title']; ?></title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="jscripts/functions.js"></script>
	<link href="css/wfpstyle.css" rel="stylesheet" type="text/css" />
	<base target="_self" />
</head>
<body id="wfpimage">

<div class="borderbottom1"><div id="vrchni"><div class="padding5">
<h2><? echo $ilng['title']." </h2>".$ilng['undertitle'] ?></div></div></div>
<div id="hlavni">
<div class="padding5-15">
<form id="formik" onSubmit="vlozImg();return false;" action="#">
<table cellspacing="9">
<tr>
<? echo "<td>
".$ilng['imgpath']."
</td>
<td>
<input type=\"text\" name=\"imgpath\" style=\"width:300px; height:15px;\" id=\"imgpath\" onchange=\"updateinvisible(this.value);\" />
</td>
<td><a href=\"#null\" onclick=\"imgexplore();\">".$ilng['explore']."</a></td>
</tr><tr>
<td>
".$ilng['alternativtext']."
</td>
<td colspan=\"2\">
<input type=\"text\" value=\"- - -\" onclick=\"clearalt();\" name=\"alttext\" style=\"width:300px; height:15px;\" id=\"alttext\" />
</td>
</tr><tr>
<td>
".$ilng['imgtitle']."
</td>
<td colspan=\"2\">
<input type=\"text\" name=\"imgtitle\" style=\"width:300px; height:15px;\" id=\"imgtitle\" />
</td>
</tr><tr>
<td>
".$ilng['imgsize']."
</td>
<td>
<input type=\"text\" name=\"imgwidth\" style=\"width:35px; height:15px; text-align:center;\" id=\"imgwidth\" onchange=\"changeheight();\" />
 x 
<input type=\"text\" name=\"imgheight\" style=\"width:35px; height:15px; text-align:center;\" id=\"imgheight\" onchange=\"changewidth();\" /> px <span style=\"display:none;\" id=\"idloadinginfo\">".$ilng['loadingimginfo']."</span>
</td>
<td class=\"valign-top\" rowspan=\"5\">
<div class=\"border1\"><div id=\"ukazkovy\"><div class=\"padding2\">
<img src=\"images/testimage.gif\" id=\"imgukazkovy\" />
".$ilng['testtext']."
</div>
</div>
</div>

</td>
</tr><tr>
<td>

</td>
<td>
<input type=\"checkbox\" name=\"proportions\" id=\"proportions\" checked=\"checked\" /> <label for=\"proportions\">".$ilng['proportions']."</label>
</td>
</tr><tr>
<td>
".$ilng['imgalign']."
</td>
<td colspan=\"2\">
<select style=\"width:145px; height:15px;\" name=\"imgalign\" id=\"imgalign\" onchange=\"zmenanahledu();\">
<option value=\"\">".$ilng['notset']."</option>
<option value=\"left\" id=\"left\">".$ilng['left']."</option>
<option value=\"right\" id=\"right\">".$ilng['right']."</option>
<option value=\"middle\" id=\"middle\">".$ilng['middle']."</option>
<option value=\"top\" id=\"top\">".$ilng['top']."</option>
<option value=\"bottom\" id=\"bottom\">".$ilng['bottom']."</option>
<option value=\"absbottom\" id=\"absbottom\">".$ilng['absbottom']."</option>
<option value=\"absmiddle\" id=\"absmiddle\">".$ilng['absmiddle']."</option>
<option value=\"baseline\" id=\"baseline\">".$ilng['baseline']."</option>
</select>
</td>
</tr><tr>
<td>
".$ilng['border']."
</td>
<td>
<input type=\"text\" name=\"imgborder\" style=\"width:35px; height:15px; text-align:center;\" id=\"imgborder\" onchange=\"zmenanahledu();\" /> px
</td>
</tr><tr>
<td>
".$ilng['margintop']."
</td>
<td>
<input type=\"text\" name=\"imgmargintop\" style=\"width:35px; height:15px; text-align:center;\" id=\"imgmargintop\" onchange=\"zmenanahledu();\" /> px, ".$ilng['marginbottom']." <input type=\"text\" name=\"imgmarginbottom\" style=\"width:35px; height:15px; text-align:center;\" id=\"imgmarginbottom\" onchange=\"zmenanahledu();\" />
</td>
</tr><tr>
<td>
".$ilng['marginleft']."
</td>
<td>
<input type=\"text\" name=\"imgmarginleft\" style=\"width:35px; height:15px; text-align:center;\" id=\"imgmarginleft\" onchange=\"zmenanahledu();\" /> px, ".$ilng['marginright']."&nbsp; <input type=\"text\" name=\"imgmarginright\" style=\"width:35px; height:15px; text-align:center;\" id=\"imgmarginright\" onchange=\"zmenanahledu();\" />
</td>
</tr><tr>
<td colspan=\"2\">
<input type=\"checkbox\" name=\"doaslink\" id=\"doaslink\" /> <label for=\"doaslink\">".$ilng['doaslink']."</label>
</td>
</tr><tr>
<td colspan=\"3\">
<a href=\"#null\" onclick=\"imgexplore('imgpath','scripts/imgexplorer.php?upload=1', 355, 600);\">".$ilng['uploadnewimg']."</a>
</td>
</tr>"; ?>
</table>
<div class="mceActionPanel">

			<div style="float: left;">
				<input id="insert" name="insert" value="<? echo $ilng['insert'];?>" type="submit">
			</div>

			<div style="float: right;">
				<input id="cancel" name="cancel" value="<? echo $ilng['cancel'];?>" onClick="tinyMCEPopup.close();" type="button">
			</div>
		</div>
</form>
</div>
</div>

<img class="neviditelny" src="images/wfpimage.gif" id="tajnyobrazek" />

</body>
</html>

