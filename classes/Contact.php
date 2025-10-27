<?php 
  require_once("Db.php");
  class Contact extends Db{
    private $agconn;

    public function __construct(){
      $this->agconn = $this->connect();
    }

    public function contact(){
      
    }
  }


?>