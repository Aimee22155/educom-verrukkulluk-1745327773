<?php

class Dishes {
    //properties
    
    private $connection;
    //kitchen and type seperate?
    private $Ingredient;
    private $Price;
    private $Calories;
    private $Preparation_method;
    private $Comments;
    private $Rating;
    private $Favorites;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this->Ingredient = new ingredient($connection);
        $this->Price = new price($connection);
        $this->Calories = new calories($connection);
        $this->Preparation_method = new preparation_method($connection);
        $this->Comments = new comments($connection);
        $this->Rating = new rating($connection);
        $this->Favorites = new favorites($connection);
    }
  
    //private function
    private function selectIngredient($ingredient_id) {
        $ingredient = $this->ingredient->selectIngredient($ingredient_id);
        return($ingredient);
    }

    
    public function selectDishes($dishes_id) {
        $sql = "SELECT * FROM dishes WHERE dishes_id = dishes_id";
        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return [];
    }








    
    
    // Add methods for selectUser, selectKitchen, selectType, calcCalories, calcPrice, 
    // selectRating, selectSteps, selectRemarks, determineFavorite.
}

