<?php

require_once 'Db.php';
class Payment extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function update_database($paystatus, $data, $ref)
    {
        $sql = 'UPDATE payments SET pay_status=?, pay_data=? WHERE pay_ref=?';
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$paystatus, $data, $ref]);

        return true;
    }

    public function verify_paystack_step2($reference)
    {
        $url = "https://api.paystack.co/transaction/verify/$reference";
        $headers = ['Content-Type: application/json', 'Authorization:Bearer sk_test_138e6315fff181d1a7e444e5f00e09d7f175215d'];
        // initialize curl
        $curlobj = curl_init($url);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlobj, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, false);
        // execute the curl session using curl_exec();
        $apiResponse = curl_exec($curlobj);
        if ($apiResponse) {
            curl_close($curlobj);

            return json_decode($apiResponse);
        } else {
            $r = curl_error($curlobj);

            return false;
        }
    }

    public function insert_payment($amt, $buyer_id, $order_id, $ref)
    {
        try {
            $sql = 'INSERT INTO payments(pay_amt,pay_buyerid,pay_orderid,pay_ref) VALUES(?,?,?,?)';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$amt, $buyer_id, $order_id, $ref]);

            return $this->agconn->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();

            return false;
        }
    }

    public function update_order_paid($order_id)
    {
        $sql = "UPDATE orders SET pay_status='paid' WHERE order_id=?";
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$order_id]);
    }

    public function initialize_paystack_step1($email, $amount, $reference)
    {
        $url = 'https://api.paystack.co/transaction/initialize';
        $postRequest = ['email' => $email, 'amount' => $amount * 100, 'reference' => $reference, 'callback_url' => 'http://localhost/agrilink/paydirect.php?reference='.$reference];
        $headers = ['Content-Type: application/json', 'Authorization:Bearer sk_test_138e6315fff181d1a7e444e5f00e09d7f175215d'];

        // initialize curl
        $curlobj = curl_init($url);
        // set curl options using the function curl_stepopt()
        curl_setopt($curlobj, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, json_encode($postRequest));
        //
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlobj, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, false);
        // execute the curl session using curl_exec();
        $apiResponse = curl_exec($curlobj);
        if ($apiResponse) {
            curl_close($curlobj);

            return json_decode($apiResponse);
        } else {
            $r = curl_error($curlobj);

            return false;
        }
    }
}
