<?php
namespace Caravans\Model;

use Nette\Database;

/**
 * @author Vladimír Antoš
 * @package caravans_model
 * @version 1.0
 */
class CaravanEquipmentManager extends ModelContainer{   
    
    /**
     * @var int
     */
    private $idCaravan;
    
    /**
     * @param \Nette\Database\Context $db
     * @param int $idCaravan
     */
    public function __construct(Database\Context $db, $idCaravan) {
        parent::__construct($db);
        $this->idCaravan = $idCaravan;
    }
    
    /**
     * @param string $name
     * @param int $price
     * @param string $info
     * @throws \Nette\InvalidArgumentException
     */
    public function save($name, $price, $info = null){
        if($this->exists($name, $price))
                throw new \Nette\InvalidArgumentException("Výbava ".$name." existuje. "
                        . "Můžeš jí ve formuláři níže přiřadit karavanu.");
        $this->database->table("vybava_specialni")->insert(array(
            "nazev" => $name,
            "cena" => $price,
            "popis" => $info
        ));
        $id = $this->database->table("vybava_specialni")->select("id_vybava")
                ->where("nazev", $name)
                ->where("cena", $price)->fetch()->id_vybava;
        $this->assignEquip($id);
    }
    
    public function assignEquip($idEquip){
        $this->database->table("karavany_vybava")->insert(array(
            "id_karavan" => $this->idCaravan,
            "id_vybava" => $idEquip
        ));
    }
    
    public function exists($name, $price){
        return $this->database->table("vybava_specialni")->where("nazev", $name)
                ->where("cena", $price)->count() > 0;
    }
    
    public function getEquipments(){
        return $this->database->query("SELECT vs.`id_vybava`, `id_karavan`,`nazev`, 
            `cena`, `popis` FROM `vybava_specialni` AS vs 
                    LEFT JOIN karavany_vybava AS kv 
                    ON vs.id_vybava=kv.id_vybava 
                    WHERE kv.id_vybava IS NULL")->fetchAll();
    }
}
