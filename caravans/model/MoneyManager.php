<?php

namespace Caravans\Model;

use \Nette;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class MoneyManager extends ModelContainer{
    
    /**
     * @var Nette\Database\Table\ActiveRow
     */
    private $data;

    public function __construct(Nette\Database\Context $db) {
        parent::__construct($db);
    }
    
    public function getTaxRate(){
        if(empty($this->data))
            throw new Nette\InvalidStateException();
        return $this->data->tax_rate;
    }
    
    public function getExchange(){
        if(empty($this->data))
            throw new Nette\InvalidStateException();
        return $this->data->exchange_rate;
    }
    
    public function save($country, $tax_rate, $exchange_rate){
        if($this->exist($country))
            throw new Nette\InvalidStateException("Pro tento stát jsi už vytvořil konfiguraci měn.");
        $this->database->table("nastaveni")->insert(array("id_jazyk" => $country, "tax_rate" => $tax_rate, "exchange_rate" => $exchange_rate));
    }
    
    public function edit($country, $tax_rate, $exchange_rate){
        if(!$this->exist($country))
            throw new Nette\InvalidStateException("Pro zadaný stát neexistuje konfigurace.");
        return $this->database->table("nastaveni")->where("id_jazyk", $country)
                ->update(array("tax_rate" => $tax_rate, "exchange_rate" => $exchange_rate));
    }
    
    public function get($country){
        $this->data = $this->database->table("nastaveni")->select("*")->where("id_jazyk", $country)->fetch();
        return $this->data;
    }
    
    public function getAll(){
        return $this->database->table("nastaveni")->select("*")->fetchAll();
    }
    
    /**
     * @param int $country
     * @return bool
     */
    public function exist($country){
        return $this->database->table("nastaveni")->where("id_jazyk", $country)->count() == 1;
    }
    
    public function delete($country){
        if(!$this->exist($country))
            throw new Nette\InvalidStateException("Nelze odstranit");
        return $this->database->table("nastaveni")->where("id_jazyk", $country)->delete();
    }
}
