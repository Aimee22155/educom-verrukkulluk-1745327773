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
                        if (isset($row['user_id'])) {
                            // Controleer of er een 'user_id' aanwezig is bij een commentaar.
                            $user = $this->user->selectUser($row['user_id']);
                            // haal gebruikersinformatie op
                            if ($user) {
                                // Controleer of er een gebruiker met dat ID bestaat.
                                $row['user_name'] = $user['user_name'];
                                // Voeg de 'user_name' toe aan array
                                if (isset($user['image'])) {
                                    $row['user_image'] = $user['image'];
                                    // Voeg de 'image' van de gebruiker toe aan de array
                                }
                            }
                        }
                        $dish_info['comments'][] = $row;
                        // Voeg de commentaar-rij toe aan de 'comments'-array binnen de '$dish_info'-array.
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
        $sql = "DELETE FROM dish_info 
                WHERE record_type = 'F' AND dish_id = $dish_id AND user_id = $user_id AND date = $date";
        $result = mysqli_query($this->connection, $sql);

        return $result;
    } 
    
    // Voeg favoriet toe, maar verwijder eerst dezelfde als die al bestaat in favorietenlijst.
    public function AddFavoriteIfNotExists($dish_id, $user_id, $date) {
        // Verwijder bestaande favoriet, indien aanwezig
        $this->deleteFavorite($dish_id, $user_id, $date);

        // Voeg favoriet toe
        $sql = "INSERT INTO dish_info (record_type, dish_id, user_id, date) 
                VALUES ('F', $dish_id, $user_id, $date)";
        $result = mysqli_query($this->connection, $sql);
        
        return $result;
    }  
    
}

