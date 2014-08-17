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
     *
     * @var Model\CaravanManager @inject
     */
    public $caravan;
    public $idCaravan;

    public function renderShowAll() {
        $caravans = $this->caravan->readCaravans();
//        $caravans[0]["hlavni_obrazek"] = caravanGalleryPath.$caravans[0]["hlavni_obrazek"];
        $this->template->caravans = $caravans;
        $this->template->footerText = "Nabídka minikaravanů";
    }

    public function renderView($id) {
        $this->idCaravan = $id;
        $this->template->caravan = $this->caravan->getCaravan($id);
        $this->template->footerText = 'Karavan';
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
        $this->caravan->sendToEmail($values->id_karavan, $values->email);
        $this->flashMessage("Email byl odeslán", \FlashMessageTypes::OK);
        $this->redirect("this");
    }

}
