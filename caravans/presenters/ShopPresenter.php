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
class ShopPresenter extends BasePresenter {

    public function startup() {
        parent::startup();
        $this->setLayout("layout");
    }
    
    public function renderDefault() {
        $this->footerText = "Těšíme se na vaši návštěvu u nás a jsme připraveni "
                . "naslouchat vašim zvláštním přáním a plnit vaše požadavky tak, "
                . "abyste si s našimi minikaravany užili pohodové cestování a tu "
                . "nejkrásnější dovolenou.";
    }

}
