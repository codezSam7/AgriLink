<?php

require_once __DIR__ . '../../classes/config.php';
require_once __DIR__ . '/../classes/Db.php';

class Category extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function fetch_all_categories()
    {
        try {
            $sql = 'SELECT * FROM categories';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();
            $rsp = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rsp;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function add_category($cat_name)
    {
        try {
            $sql = 'INSERT INTO categories(category_name) VALUES(?)';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$cat_name]);
            $add_cat = $this->agconn->lastInsertId();

            return $add_cat;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function delete_from_category($category_id)
    {
        try {
            $sql = 'DELETE FROM categories WHERE category_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$category_id]);

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();

            return false;
        }
    }
}
