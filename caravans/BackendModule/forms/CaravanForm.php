<?php

namespace Caravans\BackendModule\Forms;
use Nette\Application\UI;
/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class CaravanForm extends \Nette\Object{
    
    /**
     * @param string $submitLabel
     * @return \Nette\Application\UI\Form
     */
    public function create($submitLabel="Vytvořit"){
         $form = new UI\Form;

        $form->addText("znacka", "Značka*")
                ->setAttribute("maxlength", 30)
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 30);

        $form->addText("typ", "Typ*")
                ->setAttribute("maxlength", 50)
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 50);

        $form->addText("cena", "Cena*")
                ->setType("number")
                ->setAttribute("min", caravanCostMin)
                ->setAttribute("max", caravanCostMax)
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota")
                ->addRule(Form::RANGE, 'Rozsah musí být od %d do %d', array(caravanCostMin, caravanCostMax))
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 6);

        $form->addText("exterier", "Exteriér");

        $form->addText("podvozek", "Podvozek*")
                ->setAttribute("maxlength", 30)
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 30);

        $form->addText("podvozek2", "Podvozek 2")
                ->setAttribute("maxlength", 30)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 30);

        $form->addText("pneu", "Pneu")
                ->setAttribute("maxlength", 30)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 30);

        $form->addText("napajeni", "Napájení")
                ->setAttribute("maxlength", 20)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 20);

        $form->addText("barva", "Barva")
                ->setAttribute("maxlength", 50)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 50);

        $form->addTextArea("popis", "Popis");

        $form->addTextArea("vybava", "Výbava*")->setRequired("Nevyplnil jsi pole %label");

        $form->addText("sirka", "Šířka*")
                ->setType("number")
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");


        $form->addText("delka", "Délka*")
                ->setType("number")
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("vyska", "Výška*")
                ->setType("number")
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");


        $form->addText("nastavba_sirka", "Šířka nastavby")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("nastavba_delka", "Délka nastavby")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("nastavba_vyska", "Výška nastavby")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("vyska_vnitrni", "Vnitřní výška")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("luzko_delka", "Délka lůžka")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("luzko_sirka", "Šířka lůžka")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("hmotnost_p", "Největší povolená hmotnost")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 4)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("hmotnost_t", "Největší technicky přípustná hmotnost")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 4)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("hmotnost_max", "Provozní hmotnost")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 4)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");
        
        $form->addTextArea("specialni_edice", "Popis speciální edice");
        
        $form->addHidden("id_karavan");
        $form->addSubmit("odeslat", $submitLabel);
        return $form;
    }
}
