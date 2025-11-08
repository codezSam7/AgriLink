<?php 
  require_once("config.php");
  class Db{
    protected function connect(){
      try{
        $dsn= "mysql:host=".DBSERVER.";dbname=".DBNAME;
        $options=[PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION];
        $agconn = new PDO($dsn,DBUSER,DBPASS,$options);
        return $agconn;
      }catch(PDOException $e){
        echo $e->getMessage();
        return false;
      }
    }
  }
?>