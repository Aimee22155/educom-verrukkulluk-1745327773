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

    public function selectUsersC() {
        //haalt all users op die een commentaar hebben achtergelaten of een gerecht hebben toegevoegd aan hun favorieten.
        $sql = "select user_id, dish_id, record_type, textfield from dish_info 
                where record_type = 'C' OR record_type = 'F' order by user_id";
        $result = mysqli_query($this->connection, $sql);
        $UserC = [];
        //zet de opgehaalde users in een array
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $UserC[] = $row;
        }

        return $UserC;
    }    
    
    // Verwijder een favoriet
    public function selectdeleteFavorite($dish_id, $user_id, $date) {
        $sql = "delete from dish_info where record_type = 'F' AND dish_id = $dish_id AND user_id = $user_id AND date = $date";
        $result = mysqli_query($this->connection, $sql);

        return $result;
    } 
    
    // Voeg favoriet toe, maar verwijder eerst dezelfde als die al bestaat in favorietenlijst.
    public function selectAddFavoriteIfNotExists($dish_id, $user_id, $date) {
        // Verwijder bestaande favoriet, indien aanwezig
        $this->selectdeleteFavorite($dish_id, $user_id, $date);

        // Voeg favoriet toe
        $sql = "insert into dish_info (record_type, dish_id, user_id, date) values ('F', $dish_id, $user_id, $date)";
        $result = mysqli_query($this->connection, $sql);

        return $result;
    }  
    
}

