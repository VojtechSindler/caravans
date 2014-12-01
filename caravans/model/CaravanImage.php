<?php

namespace Caravans\Model;

use \Caravans,
    Caravans\Model;
use Nette\Utils\Image;

/**
 * Třída pro práci s obrázky v databázi.
 * Pro obrázky generuje nová jména aby se zabránilo duplicitám. 
 * <example>
 *  $this->caravanImage
 *       ->setImage("image.jpg"); //vytvoří cestu /gallery/caravans/generovany_nazev.jpg
 * </example>
 * @author Vladimír Antoš
 * @package caravans_model
 */
class CaravanImage extends Model\Gallery {

    /**
     * Cesta do složky
     * @var string
     */
    private $galleryPath = null;
    private $idCaravan = null;
    private $language;
    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
        $this->galleryPath = caravanGalleryPath;
    }

    public function setIdCaravan($id) {
        $this->idCaravan = $id;
        return $this;
    }
    
    public function setLanguage($lang){
        $this->language = $lang;
        return $this;
    }

    /**
     * @param \Nette\Http\FileUpload $image
     * @throws \Nette\InvalidStateException
     */
    public function addMainImage(\Nette\Http\FileUpload $image) {
        //file_put_contents("gallery/caravans/pokus.txt", "AHOJ");
        $imageName = $this->createImageName($image->name);
        $this->path = $this->galleryPath . $imageName;
        $thumbPath = $this->galleryPath . "thumbs/" . $imageName;
        if ($imageName == null || $this->idCaravan == null)
            throw new \Nette\InvalidStateException();
        $id = $this->createId();
        $image->move($this->path);
        \Nette\Utils\FileSystem::copy($this->path, $thumbPath);

        $image = Image::fromFile($thumbPath);
        $image->resize(caravanImageWidth, caravanImageHeight)->save($thumbPath);
        $this->database->table("galerie")->insert(array(
            "id_foto" => $id,
            "nazev" => $imageName,
            "hlavni" => true
        ));

        $this->database->table("hlavni_obrazky_karavany")->insert(array(
            "id_foto" => $id,
            "id_karavan" => $this->idCaravan,
            "jazyk" => $this->language
        ));
    }

    /**
     * @param array $images
     * @param int $idCategory
     * @throws \Nette\InvalidStateException
     */
    public function addImages(array $images, $idCategory) {
        if ($this->idCaravan == null)
            throw new \Nette\InvalidStateException();
        foreach ($images as $image) {
            if (!$image->isOk())
                continue;
            $imageName = $this->createImageName($image->name);
            $path = $this->galleryPath . $imageName;
            $thumbPath = $this->galleryPath . "thumbs/" . $imageName;
            $id = $this->createId();

            $image->move($path);
            \Nette\Utils\FileSystem::copy($path, $thumbPath);

            $image = Image::fromFile($thumbPath);
            $image->resize(caravanImageWidth, caravanImageHeight)->save($thumbPath);
            //uložení do tbl galerie
            $this->database->table("galerie")->insert(array(
                "id_foto" => $id,
                "nazev" => $imageName,
                "hlavni" => false
            ));

            $this->database->table("galerie_kategorie")->insert(array(
                "id_kategorie" => $idCategory,
                "id_karavan" => $this->idCaravan,
                "jazyk" => $this->language,
                "id_foto" => $id
            ));
        }
    }

    /**
     * Smaže hlavní obrázek z úložiště a z databáze. Pokud je zadán parametr mainImage, nenačítá se
     * název obrázku z databáze.
     * @params string $mainImage název hlavního obrázku
     * @return CaravanImage
     */
    public function deleteMainImage($mainImage = null, $imageId = null) {       
        if ($mainImage == null) {
            $mainImage = $this->mainImage();
            if($mainImage == false) return $this;
            $imageName = $mainImage->nazev;
            $this->path = $this->galleryPath . $imageName;
            $this->_deleteImage($imageName, $mainImage->id_foto, $this->idCaravan);
            $this->database->table("galerie")
                    ->where("id_foto", $mainImage->id_foto)->delete();
            //$this->database->table("hlavni_obrazky_karavany")->where("id_foto", $mainImage->id_foto)->delete();
        } else {
            $this->path = $this->galleryPath . $mainImage;
            $this->_deleteImage($mainImage, $imageId, $this->idCaravan);
//            $this->database->table("galerie")
//                    ->where("nazev", $mainImage)->delete();
            $this->database->table("hlavni_obrazky_karavany")
                    ->where(array("id_karavan"=>$this->idCaravan, "jazyk"=>$this->language))->delete();
        }
        return $this;
    }

    /**
     * Odstraní všechny obrázky karavanu kromě hlavního.
     * @return CaravanImage
     */
    public function deleteAllImages() {
        $images = $this->images();
        foreach ($images as $image) {
            $this->path = $this->galleryPath . $image->nazev;
            $this->_deleteImage($image->nazev, $image->id_foto, $this->idCaravan);
        }
        $this->database->query("DELETE galerie FROM galerie
            INNER JOIN galerie_kategorie ON galerie.id_foto = galerie_kategorie.id_foto
            WHERE galerie_kategorie.id_karavan = ? AND galerie_kategorie.jazyk=?", $this->idCaravan, $this->language);
        return $this;
    }

    public function _deleteImage($imageName, $imageId, $idCaravan) {
        if ($imageId == null)
            throw new \Nette\InvalidArgumentException;
        $this->path = $this->galleryPath . $imageName;
        parent::deleteImage();
        $this->database->table("galerie")->where("id_foto", $imageId)->delete();
        $this->database->table("galerie_kategorie")->where(array("id_foto"=>$imageId,"id_karavan"=>$idCaravan, "jazyk"=>$this->language))->delete();
    }

    /*
     * Vrací informace o hlavním obrázku z databáze.
     * @return array
     */
    public function mainImage() {
        return $this->database->query("SELECT id_foto, nazev, datum FROM galerie
                JOIN hlavni_obrazky_karavany USING(id_foto) 
                WHERE hlavni=? AND id_karavan=? AND jazyk=?", 1, $this->idCaravan, $this->language)->fetch();
    }

    public function copyMainImage($idActual, $idCurrent){
//        $this->idCaravan = $idActual;
//        $mainImage = $this->mainImage();
//        $id = $this->createId();
//         $this->database->table("galerie")->insert(array(
//            "id_foto" => $id,
//            "nazev" => $mainImage->nazev,
//            "hlavni" => $mainImage->hlavni
//        ));
//
//        $this->database->table("hlavni_obrazky_karavany")->insert(array(
//            "id_foto" => $id,
//            "id_karavan" => $idCurrent
//        ));
//        return $this;
    }
    
    public function copyImages(){
        
    }
    
    /**
     * Vrací informace o všech obrázcích kromě hlavního z databáze.
     * @return array
     */
    public function images() {
        return $this->database->query("SELECT g.id_foto, g.`nazev`, k.`nazev` as kategorie FROM "
                        . "`galerie` as g JOIN galerie_kategorie USING(id_foto) "
                        . "JOIN kategorie as k USING(id_kategorie) "
                        . "WHERE hlavni=? AND id_karavan =? AND jazyk=? ORDER BY k.`nazev`", 0, $this->idCaravan, $this->language)->fetchAll();
    }

    /**
     * Kontrola, jestli má karavan nastaven hlavní obrázek.
     * @return bool
     */
    public function hasMainImage() {
        return $this->database->table("hlavni_obrazky_karavany")
                        ->where(array("id_karavan"=> $this->idCaravan, "jazyk"=>$this->language))->count() > 0;
    }

    /**
     * Vytvoří nový název obrázku a provádí kontrolu jestli už je název unikátní.
     * @param string $oldName Název souboru z formuláře
     * @return string
     */
    private function createImageName($oldName) {
        $extension = explode(".", $oldName);
        $extension = $extension[count($extension) - 1]; //koncovka souboru
        $filename = null;
        do {
            $filename = $this->randString(imageNameLength) . "." . $extension;
        } while ($this->exists($filename));
        return $filename;
    }

    /**
     * Generuje náhodné unikátní ID fotky a kontroluje v databázi jestli neexistuje.
     * @return int
     */
    private function createId() {
        $id = null;
        do {
            $id = $this->randNumber(caravanImageIdLength);
        } while ($this->database->table("galerie")->where("id_foto", $id)->count() == 1);
        return (int) $id;
    }

}
