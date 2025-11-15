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
            // echo $e->getMessage() die();
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
            // echo $e->getMessage() die();
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
            return false;
        }
    }

    public function add_to_cart($product_id, $buyer_id, $qty)
    {
        try {
            $sql = 'INSERT INTO carts(cart_productid, cart_buyerid, cart_qty) VALUES(?,?,?)';
            $stmt = $this->agconn->prepare($sql);
            $rsp = $stmt->execute([$product_id, $buyer_id, $qty]);

            return $rsp;
        } catch (PDOException $e) {
            return false;
        }
    }

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

    public function update_cart_item($product_id, $buyer_id, $qty)
    {
        $qty++;
        $sql = 'UPDATE carts SET cart_qty = ? WHERE cart_productid = ? AND cart_buyerid = ?';
        $stmt = $this->agconn->prepare($sql);
        $rsp = $stmt->execute([$qty, $product_id, $buyer_id]);

        return $rsp;
    }

    public function create_order($buyer_id, $payment_id, $total_amount)
    {
        try {
            $sql = 'INSERT INTO orders (order_buyer_id, order_pay_id, order_totalamt, pay_status) 
                    VALUES (?, ?, ?, ?)';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$buyer_id, $payment_id, $total_amount, 'pending']);

            return $this->agconn->lastInsertId(); // return order_id
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
    }

    public function add_order_items($order_id, $buyer_id)
    {
        try {
            $cart_items = $this->fetch_buyer_cart($buyer_id);
            if (! $cart_items) {
                return false;
            }

            $sql = 'INSERT INTO order_items (order_item_orderid, order_item_productid, order_item_qty, order_item_price)
                    VALUES (?, ?, ?, ?)';
            $stmt = $this->agconn->prepare($sql);

            foreach ($cart_items as $item) {
                $stmt->execute([
                    $order_id,
                    $item['cart_productid'],
                    $item['cart_qty'],
                    $item['product_price'],
                ]);
            }

            return true;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            // exit();

            return false;
        }
    }

    public function checkout_create_order($buyer_id, $payment_id)
    {
        // Step 1: Fetch cart items
        $items = $this->fetch_buyer_cart($buyer_id);
        if (! $items) {
            return false;
        }

        // Step 2: Calculate total amount
        $total = 0;
        foreach ($items as $item) {
            $total += $item['product_price'] * $item['cart_qty'];
        }

        // Step 3: Create order
        $order_id = $this->create_order($buyer_id, $payment_id, $total);
        if (! $order_id) {
            return false;
        }

        // Step 4: Add order items
        $added = $this->add_order_items($order_id, $buyer_id);
        if (! $added) {
            return false;
        }

        // Step 5: Empty the buyer's cart
        $this->empty_my_cart($buyer_id);

        return $order_id; // Return the new order ID
    }
}
