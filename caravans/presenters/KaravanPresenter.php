<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class KaravanPresenter extends BasePresenter {

    /**
     * @var Model\CaravanManager @inject
     */
    public $caravan;
    
    /**
     * @var Model\CaravanImage @inject
     */
    public $caravanImage;
    
    public $idCaravan;
    
    public function startup() {
        parent::startup();
        $this->template->items = array();
        $this->template->addedEquipments = array();
        
    }
    
    public function renderZobrazVse() {
        $caravans = $this->caravan->readCaravans();
        $this->template->galleryPath = caravanGalleryPath2."thumbs/";
//        $caravans[0]["hlavni_obrazek"] = caravanGalleryPath.$caravans[0]["hlavni_obrazek"];
        $this->template->caravans = $caravans;
    }

    public function renderModely(){
       
    }
    
    public function renderKaravan($id) {
        $this->idCaravan = $id;
        $this->caravanImage->idCaravan = $id;
        $this->caravan->id = $id;
        $caravan = $this->caravan->getCaravan($id);
        $this->template->caravan = $caravan;
        $this->template->description = $caravan->znacka.' '.$caravan->typ.',rozměry: '.$caravan->vyska.'x'.$caravan->sirka.'x'.$caravan->delka
                .'popis:'.$caravan->popis;
        $this->template->keywords[] = $caravan->znacka;
        $this->template->keywords[] = $caravan->typ;
        $this->template->galleryPath = caravanGalleryPath2;
        $this->template->gallery = $this->caravanImage->images();
        $this->template->equipments = $this->caravan->caravanEquipment()->getCaravanEquipment();
        $section = $this->session->getSection("caravanEquipment");
        bdump($section->equipment);
        if(!isset($section->equipment[$this->idCaravan]))
            $section->equipment[$this->idCaravan] = array();
            $this->template->addedEquipments = $section->equipment[$this->idCaravan];
    }

    public function createComponentSendEmail() {
        $form = new \Nette\Application\UI\Form();
        $form->addHidden("id_karavan", $this->idCaravan);
        $form->addText("email")
                ->setType('email')
                ->setAttribute("placeholder", "váš e-mail")
                ->setAttribute("style", "text-align:center");
        $form->addSubmit("odeslat", "Odeslat");
        $form->onSuccess[] = $this->sendEmailFormSucceeded;

        return $form;
    }

    public function sendEmailFormSucceeded($form, $values) {
        $section = $this->session->getSection("caravanEquipment");
        try{
        $this->caravan->sendToEmail($values->id_karavan, 
                $values->email, 
                $section->equipment[$values->id_karavan]);
        $this->flashMessage("Email byl odeslán", \FlashMessageTypes::OK);
        $this->redirect("this");
        }catch(Nette\InvalidArgumentException $e){
            $this->flashMessage($e->getMessage(), \FlashMessageTypes::ERROR);
            $this->redirect("this");
        }
    }
    
    public function handleCalculate($idCaravan, $id_equip, $name, $price){
        $section = $this->session->getSection("caravanEquipment");
        if(!isset($section->equipment[$idCaravan]))
            $section->equipment[$idCaravan] = array();
        if(!key_exists($id_equip, $section->equipment[$idCaravan]))
            $section->equipment[$idCaravan][$id_equip] = array($name, $price);
        $this->template->addedEquipments = $section->equipment[$idCaravan];

        $this->redrawControl("cart");
    }
    
    public function handleRemoveEquip($idCaravan, $id_equip){
        $section = $this->session->getSection("caravanEquipment");
        unset($section->equipment[$idCaravan][$id_equip]);
        $this->redirect("this");
    }
}
