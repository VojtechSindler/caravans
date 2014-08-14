<?php
namespace Caravans\Model;

/**
 * Třída pro práci s karavany.
 * 
 * @author Vladimír Antoš
 * @package caravans
 */
class CaravanManager extends \Caravans\Model\ModelContainer{
    
    private $id = null;
    
    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }
    
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    
    public function getId(){
        if($this->id == null)
            throw new \Nette\InvalidStateException;
        return $this->id;
    }
    
    /**
     * @return \Caravans\Model\CaravanEquipmentManager
     */
    public function caravanEquipment(){
        return new CaravanEquipmentManager($this->database, $this->id);
    }
    
    /**
     * @return \Caravans\Model\CurrentCaravan
     */
    public function currentCaravan(){
        return new CurrentCaravan($this->database);
    }
    
    /**
     * @param \Nette\Utils\ArrayHash $data
     * @return bool
     */
    public function save(\Nette\Utils\ArrayHash $data){
        $data->id_karavan = $this->createId();
        return $this->database->table("karavany")->insert($data);
    }
    
    public function edit($id, $data){
        return $this->database->table("karavany")->where("id_karavan", $id)->update($data);
    }
    
    public function delete($id){
        return $this->database->table("karavany")->where("id_karavan", $id)->delete() > 0;
    }
    
    public function getGallery(){
        return new CaravanImage();
    }
    
    public function getCaravan($id){
        return $this->database->table("karavany")->select("*")->where("id_karavan", $id)->fetch();
    }
    
    /**
     * Vrací seznam všech karavanů včetně hlavních obrázků.
     * @return array<ActiveRow>
     */
    public function readCaravans(){
        return $this->database->query("
            SELECT k.`id_karavan`, `znacka`, `typ`, `cena`, `sirka`, 
            `delka`, `vyska`, `nastavba_sirka`,`nastavba_delka`,`nastavba_vyska`,
            `vyska_vnitrni`,`luzko_delka`,`luzko_sirka`,`hmotnost_p`,
            `hmotnost_pb`,`hmotnost_c`,`hmotnost_t`,`hmotnost_max`,`podvozek`,
            `exterier`,`podvozek2`,`pneu`,`napajeni`,`datum_vlozeni`,`vybava`,
            `popis`,`specialni_edice`,`barva`, g.`nazev` as `hlavni_obrazek`
            FROM `karavany` as k
            LEFT JOIN `hlavni_obrazky_karavany` as hok ON  hok.`id_karavan` = k.`id_karavan`
            LEFT JOIN `galerie` as g ON g.`id_foto` = hok.`id_foto`")->fetchAll();
    }
    
    /**
     * Generuje náhodné unikátní ID karavanu a kontroluje v databázi jestli neexistuje.
     * @return int
     */
    private function createId(){
        $id = null;
        do{
            $id = $this->randNumber(caravanIdLength);
        }while($this->database->table("karavany")->where("id_karavan", $id)->count() == 1);
        return $this->id = (int)$id;
    }
}
