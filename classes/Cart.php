<?php

require_once 'Db.php';

class Cart extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    // Empty Cart
    public function empty_my_cart($buyer_id)
    {
        try {
            $sql = 'DELETE FROM carts WHERE cart_buyerid = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$buyer_id]);

            return true;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function remove_from_cart($cart_id)
    {
        try {
            $sql = 'DELETE FROM carts WHERE cart_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$cart_id]);

            return true;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            // exit();

            return false;
        }
    }

    public function count_buyer_cart($buyer_id)
    {
        try {
            $sql = 'SELECT SUM(cart_qty) AS total_items FROM carts WHERE cart_buyerid = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$buyer_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? (int) $result['total_items'] : 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Fetch items in cart
    public function fetch_buyer_cart($buyer_id)
    {
        try {
            $sql = 'SELECT c.*, 
                     p.product_name, 
                     p.product_price, 
                     p.product_image,
                     c.cart_id AS cid
              FROM carts c 
              JOIN products p 
              ON c.cart_productid = p.product_id 
              WHERE c.cart_buyerid = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$buyer_id]);
            $bcart = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $bcart;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    // Add new item to cart
    public function add_to_cart($product_id, $buyer_id, $qty)
    {
        try {
            $sql = 'INSERT INTO carts(cart_productid, cart_buyerid, cart_qty) VALUES(?,?,?)';
            $stmt = $this->agconn->prepare($sql);
            $rsp = $stmt->execute([$product_id, $buyer_id, $qty]);

            return $rsp;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    // Check if already added before
    public function check_if_added_before($product_id, $buyer_id)
    {
        $sql = 'SELECT * FROM carts WHERE cart_productid = ? AND cart_buyerid = ?';
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$product_id, $buyer_id]);
        $num = $stmt->rowCount();
        if ($num > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            return $product['cart_qty'];
        } else {
            return false;
        }
    }

    // Update quantity if exists
    public function update_cart_item($product_id, $buyer_id, $qty)
    {
        $qty++;
        $sql = 'UPDATE carts SET cart_qty = ? WHERE cart_productid = ? AND cart_buyerid = ?';
        $stmt = $this->agconn->prepare($sql);
        $rsp = $stmt->execute([$qty, $product_id, $buyer_id]);

        return $rsp;
    }
}
