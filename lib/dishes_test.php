<?php

class Dishes {
    // Properties
    private $connection;
    private $KitchenType;
    private $Ingredient;
    private $Price;
    private $Calories;
    private $User;
    private $PreparationMethod;
    private $Comments;
    private $Rating;
    private $Favorites;

    // Constructor
    public function __construct($connection) {
        $this->connection = $connection;
        $this->KitchenType = new KitchenType($connection);
        $this->Ingredient = new Ingredient($connection);
        $this->Price = new Price($connection);
        $this->Calories = new Calories($connection);
        $this->PreparationMethod = new PreparationMethod($connection);
        $this->Comments = new Comments($connection);
        $this->Rating = new Rating($connection);
        $this->Favorites = new Favorites($connection);
    }

    // Kitchen + Type
    private function selectKitchenType($kitchen_id) {
        return $this->KitchenType->selectKitchenType($kitchen_id);
    }

    private function selectType($type_id) {
        $sql = "SELECT * FROM dish_types WHERE type_id = $type_id";
        $result = mysqli_query($this->connection, $sql);
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    // Ingredient
    private function selectIngredient($ingredient_id) {
        return $this->Ingredient->selectIngredient($ingredient_id);
    }

    // Calorieën en prijs berekenen
    private function calcCalories($dish_id) {
        $sql = "SELECT SUM(calories) as total_calories FROM ingredients WHERE dish_id = $dish_id";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row['total_calories'] ?? 0;
    }

    private function calcPrice($dish_id) {
        $sql = "SELECT SUM(price) as total_price FROM ingredients WHERE dish_id = $dish_id";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row['total_price'] ?? 0;
    }

    // Gebruiker
    private function selectUser($user_id) {
        $sql = "SELECT * FROM users WHERE user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    // Rating
    private function selectRating($dish_id) {
        $sql = "SELECT AVG(rating) as average_rating FROM ratings WHERE dish_id = $dish_id";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return round($row['average_rating'] ?? 0, 2);
    }

    // Bereidingswijze
    private function selectPreparationMethod($dish_id) {
        $sql = "SELECT * FROM preparation_steps WHERE dish_id = $dish_id ORDER BY step_number ASC";
        $result = mysqli_query($this->connection, $sql);
        $steps = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $steps[] = $row;
        }
        return $steps;
    }

    // Opmerkingen
    private function selectComments($dish_id) {
        $sql = "SELECT * FROM comments WHERE dish_id = $dish_id ORDER BY created_at DESC";
        $result = mysqli_query($this->connection, $sql);
        $comments = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $comments[] = $row;
        }
        return $comments;
    }

    // Favoriet bepalen
    private function determineFavorite($dish_id, $user_id) {
        return $this->Favorites->isFavorite($dish_id, $user_id);
    }

    // Gerecht ophalen (publice methode)
    public function selectRecipe($dishes_id) {
        $sql = "SELECT * FROM dishes WHERE dishes_id = $dishes_id";
        $result = mysqli_query($this->connection, $sql);
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
}
