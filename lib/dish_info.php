<?php

class DishInfo {
    //properties
    private $connection;
    private $User;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);
    }
    
    private function selectUser($user_id) {
        $user = $this->user->select_User($user_id);
        return($user);
    }

    public function selectDishInfo($dish_id) {
        //selecteer alle gerecht_info-velden die behoren tot een specifiek gerecht.
        $sql = "select * from dish_info where id = $dish_id";
        $result = mysqli_query($this->connection, $sql);
        $dish_info = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($dish_info);
    }

    public function specificUsers() {
        //haalt all users op die een commentaar hebben achtergelaten of een gerecht hebben toegevoegd aan hun favorieten.
        $sql = "select user_id from dish_info where record_type = 'O' OR record_type = 'F'";
        $result = mysqli_query($this->connection, $sql);
        $users = [];
        //zet de opgehaalde users in een array
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $users[] = $row;
        }

        return $users;
    }    
    
    // Voeg favoriet toe, maar verwijder eerst dezelfde als die al bestaat in favorietenlijst.
    public function AddFavoriteIfNotExists($dish_id, $user_id) {
        // Verwijder bestaande favoriet, indien aanwezig
        $this->deleteFavorite($dish_id, $user_id);

        // Voeg favoriet toe
        $sql = "insert into dish_info (dish_id, user_id, record_type) values ($dish_id, $user_id, 'F')";
        $result = mysqli_query($this->connection, $sql);

        return $result;
    }

    // Verwijder een favoriet
    public function deleteFavorite($dish_id, $user_id) {
        $sql = "delete from dish_info where dish_id = $dish_id AND user_id = $user_id AND record_type = 'F'";
        $result = mysqli_query($this->connection, $sql);

        return $result;
    }   
    
}

