<?php

require_once 'Db.php';

class Order extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function update_order_status($order_pay_id, $status)
    {
        try {
            $sql = 'UPDATE orders SET pay_status = ? WHERE order_pay_id = ?';
            $stmt = $this->agconn->prepare($sql);

            return $stmt->execute([$status, $order_pay_id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
