<?php

class Ingredient {
    //properties
    private $connection;
    private $article;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this->article = new article($connection);
    }
  
    private function selectArticle($article_id) {
        $article = $this->article->selectArticle($article_id);
        return($article);
    }

    public function selectIngredient($dish_id) {
        //selecteer alle ingredientvelden die behoren tot een specifiek gerecht.
        $sql = "select * from ingredient where id = $dish_id";
        $result = mysqli_query($this->connection, $sql);
        // lege aray voor tegen foutmelding null waarden.
        $Ingredient_return=[];

        // Gecreeërde array verplaatsen in "$row". 
        // Loops erdoor en maakt nieuwe array aan (loops door zolang mysqli_fetch_array kan worden uitgevoerd,
        // (e.g. select * from ingredient waar gerecht_id = $gerecht_id)). 
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            // Nieuw property: artikel_id en stop die in "$row".
            $article_id = $row["article_id"];

            // Nieuw property_2: art_ing.
            // maak nieuwe array aan, via de selecteerArtikel functie, voor elke artikel_id.
            $art_ing = $this->selectArticle($article_id);
        
            // maak nieuwe array aan en specificeer de velden.
            $Ingredient_return[] = [
                "id" => $row["id"],
                "dish_id" => $row["dish_id"],
                "article_id" => $article_id,
                "name" => $art_ing["name"],
                "description" => $art_ing["description"],
            ];
        }
        return($Ingredient_return);
    }
    
}

