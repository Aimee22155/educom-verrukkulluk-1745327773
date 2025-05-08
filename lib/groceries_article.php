<?php

class Grocery_list {
    // Properties
    private $connection;
    private $article;

    // Methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this->article = new Article($connection);
        $this->createGroceriesListTable();
    }

    // Tabel aanmaken als die nog niet bestaat
    private function createGroceriesListTable() {
        $sql = "CREATE TABLE IF NOT EXISTS groceries_list (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT,
                    article_id INT,
                    article_name VARCHAR(255),
                    unit VARCHAR(50),
                    total_quantity INT,
                    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
                    FOREIGN KEY (article_id) REFERENCES article(id) ON DELETE CASCADE
                )";
        mysqli_query($this->connection, $sql);
    }

    // Ingredient ophalen voor een gerecht 
    private function selectIngredients($dish_id) {
        $sql = "SELECT i.article_id, i.quantity, a.name AS article_name, a.unit, a.price
                FROM ingredient i
                JOIN article a ON i.article_id = a.id
                WHERE i.dish_id = $dish_id";
        $result = mysqli_query($this->connection, $sql);
        $ingredients = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $ingredients[] = $row;
        }

        return $ingredients;
    }

    // Huidige boodschappenlijst van de gebruiker ophalen
    private function selectGroceries($user_id) {
        $sql = "SELECT * FROM groceries_list WHERE user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $groceries = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $groceries[] = $row;
        }

        return $groceries;
    }

    //Article toevoegen
    private function addArticle($user_id, $artikel_id, $artikel_naam, $eenheid, $hoeveelheid) {
        $sql = "INSERT INTO groceries_list (user_id, article_id, article_name, unit, total_quantity)
                VALUES ($user_id, $artikel_id, '$artikel_naam', '$eenheid', $hoeveelheid)";
        mysqli_query($this->connection, $sql);
    }

    //Article bijwerken
    private function updateArticle($user_id, $artikel_id, $hoeveelheid) {
        $sql = "UPDATE groceries_list 
                SET total_quantity = total_quantity + $hoeveelheid 
                WHERE user_id = $user_id AND article_id = $artikel_id";
        mysqli_query($this->connection, $sql);
    }

    // Controleer of artikel al op de lijst staat
    public function articleOnList($user_id, $article_id) {
        $groceries = $this->selectGroceries($user_id);

        foreach ($groceries as $grocery) {
            if ($grocery['article_id'] == $article_id) {
                return $grocery;
            }
        }
        return false;
    }

    // Voeg boodschappen toe aan de lijst
    public function addGroceries($dish_id, $user_id) {
        $ingredients = $this->selectIngredients($dish_id);
        $grocery_list = [];
    
        foreach ($ingredients as $ingredient) {
            $article_id = $ingredient['article_id'];
            $article_name = $ingredient['article_name'];
            $unit = $ingredient['unit'];
            $quantity = $ingredient['quantity'];
            $price = $ingredient['price'];
    
            if ($this->articleOnList($user_id, $article_id)) 
            { $this->updateArticle($user_id, $article_id, $quantity);
    
                $grocery_list[] = [
                    'user_id' => $user_id,
                    'article_id' => $article_id,
                    'article_name' => $article_name,
                    'action' => 'updated',
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'price' => $price,
                ];
            } 
            else { $this->addArticle($user_id, $article_id, $article_name, $unit, $quantity);
    
                $grocery_list[] = [
                    'user_id' => $user_id,
                    'article_id' => $article_id,
                    'article_name' => $article_name,
                    'action' => 'inserted',
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'price' => $price,
                ];
            }
        }
        return $grocery_list;
    }    
    
}