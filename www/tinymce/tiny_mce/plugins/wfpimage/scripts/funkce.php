<?
function saveThumbnail($saveToDir, $imagePath, $imageName, $max_x, $max_y) {
   preg_match("'^(.*)\.(gif|jpe?g|png)$'i", $imageName, $ext);
   switch (strtolower($ext[2])) {
       case 'jpg' : 
       case 'jpeg': $im  = imagecreatefromjpeg ($imagePath);
                     break;
       case 'gif' : $im  = imagecreatefromgif  ($imagePath);
                     break;
       case 'png' : $im  = imagecreatefrompng  ($imagePath);
                     break;
       default    : $stop = true;
                     break;
   }
   
   if (!isset($stop)) {
       $x = imagesx($im);
       $y = imagesy($im);
   		
		if ($x<$max_x && $y<$max_y) {
			 $save = imagecreatetruecolor($x, $y);
		}
	else
   		
       if (($max_x/$max_y) < ($x/$y)) {
           $save = imagecreatetruecolor($x/($x/$max_x), $y/($x/$max_x));
       }
       else {
           $save = imagecreatetruecolor($x/($y/$max_y), $y/($y/$max_y));
       }
       imagecopyresized($save, $im, 0, 0, 0, 0, imagesx($save), imagesy($save), $x, $y);
       
       imagejpeg($save, "{$saveToDir}{$ext[1]}.jpg");
       imagedestroy($im);
       imagedestroy($save);
   }
}

function removediakritika($text)

	{
		$return = StrToLower($text); //velk psmena nahrad malmi.
		$return = Str_Replace(

						Array("á","è","ï","é","ì","í","¾","ò","ó","ø","š","","ú","ù","ý","ž","Á","È","Ï","É","Ì","Í","¼","Ò","Ó","Ø","Š","","Ú","Ù","Ý","Ž"," ","_","(",")","!",",","\"","'","?",":","+","/","\\","´","¡","=",":","$","@","*","&","^") ,

						Array("a","c","d","e","e","i","l","n","o","r","s","t","u","u","y","z","A","C","D","E","E","I","L","N","O","R","S","T","U","U","Y","Z","-","-","","","","","","","","-","-","-","-","-","-","-","-","-","-","-","-","-") ,

						$return);

		return $return;

	}

?>
