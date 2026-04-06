<?php

require_once 'Db.php';
class Buyer extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function fetch_all_states()
    {
        $sql = 'SELECT * FROM state';
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute();
        $rsp = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rsp;
    }

    public function fetch_lga($state_id)
    {
        $sql = 'SELECT * FROM lga WHERE state_id = ?';
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$state_id]);
        $rsp = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rsp;
    }

    public function state_exists($state_id)
    {
        $stmt = $this->agconn->prepare('SELECT 1 FROM state WHERE state_id = ? LIMIT 1');
        $stmt->execute([$state_id]);
        $rsp = $stmt->fetchColumn();

        return $rsp;
    }

    public function lga_exists_for_state($lga_id, $state_id)
    {
        $stmt = $this->agconn->prepare('SELECT 1 FROM lga WHERE lga_id = ? AND state_id = ? LIMIT 1');
        $stmt->execute([$lga_id, $state_id]);
        $rsp = $stmt->fetchColumn();

        return $rsp;
    }

    public function register_buyer($fulln, $phone, $email, $password, $state_id, $lga_id)
    {
        try {
            // validate state and lga
            if (! $this->state_exists($state_id)) {
                // invalid state
                return false;
            }
            if (! $this->lga_exists_for_state($lga_id, $state_id)) {
                // invalid lga for that state
                return false;
            }

            $sql = 'INSERT INTO buyers(buyer_fullname, buyer_phone, buyer_email, buyer_password_hash,buyer_state_id,buyer_lga_id)VALUES(?, ?, ?, ?, ?, ?)';
            $stmt = $this->agconn->prepare($sql);
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([$fulln, $phone, $email, $hashed, $state_id, $lga_id]);
            $regbuyer = $this->agconn->lastInsertId();

            return $regbuyer;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function login_buyer($email, $password)
    {
        try {
            $sql = 'SELECT * FROM buyers WHERE buyer_email = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$email]);
            $brecord = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($brecord) {
                $saved_hash = $brecord['buyer_password_hash'];
                $brsp = password_verify($password, $saved_hash);
                if ($brsp) {
                    // keep their id in session: key:user_online
                    $_SESSION['buyer_online'] = $brecord['buyer_id'];

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

    public function fetch_myproducts($buyer_id)
    {
        try {
            $sql = 'SELECT *,product_id as pid, product_description as product_desc FROM products JOIN categories ON products_category_id=category_id WHERE buyer_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$buyer_id]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function get_buyer_details($buyer_id)
    {
        try {
            $sql = 'SELECT buyer_id, buyer_fullname, buyer_email FROM buyers WHERE buyer_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$buyer_id]);
            $buyer = $stmt->fetch(PDO::FETCH_ASSOC);

            return $buyer;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function insert_order_details($cart_items, $buyer_id)
    {
        try {
            $this->agconn->beginTransaction();

            // 1. Create order
            $sql = "INSERT INTO orders (order_buyerid, order_date, delivery_status, pay_status)
                VALUES (:buyer_id, NOW(), 'Pending', 'Unpaid')";
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([':buyer_id' => $buyer_id]);

            $order_id = $this->agconn->lastInsertId();

            if (!$order_id) {
                $this->agconn->rollBack();
                return false;
            }

            // ✅ ADD detail_price HERE
            $sql2 = "INSERT INTO order_details 
                (detail_orderid, detail_buyerid, detail_productid, detail_qty, detail_price) 
                VALUES (:order_id, :buyer_id, :product_id, :qty, :price)";
            $stmt2 = $this->agconn->prepare($sql2);

            foreach ($cart_items as $item) {
                $stmt2->execute([
                    ':order_id' => $order_id,
                    ':buyer_id' => $buyer_id,
                    ':product_id' => $item['product_id'],
                    ':qty' => $item['cart_qty'],
                    ':price' => $item['product_price'] // ✅ THIS WAS MISSING
                ]);
            }

            $this->agconn->commit();

            return $order_id;
        } catch (PDOException $e) {
            $this->agconn->rollBack();
            die($e->getMessage());
            return false;
        }
    }

    public function get_buyer_orders($buyer_id)
    {
        $sql = "SELECT 
                o.*, 
                SUM(od.detail_qty * od.detail_price) AS total_amount
            FROM orders o
            JOIN order_details od 
                ON o.order_id = od.detail_orderid
            WHERE o.order_buyerid = ?
            GROUP BY o.order_id
            ORDER BY o.order_id DESC";

        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$buyer_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch_order($order_id)
    {
        $sql = "SELECT 
                od.*, 
                p.product_name, 
                p.product_image, 
                p.product_price,
                o.delivery_status,
                o.pay_status
            FROM order_details od
            JOIN products p ON od.detail_productid = p.product_id
            LEFT JOIN orders o ON od.detail_orderid = o.order_id
            WHERE od.detail_orderid = :order_id";

        $stmt = $this->agconn->prepare($sql);
        $stmt->bindValue(':order_id', $order_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch_order_amount($order_id)
    {
        try {
            $sql = "SELECT SUM(detail_qty * detail_price) AS total 
                FROM order_details 
                WHERE detail_orderid = ?";

            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$order_id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function blogout()
    {
        session_unset();
        session_destroy();
    }
}
