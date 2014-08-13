<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model;

/**
 * Homepage presenter.
 * 
 * @author Vladimír Antoš
 * @package caravans_presenters
 */
class HomepagePresenter extends BasePresenter {

    public function startup() {
        parent::startup();
        $this->setLayout("layout");
        
    }
    
    public function renderDefault() {
        $this->title = "AHOJ";
    }

}
