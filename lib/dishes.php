<?php

class Dishes {
    // === Properties ===
    private $User;
    private $connection;
    private $KitchenType;
    private $Ingredient;
    private $Price;
    private $Calories;
    private $PreparationMethod;
    private $Comments;
    private $Rating;
    private $Favorites;

    // === Constructor ===
    public function __construct($connection) {
        $this->connection = $connection;
        $this->User = new User($connection);
        $this->KitchenType = new KitchenType($connection);
        $this->Ingredient = new Ingredient($connection);
    }

    // === Private methods ===
    private function selectUser($user_id) {
        $sql = "SELECT * 
                FROM user 
                WHERE id = $user_id";
        $userResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_assoc($userResult);
    }

    private function selectKitchen($kitchen_type_id) {
        $sql = "SELECT * 
                FROM kitchen_type 
                WHERE id = $kitchen_type_id AND record_type = 'K'";
        $kitchenResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_assoc($kitchenResult);
    }

    private function selectType($kitchen_type_id) {
        $sql = "SELECT * 
                FROM kitchen_type 
                WHERE id = $kitchen_type_id 
                AND record_type = 'T'";
        $typeResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_assoc($typeResult);
    }

    private function selectIngredient($dish_id) {
        $sql = "SELECT * 
                FROM ingredient 
                WHERE dish_id = $dish_id";
        $ingredientResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($ingredientResult, MYSQLI_ASSOC);
    }

    // Bereken calorieën
    private function calcCalories($dish_id) {
        $sql = "SELECT SUM((i.quantity / a.packaging) * a.calories) AS total_calories
                FROM ingredient AS i
                JOIN article AS a ON i.article_id = a.id
                WHERE i.dish_id = $dish_id
                GROUP BY i.dish_id";
        $calorieResult = mysqli_query($this->connection, $sql);
        $calorieRow = mysqli_fetch_assoc($calorieResult);
        return $calorieRow['total_calories'] ?? 0;
    }

    // Bereken prijs
    private function calcPrice($dish_id) {
        $sql = "SELECT SUM((i.quantity / a.packaging) * a.price) AS total_cost
                FROM ingredient AS i
                JOIN article AS a ON i.article_id = a.id
                WHERE i.dish_id = $dish_id
                GROUP BY i.dish_id";
        $priceResult = mysqli_query($this->connection, $sql);
        $priceRow = mysqli_fetch_assoc($priceResult);
        return $priceRow['total_cost'] ?? 0;
    }

    // Haal gemiddelde rating op
    private function selectAVGRating($dish_id) {
        $sql = "SELECT ROUND(AVG(numberfield), 2) AS avg_rating
                FROM dish_info
                WHERE record_type = 'R' AND dish_id = $dish_id";
        $ratingResult = mysqli_query($this->connection, $sql);
        $ratingRow = mysqli_fetch_assoc($ratingResult);
        return $ratingRow['avg_rating'] ?? null;
    }

    //haal alle ratings op
    private function selectRating($dish_id) {
        $sql = "SELECT dish_id, record_type, user_id, numberfield, textfield
                FROM dish_info
                WHERE record_type = 'R' AND dish_id = $dish_id";
        $ratingResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($ratingResult, MYSQLI_ASSOC);
    }

    // Haal bereidingsstappen op
    private function selectSteps($dish_id) {
        $sql = "SELECT numberfield, textfield
                FROM dish_info
                WHERE dish_id = $dish_id AND record_type = 'P'
                ORDER BY numberfield ASC";
        $stepsResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($stepsResult, MYSQLI_ASSOC);
    }

    // Haal opmerkingen op
    private function selectComments($dish_id) {
        $sql = "SELECT user_id, textfield
                FROM dish_info
                WHERE record_type = 'C' AND dish_id = $dish_id";
        $commentResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($commentResult, MYSQLI_ASSOC);
    }

    // Haal favorieten op
    private function selectFavorites($dish_id) {
        $sql = "SELECT user_id, record_type, dish_id, date
                FROM dish_info
                WHERE record_type = 'F' AND dish_id = $dish_id";
        $favoriteResult = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($favoriteResult, MYSQLI_ASSOC);
    }

    // Haal totaal aantal favorieten op
    private function selectTotalFavorite($user_id, $dish_id) {
        $sql = "SELECT COUNT(*) AS total_count
                FROM dish_info
                WHERE record_type = 'F' AND dish_id = $dish_id";
        $favoriteResult = mysqli_query($this->connection, $sql);
        $favoriteRow = mysqli_fetch_assoc($favoriteResult);
        return $favoriteRow['total_count'] ?? 0;
    }

    // === Public method to get all dish data ===
    public function selectRecipe($dish_id, $user_id, $kitchen_type_id) {
        $sql = "SELECT * FROM dishes WHERE id = $dish_id";
        $res = mysqli_query($this->connection, $sql);
        $dish = mysqli_fetch_assoc($res);

        $user = $this->selectUser($user_id);
        $kitchen = $this->selectKitchen($kitchen_type_id);
        $type = $this->selectType($kitchen_type_id);
        $ingredient = $this->selectIngredient($dish_id);
        $calories = $this->calcCalories($dish_id);
        $price = $this->calcPrice($dish_id);
        $steps = $this->selectSteps($dish_id);
        $comments = $this->selectComments($dish_id);
        $rating = $this->selectRating($dish_id);
        $ratingAVG = $this->selectAVGRating($dish_id);
        $favorites = $this->selectFavorites($dish_id);
        $isFavorite = $this->selectTotalFavorite($user_id, $dish_id);

        $ingredients = [];
        foreach ($ingredient as $ingredient) {
            $articleId = $ingredient['article_id'];
            $articleQuery = "SELECT * FROM article WHERE id = $articleId";
            $articleResult = mysqli_query($this->connection, $articleQuery);
            $article = mysqli_fetch_assoc($articleResult);

            $ingredients[] = [
                "id" => (string) $ingredient["id"],
                "recipe_id" => (string) $ingredient["dish_id"],
                "product_id" => (string) $ingredient["article_id"],
                "amount" => (string) $ingredient["quantity"],
                "name" => $article["name"],
                "description" => $article["description"],
                "calories" => (string) $article["calories"],
                "price" => (string) $article["price"],
                "unit" => $article["unit"],
                "packaging" => $article["packaging"],
            ];
        }

        $preparation = [];
        foreach ($steps as $i => $step) {
            $preparation[] = [
                "id" => (string) ($i + 1),
                "record_type" => "P",
                "recipe_id" => (string) $dish["id"],
                "user_id" => null,
                "date" => null,
                "number" => (string) $step["numberfield"],
                "text" => $step["textfield"]
            ];
        }

        return [
            "id" => (string) $dish["id"],
            "user_id" => (string) $dish["user_id"],
            "kitchen_id" => (string) $dish["kitchen_id"],
            "type_id" => (string) $dish["type_id"],
            "title" => $dish["title"],
            "short_descr" => $dish["short_description"],
            "long_descr" => $dish["long_description"],
            "date_added" => substr($dish["date_added"], 0, 10),
            "image" => "assets/img/" . $dish["image"],
            "kitchen" => $kitchen["description"] ?? "Onbekend",
            "type" => $type["description"] ?? "Onbekend",
            "ingredients" => $ingredients,
            "sumTotalPrice" => round($price, 2),
            "sumTotalCalories" => round($calories),
            "preparation" => $preparation,
            "rating" => $rating,
            "ratingAverage" => $ratingAVG ? round($ratingAVG, 2) : 0,
            "comments" => $comments,
            "favorites" => $favorites,
            "favorited" => $isFavorite
        ];
    }
}
