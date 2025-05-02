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
        // Hoofd array
        $dish_info = [];
    
        // Haal alle info van een recept op
        $sql = "select * from dish_info 
                where dish_id = $dish_id and record_type = 'P' 
                order by numberfield";
        $result = mysqli_query($this->connection, $sql);
    
        // Als er preparation steps aanwezig zijn, voeg ze toe aan de array
        if ($result) {
            $dish_info['preparation_steps'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    
        // Haal comments en favorites op
        $userSql = "select record_type, dish_id, user_id, date, numberfield, textfield 
                    from dish_info 
                    where dish_id = $dish_id 
                    and (record_type = 'C' or record_type = 'F') 
                    order by user_id";
        $result = mysqli_query($this->connection, $userSql);
    
        // Als er reacties of favorieten zijn, voeg die dan toe aan de array
        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $dish_info['userC'][] = $row;
            }
        }
        return $dish_info;
    }
    
    // Verwijder een favoriet
    public function deleteFavorite($dish_id, $user_id, $date) {
        $sql = "delete from dish_info 
                where record_type = 'F' and dish_id = $dish_id and user_id = $user_id and date = $date";
        $result = mysqli_query($this->connection, $sql);

        return $result;
    } 
    
    // Voeg favoriet toe, maar verwijder eerst dezelfde als die al bestaat in favorietenlijst.
    public function AddFavoriteIfNotExists($dish_id, $user_id, $date) {
        // Verwijder bestaande favoriet, indien aanwezig
        $this->deleteFavorite($dish_id, $user_id, $date);

        // Voeg favoriet toe
        $sql = "insert into dish_info (record_type, dish_id, user_id, date) 
                values ('F', $dish_id, $user_id, $date)";
        $result = mysqli_query($this->connection, $sql);

        return $result;
    }  
    
}

