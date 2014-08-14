<?php

namespace Caravans\BackendModule\Controls;

use Nette\Application\UI;
use Nette\Application\UI\Form;
use \Caravans\BackendModule;
use Caravans\Model;

/**
 * Komponenta pro vytváření a editaci obrázků.
 * @author Vladimír Antoš
 * @package caravans_backend_controls
 */
class GalleryManagerControl extends UI\Control {

    /**
     * @var Model\CategoryManager
     */
    private $category;

    /**
     * @var Model\CaravanImage
     */
    private $caravanImage;
    private $idCaravan = null;

    public function __construct(Model\CategoryManager $cm, Model\CaravanImage $ci, $idCaravan) {
        $this->category = $cm;
        $this->caravanImage = $ci;
        $this->idCaravan = $idCaravan;
        $this->caravanImage->setIdCaravan($this->idCaravan);
    }

    public function render() {
        $this->template->setFile(__DIR__ . "/addPictures.latte");
        $this->template->maxImageSize = maxImageSize;
        $this->template->render();
    }

    /**
     * Zobrazení fotek.
     */
    public function renderGallery(){
        $this->template->setFile(__DIR__."/gallery.latte");
        $this->template->galleryPath = caravanGalleryPath2;
        $this->template->mainImage = $this->caravanImage->mainImage();
        $this->template->images = $this->caravanImage->images();
        $this->template->columns = 3; // kolik bude zobrazeno obrázků vedle sebe
        $this->template->render();
    }
    
    protected function createComponentAddImagesForm() {
        $form = new UI\Form();
        $upload = $form->addUpload("mainImage", "Hlavní obrázek");
        if ($this->caravanImage->hasMainImage())
            $upload->setDisabled();
        $upload->addCondition(Form::FILLED)
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::IMAGE, "Můžete vložit pouze soubory JPEG, PNG nebo GIF")
                ->addRule(Form::MAX_FILE_SIZE, "Maximální velikost obrázku je " . maxImageSize . " kB", maxImageSize * 1024);
        $form->addSelect("kategorie", "Kategorie", $this->category->readAll(true))
                ->setPrompt("Vyber kategorii"); //->setRequired("Nevyplnil jsi pole %label");

        $form->addUpload("images", "Další obrázky", true)
                ->addCondition(Form::FILLED)
                ->addRule(Form::IMAGE, "Můžete vložit pouze soubory JPEG, PNG nebo GIF")
                ->addRule(Form::MAX_FILE_SIZE, "Maximální velikost obrázku je " . maxImageSize . " kB", maxImageSize * 1024);
        $form->onSuccess[] = $this->addImagesFormSucceeded;
        $form->addSubmit("odeslat", "Přidat obrázky");
        return $form;
    }

    public function addImagesFormSucceeded($form, $values) {
        try {
            if ($values->mainImage->name != null) {
                $this->caravanImage->addMainImage($values->mainImage);
            }
            
            if(!empty($values->images)) {
                if ($values->kategorie == null)
                    throw new \Nette\InvalidStateException("Nezadal jsi kategorii");
                $this->caravanImage->addImages($values->images, $values->kategorie);
            }
             $this->redirect("this");
        } catch (\Nette\InvalidStateException $e) {
            $form->addError($e->getMessage());
        }
    }
    
    public function handleDeleteMainImage($imageName, $idCaravan){
        $this->caravanImage->deleteMainImage($imageName);
        $this->redirect("this");
    }
    
    public function handleDeleteImage($imageName){
        $this->caravanImage->deleteImage($imageName);
        $this->redirect("this");
    }
}
