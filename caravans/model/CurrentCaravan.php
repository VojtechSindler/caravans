<?php
namespace Caravans\Model;

/**
 * Třída nastavuje a vypisuje aktuální nabídky karavanů.
 * @author 
 * @package
 * @version 1.0 
 */
class CurrentCaravan extends CaravanManager{
    
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
    public function setCurrent($idCaravan, $idBase){
        
    }
    
    /**
     * Odstraní záznam z tabulky aktuální_karavany. Pokud je parametr fullErase = true, 
     * bude karavan vymazán úplně včetně fotek. TUTO MOŽNOST NEŘEŠIT!!!
     * @param bool $fullErase
     */
    public function unsetCurrent($fullErase = false){
        
    }
    
    /**
     * Vrací seznam všech aktuálních nabídek.
     */
    public function getCurrentCaravans(){
        
    }
}
