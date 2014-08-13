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
        $caravans = $this->caravan->readCaravans();
        $this->template->caravans = array_map($caravans[""], $array1);
    }
}