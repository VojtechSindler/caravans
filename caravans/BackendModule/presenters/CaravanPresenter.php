<?php

namespace Caravans\BackendModule\Presenters;

use Nette\Application\UI\Form;
use \Caravans\BackendModule;
use \Caravans\Model;
/**
 * @author Vladimír Antoš
 * @package caravan_backend
 */
class CaravanPresenter extends \BackendPresenter {

    /**
     * @var \Caravans\Model\CaravanManager @inject
     */
    public $caravan;

    /**
     * @var \Caravans\Model\CaravanImage @inject
     */
    public $caravanImage;

    /**
     * @var \Caravans\Model\CategoryManager @inject
     */
    public $category;
    private $idCaravan;
    private $copy = false;
    public function startup() {
        parent::startup();
        $this->template->maxImageSize = maxImageSize;
        if (isset($this->params["idCaravan"])) {
            $this->idCaravan = $this->params["idCaravan"];
            $this->caravan->id = $this->idCaravan;
        }
    }

    public function renderAdd() {
        $this->navigation("Karavany", "Vytvořit karavan");
        $this->isEdit = false;
        $this->title = "Vytvořit karavan";
        $this->sidebar("listOfCaravans", "Seznam karavanů");
    }

    public function renderShow() {
        $this->navigation("Karavany", "Výpis karavanů");
        $this->title = "Seznam karavanů";
        $this->template->caravans = $this->caravan->readCaravans();
    }

    public function renderEdit($idCaravan, $language) {
        bdump($language);
        $this->navigation("Karavany", "Editace karavanu");
        $this->isEdit = true;
        $this->idCaravan = $idCaravan;
        $this->template->idCaravan = $idCaravan;
        $this->template->language = $language;
        $caravan = $this->caravan->getCaravan($idCaravan, $language);
        $this->title = "Úprava karavanu " . $caravan->znacka . " " . $caravan->typ;
        $this["addCaravanForm"]->setDefaults($caravan);
        $this->sidebar("editCaravanMenu", "Menu");
    }

//    public function renderCopy($idCaravan){
//        $this->navigation("Karavan", "Kopírovat karavan");
//        $this->title = "Kopírovat karavan";
//        $this->idCaravan = $idCaravan;
//        $this->template->idCaravan = $idCaravan;
//        $caravan = $this->caravan->getCaravan($idCaravan);
//        $this->title = "Vytvořit kopii " . $caravan->znacka . " " . $caravan->typ;
//        $this["addCaravanForm"]->setDefaults($caravan);
//        $this->sidebar("editCaravanMenu", "Menu");
//    }
    
    public function renderEquipment($idCaravan, $language) {
        $this->navigation("Karavany", "Editace výbavy karavanu");
        $this->idCaravan = $idCaravan;
        $caravan = $this->caravan->getCaravan($idCaravan, $language);
        $this->title = "Přidat výbavu pro karavan " . $caravan->znacka
                . " " . $caravan->typ . " (s číslem " . $caravan->id_karavan . ")";
        $this["addEquipmentForm"]->setDefaults(array("jazyk" => $language));
        $this->template->language = $language;
        $this->template->equipments = $this->caravan->caravanEquipment($caravan->jazyk)->getCaravanEquipment();
    }
    
    protected function createComponentAddCaravanForm() {    
        $caravans = $this->caravan->readCaravans();
        $data = array();
        foreach($caravans as $caravan){
            $data[$caravan->id_karavan] = $caravan->id_karavan.": ".$caravan->znacka." ".$caravan->typ;
        }
        $form = new Form();
        
        $form->addSelect("id_zaklad", "Základní verze", $data)->setPrompt('');
        $form->addSelect("jazyk", "Jazyk", array(
            Model\Language::CS => "čeština", 
            Model\Language::DE => "němčina", 
            Model\Language::EN => "angličtina"));
        $form->addSelect("id_origin", "Překládáš karavan", $data)->setPrompt('');
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
                ->addRule(Form::FLOAT, "%label musí být číselná hodnota")
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

        $form->addText("eshop_link", "Odkaz na eshop");
        
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

        $form->addText("nastavba_delka", "Délka bez oje")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("vyska_vnitrni", "Vnitřní výška")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 3)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("sirka_vnitrni", "Vnitřní šířka")
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

