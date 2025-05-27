<?php

class User {
    //properties
    private $connection;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function selectUser($user_id) {
        $sql = "SELECT * FROM user WHERE id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return($user);
    }

}
