<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Základní presenter administrace. Dědí od něj všechny odstatní. Má za úkol ověřovat přihlašování.
 * @author Vladimír Antoš
 * @package caravan_backend
 */
class BackendPresenter extends Caravans\Presenters\BasePresenter{
    
    /**
     * Pro rozlišení jestli se jedná o přidávací nebo editační formulář.
     * @var bool
     */
    protected $isEdit = false;
    
    public function startup() {
        parent::startup();
        if(!$this->getUser()->isLoggedIn())
            $this->redirect("Sign:in");
        $this->template->userName = $this->getUser()->identity->jmeno." ".$this->getUser()->identity->prijmeni;
    }
}
