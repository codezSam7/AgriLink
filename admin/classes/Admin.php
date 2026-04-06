<?php

require_once dirname(__DIR__, 2) . '/classes/config.php';
require_once dirname(__DIR__, 2) . '/classes/Db.php';

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

    public function delete_from_products($product_id)
    {
        try {
            $sql = 'DELETE FROM products WHERE product_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$product_id]);

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();

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

    public function fetch_farmers_by_id($farmer_id)
    {
        try {
            $sql = 'SELECT f.*, s.state_name 
                    FROM farmers f 
                    JOIN state s ON f.farmer_state_id = s.state_id WHERE f.farmer_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$farmer_id]);
            $farmer = $stmt->fetch(PDO::FETCH_ASSOC);

            return $farmer;
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
            $sql = 'SELECT 
                    o.*,
                    b.buyer_fullname,
                    b.buyer_email,
                    b.buyer_phone
                FROM orders o
                JOIN buyers b ON o.order_buyerid = b.buyer_id
                ORDER BY o.order_date DESC';

            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $orders;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();

            return false;
        }
    }

    public function update_order_status($order_id, $status)
    {
        try {
            $sql = 'UPDATE orders SET pay_status = ? WHERE order_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$status, $order_id]);

            return true;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //exit();
            return false;
        }
    }

    public function fetch_logistics_providers()
    {
        try {
            $sql = "SELECT * FROM logistics_providers WHERE status = 'active' ORDER BY name ASC";
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();

            $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $providers ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function assign_logistics($order_id, $logistics_id)
    {
        try {
            $sql = "UPDATE orders 
                SET logistics_id = ?, delivery_status = 'assigned' 
                WHERE order_id = ?";
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$logistics_id, $order_id]);

            return true;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //exit();
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
