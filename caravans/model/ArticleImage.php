<?php

namespace Caravans\Model;

use \Caravans,
    Caravans\Model;
use Nette\Utils\Image;

/**
 * Třída pro práci s obrázky v databázi.
 * Pro obrázky generuje nová jména aby se zabránilo duplicitám. 
 * @author Bruno Puzják
 * @package caravans_model
 */
class ArticleImage extends Model\Gallery {

    /** @var \Caravans\Model\ArticleManager @inject * */
    public $articleManager;

    /**
     * Cesta do složky
     * @var string
     */
    private $galleryPath = null;
    private $idArticle = null;
    private $language;

    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
        $this->galleryPath = 'gallery/article/';
    }

    /**
     * @param \Nette\Http\FileUpload $image
     * @throws \Nette\InvalidStateException
     */
    public function addMainImage(\Nette\Http\FileUpload $image, $id) {
        $this->idArticle = $id;
        $imageName = $this->createImageName($image->name);
        $this->path = $this->galleryPath . $imageName;
        $image->move($this->path);
        if ($imageName == null || $this->idArticle == null)
            throw new \Nette\InvalidStateException();

        $image = Image::fromFile($this->path);
        $image->resize(160, 160)->save($this->path);
        $this->database->query("UPDATE clanky SET image='$this->path' WHERE id_clanek = $id");
    }

    /**
     * @param \Nette\Http\FileUpload $image
     * @throws \Nette\InvalidStateException
     */
    public function editMainImage(\Nette\Http\FileUpload $image, $id) {
        $this->idArticle = $id;
        $imageName = $this->createImageName($image->name);
        $this->path = $this->galleryPath . $imageName;
        $image->move($this->path);
        if ($imageName == null || $this->idArticle == null)
            throw new \Nette\InvalidStateException();

        $image = Image::fromFile($this->path);
        $image->resize(160, 160)->save($this->path);
        $this->database->query("UPDATE clanky SET image='$this->path' WHERE id_clanek = $id");
    }

    /**
     * Smaže hlavní obrázek z úložiště a z databáze. Pokud je zadán parametr mainImage, nenačítá se
     * název obrázku z databáze.
     * @params string $id id článku
     * @return CaravanImage
     */
    public function deleteMainImage($id = null) {
        $mainImage = $this->database->query("SELECT image FROM clanky WHERE id_clanek = $id")->fetch();
        $imageName = $mainImage->image;
        if ($imageName != "") {
            $this->path = $imageName;
            parent::deleteImage();
            $this->database->query("UPDATE clanky SET image='' WHERE id_clanek = $id");
        }
    }

    /*
     * Vrací informace o hlavním obrázku z databáze.
     * @return array
     */

    public function mainImage() {
        //upravit
        return $this->database->query("SELECT id_foto, nazev, datum FROM galerie
                JOIN hlavni_obrazky_karavany USING(id_foto) 
                WHERE hlavni=? AND id_karavan=? AND jazyk=?", 1, $this->idArticle, $this->language)->fetch();
    }

    /**
     * Kontrola, jestli má karavan nastaven hlavní obrázek.
     * @return bool
     */
    public function hasMainImage() {
        //upravit
        return $this->database->table("hlavni_obrazky_karavany")
                        ->where(array("id_karavan" => $this->idArticle, "jazyk" => $this->language))->count() > 0;
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
