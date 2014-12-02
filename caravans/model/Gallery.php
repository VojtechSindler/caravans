<?php

namespace Caravans\Model;

/**
 * Třída pro práci s fyzickými obrázky.
 * @author Vladimír Antoš
 * @package caravans_model
 */
class Gallery extends ModelContainer{
    
    /** @var string */
    protected $path;
    
    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }
    
    public function setPath($path){
        $this->path = $path;
    }
    
    public function getPath(){
        return $this->path;
    }


    public function upload(){
        //asi není potřeba File Input vrací instanci FileUpload => volat FileUpload.move()
    }
    
    /**
     * Vrací seznam obrázků v danné složce.
     */
    public function getImages(){
        
    }
    
    /**
     * @return Gallery
     */
    public function deleteImage(){
        unlink($this->path);
    }
    
    /**
     * @param string $filename
     * @return bool
     */
    public function exists($filename){
        return file_exists($filename);
    }
}
