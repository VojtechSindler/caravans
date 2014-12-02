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
        bdump($data);
        if ($data->id_origin == null)
            $data->id_clanek = $this->createId();
        else $data->id_clanek = $data->id_origin;
        $data->id_autor = $this->userId;
        $data->remove("id_origin");
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
    public function delete($id, $jazyk = null) {
        if (is_null($jazyk))
            return $this->database->table("clanky")->where("id_clanek=$id")->delete();
        else
            return $this->database->table("clanky")->where(array ("id_clanek" => $id, "jazyk" => $jazyk))->delete();
    }

    /**
     * Vrací všechny články a novinky.
     * Pokud se vloží parametr $id, vrátí pouze daný článek
     * 
     * @param type $id
     * @return array
     */
    public function getAll($id = null, $jazyk = 21, $all = false) {
        if (is_null($id)) {
            if ($all)
                $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text,kategorie, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor and jazyk=$jazyk  ORDER BY datum_vytvoreni desc")->fetchAll();
            else
                $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text,kategorie, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor AND c.kategorie=? and jazyk=$jazyk  ORDER BY datum_vytvoreni desc", IArticleCategory::ARTICLE)->fetchAll();
        } else {
            $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text,kategorie, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor and id_clanek=$id and jazyk=$jazyk ORDER BY datum_vytvoreni desc")->fetchAll();
        }
        return $articles;
    }

    /**
     * Vrací všechny články a novinky.
     * Pokud se vloží parametr $id, vrátí pouze daný článek
     * 
     * @param type $id
     * @return array
     */
    public function getAllAdmin($id = null, $all = false) {
        if (is_null($id)) {
            if ($all)
                $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text,kategorie, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor ORDER BY datum_vytvoreni desc")->fetchAll();
            else
                $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text,kategorie, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor AND c.kategorie=? ORDER BY datum_vytvoreni desc", IArticleCategory::ARTICLE)->fetchAll();
        } else {
            $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text,kategorie, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor and id_clanek=$id ORDER BY datum_vytvoreni desc")->fetchAll();
        }
        return $articles;
    }
    
    public function getExhibitions($jazyk=21) {
        return $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor AND c.kategorie=? and jazyk=$jazyk ORDER BY datum_vytvoreni desc", IArticleCategory::EXHIBITON)->fetchAll();
    }

    /**
     * Vrací 5 nejnovějších článků a novinek.
     * 
     * @param type $id
     * @return array
     */
    public function getNewArticles($limit = 5, $jazyk = 21) {
        $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor AND c.id_clanek != $this->id AND jazyk=$jazyk ORDER BY datum_vytvoreni desc LIMIT " . $limit)->fetchAll();
        return $articles;
    }

    /**
     * Vrací všechny novinky.
     * @return array
     */
    public function getNews( $jazyk = 21) {
        $articles = $this->database->query("SELECT c.id_clanek,c.jazyk,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor and c.novinka=1 AND jazyk=$jazyk ORDER BY datum desc")->fetchAll();
        return $articles;
    }

    /**
     * Vrací všechny clanky.
     * @return array
     */
    public function getArticles( $jazyk = 21) {
        $articles = $this->database->query("SELECT c.id_clanek,c.jazyk  ,u.jmeno,u.prijmeni,c.nadpis,c.perex,c.text, DATE_FORMAT(c.datum_vytvoreni,'%d.%m.%Y')as'datum' FROM clanky c, uzivatele u WHERE u.id=c.id_autor and c.novinka=0AND jazyk=$jazyk ORDER BY datum desc")->fetchAll();
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
    public function createPerex($text, $limit = 200) {
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_NOQUOTES, 'UTF-8');
        if (strlen($text) > $limit) {
            $text = substr($text, 0, $limit + 1);
            $pos = strrpos($text, " ");
            $text = substr($text, 0, ($pos ? $pos : -1)) . "…";
        }
        return $text;
    }

}
