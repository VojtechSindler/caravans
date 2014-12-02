<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class CaravanPresenter extends BasePresenter {

    /**
     * @var Model\CaravanManager @inject
     */
    public $caravan;

    /**
     * @var Model\CaravanImage @inject
     */
    public $caravanImage;
    public $idCaravan;
    private $captcha;

    public function startup() {
        parent::startup();
        $this->template->items = array();
        $this->template->addedEquipments = array();
        $this->captcha = new Model\Captcha(170, 75, 4, 4);
        $this->caravanImage->setLanguage(Model\Language::convertToInt($this->locale));
    }

    public function renderShowAll() {
        $caravans = $this->caravan->readCaravans(Model\Language::convertToInt($this->locale));
        $this->template->galleryPath = caravanGalleryPath2 . "thumbs/";
//        $caravans[0]["hlavni_obrazek"] = caravanGalleryPath.$caravans[0]["hlavni_obrazek"];
        $this->template->caravans = $caravans;
    }

    public function renderModels() {
        
    }

    public function renderView($id, $title) {
        $this->idCaravan = $id;
        $this->caravanImage->idCaravan = $id;
        $this->caravan->id = $id;
        $caravan = $this->caravan->getCaravan($id, Model\Language::convertToInt($this->locale));
        $this->template->caravan = $caravan;
        $this->template->description = $caravan->znacka . ' ' . $caravan->typ . ',rozměry: ' . $caravan->vyska . 'x' . $caravan->sirka . 'x' . $caravan->delka
                . 'popis:' . $caravan->popis;
        $this->template->children = $this->caravan->getSimilarCaravans($caravan->id_karavan, $caravan->id_zaklad, Model\Language::convertToInt($this->locale));
        $this->template->keywords[] = $caravan->znacka;
        $this->template->keywords[] = $caravan->typ;
        $this->template->galleryPath = caravanGalleryPath2;
        $this->template->gallery = $this->caravanImage->images();
        $this->template->equipments = $this->caravan->caravanEquipment(Model\Language::convertToInt($this->locale))->getCaravanEquipment();
        $section = $this->session->getSection("caravanEquipment");
        if (!isset($section->equipment[$this->idCaravan]))
            $section->equipment[$this->idCaravan] = array();
        $this->template->addedEquipments = $section->equipment[$this->idCaravan];
        $this->template->captcha = $this->captcha->createImage()->save();
    }

    public function createComponentSendEmail() {
        $form = new \Nette\Application\UI\Form();
        $form->setTranslator($this->translator);
        $form->addHidden("id_karavan", $this->idCaravan);
        $form->addText("email")
                ->setType('email')
                ->addRule(\Nette\Application\UI\Form::EMAIL, "messages.caravan.right.form.emailError")
                ->setAttribute("placeholder", "messages.caravan.right.form.email")
                ->setAttribute("style", "text-align:center; width: 130px;font-size: 13px");
        $form->addText("captcha")
                ->setType('text')
                ->setAttribute("placeholder", "messages.caravan.right.form.captcha")
                ->setAttribute("style", "text-align:center; width: 146px;font-size: 13px;background-color:#fff;border-radius: 5px; height: 30px; border: 1px solid #BDB8B0");

        $form->addSubmit("odeslat", "messages.caravan.right.form.button");
        $form->onSuccess[] = $this->sendEmailFormSucceeded;

        return $form;
    }

    public function sendEmailFormSucceeded($form, $values) {
        $section = $this->session->getSection("caravanEquipment");
        try {
            $this->captcha->match($values->captcha);
            $this->caravan->sendToEmail($values->id_karavan, $values->email, Model\Language::convertToInt($this->locale), $section->equipment[$values->id_karavan]);
            $this->flashMessage($this->translator->translate("messages.caravan.right.form.sendEmail"), \FlashMessageTypes::OK);
            $this->redirect("this");
        } catch (Nette\InvalidArgumentException $e) {
            $this->flashMessage($e->getMessage(), \FlashMessageTypes::ERROR);
            $this->redirect("this");
        } catch (Model\CaptchaException $e) {
            $this->flashMessage($this->translator->translate("messages.caravan.right.form.captchaError"), \FlashMessageTypes::ERROR);
            $this->redirect("this");
        }
    }

    public function handleCalculate($idCaravan, $id_equip, $name, $price) {
        $section = $this->session->getSection("caravanEquipment");
        if (!isset($section->equipment[$idCaravan]))
            $section->equipment[$idCaravan] = array();
        if (!key_exists($id_equip, $section->equipment[$idCaravan]))
            $section->equipment[$idCaravan][$id_equip] = array($name, $price);
        $this->template->addedEquipments = $section->equipment[$idCaravan];

        $this->redrawControl("cart");
    }

    public function handleRemoveEquip($idCaravan, $id_equip) {
        $section = $this->session->getSection("caravanEquipment");
        unset($section->equipment[$idCaravan][$id_equip]);
        $this->redirect("this");
    }

}
