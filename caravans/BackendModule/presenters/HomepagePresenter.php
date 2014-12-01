<?php

namespace Caravans\BackendModule\Presenters;

/**
 * 
 * @author Vladimír Antoš
 * @package caravans_backend
 */
class HomepagePresenter extends \BackendPresenter{
    
    /**
     * @var \Caravans\Model\StatisticsManager @inject
     */
    public $statistics;
    
    public function startup() {
        parent::startup();
    }
    
    public function renderDefault(){
        $this->title = "Domovská stránka administrace";
        $this->template->statistics = $this->statistics->countColumns();
        $this->template->size = $this->statistics->size();
        $this->template->lastArticle = $this->statistics->lastInsertArticle();
        $this->template->lastCaravan = $this->statistics->lastInsertCaravan();
        $this->template->gallerySize = $this->statistics->gallerySize();
        $this->sidebar("statistics", "Statistiky");
    }
    
    public function renderVersions(){
        $this->title = "Aktualizace systému";
        $this->template->name = \Caravans\Model\System::NAME;
        $this->template->version = \Caravans\Model\System::VERSION;
        $this->template->version_id = \Caravans\Model\System::VERSION_ID;
        $this->template->date = \Caravans\Model\System::REVISION;
    }
}
