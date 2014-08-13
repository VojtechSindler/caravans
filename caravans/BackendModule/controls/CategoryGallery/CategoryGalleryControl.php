<?php

namespace Caravans\BackendModule\Controls;

use Nette\Application\UI;

/**
 * Komponenta pro přidávání, výpis a editaci kategorií galerie.
 * @author Vladimír Antoš
 * @package caravans_backend_controls
 */
class CategoryGalleryControl extends UI\Control {

    /** @var \Caravans\Model\CategoryManager */
    private $categoryManager;

    /**
     * @var Nette\Application\Request
     */
    private $request;

    /**
     * @var bool
     */
    private $isEdit;
    
    public function __construct(\Caravans\Model\CategoryManager $cm, \Nette\Application\Request $r) {
        $this->categoryManager = $cm;
        $this->request = $r;
    }

    /**
     * Vytvoří formulář pro přidávání kategorií a zároven vypisuje seznam kategorií s možnostmi editace.
     */
    public function render() {
        $this->template->setFile(__DIR__ . "/category.latte");
        if($this->isEdit)
            $this->template->title2 = "Upravit kategorii galerie";
        else $this->template->title2 = "Vytvořit kategorii galerie";
        $this->template->render();
    }

    public function renderEditableListCategories() {
        $this->template->setFile(__DIR__ . "/category_editablelist.latte");
        $paginator = $this->getComponent("pagingRenderer")->paginator;
        $paginator->ItemCount = $this->categoryManager->count();
        $this->template->categories = $this->categoryManager
                ->pageableReadAll($paginator->length, $paginator->offset);
        $this->template->render();
    }

    public function handleDelete($id) {
        try {
            if ($this->categoryManager->delete($id)) {
                $this->flashMessage("Kategorie byla úspěšně odstraněna");
                $this->redirect("this");
            }
        } catch (Exception $ex) {
            $form->addError($ex->getMessage());
        }
    }

    public function handleEdit($id) {
        $this->isEdit = true;
        $this["addCategoryForm"]->setDefaults($this->categoryManager->get($id));
    }

    protected function createComponentAddCategoryForm() {
        $form = new UI\Form();
        $form->addText("nazev", "Název")->setRequired("Nezadal jsi název kategorie");
        $form->addHidden("id_kategorie");
        $form->addSubmit("send", ($this->isEdit ? "Upravit" : "Vytvořit"));
        $form->onSuccess[] = $this->addCategoryFormSucceeded;
        return $form;
    }

    public function addCategoryFormSucceeded($form, $values) {
        try {
            if (empty($values->id_kategorie)){  //INSERT
                $this->categoryManager->save($values->nazev);
                $this->flashMessage("Kategorie byla úspěšně vytvořena", \FlashMessageTypes::OK);
            }else{ //EDIT
                $this->categoryManager->edit($values->nazev, $values->id_kategorie);
                $this->flashMessage("Kategorie byla úspěšně upravena", \FlashMessageTypes::OK);
            }
            $this->redirect('this');
        } catch (\Caravans\ExistsValueException $ex) {
            $form->addError($ex->getMessage());
        }
    }

    /**
     * Stránkovací komponenta.
     * @return \Caravans\Controls\PagingRendererControl
     */
    protected function createComponentPagingRenderer() {
        $page = !isset($this->request->parameters["pagingRenderer-page"]) ?
                1 : $this->request->parameters["pagingRenderer-page"];
        $paging = new \Caravans\Controls\PagingRendererControl();
        $pad = $paging->getPaginator();
        $pad->setPage($page);
        $pad->setItemsPerPage(categoryItemsPerPage);
        $this->template->ajax = null;
        return $paging;
    }

}
