<?php

namespace Caravans\Model;

/**
 * Třída nastavuje a vypisuje aktuální nabídky karavanů.
 * @author 
 * @package
 * @version 1.0 
 */
class CurrentCaravan extends CaravanManager {

    /**
     * Možná bude potřeba i ID karavanu, to ted nevím zjistíš při impelemntaci.
     * @param \Nette\Database\Context $db
     */
    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }

    /**
     * Do tabulky aktuální_karavany přidá záznam
     * @param int $idCaravan Karavan který bude uložen jako aktuální
     * @param int $idBase Základní model od kterého se tento karavan odvíjí.
     */
    public function setCurrent($idCaravan, $idBase) {
        $data = array("id_karavan" => $idCaravan, "id_zaklad" => $idBase, "datum_do" => "00-00-0000");
        //rozdělit where
        $isCur=$this->database->table("aktualni_karavany")->select("*")->where("id_karavan=$idCaravan and id_zaklad=$idBase")->count();
    if($isCur==0)
        return $this->database->table("aktualni_karavany")->insert($data);
    else
        return false;
    }

    /**
     * Odstraní záznam z tabulky aktuální_karavany. Pokud je parametr fullErase = true, 
     * bude karavan vymazán úplně včetně fotek. TUTO MOŽNOST NEŘEŠIT!!!
     * @param bool $fullErase
     * @param int $idCaravan
     */
    public function unsetCurrent($idCaravan,$fullErase = false ) {
        if ($fullErase) {
         // vymazání fotek   
        }
        $this->database->table("aktualni_karavany")->where("id_karavan=$idCaravan")->delete();
    }

    /**
     * Vrací seznam všech aktuálních nabídek.
     */
    public function getCurrentCaravans() {
        $this->database->table("aktualni_karavany")->select("*")->fetchAll();
    }

}
