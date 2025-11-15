<?php

require_once dirname(__DIR__, 2).'/classes/config.php';
require_once dirname(__DIR__, 2).'/classes/Db.php';

class Admin extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function login_admin($username, $password)
    {
        try {
            $sql = 'SELECT * FROM admins WHERE admin_username = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$username]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($record) {
                $saved_hash = $record['admin_password'];
                $rsp = password_verify($password, $saved_hash);
                if ($rsp) {
                    // keep their id in session: key:user_online
                    $_SESSION['admin_online'] = $record['admin_id'];

                    return true; // password and username are correct
                } else {
                    $_SESSION['errormsg'] = 'Incorrect password';

                    return false; // incorrect password
                }
            } else {
                $_SESSION['errormsg'] = 'Invalid username';

                return false;
            }
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    // create a method that accepts user_id and returns all the details of the user so as for them to keep them logged whenever they go from page to page
    public function get_admin_details($admin_id)
    {
        try {
            $sql = 'SELECT * FROM admins WHERE admin_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$admin_id]);
            $rsp = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rsp;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
    }

    public function fetch_products()
    {
        try {
            $sql = 'SELECT *,product_id as pid, product_description as pdesc FROM products JOIN categories ON product_category_id=category_id JOIN farmers ON product_farmer_id=farmer_id JOIN state ON farmer_state_id = state_id';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function fetch_farmers()
    {
        try {
            $sql = 'SELECT f.*, s.state_name 
                    FROM farmers f 
                    JOIN state s ON f.farmer_state_id = s.state_id';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();
            $farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $farmers;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function fetch_buyers()
    {
        try {
            $sql = 'SELECT b.*, s.state_name 
                    FROM buyers b 
                    JOIN state s ON b.buyer_state_id = s.state_id';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();
            $farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $farmers;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function fetch_orders()
    {
        try {

        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    // a method that logs out user by destroying all the session for the user
    public function logout()
    {
        session_unset();
        session_destroy();
    }
}

// $re = new Admin;
// var_dump($re->change_recipe_status(11));
