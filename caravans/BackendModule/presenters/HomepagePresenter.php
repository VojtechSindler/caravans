<?php

namespace Caravans\BackendModule\Presenters;

/**
 * 
 * @author Vladimír Antoš
 * @package caravans_backend
 */
class HomepagePresenter extends \BackendPresenter{
    
    public function startup() {
        parent::startup();
    }
    
    public function renderDefault(){
        $this->title = "Domovská stránka administrace";
        $this->sidebar("pokus", "Statistiky");
    }
}
