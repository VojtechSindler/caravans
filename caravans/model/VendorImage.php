<?php

namespace Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class VendorImage extends Gallery{
    
    /**
     * @param string $path
     */
    public function __construct($path) {
        $this->path = $path."/";
    }
    
    /**
     * @param string $path
     * @return \Caravans\Model\VendorImage
     */
    public static function create($path, $id) {
        if(!file_exists($path))
            \Nette\Utils\FileSystem::createDir($path);
        if(!file_exists($path.$id))
            \Nette\Utils\FileSystem::createDir($path.$id);  
        return new VendorImage($path.$id);
    }

    public function uploadImage(\Nette\Http\FileUpload $image) {
        $this->removeDir($this->path, false);
        $extension = explode(".", $image->name);
        $extension = $extension[count($extension) - 1]; //koncovka souboru
        $filename = $this->randString(imageNameLength) . "." . $extension;
        $path = $this->path."obrazek".".".$extension;
        $image->move($path);
        $image = \Nette\Utils\Image::fromFile($path);
        $image->resize(caravanImageWidth, caravanImageHeight)->save($path);
    }
}
