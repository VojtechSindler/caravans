<?php

namespace Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class AlbumManager extends Gallery {

    const TABLE = "fotogalerie";

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Nette\Utils\DateTime 
     */
    private $date;

    /**
     * @var int
     */
    private $lang;

    /**
     * @var string
     */
    private $mainImage;
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return \Nette\Utils\DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getMainImage(){
        return $this->mainImage;
    }
    
    /**
     * @param int $id
     * @return \Caravans\Model\AlbumManager
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     * @return \Caravans\Model\AlbumManager
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $description
     * @return \Caravans\Model\AlbumManager
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @param \Nette\Utils\DateTime $date
     * @return \Caravans\Model\AlbumManager
     */
    public function setDate(\Nette\Utils\DateTime $date) {
        $this->date = $date;
        return $this;
    }

    /**
     * @param int $lang
     * @return \Caravans\Model\AlbumManager
     */
    public function setLang($lang) {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @param string $image
     * @return \Caravans\Model\AlbumManager
     */
    public function setMainImage($image){
        $this->mainImage = $image;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getLanguage() {
        return Language::convertToString($this->lang);
    }

    /**
     * Vrací cestu do galerie
     * @return string
     */
    public function getPath() {
        if ($this->id == null || $this->lang == null)
            throw new \Nette\InvalidStateException("Nejsou zadány všechny parametry");
        return galleryPath . $this->id . "/";
    }

    /**
     * Vrací cestu do složky s náhledovými obrázky
     * @return string
     */
    public function getThumbPath() {
        return $this->getPath() . "thumb";
    }

    /**
     * @param string $name
     * @param int $lang
     * @param int $idOriginal
     * @param string $description
     * @throws \Nette\InvalidArgumentException
     */
    public function create($name, $lang, $idOriginal = null, $description = null) {
        $id = $idOriginal == null ? time() : $idOriginal;
        try {
            $this->database->table(self::TABLE)->insert(
                    array("id_galerie" => $id, "jazyk" => $lang, "nazev" => $name, "popis" => $description));
        } catch (\PDOException $ex) {
            if ($ex->getCode() == 23000)
                throw new \Nette\InvalidArgumentException("Tato galerie už existuje");
        }
        $path = $this->path($id);
        if (!file_exists($path))
            mkdir($path);
    }

    /**
     * @param int $id
     * @param int $lang
     * @param string $name
     * @param string $idOriginal
     * @param string $description
     * @return bool
     */
    public function edit($id, $oldLang, $lang, $name, $description = null) {
        try{
        $this->database->table("fotogalerie")
                ->where(array("id_galerie" => $id, "jazyk" => $oldLang))
                ->update(array("nazev" => $name, "jazyk" => $lang, "popis" => $description));
        } catch (\PDOException $ex) {
            if ($ex->getCode() == 23000)
                throw new \Nette\InvalidArgumentException("Tato galerie už existuje");
        }
    }

    /**
     * @return \Caravans\Model\AlbumManager[]
     */
    public function getAll() {
        $result = $this->database->query("SELECT id_galerie, nazev, popis, datum_vytvoreni, jazyk FROM fotogalerie ORDER BY id_galerie DESC, jazyk ASC")->fetchAll();
        $data = array();
        foreach ($result as $row) {
            $album = new AlbumManager($this->database);
            $album->id = $row->id_galerie;
            $album->name = $row->nazev;
            $album->description = $row->popis;
            $album->date = $row->datum_vytvoreni;
            $album->lang = $row->jazyk;
            $data[] = $album;
        }
        return $data;
    }

    /**
     * @param int $id
     * @param int $lang
     * @return \Caravans\Model\AlbumManager
     * @throws \Nette\InvalidStateException
     */
    public function getAlbum($id, $lang) {
        $result = $this->get($id, $lang);
        $album = new AlbumManager($this->database);
        $album->id = $result->id_galerie;
        $album->name = $result->nazev;
        $album->description = $result->popis;
        $album->lang = $result->jazyk;
        $album->date = $result->datum_vytvoreni;
        return $album;
    }

    /**
     * @param int $id
     * @param int $lang
     * @return \Nette\Database\Table\ActiveRow
     * @throws \Nette\InvalidStateException
     */
    public function get($id, $lang) {
        $result = $this->database->table("fotogalerie")->select("*")->where(array("id_galerie" => $id, "jazyk" => $lang))->fetch();
        if (!$result)
            throw new \Nette\InvalidStateException("Fotogalerie nebyla nalezena");
        return $result;
    }

    /**
     * @param int $lang
     * @return \Nette\Database\Table\ActiveRow
     */
    public function getByLang($lang) {
        $results = $this->database->table("fotogalerie")->select("*")->where(array("jazyk" => $lang))->fetchAll();
        $data = array();
        foreach ($results as $result) {
            $album = new AlbumManager($this->database);
            $album->id = $result->id_galerie;
            $album->name = $result->nazev;
            $album->description = $result->popis;
            $album->lang = $result->jazyk;
            $album->mainImage = $result->hlavni_obrazek;
            $album->date = $result->datum_vytvoreni;
            $data[] = $album;
        }
        return $data;
    }

    /**
     * Vrací počet obrázků v galerii
     * @return int
     */
    public function count() {
        $count = iterator_count(new \DirectoryIterator($this->getPath())) - 3;
        return $count < 0 ? 0 : $count;
    }

    /**
     * @param int $id
     * @param int $lang
     * @throws \Nette\InvalidArgumentException
     */
    public function delete($id, $lang) {
        try {
            $this->database->table("fotogalerie")->where(array("id_galerie" => $id, "jazyk" => $lang))->delete();
            if (!$this->existAlbum($id))
                $this->removeDir($this->path($id));
        } catch (\UnexpectedValueException $ex) {
            throw new \Nette\InvalidArgumentException("Galerie neexistuje");
        }
    }

    public function getImages() {
        $images = array();
        $iterator = new \DirectoryIterator($this->getPath());
        foreach ($iterator as $image)
            if ($image->isFile())
                $images[] = $image->getFilename();
        return $images;
    }

    /**
     * @param string $id Tvar ID-lang
     * @param array $images
     */
    public function addImages($id, array $images) {
        $path = galleryPath . $id . "/";
        foreach ($images as $image) {
            $image->move($path . $image->name);
            $this->resize($path, $image->name, 100, 100);
        }
    }

    /**
     * @param int $id
     * @param \Nette\Http\FileUpload $image
     */
    public function addMainImage($id, \Nette\Http\FileUpload $image) {
        $this->database->table(self::TABLE)->where("id_galerie", $id)->update(array("hlavni_obrazek" => $image->getName()));
        $this->addImages($id, array($image));
    }

    /**
     * Odstraní obrázek
     * @param int $id
     * @param string $image
     */
    public function deletePicture($id, $image) {
        unlink($this->path($id) . $image);
        unlink($this->path($id) . "thumb/" . $image);
    }

        
    public function deleteMainImage($id, $image){
        $this->database->table(self::TABLE)->where("id_galerie", $id)->update(array("hlavni_obrazek" => null));
        $this->deletePicture($id, $image);
    }
    
    /**
     * @param int $id
     * @param int $lang
     * @return string
     */
    private function path($id) {
        return galleryPath . $id . "/";
    }

    /**
     * @param string $dir
     * @param string $fileName
     * @param int $width
     * @param int $height
     * @return \Caravans\Model\AlbumManager
     */
    private function resize($dir, $fileName, $width, $height) {
        $thumbPath = $dir . "/thumb/" . $fileName;
        \Nette\Utils\FileSystem::copy($dir . "/" . $fileName, $thumbPath);
        $image = \Nette\Utils\Image::fromFile($thumbPath);
        $image->resize($width, $height)->save($thumbPath);
        return $this;
    }

    private function existAlbum($id) {
        return $this->database->table(self::TABLE)->select("*")->where("id_galerie", $id)->count() > 0;
    }

//
//    private $id;
//    private $name;
//    private $description;
//    private $date;
//    private $lang;
//
//    public function getLang() {
//        return $this->lang;
//    }
//
//    public function setLang($lang) {
//        $this->lang = $lang;
//        return $this;
//    }
//
//    public function getId() {
//        return $this->id;
//    }
//
//    public function getName() {
//        return $this->name;
//    }
//
//    public function getDescription() {
//        return $this->description;
//    }
//
//    public function getDate() {
//        return $this->date;
//    }
//
//    public function setId($id) {
//        $this->id = $id;
//        return $this;
//    }
//
//    public function setName($name) {
//        $this->name = $name;
//        return $this;
//    }
//
//    public function setDescription($description) {
//        $this->description = $description;
//        return $this;
//    }
//
//    public function setDate($date) {
//        $this->date = $date;
//        return $this;
//    }
//
//    /**
//     * @param string $name
//     * @param int $lang
//     * @param string $description
//     * @throws \Nette\InvalidArgumentException
//     */
//    public function create($name, $lang, $idOriginal = null, $description = null) {
//        $id = ($idOriginal == null ? time() : $idOriginal);
//        bdump($idOriginal);
//        try {
//            $this->database->table("fotogalerie")->insert(array("id_galerie" => $id, "jazyk" => $lang, "nazev" => $name, "popis" => $description));
//        } catch (\PDOException $ex) {
//            if ($ex->getCode() == 23000)
//                throw new \Nette\InvalidArgumentException("Tato galerie už existuje");
//        }
//        mkdir(galleryPath . $id."-".$lang, 777);
//    }
//
//    /**
//     * @param int $id
//     * @param string $name
//     * @param int $lang
//     * @param string $description
//     * @return bool
//     */
//    public function edit($id, $name, $lang, $description = null) {
//        return $this->database->table("fotogalerie")->where(array("id_galerie" => $id, "jazyk" => $lang))->update(
//                        array("nazev" => $name, "jazyk" => $lang, "popis" => $description));
//    }
//
//    /**
//     * Odstraní galerii.
//     * @param int $id
//     * @param int $lang
//     * @throws \Nette\InvalidArgumentException
//     */
//    public function delete($id, $lang) {
//        try {
//            $this->database->table("fotogalerie")->where(array("id_galerie" => $id, "jazyk" => $lang))->delete();
//            $this->removeDir(galleryPath . $id);
//        } catch (\UnexpectedValueException $ex) {
//            throw new \Nette\InvalidArgumentException("Galerie neexistuje");
//        }
//    }
//    
//    /**
//     * Odstraní obrázek
//     * @param int $id
//     * @param string $image
//     */
//    public function deletePicture($id, $image){
//        unlink(galleryPath.$id."/".$image);
//        unlink(galleryPath.$id."/thumb/".$image);
//    }
//
//    /**
//     * @param int $id ID galerie
//     * @param \Nette\Http\FileUpload[] $images
//     */
//    public function addImages($id, array $images) {
//        foreach ($images as $image) {
//            $image->move(galleryPath . $id . "/" . $image->name);
//            $this->resize(galleryPath . $id, $image->name, 100, 100);
//        }
//    }
//    
//    public function addMainImage($id, \Nette\Http\FileUpload $image){
//       // $this->database->table("fotogalerie")->
//    }
//
//    public function get($id, $lang) {
//        return $this->database->table("fotogalerie")->where(array("id_galerie" => $id, "jazyk" => $lang))->fetch();
//    }
//
//    /**
//     * Vrací seznam všech galerií.
//     * @return AlbumManager[]
//     */
//    public function getAllAlbums() {
//        $result = $this->database->table("fotogalerie")->select("*")->fetchAll();
//        $data = array();
//        foreach ($result as $row) {
//            $album = new AlbumManager($this->database);
//            $album->id = $row->id_galerie;
//            $album->name = $row->nazev;
//            $album->description = $row->popis;
//            $album->date = $row->datum_vytvoreni;
//            $album->lang = $row->jazyk;
//            $data[] = $album;
//        }
//        return $data;
//    }
//
//    public function getImages() {
//        $images = array();
//        $iterator = new \DirectoryIterator(galleryPath.$this->id."-".$this->lang);
//        foreach($iterator as $image)
//            if($image->isFile())
//                $images[] = $image->getFilename();
//        return $images;
//    }
//
//    /**
//     * Vrací počet obrázků v galerii.
//     * @param int $id
//     * @return int
//     */
//    public function count() {
//        $count = iterator_count(new \DirectoryIterator(galleryPath . $this->id."-".$this->lang)) - 3;
//        return $count < 0 ? 0 : $count;
//    }
//
//    /**
//     * @param string $dir
//     * @param string $fileName
//     * @param int $width
//     * @param int $height
//     * @return \Caravans\Model\AlbumManager
//     */
//    private function resize($dir, $fileName, $width, $height) {
//        $thumbPath = $dir . "/thumb/" . $fileName;
//        \Nette\Utils\FileSystem::copy($dir . "/" . $fileName, $thumbPath);
//        $image = \Nette\Utils\Image::fromFile($thumbPath);
//        $image->resize($width, $height)->save($thumbPath);
//        return $this;
//    }
}
