<?php

class gerecht_info {
    //properties
    private $connection;
    private $user;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);
    }
    
    private function selecteerUser($user_id) {
        $user = $this->user->selectUser($user_id);
        return($user);
    }

    public function selecteerGerecht_info($gerecht_id) {
        //selecteer alle gerecht_info-velden die behoren tot een specifiek gerecht.
        $sql = "select * from gerecht_info where id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        $gerecht = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // lege aray voor tegen foutmelding null waarden.
        return[];
    }

    public function specific_user($user_id) {
        //ophalen user bij Record Type "O" (opmerking) en "F" favoriet
        $sql = "select user_id from gerecht_info where record_type = 'O' or record_type = 'F'";
        $result = mysqli_query($this->connection, $sql);
        $specific_user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        // lege aray voor tegen foutmelding null waarden.
        return[];
    }
    
    public function addFavorite() {
    //methode addFavorite in RecipeInfo class
    $sql = "";
    $result = mysqli_query($this->connection, $sql);
    $gerecht = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    // public function deleteFavorite() {
    // //methode deleteFavorite in RecipeInfo class
    // }

}

