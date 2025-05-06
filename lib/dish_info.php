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
    
    public function selectDishInfo($dish_id, $record_type) {
        $dish_info = [
        'preparation_steps' => [],
        'rating' => [],
        'comments' => [],
        'favorites' => []
        ];
        
        $sql = "SELECT * FROM dish_info 
                WHERE dish_id = $dish_id 
                AND record_type = '$record_type'
                ORDER BY numberfield";
    
        $result = mysqli_query($this->connection, $sql);
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                switch ($row['record_type']) {
                    case 'P':
                        $dish_info['preparation_steps'][] = $row;
                        break;
                    case 'R':
                        $dish_info['rating'][] = $row;
                        break;
                    case 'C':
                        $dish_info['comments'][] = $row;
                        break;
                    case 'F':
                        $dish_info['favorites'][] = $row;
                        break;
                }
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

