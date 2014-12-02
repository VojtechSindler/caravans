<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model,
    Nette\Mail\Message,
    Nette\Mail\SendmailMailer,
    Nette\Latte\Engine;
;

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

    }

    public function createComponentAddKontaktForm() {
        $form = new \Nette\Application\UI\Form();
        $form->setTranslator($this->translator);
        $form->addText('jmeno', 'messages.contactForm.name')
                ->setRequired('Musíte zadat vaše jméno');

        $form->addText('mail', 'messages.contactForm.email')
                ->setRequired("Musíte zadat váš email")
                ->setType('email');
        $form->addTextArea('text', 'messages.contactForm.message')
                ->setRequired("Musíte zadat text");

        $form->addSubmit('submit', 'messages.contactForm.button');

        $form->onSuccess[] = $this->AddKontaktFormSuccessed;

        return $form;
    }

    public function AddKontaktFormSuccessed($form, $values) {
        $mail = new \Nette\Mail\Message();
        $mail->setFrom($values->mail)
                ->addTo(adminEmail)
                ->setSubject("Minikaravany dotaz")
                ->setBody($values->text . ' ' . $values->jmeno);

        $send = new \Nette\Mail\SendmailMailer();
        $send->send($mail);
        $this->flashMessage("Email nám byl odeslán, hned jak to bude možné vám odpovíme. Děkujeme za váš zájem.");
        $this->redirect("this");
    }

}
