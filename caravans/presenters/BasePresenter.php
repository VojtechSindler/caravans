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
        $this->template->footerText = null;
        
    }
    public function setTitle($title){
        $this->template->title = $title;
    }
    
    public function setFooterText($text){
        $this->template->footerText = $text;
    }
}