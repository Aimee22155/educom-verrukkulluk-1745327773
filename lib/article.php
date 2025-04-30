<?php

class Article {
    //properties
    private $connection;
    
    //methods
    public function __construct($connection) {
        $this->connection = $connection; 
         //the first connection is the same as the property $connection.
         //the second $connection is the data that is being putt into the class, (not the same as the property $connection).
       
    }
  
    public function selectArticle($article_id) {
        $sql = "select * from article where id = $article_id";
        $result = mysqli_query($this->connection, $sql);
        $article = mysqli_fetch_array($result, MYSQLI_ASSOC); //mysqli_assoc --> kolomnamen
        
        return($article);
    }
}
