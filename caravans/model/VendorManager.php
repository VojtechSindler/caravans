<?php

namespace Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class VendorManager extends ModelContainer {

    /**
     * @param \Nette\Database\Context $db
     */
    public function __construct(\Nette\Database\Context $db) {
        parent::__construct($db);
    }

    /**
     * Uloží a vrátí id prodejce.
     * @param array $data
     * @return int
     * @throws \RuntimeException
     */
    public function add(array $data) {
        $data["id_prodejce"] = time();
        try {
            $this->database->table("prodejci")->insert($data);
            return $data["id_prodejce"];
        } catch (\PDOException $ex) {
            throw new \RuntimeException();
        }
    }

    public function edit($id, array $data) {
        if (!$this->exists($id))
            throw new \RuntimeException("Tento prodejce neexistuje");
        return $this->findAll()->where("id_prodejce", $id)->update($data);
    }

    public function deleteById($id) {
        if (!$this->exists($id))
            throw new \RuntimeException("Tento prodejce neexistuje");
        return $this->findById($id)->delete();
    }

    public function getRegion() {
        return $this->database->table("kraje")->fetchPairs("id_kraj", "kraj");
    }

    public function findAll() {
        return $this->database->table("prodejci");
    }

    /**
     * @param int $id
     * @return \Nette\Database\Table\Selection
     */
    public function findById($id) {
        return $this->findAll()->where("id_prodejce", $id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exists($id) {
        return $this->findById($id)->count() > 0;
    }

    /**
     * @param int $id
     * @return VendorImage
     */
    public function imageFactory($id) {
        return VendorImage::create(vendorGallery, $id);
    }
}
