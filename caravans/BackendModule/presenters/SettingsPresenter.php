<?php

namespace Caravans\BackendModule\Presenters;

use Caravans\BackendModule;

/**
 * Presenter pro nastavení systému a přidávání kategorií galerie.
 * 
 * @author Vladimír Antoš
 * @package caravans_backend
 */
class SettingsPresenter extends \BackendPresenter {

    /** @var \Caravans\Model\CategoryManager @inject */
    public $categoryManager;

    public function startup() {
        parent::startup();
    }

    public function renderDefault() {
        $this->title = "Nastavení systému";
    }

    protected function createComponentCategoryGallery() {
        $category = new BackendModule\Controls\CategoryGalleryControl($this->categoryManager, $this->request);

        return $category;
    }

}
