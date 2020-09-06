<?php

class Database{
    
   private static $dbHost = "$$$$$$$$$$";
   private static $dbName = "$$$$$$$$$$$";
   private static $dbUser = "$$$$$$$";
   private static $dbUserPassword = "$$$$$$$";
    
    private static $connection = null;

   public static function connect(){
        try{  
          self::$connection = new PDO("mysql:host=" .   self::$dbHost . ";dbname=" . self::$dbName,self::$dbUser,self::$dbUserPassword);

      }
     catch(PDOException $e){
          die($e->getMessage());
}
        return self::$connection;
    }
    public static function disconnect(){
        self::$connection = null;
    }
}
?>