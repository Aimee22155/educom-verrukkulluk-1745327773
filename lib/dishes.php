<?php

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
    public function selectRecipe($dish_id) {
        // Voorbeeld user_id, in een echte applicatie komt dit meestal uit sessie of login
        $user_id = 1;
    
        $sql = "SELECT * FROM dishes WHERE id = $dish_id";
        $result = mysqli_query($this->connection, $sql);  
        $dish = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
        // Vul gerelateerde gegevens in
        $user = $this->selectUser($user_id);
        $kitchen = $this->selectKitchen($dish['kitchen_id']);
        $type = $this->selectType($dish['type_id']);
        $ingredients = $this->selectIngredient($dish['id']);
        $price = $this->calcPrice($ingredients);
        $calories = $this->calcCalo($ingredients);
        $rating = $this->selectRating($dish['id']);
        $preparationSteps = $this->selectPreparationSteps($dish['id']);
        $comments = $this->selectComments($dish['id']);
        $favorites = $this->selectFavorites($dish['id']);
    
        // Voeg deze toe aan het gerecht
        $dish['user'] = $user;
        $dish['kitchen'] = $kitchen;
        $dish['type'] = $type;
        $dish['ingredients'] = $ingredients;
        $dish['Price'] = $price;
        $dish['calories'] = $calories;
        $dish['Rating'] = $rating;
        $dish['preparation_steps'] = $preparationSteps;
        $dish['comments'] = $comments;
        $dish['favorites'] = $favorites;
    
        return $dish;
    }
    
}


