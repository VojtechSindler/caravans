<?php

namespace Caravans\Model;

/**
 * Třída zpracovává kategorie galerií.
 * 
 * @author Vladimír Antoš
 * @package caravans_model
 */
class CategoryManager extends ModelContainer {

    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }

    /**
     * 
     * @param string $name
     * @return bool
     * @throws \Caravans\ExistsValueException
     */
    public function save($name) {
        if ($this->exists($name))
            throw new \Caravans\ExistsValueException("Kategorie " . $name . " již byla vytvořena.");
        return (bool) $this->database->table("kategorie")->insert(array("nazev" => $name));
    }

    /**
     * @param string $name
     * @return bool
     * @throws \Caravans\ExistsValueException
     */
    public function edit($name, $id) {
        if ($this->exists($name))
            throw new \Caravans\ExistsValueException("Kategorie " . $name . " již byla vytvořena.");
        return (bool) $this->database->table("kategorie")
                ->where("id_kategorie", $id)->update(array("nazev" => $name));
    }

    /**
     * Kontrola existence kategorie podle názvu.
     * @param string $name
     * @return bool
     */
    public function exists($name) {
        return $this->database->table("kategorie")->where("nazev", $name)->count() > 0;
    }

    /**
     * Kontrola existence kategorie podle ID.
     * @param int $id
     * @return bool
     */
    public function existsId($id) {
        return $this->database->table("kategorie")->where("id_kategorie", $id)->count() > 0;
    }

    /**
     * Vrací všechny kategorie.
     * @return array
     */
    public function readAll($fetchPairs = false) {
        if($fetchPairs)
            return $this->database->table("kategorie")->order("nazev ASC")->fetchPairs("id_kategorie", "nazev");
        return $this->database->table("kategorie")->order("nazev ASC")->fetchAll();
    }

    public function get($id) {
        return $this->database->table("kategorie")
                        ->select("id_kategorie, nazev")->where("id_kategorie", $id)->fetch();
    }

    /**
     * @param int $length
     * @param int $offset
     * @return array
     */
    public function pageableReadAll($length, $offset) {
        return $this->database->table("kategorie")
                        ->select("*")
                        ->order("nazev ASC")
                        ->limit($length, $offset)
                        ->fetchAll();
    }

    /**
     * Smaže kategorii podle ID.
     * @param int $id
     * @return bool
     * @throws \Caravans\ExistsValueException
     */
    public function delete($id) {
        if (!$this->existsId($id))
            throw new \Caravans\ExistsValueException("Kategorie neexistuje.");
        return $this->database->table("kategorie")->where("id_kategorie", $id)->delete() > 0;
    }

    /**
     * Vrací počet všech kategorií.
     * @return int
     */
    public function count() {
        return $this->database->table("kategorie")->count();
    }

}
