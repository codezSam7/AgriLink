<?php

require_once dirname(__DIR__, 2).'/classes/config.php';
require_once dirname(__DIR__, 2).'/classes/Db.php';

class Logistics extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
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
            return [];
        }
    }

    public function update_delivery_status()
    {
        try {
            $sql = 'UPDATE orders SET delivery_status = ? WHERE order_id = ?';
            $stmt = $l->agconn->prepare($sql);
            $stmt->execute([$status, $order_id]);

            return true;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            // exit();

            return false;
        }
    }
}