        $form->addText("hmotnost_t", "Největší technicky přípustná hmotnost")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 4)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addText("hmotnost_p", "Pohotovostní hmotnost")
                ->setType("number")
                ->addCondition(Form::FILLED)
                ->addRule(Form::MAX_LENGTH, "%label může mít maximálně %d znaků", 4)
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");

        $form->addTextArea("specialni_edice", "Popis speciální edice");
        
        $form->addHidden("id_karavan");
        $form->addSubmit("odeslat", ($this->isEdit ? "Upravit" : "Vytvořit"));
        $form->onSuccess[] = $this->addCaravanFormSucceeded;
        return $form;
    }

//    public function copyCaravan($form, $values){
//       try{
//           $values["id_zaklad"] = $this->idCaravan;
//           $this->caravan->save($values);
////           $this->flashMessage("Karavan byl zkopírován");
////           $this->redirect("this");
//       } catch (Exception $ex) {
//            $this->flashMessage($ex->getMessage());
//            $this->redirect("this");
//       }
//    }
    
    public function addCaravanFormSucceeded($form, $values){
         try {
            if (empty($values->id_karavan)) { //vytvoření karavanu
                $data = clone $values;
                $post = $values->remove("mainImage")->remove("images")->remove("kategorie"); //odstranění obrázků
                $this->caravan->save($post);

//                $this->caravanImage->setIdCaravan($this->caravan->getId()); //ID karavanu kterému patří obrázky
//                //Zpracování hlavního obrázku
//                if ($data->mainImage->isOk())
//                    $this->caravanImage->addMainImage($data->mainImage);
//
//                //Zpracování dalších obrázků
//                $this->caravanImage->addImages($data->images, $data->kategorie);
                $this->flashMessage("Karavan byl úspěšně vytvořen", \FlashMessageTypes::OK);
                $this->redirect("this");
            }else{
                //editace
                $values->remove("id_origin");
                $values->remove("mainImage")->remove("images")->remove("kategorie");
                $this->caravan->edit($values->id_karavan, $values->remove("id_karavan"));
                $this->flashMessage("Karavan byl úspěšně editován", \FlashMessageTypes::OK);
                $this->redirect("this");
            }
        } catch (Exception $ex) {
            $form->addError($ex->getMessage());
        }
    }

    protected function createComponentAddEquipmentForm() {
        $form = new Form();
        $form->addText("nazev", "Název*")->setRequired("Nevyplnil jsi pole %label");
        $form->addSelect("jazyk", "Jazyk", array(
            Model\Language::CS => "čeština", 
            Model\Language::DE => "němčina", 
            Model\Language::EN => "angličtina"));
        $form->addText("cena", "Cena*")
                ->setType("number")
                ->setRequired("Nevyplnil jsi pole %label")
                ->addRule(Form::NUMERIC, "%label musí být číselná hodnota");
        $form->addTextArea("popis", "Popis");
        $form->onSuccess[] = $this->addEquipmentFormSucceeded;
        $form->addSubmit("odeslat", "Uložit");
        return $form;
    }

    public function addEquipmentFormSucceeded($form, $values) {
        try {
            $this->caravan->caravanEquipment($values->jazyk)->save($values->nazev, $values->cena, $values->popis, $values->jazyk);
            $this->redirect("this");
        } catch (\Nette\InvalidArgumentException $ex) {
            $form->addError($ex->getMessage());
        }
    }

    protected function createComponentGalleryManager() {
        if ($this->idCaravan == null)
            $this->idCaravan = $this->params["idCaravan"];
        $gm = new BackendModule\Controls\GalleryManagerControl($this->category, $this->caravanImage, $this->idCaravan, $this->params["language"]);
        return $gm;
    }

    public function handleDelete($idCaravan, $language) {
        $this->caravanImage->setIdCaravan($idCaravan);
        $this->caravanImage->setLanguage($language);
        $this->caravanImage->deleteMainImage()->deleteAllImages();
        $this->caravan->delete($idCaravan, $language);
        $this->flashMessage("Karavan byl úspěšně odstraněn", \FlashMessageTypes::OK);
        $this->redirect("this");
    }

    public function handleDeleteEquipment($id, $language) {
        $this->caravan->caravanEquipment($language)->delete($id);
    }

//    public function actionCopy($idCaravan){
//        $this->copy = true;
//    }
}