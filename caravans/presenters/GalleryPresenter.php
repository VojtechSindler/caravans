<?php

namespace Caravans\Presenters;
use Nette,
    Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class GalleryPresenter extends BasePresenter {
    
    /**
     * @var Model\AlbumManager @inject
     */
    public $album;
    
    public function startup() {
        parent::startup();
        $this->template->galleryPath = galleryPath2;
    }
    
    public function renderShowAll(){
        $this->template->albums = $this->album->getByLang(Model\Language::convertToInt($this->locale));
    }
    
    public function renderView($id, $name){
        $this->template->album = $this->album->getAlbum($id, Model\Language::convertToInt($this->locale));
        $this->template->pattern = Model\AlbumManager::SMALL; //velikost náhledového obrázku
    }
}