<?php

namespace Caravans\BackendModule\Presenters;

use Nette\Application\UI\Form;
use \Caravans\BackendModule;
use Caravans\Model;

/**
 * Description of ArticlePresenter
 * Umožňuje vytvářet, zobrazovat a editovat články.
 * Používá ArticlePreviewControl pro tabulkový a náhledový soupis článků.
 * 
 * @author Bruno Puzják
 */
class ArticlePresenter extends \BackendPresenter {

    /** @var \Caravans\Model\ArticleManager @inject * */
    public $articleManager;
    public $id;
    public $jazyk;

    public function startup() {
        parent::startup();
        $this->title = "Seznam článků";
        $this->navigation("Články", "Seznam článků");
        $this->sidebar("articleViewSettings", "Změna zobrazení");
        $this->articleManager->setUserId($this->getUser()->identity->getId());
    }

    public function renderEdit($id,$jazyk) {
        $this->navigation("Články", "Upravit článek");
        $this->id = $id;
        $this->jazyk = $jazyk;
        $this->title = "Upravit článek";
        $this->template->articles = $this->articleManager->getAllAdmin();
        $this->sidebar("listOfArticles", "Seznam Článků");
    }

    public function renderAdd() {
        $this->navigation("Články", "Vytvořit článek");
        $this->title = "Vytvořit článek";
        $this->template->articles = $this->articleManager->getAllAdmin();
        $this->sidebar("listOfArticles", "Seznam Článků");
    }

    public function renderView($id, $jazyk) {
        $this->navigation("Články", "Zobrazení článku");
        $this->id = $id;
        $this->title = "Článek $id";
        $this->template->articles = $this->articleManager->getAllAdmin();
        $this->sidebar("listOfArticles", "Seznam Článků");
        $article = $this->articleManager->getAll($this->id, $jazyk);
        $this->template->article = $article[0];
    }

    /**
     * vytváří formulář pro přidání článků
     * 
     * @return \Nette\Application\UI\Form  
     */
    protected function createComponentAddArticleForm() {
        $form = new Form();
        $form->addText("nadpis", "Nadpis*")
                ->setRequired("Nevyplnil jsi pole %label");

        $form->addText("perex", "Perex");

        $form->addSelect("kategorie", "Kategorie", 
                array(Model\IArticleCategory::ARTICLE => "Článek", 
                    Model\IArticleCategory::EXHIBITON => "Výstava"));
        
        $form->addTextArea("text", "Text*")
                ->setRequired("Nevyplnil jsi pole %label");


        $form->addCheckbox('novinka', 'Novinka');
        $language = new Model\Language;
        $items=array($language::CS=>"Český", $language::EN=>"Anglický", $language::DE=>"Německý");
        
        $form->addSelect("jazyk","Jazyk", $items);

        $data=$this->articleManager->getAllAdmin();
        foreach ($data as $key => $value) {
            $IDs[$value->id_clanek]=$value->nadpis;
        }
        $form->addSelect("id_origin", "Překládáš článek", $IDs)->setPrompt(null);
        
        $form->addSubmit("odeslat", "Vytvořit");
        $form->onSuccess[] = $this->addArticleFormSucceeded;

        return $form;
    }

    /**
     * Zpracování formuláře pro přidání článku. 
     * Pokud nebyl vložen perex, volá metodu $this->articleManager->createPerex($text)
     * 
     * @param type $form
     * @param type $values
     */
    public function addArticleFormSucceeded($form, $values) {
        try {
//            if ($values->perex == null) {
//                $values->perex = $this->articleManager->createPerex($values->text);
//            }
            $this->articleManager->save($values);

            $this->flashMessage("Článek byl úspěšně vytvořen", \FlashMessageTypes::OK);
            $this->redirect("default");
        } catch (Exception $ex) {
            $form->addError($ex->getMessage());
        }
    }

    /**
     * Vytváří formulář pro editaci článku.
     * 
     * @return \Nette\Application\UI\Form
     */
    protected function createComponentAddEditForm() {
        if(is_null($this->jazyk)){
            $article = $this->articleManager->getAllAdmin();
        }else{
            $article = $this->articleManager->getAll($this->id,$this->jazyk);
        }
        
        $article = $article[0];
        $form = new Form();
        $form->addHidden("id_clanek")->setDefaultValue($article["id_clanek"]);
        $form->addText("nadpis", "Nadpis*")
                        ->setRequired("Nevyplnil jsi pole %label")
                ->defaultValue = $article['nadpis'];

        $form->addText("perex", "Perex")
                ->defaultValue = $article['perex'];

        $form->addSelect("kategorie", "Kategorie", 
                array(Model\IArticleCategory::ARTICLE => "Článek", 
                    Model\IArticleCategory::EXHIBITON => "Výstava"))->defaultValue = $article["kategorie"];
        
        $form->addTextArea("text", "Text*")
                        ->setRequired("Nevyplnil jsi pole %label")
                ->defaultValue = $article['text'];



        $form->addCheckbox('novinka', 'Novinka');
        $language = new Model\Language;
        $items=array($language::CS=>"Český", $language::EN=>"Anglický", $language::DE=>"Německý");
        $form->addSelect("jazyk","Jazyk", $items)->setDefaultValue($article["jazyk"]);


        $form->addSubmit("odeslat", "Editovat");
        $form->onSuccess[] = $this->addEditFormSucceeded;

        return $form;
    }

    /**
     * Zpracování formuláře pro editaci článku.
     * Pokud nebyl vložen perex, volá metodu $this->articleManager->createPerex($text)
     * 
     * @param type $form
     * @param type $values
     */
    public function addEditFormSucceeded($form, $values) {
        try {
//            if ($values->perex == null) {
//                $values->perex = $this->articleManager->createPerex($values->text);
//            }
            $this->articleManager->edit($values);

            $this->flashMessage("Článek byl úspěšně editován", \FlashMessageTypes::OK);
            $this->redirect("default");
        } catch (Exception $ex) {
            $form->addError($ex->getMessage());
        }
    }

    /**
     * Metoda pro vytvoření komponenty ArticlePreviewControl
     * 
     * @return \Caravans\BackendModule\Controls\ArticlePreviewControl
     */
    protected function createComponentArticlePreview() {
        $articlePreview = new BackendModule\Controls\ArticlePreviewControl($this->articleManager, $this->request);
        return $articlePreview;
    }

    protected function createComponentAddViewSettings() {
        $form = new Form();
        $form->addSelect("view", "Zobrazení", array("Tabulkové","Náhledové"))
                ->setAttribute("onchange", "this.form.submit();");
        return $form;
    }

}
