<?php

namespace Caravans\BackendModule\Presenters;

use Nette,
    \Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class VendorPresenter extends \BackendPresenter {

    /**
     * @var Model\VendorManager @inject
     */
    public $vendor;
    private $region;

    public function startup() {
        parent::startup();
        $this->template->vendors = $this->vendor->findAll(); //->order("id_prodejce, nazev, kraje.kraj ASC");
        $this->region = $this->vendor->getRegion();
        if (!$this->region) {
            $this->error("Nepodařilo se načíst kraje");
        }
    }

    public function actionEdit($id) {
        $vendor = $this->vendor->findById($id)->fetch();
        $this["createVendorForm"]->setDefaults($vendor);
        $this->setView("default");
        
    }

    public function renderDefault() {
        $this->template->title = "Dealerská síť";
    }

    protected function createComponentCreateVendorForm() {
        $form = new Nette\Application\UI\Form();
        $form->addSelect("id_kraj", "Kraj", $this->region)
                ->setPrompt('')
                ->setRequired("Nevyplnil jsi pole %label");
        $form->addText("nazev", "Název")
                ->setAttribute("maxlength", 80)
                ->setRequired("Nevyplnil jsi pole %label");
        $form->addText("adresa", "Adresa")
                ->setAttribute("maxlength", 50)
                ->setRequired("Nevyplnil jsi pole %label");
        $form->addText("mesto", "Město")
                ->setAttribute("maxlength", 50)
                ->setRequired("Nevyplnil jsi pole %label");
        $form->addText("psc", "PSČ")
                ->addRule(Nette\Application\UI\Form::NUMERIC)
                ->addRule(Nette\Application\UI\Form::LENGTH, "Délka musí být 5 čísel", 5)
                ->setAttribute("maxlength", 5)
                ->setRequired("Nevyplnil jsi pole %label");
        $form->addText("email", "Email")
                ->addRule(Nette\Application\UI\Form::EMAIL)
                ->setAttribute("maxlength", 50);
        $form->addText("telefon", "Telefon")
                ->addRule(Nette\Application\UI\Form::NUMERIC)
                ->addRule(Nette\Application\UI\Form::LENGTH, "Délka musí být 9 čísel", 9)
                ->setAttribute("maxlength", 9);
        $form->addText("web", "Web")
                ->addCondition(Nette\Application\UI\Form::FILLED)
                ->addRule(Nette\Application\UI\Form::URL);
        $form->addUpload("image", "Obrázek", false)
                ->addCondition(Nette\Application\UI\Form::FILLED)
                ->addRule(Nette\Application\UI\Form::IMAGE, "Neplatný formát hlavního obrázku");
        $form->addSubmit("send", "Uložit");
        $form->onSuccess[] = $this->createVendorSucceeded;
        return $form;
    }

    public function createVendorSucceeded($form, $values) {
        try {
            if(isset($values->image)){
                $image = $values->image;
                unset($values->image);
            }
            $id = null;
            if (isset($this->params["id"]) && $this->params["id"] != null) {
                $id = $this->params["id"];
                $this->vendor->edit($this->params["id"], (array) $values);
                $this->flashMessage("Upraveno", \FlashMessageTypes::OK);
            } else {
                $id = $this->vendor->add((array) $values);
                $this->flashMessage("Uloženo", \FlashMessageTypes::OK);
            }
            if(isset($image))
                $this->vendor->imageFactory($id)->uploadImage($image);
          //  $this->redirect("this");
        } catch (\RuntimeException $ex) {
            $form->addError($ex->getMessage());
        }
    }

    public function handleDelete($id) {
        try {
            $this->vendor->deleteById($id);
            $this->flashMessage("Prodejce byl úspěšně odstraněn", \FlashMessageTypes::OK);
            $this->redirect("this");
        } catch (\RuntimeException $ex) {
            $this->flashMessage($ex->getMessage(), \FlashMessageTypes::ERROR);
        }
    }

}
