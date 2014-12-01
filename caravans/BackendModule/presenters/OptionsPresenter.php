<?php

namespace Caravans\BackendModule\Presenters;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class OptionsPresenter extends \BackendPresenter{
   
     public function startup() {
         parent::startup();
         $this->title = "Nastavení";
     }
    
     protected function createComponentChangePassword() {
        $form = new \Nette\Application\UI\Form();
        $form->addPassword("heslo", "Heslo")->setRequired("Nezadal jsi heslo");
        $form->addPassword("heslo2", "Heslo znovu")->setRequired("Nezadal jsi znovu heslo")
                ->addRule(\Nette\Application\UI\Form::EQUAL, 'Hesla se neshodují', $form['heslo']);
        $form->onSuccess[] = $this->changePasswordSucceeded;
        $form->addSubmit("send", "Uložit");
        return $form;
    }

    public function changePasswordSucceeded($form, $values) {
        try{
            var_dump($values->heslo != $values->heslo2);
        if($values->heslo != $values->heslo2){
            $this->flashMessage ("Hesla se neshodují");
      //  $this->redirect("this");
        }//$2y$10$Yx61eEiMWb7emjgpK7fVqOCbMFVJtGGOewDmFmUS3/xomcpm1LuMy
        $this->database->table("uzivatele")
                ->where("id", $this->user->identity->id)
                ->update(array("heslo" => \Nette\Security\Passwords::hash($values->heslo)));
        $this->flashMessage("Heslo bylo změněno");
        $this->redirect("this");
        }catch(\Nette\InvalidArgumentException $e){
            $form->addError($e->getMessage());
            $this->redirect("this");
        }
    }
}
