<?php

namespace Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class StatisticsManager extends ModelContainer{
    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }
    
    public function countColumns(){
        return $this->database->query("SHOW TABLE STATUS WHERE Name='clanky' OR Name='karavany' OR Name='galerie'")->fetchPairs("Name", "Rows");
    }
    
    public function size(){
        return $this->database->query("SELECT table_name AS `Table`, 
        round(((data_length + index_length) / 1024), 2) Size 
        FROM information_schema.TABLES 
        WHERE table_schema = 'f62049' AND table_name='clanky' 
        OR table_name='karavany' OR table_name='galerie'")->fetchPairs("Table", "Size");
    }
    
    public function lastInsertArticle(){
        return $this->database->query("SELECT `datum_vytvoreni` FROM `clanky` ORDER BY `datum_vytvoreni` DESC LIMIT 1")->fetch();
    }
    
    public function lastInsertCaravan(){
        return $this->database
                ->query("SELECT `datum_vlozeni` FROM `karavany` ORDER BY `datum_vlozeni` DESC LIMIT 1")->fetch();
    }
    
    public function gallerySize(){
        return round($this->_gallerySize(caravanGalleryPath)/1024/1024, 2);
    }
    
    private function _gallerySize($path){
        $size = 0;
        $iterator = new \DirectoryIterator($path);
        foreach($iterator as $fileInfo){
            if($fileInfo->isFile()){
                $size += $fileInfo->getSize();
            }
            if($fileInfo->isDir() && !$fileInfo->isDot())
                $this->size($fileInfo->getPath ());
        }
        return $size;
    }
}
