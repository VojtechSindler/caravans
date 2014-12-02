<?php

namespace Caravans\BackendModule\Presenters;

use Nette,
    App\Model;

/**
 * Přihlašovací/odhlašovací presenter.
 * 
 * @author Vladimír Antoš
 * @package caravans_backend
 */
class SignPresenter extends \Caravans\Presenters\BasePresenter {

    public function startup(){
        parent::startup();
        $this->setLayout("loginlayout");
        $this->setTitle("Přihlášení");
    }
    
    public function renderIn(){
        $this->template->identity = $this->getUser()->identity;
    }
    
    /**
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = new Nette\Application\UI\Form;
        $form->addText('email', 'Email')
                ->setRequired('Nevyplnil jsi email');

        $form->addPassword('heslo', 'Heslo')
                ->setRequired('Nevyplnil jsi heslo.');
        $form->addSubmit('odeslat', 'Přihlásit se');
        
        $form->onSuccess[] = $this->signInFormSucceeded;
        return $form;
    }

    public function signInFormSucceeded($form, $values) {
        try {
            $this->getUser()->login($values->email, $values->heslo);
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    public function actionOut() {
        $this->getUser()->logout(true);
        $this->flashMessage('Odhlášení proběhlo úspěšně.');
        $this->redirect('in');
    }

}
