<?php

class Grocery_list {
    //Properties
    private $connection;
    private $Ingredient;
    private $User;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this-> Ingredient = new Ingredient($connection);
        $this->User = new User($connection);
    }

    // Ondersteunende functie ingrediënten
    private function selectIngredientList($dish_id) {
        $sql = "select article_id from ingredient where dish_id = $dish_id";
        $result = mysqli_query($this->connection, $sql);
        $ingredientlist = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        return($ingredientlist);
    }

    // Ondersteunende functie boodschappenlijst
    private function selectGroceries($user_id) {
        $sql = "SELECT
                    u.user_name,
                    a.name AS article_name,
                    a.unit,
                    SUM(i.quantity) AS total_quantity
                FROM
                    USER u
                JOIN dishes d ON u.id = d.user_id
                JOIN ingredient i ON d.id = i.dish_id
                JOIN article a ON i.article_id = a.id
                GROUP BY
                    u.user_name,
                    a.name,
                    a.unit";
        $result = mysqli_query($this->connection, $sql);
        $groceries= mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        return($groceries);
    }

    // functie: ArtikelOpLijst
    public function ArticleOnList($article_id, $user_id) {
        $groceries = $this->selectGroceries($user_id);

        foreach ($groceries as $grocery) {
            if ($grocery->article_id == $article_id) {
                // Artikel is op de lijst
                return $grocery;
            }
        }

        // Artikel is niet op de lijst
        return false;
    }

    // functie: boodschappenToevoegen
    public function addGroceries($dish_id, $user_id) {
        $ingredientlist = $this->selectIngredientList($dish_id); 

        foreach ($ingredient as $ingredientlist) {
            $article_id = $ingredient['article_id'];

            if ($this->ArticleOnList($article_id, $user_id)) {
                // Artikel bijwerken
                $this->UpdateArticle($article_id, $user_id);
            } else {
                // Artikel toevoegen
                $this->AddArticle($article_id, $user_id);
            }
        }
    }

    // // Simuleert toevoegen van artikel aan boodschappenlijst
    // function AddArticle($article_id, $user_id) {
    //     echo "Article $article_id added to user $user_id\n";
    // }

    // // Simuleert bijwerken van bestaand artikel op boodschappenlijst
    // function UpdateArticle($article_id, $user_id) {
    //     echo "Article $article_id updated for user $user_id\n";
    // }
}
