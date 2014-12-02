<?php

namespace Caravans\Model;

use Nette\Mail\Message,
    Nette\Mail\SendmailMailer,
    Nette\Latte\Engine;

/**
 * Třída pro práci s karavany.
 * 
 * @author Vladimír Antoš
 * @package caravans
 */
class CaravanManager extends \Caravans\Model\ModelContainer {

    private $id = null;

    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        if ($this->id == null)
            throw new \Nette\InvalidStateException;
        return $this->id;
    }

    /**
     * @return \Caravans\Model\CaravanEquipmentManager
     */
    public function caravanEquipment($lang) {
        return new CaravanEquipmentManager($this->database, $this->id, $lang);
    }

    /**
     * @return \Caravans\Model\CurrentCaravan
     */
    public function currentCaravan() {
        return new CurrentCaravan($this->database);
    }

    /**
     * @param \Nette\Utils\ArrayHash $data
     * @return bool
     */
    public function save(\Nette\Utils\ArrayHash $data) {
        if($data->id_origin == null) //originální verze karavanu v CZ
            $data->id_karavan = $this->createId();
        else $data->id_karavan = $data->id_origin;
        if($data->id_zaklad == 0)
            $data->id_zaklad = null;
        $data->remove("id_origin");
        $this->database->table("karavany")->insert($data);
    }

    public function edit($id, $data) {
        $id_zaklad = $data->id_zaklad;
        return $this->database->table("karavany")->where(array("id_karavan"=> $id, "jazyk" => $data->jazyk))->update($data);
    }

    public function delete($id, $language) {
        return $this->database->table("karavany")->where(array("id_karavan"=> $id, "jazyk" => $language))->delete() > 0;
    }

    public function getGallery() {
        return new CaravanImage();
    }

    public function getCaravan($id, $lang = null) {
        if($lang != null)
        return $this->database->query("SELECT k.`id_karavan`, `id_zaklad`, `znacka`, k.`jazyk`, `typ`, `cena`, `sirka`, 
            `delka`, `vyska`, `nastavba_delka`,
            `vyska_vnitrni`, `sirka_vnitrni`, `luzko_delka`,`luzko_sirka`,`hmotnost_p`,
            `hmotnost_pb`,`hmotnost_c`,`hmotnost_t`,`hmotnost_max`,`podvozek`,
            `exterier`,`podvozek2`,`pneu`,`napajeni`,`datum_vlozeni`,`vybava`,
            `popis`,`specialni_edice`,`barva`, `eshop_link`, g.`nazev` as `hlavni_obrazek`
            FROM `karavany` as k
            LEFT JOIN `hlavni_obrazky_karavany` as hok ON  hok.`id_karavan` = k.`id_karavan` AND hok.jazyk =
k.jazyk
            LEFT JOIN `galerie` as g ON g.`id_foto` = hok.`id_foto`
            WHERE k.`id_karavan`=? AND k.`jazyk`=?", $id, $lang)->fetch();
        else return $this->database->query("SELECT k.`id_karavan`, `id_zaklad`, `znacka`, k.`jazyk`, `typ`, `cena`, `sirka`, 
            `delka`, `vyska`,`nastavba_delka`,
            `vyska_vnitrni`, `sirka_vnitrni`, `luzko_delka`,`luzko_sirka`,`hmotnost_p`,
            `hmotnost_pb`,`hmotnost_c`,`hmotnost_t`,`hmotnost_max`,`podvozek`,
            `exterier`,`podvozek2`,`pneu`,`napajeni`,`datum_vlozeni`,`vybava`,
            `popis`,`specialni_edice`,`barva`, `eshop_link`, g.`nazev` as `hlavni_obrazek`
            FROM `karavany` as k
            LEFT JOIN `hlavni_obrazky_karavany` as hok ON  hok.`id_karavan` = k.`id_karavan` AND hok.jazyk =
k.jazyk
            LEFT JOIN `galerie` as g ON g.`id_foto` = hok.`id_foto`
            WHERE k.`id_karavan`=?", $id)->fetch();
    }

    /**
     * Vrací seznam všech karavanů včetně hlavních obrázků.
     * @return array<ActiveRow>
     */
    public function readCaravans($language = null) {
        return $this->database->query("
            SELECT k.`id_karavan`, k.`jazyk`, `id_zaklad`, `znacka`, `typ`, `cena`, `sirka`, 
            `delka`, `vyska`, `nastavba_delka`,
            `vyska_vnitrni`, `sirka_vnitrni`,  `luzko_delka`,`luzko_sirka`,`hmotnost_p`,
            `hmotnost_pb`,`hmotnost_c`,`hmotnost_t`,`hmotnost_max`,`podvozek`,
            `exterier`,`podvozek2`,`pneu`,`napajeni`,`datum_vlozeni`,`vybava`,
            `popis`,`specialni_edice`, `eshop_link`, `barva`, g.`nazev` as `hlavni_obrazek`
            FROM `karavany` as k
            LEFT JOIN `hlavni_obrazky_karavany` as hok ON  hok.`id_karavan` = k.`id_karavan` AND hok.jazyk = k.jazyk
            LEFT JOIN `galerie` as g ON g.`id_foto` = hok.`id_foto`".($language ? "WHERE k.`jazyk`='".$language."'" : null). "ORDER BY `datum_vlozeni` DESC")->fetchAll();
    }

    /**
     * Generuje náhodné unikátní ID karavanu a kontroluje v databázi jestli neexistuje.
     * @return int
     */
    private function createId() {
        $id = null;
        do {
            $id = $this->randNumber(caravanIdLength);
        } while ($this->database->table("karavany")->where("id_karavan", $id)->count() == 1);
        return $this->id = (int) $id;
    }

    //nutno dodat poštovní server a upravit email.latte
    public function sendToEmail($idCaravan, $email, $lang, $equip = null) {
        if ($email == null)
            throw new \Nette\InvalidArgumentException("Nevyplnil jsi email");
        $latte = new \Latte\Engine();
        $params = $this->getCaravan($idCaravan, $lang);
        $mail = new \Nette\Mail\Message();
        if($lang == Language::CS)
            $file = __DIR__ . '/../templates/Caravan/email.latte';
        else $file = __DIR__ . '/../templates/Caravan/email_de.latte';
        $mail->setFrom(adminEmail)
                ->addTo($email)
                ->setSubject("Minikaravan " . $params->znacka . " " . $params->typ)
                ->setHtmlBody(
                        $latte->renderToString($file, array("id_karavan" => $idCaravan, "znacka" => $params->znacka,
                            "rozmery" => $params->vyska . "x" . $params->sirka . "x" . $params->delka,
                            "typ" => $params->typ, "cena" => $params->cena, "spec_vybava" => $equip, "website" => website)));
        $send = new \Nette\Mail\SendmailMailer();
        $send->send($mail);
    }

    public function getSimilarCaravans($idCaravan, $parent, $lang = null) {
        if ($parent == null) {
            return $this->database->query("SELECT k.`id_karavan`, `id_zaklad`, `znacka`, `typ`, `cena`,g.`nazev` as `hlavni_obrazek` FROM karavany as k
                        LEFT JOIN `hlavni_obrazky_karavany` as hok ON  hok.`id_karavan` = k.`id_karavan` AND hok.jazyk =
k.jazyk
                        LEFT JOIN `galerie` as g ON g.`id_foto` = hok.`id_foto` 
                        WHERE id_zaklad=" . $idCaravan . " AND k.`jazyk` =?                        
ORDER BY `datum_vlozeni` DESC", $lang)->fetchAll();
        }else{
            return $this->database->query("SELECT k.`id_karavan`, k.`id_zaklad`, 
`znacka`, `typ`, `cena`,g.`nazev` as `hlavni_obrazek` 
FROM `karavany` as k  
LEFT JOIN `hlavni_obrazky_karavany` as hok ON hok.`id_karavan` = k.`id_karavan` AND hok.jazyk =
k.jazyk
LEFT JOIN `galerie` as g ON g.`id_foto` = hok.`id_foto` 
WHERE (`id_zaklad` = ".$parent." OR k.`id_karavan`=".$parent.") AND k.`id_karavan`!=".$idCaravan." AND k.jazyk=?", $lang);
        }
    }

//    public function createCopy(\Nette\Utils\ArrayHash $data){
//        $this->save($data);
//        $id_caravan = $data->id_karavan;
//        $image = new CaravanImage($this->database);
//        $image->setIdCaravan($id_caravan);
//    }
}
