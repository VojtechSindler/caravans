<?php

namespace Caravans\BackendModule\Controls;

use \Nette\Application\UI;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class ImageEditableViewerControl extends UI\Control{
        
    /**
     * @var \Caravans\Model\AlbumManager
     */
    private $manager;
    
    /**
     * @param array $albums
     * @param \Caravans\Model\AlbumManager $albumManager
     */
    public function __construct(\Caravans\Model\AlbumManager $albumManager){
        $this->manager = $albumManager;
    }
    
    public function render(){
        $this->template->setFile(__DIR__."/default.latte");
        $this->template->albums = $this->manager->getByLang(\Caravans\Model\Language::CS);
        $this->template->galleryPath = galleryPath2;
        $this->template->render();
    }
    
    public function handleDelete($id, $lang, $imageName){
        $this->manager->deletePicture($id, $imageName);
        $this->flashMessage("Obrázek byl odstraněn", \FlashMessageTypes::OK);
        $this->redirect("this");
    }
    
    public function handleDeleteMainImage($id, $lang, $imageName){
        $this->manager->deleteMainImage($id, $imageName);
        $this->flashMessage("Obrázek byl odstraněn", \FlashMessageTypes::OK);
        $this->redirect("this");
    }
}
