<?php 
  require_once("Db.php");
  class Buyer extends Db{
    private $agconn;
    public function __construct(){
      $this->agconn = $this->connect();
    }

    public function register_buyer($fulln, $phone, $email, $password){
      try{
        $sql = "INSERT INTO buyers(buyer_fullname, buyer_phone, buyer_email, buyer_password_hash)VALUES(?, ?, ?, ?)";
        $stmt = $this->agconn->prepare($sql);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$fulln,$phone,$email,$hashed]);
        $rsp = $this->agconn->lastInsertId();
        return $rsp;
      }catch(PDOException $e){
        //echo $e->getMessage();
        return false;
      }
    }

    public function login_buyer($fulln,$email,$password){
      try{
        $sql = "SELECT * FROM buyers WHERE buyer_fullname = ? AND buyer_email = ?";
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$fulln,$email]);
        $brecord = $stmt->fetch(PDO::FETCH_ASSOC);
        if($brecord){
          $saved_hash = $brecord["buyer_password_hash"];
          $brsp = password_verify($password, $saved_hash);
          if($brsp){
            //keep their id in session: key:user_online
            $_SESSION["buyer_online"] = $brecord["buyer_id"];
            return true;//password and username are correct
          }else{
            $_SESSION["errormsg"] = "Incorrect password";
            return false;//incorrect password
          }
        }else{
          $_SESSION["errormsg"] = "Invalid username";
          return false;
        }
      }catch(PDOException $e){
        //echo $e->getMessage(); die();
        return false;
      }
    }

    public function get_buyer_details($buyer_id){
      try{
        $sql = "SELECT buyer_id, buyer_fullname, buyer_email FROM buyers WHERE buyer_id = ?";
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$buyer_id]);
        $buyer = $stmt->fetch(PDO::FETCH_ASSOC);
        return $buyer;
      }catch(PDOException $e){
        //echo $e->getMessage(); die();
        return false;
      }
    }

    public function blogout(){
      session_unset();
      session_destroy();
    }
  }
?>