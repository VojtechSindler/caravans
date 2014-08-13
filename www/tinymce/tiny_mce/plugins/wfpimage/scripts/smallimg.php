<?

   $imagePath=$_GET['imgpath'];
   $max_x=120;
   $max_y=120;
   preg_match("'^(.*)\.(gif|jpe?g|png)$'i", "a".substr($imagePath,-5), $ext);
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
       imagedestroy($im);
       Header("Content-type: image/jpeg"); 
	   imagejpeg($save);
       
       imagedestroy($save);
   }

?>