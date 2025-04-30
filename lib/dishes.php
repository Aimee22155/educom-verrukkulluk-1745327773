<?php

class Dishes {
    //properties
    
    private $connection;
    //kitchen and type seperate?
    private $ingredient;
    private $price;
    private $calories;
    private $preparation_method;
    private $comments;
    private $rating;
    private $favorites;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingredient = new ingredient($connection);
        $this->price = new price($connection);
        $this->calories = new calories($connection);
        $this->preparation_method = new preparation_method($connection);
        $this->comments = new comments($connection);
        $this->rating = new rating($connection);
        $this->favorites = new favorites($connection);
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

