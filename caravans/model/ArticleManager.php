<?php

namespace Caravans\Model;

/**
 * Description of ArticleManager
 * 
 * @author Bruno
 */
class ArticleManager extends \Caravans\Model\ModelContainer {

    private $id = null;
    private $userId;

    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }

    public function setUserId($id) {
        $this->userId = $id;
        return $this;
    }

    /**
     * Generuje náhodné unikátní ID článku a kontroluje v databázi jestli neexistuje.
     * @return int
     */
    private function createId() {
        $id = null;
        do {
            $id = $this->randNumber(caravanIdLength);
        } while ($this->database->table("clanky")->where("id_clanek", $id)->count() == 1);
        return (int) $id;
    }

    /** Vrací vrací id článku
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /** Nastavuje id článku
     * 
     * @param type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /** Uloží článek
     * 
     * @param \Nette\Utils\ArrayHash $data
     * @return bool
     */
    public function save(\Nette\Utils\ArrayHash $data) {
        $data->id_clanek = $this->createId();
        $data->id_autor = $this->userId;
        return $this->database->table("clanky")->insert($data);
    }

    /** Upraví článek
     * 
     * @param \Nette\Utils\ArrayHash $data
     * @return bool
     */
    public function edit(\Nette\Utils\ArrayHash $data) {
        $data->id_autor = $this->userId;
        $id = $data->id_clanek;
        $data->remove("id_clanek");
        return $this->database->table("clanky")->where("id_clanek=$id")->update($data);
    }

    /** Vymaže článek
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        return $this->database->table("clanky")->where("id_clanek=$id")->delete();
    }

    /**
     * Vrací všechny články.
     * Pokud se vloží parametr $id, vrátí pouze daný článek
     * 
     * @param type $id
     * @return type
     */
    public function getArticles($id = null) {
        if (is_null($id)) {
            $articles = $this->database->query("SELECT c.id_clanek,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor ORDER BY datum desc")->fetchAll();
        } else {
            $articles = $this->database->query("SELECT c.id_clanek,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor and id_clanek=$id  ORDER BY datum desc")->fetchAll();
        }
        return $articles;
    }

    /** Vytváří perex
     * Ze zadaného textu vezme x znaků (dle $limit) a následně testuje, jestli je xtý znak mezera, 
     * pokud ne ořezává text, dokud není poslední znak právě mezera
     * 
     * @param type $text
     * @param type $limit
     * @return string
     */
    public function createPerex($text, $limit = 50) {
        if (strlen($text) > $limit) {
            $text = substr($text, 0, $limit + 1);
            $pos = strrpos($text, " ");
            $text = substr($text, 0, ($pos ? $pos : -1)) . "…";
        }
        return $text;
    }

}
