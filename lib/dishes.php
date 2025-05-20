<?php

// // Include the required classes
// require_once("lib/User.php");
// require_once("lib/kitchen_type.php");
// require_once("lib/ingredient.php");
// require_once("lib/dish_info.php");

class Dishes {
    // === Properties === variabelen in huidige class + benodigde classes
    private $connection;
    private $User;
    private $KitchenType;
    private $Ingredient;
    private $DishInfo;

    // === Constructor ===
    public function __construct($connection) {
        $this->connection = $connection;
        $this->User = new User($connection);
        $this->KitchenType = new KitchenType($connection);
        $this->Ingredient = new Ingredient($connection);
        $this->DishInfo = new DishInfo($connection);
    }

    // === Private methods ===
    //user
    private function selectUser($user_id) {
        $user = $this->User->selectUser($user_id);
        return ($user);
    }

    //kitchen
    private function selectKitchen($kitchen_type_id) {
        $kitchen = $this->KitchenType->selectKitchenType($kitchen_type_id);
        return ($kitchen);
    }

    //type
    private function selectType($kitchen_type_id) {
        $type = $this->KitchenType->selectKitchenType($kitchen_type_id);
        return ($type);
    }

    //ingredient
    private function selectIngredient($dish_id) {
        $ingredient= $this->Ingredient->selectIngredient($dish_id);
        return ($ingredient);
    }

    private function calcPrice($ingredients) {
        //start bij 0
        $total = 0;
        //loopt door de array met ingredienten die behoren tot het gerecht
        foreach($ingredients as $ingredient) {
            //controleert of de ingredienten een prijswaarde hebben (om fouten te voorkomen)
            if (isset($ingredient['price'])) {
                        //telt de prijzen bij elkaar op
                        $total += $ingredient['price'];
            }
        }
        //returnt het totale bedrag
        return $total;
    }

    private function calcCalo($ingredients) {
        $total = 0;
        foreach ($ingredients as $ingredient) {
            if (
                isset($ingredient['calories']) &&
                isset($ingredient['packaging']) &&
                isset($ingredient['quantity']) &&
                $ingredient['packaging'] > 0
            ) {
                //Bereken de portie (hoeveelheid gebruikt t.o.v. verpakking)
                $portion = $ingredient['quantity'] / $ingredient['packaging'];
                //Bereken de calorieën voor dat ingrediënt en tel bijelkaar op
                $total += $portion * $ingredient['calories'];
            }
        }
        return $total;
    }    

    //rating
    private function selectRating($dish_id) {
        $rating = $this->DishInfo->selectDishInfo($dish_id, "R");
        return $rating;
    }

    // //steps
    private function selectPreparationSteps($dish_id) {
        $PreparationSteps = $this->DishInfo->selectDishInfo($dish_id, "P");
        return $PreparationSteps;
    }

    //comments
    private function selectComments($dish_id) {
        $comments = $this->DishInfo->selectDishInfo($dish_id, "C");
        return $comments;
    }

    // //favorites
    private function selectFavorites($dish_id) {
        $favorite = $this ->DishInfo->selectDishInfo($dish_id, "F");
        return $favorite;
    }

    // === Public method === 
    public function selectRecipeOrMore($dish_id = null) {

        $sql = "SELECT * FROM dishes";
        //foutmelding indien geen dish_id
        if($dish_id !== null) {
            $sql .= " WHERE id = " . mysqli_real_escape_string($this->connection, $dish_id);
        }

        // maakt een array om de opgehaalde gerechten op te slaan
        $dishes = []; 
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $dish_id = $row["id"];
            $user_id = 1; // Example user ID, replace with actual logic if needed

            // Fetch related data using $row
            $user = $this->selectUser($user_id);
            $kitchen = $this->selectKitchen($row['kitchen_id']);
            $type = $this->selectType($row['type_id']);
            $ingredients = $this->selectIngredient($row['id']);
            $price = $this->calcPrice($ingredients);
            $calories = $this->calcCalo($ingredients);
            $rating = $this->selectRating($row['id']);
            $preparationSteps = $this->selectPreparationSteps($row['id']);
            $comments = $this->selectComments($row['id']);
            $favorites = $this->selectFavorites($row['id']);

            // Add related data to the dish
            $row['User'] = $user;
            $row['Kitchen'] = $kitchen;
            $row['Type'] = $type;
            $row['Ingredients'] = $ingredients;
            $row['Price'] = $price;
            $row['Calories'] = $calories;
            $row['Rating'] = $rating;
            $row['Preparation_steps'] = $preparationSteps;
            $row['Comments'] = $comments;
            $row['Favorites'] = $favorites;

            $dishes[] = $row;
        }
    
        // Bepaalt wat er geretourneerd moet worden (één gerecht of meerdere)
        if (count($dishes) === 1 && !is_array($dish_id)) {
            return $dishes[0];
        } else {
            return $dishes;
        }
    }
    
}


