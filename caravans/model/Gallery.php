<?php

namespace Caravans\Model;

/**
 * Třída pro práci s fyzickými obrázky.
 * @author Vladimír Antoš
 * @package caravans_model
 */
class Gallery extends ModelContainer {

    /** @var string */
    protected $path;

    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    public function upload() {
        //asi není potřeba File Input vrací instanci FileUpload => volat FileUpload.move()
    }

    /**
     * Vrací seznam obrázků v danné složce.
     */
    public function getImages() {
        
    }

    /**
     * @return Gallery
     */
    public function deleteImage() {
        unlink($this->path);
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function exists($filename) {
        return file_exists($filename);
    }

    /**
     * Odstraní složku včetně souborů
     * @param string $dir
     * @param bool $withFolder Pokud je true, smaže se i samotná složka
     */
    public function removeDir($dir, $withFolder = true) {
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                continue;
            }
            if ($file->isDir() && $withFolder) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        if($withFolder)
        rmdir($dir);
    }
}
