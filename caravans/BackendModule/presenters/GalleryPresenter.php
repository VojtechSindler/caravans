<?php

namespace Caravans\BackendModule\Presenters;

use \Nette\Application\UI;
use \Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class GalleryPresenter extends \BackendPresenter {

    /**
     * @var Model\AlbumManager @inject
     */
    public $album;
    private $albums;

    public function startup() {
        parent::startup();
        $this->albums = $this->album->getAll();
    }

    public function renderDefault() {
        $this->navigation("Správce galerie");
        $this->title = "Správce galerie";
        $this->template->albums = $this->albums;
        $this->sidebar("albumsList", "Seznam galerií");
    }

    public function actionEdit($id, $lang) {
        try {
            $album = $this->album->get($id, $lang);
        } catch (\Nette\InvalidStateException $ex) {
            $this->flashMessage($ex->getMessage(), \FlashMessageTypes::ERROR);
            $this->redirect("Gallery:");
        }
        $this["addGallery"]->setDefaults($album->toArray());
        $this["addGallery"]["galerie_original"]->setDisabled();
        $this->navigation("Správce galerie", "Editace");
        $this->template->albums = $this->albums;
        $this->title = "Správce galerie";
        $this->sidebar("albumsList", "Seznam galerií");
    }

    protected function createComponentAddGallery() {
        $form = new UI\Form;
        $data = array();
        $albums = $this->album->getByLang(Model\Language::CS);
        foreach($albums as $album) 
            $data[$album->id] = $album->name;
        $form->addSelect("galerie_original", "Překlad galerie", $data)->setPrompt('');
        $form->addSelect("jazyk", "Jazyk", array(
            Model\Language::CS => "čeština",
            Model\Language::DE => "němčina",
            Model\Language::EN => "angličtina"));
        $form->addText("nazev", "Název")->setRequired("Nezadal jsi název")
                ->addRule(UI\Form::MAX_LENGTH, "Maximální velikost je 50", 50);
        $form->addTextArea("popis", "Popis");
        $form->addHidden("id_galerie");
        $form->onSuccess[] = $this->addGallerySucceeded;
        $form->addSubmit("send", "Uložit");
        return $form;
    }

    public function addGallerySucceeded($form, $values) {
        try {
            if (!empty($values->id_galerie)) {
                $this->album->edit($values->id_galerie,$this->params["lang"], $values->jazyk, $values->nazev, $values->popis);
                $this->flashMessage("Galerie byla upravena", \FlashMessageTypes::OK);
                $this->redirect("Gallery:");
            } else {
                $this->album->create($values->nazev, $values->jazyk, $values->galerie_original, $values->popis);
                $this->flashMessage("Galerie byla úspěšně vytvořena, můžeš přidat obrázky", \FlashMessageTypes::OK);
            }
            $this->redirect("this");
        } catch (\Nette\InvalidArgumentException $ex) {
            $form->addError($ex->getMessage());
        }
    }

    public function handleDelete($id, $lang) {
        try {
            $this->album->delete($id, $lang);
            $this->flashMessage("Galerie byla odstraněna", \FlashMessageTypes::OK);
        } catch (\Nette\InvalidArgumentException $ex) {
            $this->flashMessage($ex->getMessage(), \FlashMessageTypes::ERROR);
        }
        $this->redirect("this");
    }

    protected function createComponentAddImages() {
        $form = new UI\Form;
        $data = array();
        $albums = $this->album->getByLang(Model\Language::CS);
        foreach ($albums as $album) {
            $data[$album->id] = $album->name;
        }
        
        $form->addSelect("galerie", "Galerie", $data)
                ->setPrompt("")
                ->setRequired("Nevybral jsi galerii");
        $form->addUpload("main", "Hlavní obrázek", false)
                ->addCondition(UI\Form::FILLED)
                ->addRule(UI\Form::IMAGE, "Neplatný formát hlavního obrázku");
        $form->addUpload("images", "Vlož obrázky", true)
                ->addCondition(UI\Form::FILLED)
                ->addRule(UI\Form::IMAGE, "Neplatný formát obrázku");
        $form->onSuccess[] = $this->addImagesSucceeded;
        $form->addSubmit("send", "Uložit");
        return $form;
    }

    public function addImagesSucceeded($form, $values = null) {
        $this->album->addMainImage($values->galerie, $values->main);
        $this->album->addImages($values->galerie, $values->images);
        $this->flashMessage("Obrázky byly nahrány", \FlashMessageTypes::OK);
        $this->redirect("this");
    }

    protected function createComponentImageViewer(){
        $image = new \Caravans\BackendModule\Controls\ImageEditableViewerControl($this->album);
        return $image;
    }
//    
//    public function handleDelete($id, $lang) {
//        try {
//            $this->album->delete($id, $lang);
//        } catch (\Nette\InvalidArgumentException $ex) {
//            $this->flashMessage($ex->getMessage(), \FlashMessageTypes::ERROR);
//        }
//        $this->redirect("Homepage:");
//    }
}
