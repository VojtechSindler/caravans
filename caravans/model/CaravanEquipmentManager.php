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
    
    private $lang;
    
    /**
     * @param \Nette\Database\Context $db
     * @param int $idCaravan
     */
    public function __construct(Database\Context $db, $idCaravan, $lang) {
        parent::__construct($db);
        $this->idCaravan = $idCaravan;
        $this->lang = $lang;
    }
    
    /**
     * @param string $name
     * @param int $price
     * @param string $info
     * @throws \Nette\InvalidArgumentException
     */
    public function save($name, $price, $info = null){
        $this->database->table("vybava_specialni")->insert(array(
            "nazev" => $name,
            "cena" => $price,
            "popis" => $info
        ));
        $id = $this->database->table("vybava_specialni")->select("id_vybava")
                ->where("nazev", $name)
                ->where("cena", $price)->fetch()->id_vybava;

        $this->database->table("karavany_vybava")->insert(array(
            "id_karavan" => $this->idCaravan,
            "id_vybava" => $id,
            "jazyk" => $this->lang
        ));
    }
    
    /**
     * Vrací výbavu karavanu.
     */
    public function getCaravanEquipment(){
        return $this->database->query("SELECT `id_vybava`, `nazev`, `cena`, `popis` 
            FROM `vybava_specialni`
        JOIN `karavany_vybava` USING(`id_vybava`) WHERE `id_karavan`=? AND `jazyk`=?",$this->idCaravan, $this->lang)->fetchAll();
    }
    
    public function delete($id){
        $this->database->table("vybava_specialni")
                ->where(array("id_vybava"=> $id))->delete();
        return $this->database->table("karavany_vybava")->where(array("id_vybava"=>$id,"jazyk"=>$this->lang))->delete();
    }
}
