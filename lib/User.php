<?php

class User {
    //properties
    private $connection;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function selectUser($user_id) {

        $sql = "select * from user where id = $user_id";

        $result = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC); //mysqli_assoc --> kolomnamen

        return($user);

    }


}
