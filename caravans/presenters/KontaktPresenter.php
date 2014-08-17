<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model;

/**
 * Homepage presenter.
 * 
 * @author Bruno Puzják
 * @package caravans_presenters
 */
class KontaktPresenter extends BasePresenter {

    public function startup() {
        parent::startup();
        $this->setLayout("layout");
    }

    public function renderDefault() {
        $this->footerText = "Těšíme se na vaši návštěvu u nás a jsme připraveni "
                . "naslouchat vašim zvláštním přáním a plnit vaše požadavky tak, "
                . "abyste si s našimi minikaravany užili pohodové cestování a tu "
                . "nejkrásnější dovolenou.";
    }

    public function createComponentAddKontaktForm() {
        $form = new \Nette\Application\UI\Form();

        $form->addText('jmeno')
                ->setRequired('Musíte zadat vaše jméno')
                ->setAttribute("style", "border-radius:0px; background-color:white");

        $form->addText('mail')
                ->setRequired("Musíte zadat váš email")
                ->setType('email')
                ->setAttribute("style", "border-radius:0px; background-color:white");
        $form->addTextArea('text')
                ->setRequired("Musíte zadat text")
                ->setAttribute("style", "width:90%;height:100px");

        $form->addSubmit('submit', 'Odeslat');

        $form->onSuccess[] = $this->AddKontaktFormSuccessed;

        return $form;
    }

    public function AddKontaktFormSuccessed($form, $values) {
        $mail = new \Nette\Mail\Message();
        $mail->setFrom($values->mail)
                ->addTo('minikaravany@email.cz')
                ->setSubject("Minikaravany dotaz")
                ->setBody($values->text . ' ' . $values->jmeno);

        $send = new \Nette\Mail\SendmailMailer();
        $send->send($mail);
        $this->flashMessage("Email nám byl odeslán, hned jak to bude možné vám odpovíme. Děkujeme za váš zájem.");
        $this->redirect("this");
    }

}
