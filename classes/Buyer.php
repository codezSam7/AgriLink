<?php 
  require_once("Db.php");
  class Buyer extends Db{
    private $agconn;
    public function __construct(){
      $this->agconn = $this->connect();
    }

    public function fetch_all_states(){
      $sql = "SELECT * FROM state";
      $stmt = $this->agconn->prepare($sql);
      $stmt->execute();
      $rsp = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rsp;
    }

    public function fetch_lga($state_id){
      $sql = "SELECT * FROM lga WHERE state_id = ?";
      $stmt = $this->agconn->prepare($sql);
      $stmt->execute([$state_id]);
      $rsp = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rsp;
    }

    // small helper to validate existence
    public function state_exists($state_id){
      $stmt = $this->agconn->prepare("SELECT 1 FROM state WHERE state_id = ? LIMIT 1");
      $stmt->execute([$state_id]);
      $rsp = $stmt->fetchColumn();
      return $rsp;
    }

    public function lga_exists_for_state($lga_id, $state_id){
      $stmt = $this->agconn->prepare("SELECT 1 FROM lga WHERE lga_id = ? AND state_id = ? LIMIT 1");
      $stmt->execute([$lga_id, $state_id]);
      $rsp = $stmt->fetchColumn();
      return $rsp;
    }

    public function register_buyer($fulln,$phone,$email,$password,$state_id, $lga_id){
      try{
        // validate state and lga
        if(!$this->state_exists($state_id)){
          // invalid state
          return false;
        }
        if(!$this->lga_exists_for_state($lga_id, $state_id)){
          // invalid lga for that state
          return false;
        }

        $sql = "INSERT INTO buyers(buyer_fullname, buyer_phone, buyer_email, buyer_password_hash,buyer_state_id,buyer_lga_id)VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $this->agconn->prepare($sql);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$fulln,$phone,$email,$hashed,$state_id,$lga_id]);
        $regbuyer = $this->agconn->lastInsertId();
        return $regbuyer;
      }catch(PDOException $e){
        //echo $e->getMessage(); die();
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
        echo $e->getMessage(); die();
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