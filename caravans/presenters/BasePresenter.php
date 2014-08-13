<?php

namespace Caravans\Presenters;

use Nette,
	Caravans\Model;


/**
 * Společný předek všech presenterů v aplikaci.
 * 
 * @author Vladimír Antoš
 * @package caravans_presenters
 * @abstract
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function startup() {
        parent::startup();
        $this->template->website = website;
        $this->template->navigation = array();
        
    }
    public function setTitle($title){
        $this->template->title = $title;
    }
    
    /**
     * Nastavuje nadpis sidebaru.
     * @param string $title
     */
    public function sidebar($file, $title){
        $this->template->scontent = $file;
        $this->template->stitle = $title;
    }
    
    /**
     * Nastavuje data pro navigační panel.
     * @params string ...
     */
    public function navigation(){
        $this->template->navigation = func_get_args();
    }
}