<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model;

/**
 * Homepage presenter.
 * 
 * @author Bruno Puzják
 * @package caravans_presenters
 */
class RecenzePresenter extends BasePresenter {

    public function startup() {
        parent::startup();
        $this->setLayout("layout");
    }
    
    public function renderDefault() {

    }

}
