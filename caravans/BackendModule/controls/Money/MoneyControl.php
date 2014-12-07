<?php

namespace Caravans\BackendModule\Controls;

use Caravans\BackendModule,
    \Caravans\Model;
use \Nette\Application\UI;

/**
 * Komponenta pro správu daní podporovaných států.
 * @author Vladimír Antoš
 * @version 1.0
 */
class MoneyControl extends UI\Control {

    /**
     * @var Model\MoneyManager
     */
    private $money;

    /**
     * @var bool
     */
    private $isEdit = false;
    
    public function __construct(Model\MoneyManager $m) {
        $this->money = $m;
    }
    
    public function render() {
        $this->template->setFile(__DIR__ . "/form.latte");
        $this->template->formTitle = "Správce daní";
        $this->template->render();
    }
    
    public function renderTable(){
        $this->template->setFile(__DIR__."/table.latte");
        $this->template->data = $this->money->getAll();
        $this->template->render();
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    protected function createComponentTaxForm(){
        $form = new UI\Form;
        $form->addSelect("id_jazyk", "Stát: ", array(
            Model\Language::CS => "Česká republika", 
            Model\Language::DE => "Německo"))
                ->setRequired("Nevyplnil jsi stát");
        $form->addText("tax_rate", "Daň: ")
                ->addRule(UI\Form::FLOAT, "%label musí být číselná hodnota")
                ->setRequired("Nezadal jsi daň");
        $form->addText("exchange_rate", "Směnný kurz: ")
                ->addRule(UI\Form::FLOAT, "%label musí být číselná hodnota")
                ->setRequired("Nezadal jsi kurz");
        $form->addHidden("edit", $this->isEdit);
        $form->onSuccess[] = $this->taxFormSucceeded;
        $form->addSubmit("send", "Uložit");
        return $form;
    }
    
    public function taxFormSucceeded($form, $values){
        try{
            if($values->edit){
                //editace
                $this->money->edit($values->id_jazyk, $values->tax_rate, $values->exchange_rate);
                $this->flashMessage("Upraveno", \FlashMessageTypes::OK);
            }else{
                $this->money->save($values->id_jazyk, $values->tax_rate, $values->exchange_rate);
                $this->flashMessage("Uloženo", \FlashMessageTypes::OK);
            }
            $this->redirect("this");
        } catch (\Nette\InvalidStateException $ex) {
              $form->addError($ex->getMessage());
        }
    }
    
    public function handleEdit($country){
        $this->isEdit = true;
        $this["taxForm"]->setDefaults($this->money->get($country));
    }
    
    public function handleDelete($country){
        try{
            $this->money->delete($country);
            $this->flashMessage("Odstraněno", \FlashMessageTypes::OK);
            $this->redirect("this");
        } catch (\Nette\InvalidStateException $ex) {
            $this->flashMessage($ex->getMessage());
        }
    }
}
