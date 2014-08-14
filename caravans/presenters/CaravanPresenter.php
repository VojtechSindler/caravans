<?php
namespace Caravans\Presenters;
use Nette,
    Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class CaravanPresenter extends BasePresenter{
    
    /**
     *
     * @var Model\CaravanManager @inject
     */
    public $caravan;
    
    public function renderShowAll(){
        $this->template->columns = 3;
        $caravans = $this->caravan->readCaravans();
        $caravans[0]["hlavni_obrazek"] = caravanGalleryPath.$caravans[0]["hlavni_obrazek"];
        $this->template->caravans = $caravans;
        $this->template->footerText = "Nabídka minikaravanů";
    }
}