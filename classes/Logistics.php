<?php

require_once 'Db.php';

class Logistics extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function register_logistics($fulln, $phone, $email, $password, $address)
    {
        try {
            $sql = 'INSERT INTO logistics_providers(`name`, phone, email, `password`, `address`)VALUES(?, ?, ?, ?, ?)';
            $stmt = $this->agconn->prepare($sql);
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([$fulln, $phone, $email, $hashed, $address]);
            $reglog = $this->agconn->lastInsertId();

            return $reglog;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function login_logistics($email, $password)
    {
        try {
            $sql = 'SELECT * FROM logistics_providers WHERE email = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$email]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($record) {
                $saved_hash = $record['password'];
                $rsp = password_verify($password, $saved_hash);
                if ($rsp) {
                    $_SESSION['logistic_online'] = $record['logistics_id'];

                    return true;
                } else {
                    $_SESSION['errormsg'] = 'Incorrect password';

                    return false;
                }
            } else {
                $_SESSION['errormsg'] = 'Invalid username';

                return false;
            }
        } catch (PDOException $e) {
            // echo $e->getMessage();
            // exit();

            return false;
        }
    }

    public function get_logistics_details($logistics_id)
    {
        try {
            $sql = 'SELECT logistics_id, name, email FROM logistics_providers WHERE logistics_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$logistics_id]);
            $logistic = $stmt->fetch(PDO::FETCH_ASSOC);

            return $logistic;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function fetch_assigned_orders($logistics_id)
    {
        try {
            $sql = 'SELECT 
                        o.*,
                        b.buyer_fullname
                    FROM orders o
                    JOIN buyers b ON o.order_buyerid = b.buyer_id
                    WHERE o.logistics_id = ?
                    ORDER BY o.order_date DESC';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$logistics_id]);

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $orders;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update_delivery_status($order_id, $status)
    {
        try {
            $sql = 'UPDATE orders 
                SET delivery_status = ?, delivered_at = NOW()
                WHERE order_id = ?';

            $stmt = $this->agconn->prepare($sql);

            return $stmt->execute([$status, $order_id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function llogout()
    {
        session_unset();
        session_destroy();
    }
}

// $a = new Logistics;
// $assigned = $a->fetch_assigned_orders(3);
// echo '<pre>';
// print_r($assigned);
// echo '</pre>';
