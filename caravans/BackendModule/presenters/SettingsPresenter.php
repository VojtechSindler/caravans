<?php

namespace Caravans\BackendModule\Presenters;

use Caravans\BackendModule,
    \Caravans\Model;
use \Nette\Application\UI;
/**
 * Presenter pro nastavení systému a vytváření kategorií galerie karavanu.
 * @author Vladimír Antoš
 * @package caravans_backend
 */
class SettingsPresenter extends \BackendPresenter {

   
    /** @var \Caravans\Model\CategoryManager @inject */
    public $categoryManager;

    /**
     * @var Model\MoneyManager @inject
     */
    public $moneyManager;
    
    public function startup() {
        parent::startup();
    }

    public function renderDefault() {
        $this->navigation("Nastavení galerie");
        $this->title = "Nastavení galerie";
    }

    protected function createComponentCategoryGallery() {
        $category = new BackendModule\Controls\CategoryGalleryControl($this->categoryManager, $this->request);
        return $category;
    }

    protected function createComponentCurrencyRateForm(){
        $form = new UI\Form;
        
        return $form;
    }
    
    protected function createComponentMoneyControl() {
        $tax = new BackendModule\Controls\MoneyControl($this->moneyManager);
        
        return $tax;
    }
}
